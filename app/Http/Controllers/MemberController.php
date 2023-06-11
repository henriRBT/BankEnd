<?php

namespace App\Http\Controllers;

use App\Models\member; 
use Illuminate\Http\Request;
use App\Http\Resources\MemberResource;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use PDF;
use Illuminate\Support\Facades\DB;
class MemberController extends Controller
{
    public function index()
    {
        // Membuat variabel untuk menampung data member
        $member = member::all();
        return new MemberResource(true, 'list Data Member', $member);
    }

    /**
      * create
      *
      * @return void
      */
      public function create()
      {
         return view('member.create');
      }

      /**
      * store
      *
      * @param Request $request
      * @return void
      */
    public function store(Request $request){
        //Validasi Formulir
        $validator = Validator::make($request->all(), [
            'nama_member' => 'required',
            'no_telepon_member' => 'required',
            'alamat_member' => 'required',
            'tanggal_lahir_member' => 'required',
            'email_member' => 'required|email:rfc,dns',
    ]);

    if( $validator->fails()){
        return response()->json($validator->errors(), 422);
    }

    // Mendapatkan tanggal sekarang 
    $tanggalSekarang = Carbon::now();

    // Ambil 2 digit tahun sekarang
    $tahunDaftar = $tanggalSekarang->format('y');

     // Mengambil 2 digit bulan daftar
    $bulanDaftar = $tanggalSekarang->format('m');

     // Mengambil ID terakhir
     $last_id = member::max('id');

     // Mengambil 3 digit sequence number
     $seq = str_pad($last_id ? intval(substr($last_id, -3)) + 1 : 1, 3, '0', STR_PAD_LEFT);

     // Membuat ID dengan format yang diinginkan
     $id = "{$tahunDaftar}.{$bulanDaftar}.{$seq}";

    //  Tanggal Masa Aktif Member
    $tanggalMasaAktif = $tanggalSekarang->addYear();

    // generate id berdasarkan tanggal
     $password = Carbon::parse($request->tanggal_lahir_member)->format('dmy');
    
    
    //Fungsi Menambah Data ke dalam Database
    $member = member::create([
        'id'  =>  $id,
        'nama_member' => $request->nama_member,
        'no_telepon_member' => $request->no_telepon_member,
        'alamat_member'  => $request->alamat_member, 
        'tanggal_lahir_member'  => $request->tanggal_lahir_member, 
        'email_member' => $request->email_member,
        'tanggal_daftar' => $tanggalSekarang = Carbon::now(), 
        'tanggal_masa_aktif' => $tanggalMasaAktif,
        'status' =>  1,
        'deposit_uang' => 0,
        'username'  =>  $id,
        'password'  => bcrypt($password)
    ]);
        return new MemberResource(true, 'Data Member Berhasil Ditambahkan', $member);
    }

    public function update(Request $request, $id){
        // mencari id member ada atau tidak 
        $member = member::where('id', (string) $id)->first();
        //Validasi Formulir
        $validator = Validator::make($request->all(), [
            'nama_member' => 'required',
            'no_telepon_member' => 'required',
            'alamat_member' => 'required',
            'tanggal_lahir_member' => 'required',
            'email_member' => 'required|email:rfc,dns',
        ]);

    if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
    }

    if (!$member) {
        return response()->json([
            'success' => false,
            'message' => 'Data Member not found'
        ], 404);
    }

    // id instruktur ketemu maka akan update
    if($member){
        $member->update([
            'nama_member' => $request->nama_member,
            'no_telepon_member' => $request->no_telepon_member,
            'alamat_member'  => $request->alamat_member, 
            'tanggal_lahir_member'  => $request->tanggal_lahir_member, 
            'email_member' => $request->email_member,
           
        ]);
        return new MemberResource(true, 'Data Member Berhasil di Update!', $member);
     }
        return response()->json([
            'success' => false,
            'message' => 'Post not found'
        ], 404);
    }

    public function show(member $member)
    {
         return new MemberResource(true, 'Data Post Ditemukan!', $member);
    }

    public function hapus($id){
        // mencari id member ada atau tidak 
        $member = member::where('id', (string) $id)->first();
        
        if (!$member) {
            return response()->json([
                'success' => false,
                'message' => 'Data Member not found'
            ], 404);
        }

        $member->update([
            'status' =>  0,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data Member berhasil dinonaktifkan'
        ]);
    }

    public function resetPassword($id){
        // mencari id member ada atau tidak 
        $member = member::where('id', (string) $id)->first();
        
        if (!$member) {
            return response()->json([
                'success' => false,
                'message' => 'Data Member not found'
            ], 404);
        }
     
        $password = Carbon::parse($member->tanggal_lahir_member)->format('dmy');
        
        $member->update([
            'password'  => bcrypt($password)
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data Password berhasil direset'
        ]);
    }
    
    public function cetakMember(string $id){
        $nama = DB::table('members')
        ->select('members.id as id_member', 'members.nama_member', 
        'members.alamat_member', 'members.no_telepon_member',)
        ->where('id',  '=', $id)->get();
        return response()->json([
            'message' => 'Berhasil',
            'data' => $nama
        ]);
    }
}
