<?php

namespace App\Http\Controllers;

use App\Models\member;    
use App\Models\aktivasi;  
use App\Models\pegawai;  
use Illuminate\Http\Request;
use App\Http\Resources\AktivasiResource;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PDF;

class AktivasiController extends Controller
{
    public function index()
    {
        //get posts
        $aktivasi = aktivasi::all();

        foreach ($aktivasi as $index => $member) {
            $aktivasi[$index]->member = member::find($member->id_member);
        }
        foreach ($aktivasi as $index => $pegawai) {
            $aktivasi[$index]->pegawa = pegawai::find($pegawai->id_pegawai);
        }
        
        return new AktivasiResource(true, 'list Data Aktivasi',$aktivasi);
    }

    /**
      * create
      *
      * @return void
      */
      public function create()
      {
         return view('aktivasi.create');
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
        'id_pegawai'  => 'required',
        'jumlah_bayar'  => 'required'
    ]);

    if( $validator->fails()){
        return response()->json($validator->errors([
            'message' => 'Data tidak ada'
        ]), 422);
    }

    // Mendapatkan tanggal sekarang 
    $tanggalSekarang = Carbon::now();
    // Ambil 2 digit tahun sekarang
    $tahunAktivasi = $tanggalSekarang->format('y');
     // Mengambil 2 digit bulan daftar
    $bulanAktivasi = $tanggalSekarang->format('m');
     // Mengambil ID terakhir
     $last_id = aktivasi::max('no_struk_aktivasi');
     // Mengambil 3 digit sequence number
     $seq = str_pad($last_id ? intval(substr($last_id, -3)) + 1 : 1, 3, '0', STR_PAD_LEFT);


     // Membuat ID dengan format yang diinginkan
     $no_struk_aktivasi = "{$tahunAktivasi}.{$bulanAktivasi}.{$seq}";

    //  Tanggal Masa Aktif Member
    $tanggalMasaAktif = $tanggalSekarang->addYear();

    //Kondisi Minimal Deposit 
    if($request->jumlah_bayar < 3000000){
        return response()->json([
            'jumlah_bayar'=> ['Minimal deposit uang adalah 3000000']
        ], 422);
    }
    
    $aktivasi = aktivasi::create([
        'no_struk_aktivasi'  =>  $no_struk_aktivasi,
        'id_member' => $request->id_member,
        'id_pegawai' => $request->id_pegawai,
        'tanggal_transaksi' =>  $tanggalSekarang = Carbon::now(), 
        'jumlah_bayar' => $request->jumlah_bayar,
        'tanggal_berlaku' => $tanggalMasaAktif
    ]);

        member::where('id', $request->id_member)->update(['status' => '1']);
        member::where('id', $request->id_member)->update(['tanggal_masa_aktif' =>  $tanggalMasaAktif]);
        
        return new AktivasiResource(true, 'Transaksi Berhasil Ditambahkan', $aktivasi);
    }

    public function show($no_struk_aktivasi)
    {
        $aktivasi =aktivasi::where('no_struk_aktivasi', (string) $no_struk_aktivasi)->first();
        if( $aktivasi){
            return response()->json([
                'status' => '',
                'message' => 'Data Aktivasi Berhasil Ditampilkan',
                'data' => $aktivasi
            ], 200);
            return new AktivasiResource(true, 'Data Post Ditemukan!',$aktivasi);
        } else{
            return response()->json([
                'status' => 'false',
                'message' => 'Data tidak ada',
                'data' => $aktivasi
            ], 200);
        }
    }

    public function cetakAktivasi(string $no_struk_aktivasi){
        $nama = DB::table('aktivasis')
        ->join('members','aktivasis.id_member','=','members.id')
        ->join('pegawais','aktivasis.id_pegawai','=','pegawais.id')
        ->select('aktivasis.no_struk_aktivasi','members.id as id_member', 'members.nama_member', 
        'aktivasis.jumlah_bayar', 'aktivasis.tanggal_berlaku', 'pegawais.id as id_pegawai', 
        'pegawais.nama_pegawai')
        ->where('no_struk_aktivasi',  '=', $no_struk_aktivasi)->get();
        
        return response()->json([
            'message' => 'Berhasil',
            'data' => $nama
        ]);
    }

}
