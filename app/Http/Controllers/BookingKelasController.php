<?php

namespace App\Http\Controllers;

use App\Models\booking_kelas;  
use App\Models\member;    
use App\Models\jadwal_harian;
use App\Models\instruktur;  
use App\Models\kelas;    
use App\Models\deposit_uang;  
use App\Models\deposit_kelas;  
use App\Models\transaksi_deposit_kelas; 
use Illuminate\Http\Request;
use App\Http\Resources\BookingKelasResource;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use PDF;
use Illuminate\Support\Facades\DB;

class BookingKelasController extends Controller
{
     /**
    * index
    *
    * @return void
    */
 
    public function index()
    {
        //get posts
        $bookingkelas = booking_kelas::all();

        $nama = DB::table('booking_kelas')
        ->join('jadwal_harians','id_jadwal_harian','=','jadwal_harians.id')
        ->join('kelas','id_kelas','=','kelas.id')
        ->join('instrukturs','jadwal_harians.id_instruktur','=','instrukturs.id')
        ->join('members','booking_kelas.id_member','=','members.id')
        ->select('booking_kelas.no_struk_booking_kelas','members.nama_member', 
        'kelas.nama_kelas','instrukturs.nama_instruktur', 
        'booking_kelas.waktu_booking', 
        'booking_kelas.tipe')
        ->latest('jadwal_harians.created_at')->get();

        foreach ($bookingkelas as $index => $member) {
            $bookingkelas[$index]->member = member::find($member->id_member);
        }
        foreach ($bookingkelas as $index => $jadwalHarian) {
            $bookingkelas[$index]->jadwalHarian = jadwal_harian::find( $jadwalHarian->id_jadwal_harian);
        }
        foreach ($bookingkelas as $index => $depositUang) {
            $bookingkelas[$index]->depositUang = deposit_uang::find( $depositUang->no_struk_uang);
        }
        foreach ($bookingkelas as $index => $transaksiDepositKelas) {
            $bookingkelas[$index]->transaksiDepositKelas = transaksi_deposit_kelas::find( $transaksiDepositKelas->no_struk_kelas);
        }
        return new BookingKelasResource(true, 'list Data Booking', $nama);
    }

     /**
      * create
      *
      * @return void
      */
      public function create()
      {
         return view('booking_kelas.create');
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
            'id_jadwal_harian'  => 'required',
            
        ]);

        if( $validator->fails()){
            return response()->json($validator->errors([
                'message' => 'Data tidak ada'
            ]), 422);
        }

        // Mendapatkan tanggal sekarang 
        $tanggalSekarang = Carbon::now();
        
        $tahunBookingKelas = $tanggalSekarang->format('y');
        $bulanBookingKelas = $tanggalSekarang->format('m');
    
        $last_id = booking_kelas::max('no_struk_booking_kelas');
        $seq = str_pad($last_id ? intval(substr($last_id, -3)) + 1 : 1, 3, '0', STR_PAD_LEFT);
        $no_struk_booking_kelas = "{$tahunBookingKelas}.{$bulanBookingKelas}.{$seq}";
        

        $member = member::where('id', (string) $request->id_member)->first();
        $transaksiDepositKelas = transaksi_deposit_kelas::where('id_member',(string) $request->id_member)->latest()->first();
        $depositUang = deposit_uang::where('id_member', (string) $request->id_member )->latest()->first();
        $harian = jadwal_harian::where('id', '=', $request->id_jadwal_harian)->first();
        $kelas = kelas::where('id', '=', $harian->id_kelas)->first();

        // Pengecekan untuk member tidak bisa booking kelas lebih dari 1 kali 
        $cekBooking = booking_kelas::where('id_jadwal_harian','=',$request->id_jadwal_harian)->where('id_member','=',$request->id_member)->get();
        if($cekBooking->isNotEmpty()){
            return response(['message' => 'Sudah Melakukan Booking'],400);
        }

        // Pengecekan untuk booking kelas
        if(empty($transaksiDepositKelas)){

            if (empty($depositUang)){
                return response(['message' => 'Member tidak ada Transaksi Deposit Uang'], 400);
            }else if(!empty($depositUang)){
               if($depositUang->total_deposit >= $kelas->harga_kelas){
                    $bookingKelas = booking_kelas::create([
                        'no_struk_booking_kelas'  =>  $no_struk_booking_kelas,
                        'id_member' => $request->id_member,
                        'id_jadwal_harian' => $request->id_jadwal_harian,
                        'no_struk_transaksi_kelas' => null,
                        'no_struk_uang' => $depositUang->no_struk_uang,
                        'waktu_booking' => $tanggalSekarang = Carbon::now(),
                        'tanggal_booking_kelas' => $harian->tanggal,
                        'slot_kelas' => 10-1,
                        'tipe' => 'Reguler'
                    ]);
                    $depositUang->decrement('total_deposit', $kelas->harga_kelas);
                    $depositUang->save();
                    return response(['message' => $bookingKelas], 200);
               } else{
                    return response(['message' => 'Member Ada Saldo Deposit Uang Tidak Cukup'], 400);
               }
            }else if(empty($transaksiDepositKelas)) {
                return response(['message' => 'Member tidak ada Transaksi Deposit Kelas'], 400);
            }
        }else{
            if( $transaksiDepositKelas->id_kelas == $harian->id_kelas){
                $bookingKelas = booking_kelas::create([
                    'no_struk_booking_kelas'  =>   $no_struk_booking_kelas,
                    'id_member' => $request->id_member,
                    'id_jadwal_harian' => $request->id_jadwal_harian,
                    'no_struk_transaksi_kelas' => $transaksiDepositKelas->no_struk_kelas,
                    'no_struk_uang' => null,
                    'waktu_booking' => $tanggalSekarang = Carbon::now(),
                    'tanggal_booking_kelas' => $harian->tanggal,
                    'slot_kelas' => 10-1,
                    'tipe' => 'Paket'
                ]);
                $transaksiDepositKelas->decrement('total_deposit_kelas', 1);
                $transaksiDepositKelas->save();
                // deposit_kelas::where('id_member', (string) $request->id_member, 'id_kelas', '=', $kelas)->update(['sisa_deposit_kelas' => 'total_deposit_kelas']);
                
                return response(['message' => $bookingKelas], 200);
            }
        } 
       
    }

    /**
     * show
     *
     * @param  mixed $post
     * @return void
     */
    public function show($no_struk_booking_kelas)
    {
        // $bookingkelas = booking_kelas::where('no_struk_booking_kelas', (string) $no_struk_booking_kelas)->first();

        $nama = DB::table('booking_kelas')
        ->join('jadwal_harians','id_jadwal_harian','=','jadwal_harians.id')
        ->join('kelas','id_kelas','=','kelas.id')
        ->join('members','booking_kelas.id_member','=','members.id')
        ->select('booking_kelas.no_struk_booking_kelas','members.nama_member', 
        'kelas.nama_kelas','instrukturs.nama_instruktur', 
        'booking_kelas.waktu_booking',
        'booking_kelas.tipe')
        ->where('no_struk_booking_kelas', (string) $no_struk_booking_kelas)
        ->latest('jadwal_harians.created_at')->get();

        if($nama){
            return response()->json([
                'status' => 'success',
                'message' => 'Data Booking Berhasil Ditampilkan',
                'data' => $nama
            ], 200);
             return new BookingKelasResource(true, 'Data Post Ditemukan!', $bookingkelas);
        } else{
            return response()->json([
                'status' => 'false',
                'message' => 'Data Booking tidak ada',
                'data' => $nama
            ], 200);
        }
    }

    public function cetakPaket(string $no_struk_booking_kelas){
        $nama = DB::table('booking_kelas')
        ->join('jadwal_harians','booking_kelas.id_jadwal_harian','=','jadwal_harians.id')
        ->join('kelas','jadwal_harians.id_kelas','=','kelas.id')
        ->join('members','booking_kelas.id_member','=','members.id')
        ->join('instrukturs','jadwal_harians.id_instruktur','=','instrukturs.id')
        ->join('transaksi_deposit_kelas', 'booking_kelas.no_struk_transaksi_kelas', '=', 'transaksi_deposit_kelas.no_struk_kelas')
        ->select('booking_kelas.no_struk_booking_kelas','members.id as id_member', 'members.nama_member', 
        'kelas.nama_kelas','instrukturs.nama_instruktur', 
        'booking_kelas.tipe', 
        'transaksi_deposit_kelas.total_deposit_kelas',
        'transaksi_deposit_kelas.tanggal_berlaku')
        ->where('no_struk_booking_kelas', '=', $no_struk_booking_kelas)->get();
        
        return response()->json([
            'message' => 'Berhasil',
            'data' => $nama
        ], 200);
    }

    public function cetakReguler(string $no_struk_booking_kelas){
        $nama = DB::table('booking_kelas')
        ->join('jadwal_harians','booking_kelas.id_jadwal_harian','=','jadwal_harians.id')
        ->join('kelas','jadwal_harians.id_kelas','=','kelas.id')
        ->join('members','booking_kelas.id_member','=','members.id')
        ->join('instrukturs','jadwal_harians.id_instruktur','=','instrukturs.id')
        ->join('deposit_uangs', 'booking_kelas.no_struk_uang', '=', 'deposit_uangs.no_struk_uang')
        ->select('booking_kelas.no_struk_booking_kelas','members.id as id_member', 'members.nama_member', 
        'kelas.nama_kelas', 'kelas.harga_kelas',
        'instrukturs.nama_instruktur',
        'booking_kelas.tipe', 
        'deposit_uangs.total_deposit')
        ->where('no_struk_booking_kelas',  '=', $no_struk_booking_kelas)->get();
        return response()->json([
            'message' => 'Berhasil',
            'data' => $nama
        ], 200);
    }
}
