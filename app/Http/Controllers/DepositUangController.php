<?php

namespace App\Http\Controllers;

use App\Models\member;  
use App\Models\pegawai;  
use App\Models\deposit_uang;  
use App\Models\promo;  
use Illuminate\Http\Request;
use App\Http\Resources\DepositUangResource;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use PDF;
use Illuminate\Support\Facades\DB;

class DepositUangController extends Controller
{
    /**
    * index
    *
    * @return void
    */
 
    public function index()
    {
        //get posts
        $uang = deposit_uang::all();

        foreach ($uang as $index => $member) {
            $uang[$index]->member = member::find($member->id_member);
        }
        foreach ($uang as $index => $pegawai) {
            $uang[$index]->pegawa = pegawai::find($pegawai->id_pegawai);
        }

        foreach ($uang as $index => $promo) {
            $uang[$index]->promo = promo::find($promo->id);
        }

        return new DepositUangResource(true, 'list Data Uang', $uang);
    }

       /**
      * create
      *
      * @return void
      */
      public function create()
      {
         return view('deposit_uang.create');
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
        'id_promo'  => 'required',
        'jumlah_bayar'  => 'required'
    ]);

    if( $validator->fails()){
        return response()->json($validator->errors([
            'message' => 'Data tidak ada'
        ]), 422);
    }

     // Mendapatkan tanggal sekarang 
    $tanggalSekarang = Carbon::now();

    $tahunDepositUang = $tanggalSekarang->format('y');
    $bulanDepositUang = $tanggalSekarang->format('m');
 
    $last_id = deposit_uang::max('no_struk_uang');
    $seq = str_pad($last_id ? intval(substr($last_id, -3)) + 1 : 1, 3, '0', STR_PAD_LEFT);
    $no_struk_uang = "{$tahunDepositUang}.{$bulanDepositUang}.{$seq}";
 
    //  pengecekan Deposit Uang & promo
    $uang =deposit_uang::where('id_member', (string) $request->id_member)->first();
    $promo = promo::where('id', $request->id_promo)->first();

    //CEK MEMBER YANG SAMA MELAKUKAN TRANSAKSI + MASIH ADA SISA DEPOSIT
    if($uang){
        $strukLama =  $no_struk_uang;
        $depositUangSisa = $uang->total_deposit;

        if($promo && $promo->id == 1 && $request->jumlah_bayar >= 3000000){
            $bonus = $promo->bonus;
        }else{
            $bonus = 0;
            
        }

        //Kondisi Minimal Deposit 
        if($request->jumlah_bayar < 500000){
            return response()->json([
                'jumlah_bayar'=> ['Minimal deposit uang adalah 500.000']
            ], 422);
        }
        $totalJumlahDepositBaru =   $depositUangSisa + $request->jumlah_bayar + $bonus;

        $uang = deposit_uang::create([
            'no_struk_uang'  =>  $no_struk_uang,
            'id_member' => $request->id_member,
            'id_pegawai' => $request->id_pegawai,
            'id_promo' => $request->id_promo,
            'tanggal_transaksi' =>  $tanggalSekarang = Carbon::now(), 
            'jumlah_bayar' => $request->jumlah_bayar,
            'total_deposit' => $totalJumlahDepositBaru,
            'sisa_deposit' => $depositUangSisa,
            'bonus' =>$bonus,
        ]);
        member::where('id', $request->id_member)->update(['deposit_uang' =>  $totalJumlahDepositBaru]);
    }
    
    // Transaksi Pertama Kali
    else{

        if($promo && $promo->id == 1 && $request->jumlah_bayar >= 3000000){
            $bonus = $promo->bonus;
        }else{
            $bonus = 0;
        }

        //Kondisi Minimal Deposit 
        if($request->jumlah_bayar < 500000){
            return response()->json([
                'jumlah_bayar'=> ['Minimal deposit uang adalah 500.000']
            ], 422);
        }
        
        $totalDeposit = $request->jumlah_bayar + $bonus;

        $uang = deposit_uang::create([
            'no_struk_uang'  =>  $no_struk_uang,
            'id_member' => $request->id_member,
            'id_pegawai' => $request->id_pegawai,
            'id_promo' => $request->id_promo,
            'tanggal_transaksi' =>  $tanggalSekarang = Carbon::now(), 
            'jumlah_bayar' => $request->jumlah_bayar,
            'total_deposit' => $totalDeposit,
            'sisa_deposit' => 0,
            'bonus' =>$bonus,
        ]);
        member::where('id', $request->id_member)->update(['deposit_uang' =>  $totalDeposit]);
    }
        return new DepositUangResource(true, 'Transaksi Berhasil Ditambahkan', $uang);
    }

    public function show($no_struk_uang)
    {
        $uang =deposit_uang::where('no_struk_uang', (string) $no_struk_uang)->latest()->first();
        if( $uang){
            return response()->json([
                'status' => 'success',
                'message' => 'Data Deposit Uang Berhasil Ditampilkan',
                'data' => $uang 
            ], 200);
            return new DepositUangResource(true, 'Data Post Ditemukan!', $uang);
        } else{
            return response()->json([
                'status' => 'false',
                'message' => 'Data Deposit Uang tidak ada',
                'data' => $uang
            ], 200);
        }
    }

    public function cetakDepositUang(string $no_struk_uang){
        $nama = DB::table('deposit_uangs')
        ->join('members','deposit_uangs.id_member','=','members.id')
        ->join('pegawais','deposit_uangs.id_pegawai','=','pegawais.id')
        ->select('deposit_uangs.no_struk_uang',
        'members.id as id_member', 'members.nama_member', 
        'pegawais.id as id_pegawai', 'pegawais.nama_pegawai',
        'deposit_uangs.jumlah_bayar','deposit_uangs.sisa_deposit',
        'deposit_uangs.total_deposit',
        'deposit_uangs.bonus')
        ->where('no_struk_uang',  '=', $no_struk_uang)->get();
        return response()->json([
            'message' => 'Berhasil',
            'data' => $nama
        ], 200);
    }
}
