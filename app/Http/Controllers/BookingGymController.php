<?php

namespace App\Http\Controllers;

use App\Models\booking_gym;  
use App\Models\member;    
use Illuminate\Http\Request;
use App\Http\Resources\BookingGymResource;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PDF;

class BookingGymController extends Controller
{
      /**
    * index
    *
    * @return void
    */
 
    public function index()
    {
        //get posts
        $gym = booking_gym::all();

        foreach ($gym as $index => $member) {
            $gym[$index]->member = member::find($member->id_member);
        }
      
        return new BookingGymResource(true, 'list Data Booking', $gym);
    }

     /**
      * create
      *
      * @return void
      */
      public function create()
      {
         return view('booking_gym.create');
      }

      /**
      * store
      *
      * @param Request $request
      * @return void
      */
    public function store(Request $request){
        //Validasi Formulir
        $validator = Validator::make( $request->All(), [
        'id_member'  => 'required',
        'tanggal_booking'  => 'required',
        'slot_waktu'  => 'required'
    ]);

    if( $validator->fails()){
        return response()->json($validator->errors([
            'message' => 'Data tidak ada'
        ]), 422);
    }

    // Mendapatkan tanggal sekarang 
    $tanggalSekarang = Carbon::now();
            
    $tahunGym = $tanggalSekarang->format('y');
    $bulanGym = $tanggalSekarang->format('m');

    $last_id = booking_gym::max('no_struk_gym');
    $seq = str_pad($last_id ? intval(substr($last_id, -3)) + 1 : 1, 3, '0', STR_PAD_LEFT);
    $no_struk_gym = "{$tahunGym}.{$bulanGym}.{$seq}";
    
    $booking = booking_gym::create([
        'no_struk_gym'  => $no_struk_gym,
        'id_member' => $request->id_member,
        'waktu_booking' => $tanggalSekarang,
        'tanggal_booking' => $request->tanggal_booking,
        'slot_waktu' => $request->slot_waktu,
        'waktu_presensi' => 0
    ]);
        return new BookingGymResource(true, 'Booking Berhasil Ditambahkan', [$booking] );
    }

     /**
     * show
     *
     * @param  mixed $post
     * @return void
     */
    public function show($no_struk_gym)
    {
        $booking = booking_gym::where('no_struk_gym', (string) $no_struk_gym)->first();

        if($booking){
            return response()->json([
                $booking
            ], 200);
            return new BookingGymResource(true, 'Data Post Ditemukan!', $booking);
        } else{
            return response()->json([
                'status' => 'false',
                'message' => 'Data Booking tidak ada',
                'data' => $booking
            ], 200);
        }
    }

    public function presensi($no_struk_gym)
    {
        $booking = booking_gym::where('no_struk_gym', (string) $no_struk_gym)->first();
       
        $booking->update([
            'waktu_presensi' => Carbon::now()
        ]);
        return new BookingGymResource(true, 'Data Booking Berhasil di !', null);
    }

    public function batal($no_struk_gym)
    {
        $booking = booking_gym::where('no_struk_gym', (string) $no_struk_gym)->first();

        if($booking) {
            $booking->delete();
   
            return response()->json([
               'success' => true,
               'message' => 'Booking Batal'
               ], 200);
         }
   
        return new BookingGymResource(true, 'Data Booking Dibatal!', null);
    }

    public function cetak(string $no_struk_gym){
        $nama = DB::table('booking_gyms')
        ->join('members','booking_gyms.id_member','=','members.id')
        ->select('booking_gyms.no_struk_gym','members.id as id_member', 'members.nama_member', 
        'booking_gyms.slot_waktu',)
        ->where('no_struk_gym',  '=', $no_struk_gym)->get();
        return response()->json([
            'message' => 'Berhasil',
            'data' => $nama
        ]);
    }
}
