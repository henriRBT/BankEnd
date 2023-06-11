<?php

namespace App\Http\Controllers;

use App\Models\member;  
use App\Models\kelas;  
use App\Models\transaksi_deposit_kelas;  
use App\Models\pegawai; 
use App\Models\promo; 
use App\Models\deposit_kelas;  
use Illuminate\Http\Request;
use App\Http\Resources\TransaksiDepositKelasResource;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PDF;

class TransaksiDepositKelasController extends Controller
{
     /**
    * index
    *
    * @return void
    */
 
    public function index()
    {
        //get posts
        $depositkelas = transaksi_deposit_kelas::all();

        foreach ( $depositkelas as $index => $member) {
             $depositkelas[$index]->member = member::find($member->id_member);
        }
        foreach ($depositkelas as $index => $pegawai) {
            $depositkelas[$index]->pegawai = pegawai::find($pegawai->id_pegawai);
        }
        foreach ( $depositkelas as $index =>  $kelas) {
             $depositkelas[$index]->kelas = kelas::find( $kelas->id_kelas);
        }
        foreach ($depositkelas as $index => $promo) {
            $depositkelas[$index]->promo = promo::find($promo->id);
        }
        return new TransaksiDepositKelasResource(true, 'list Data Deposit Kelas',  $depositkelas);
    }

    /**
      * create
      *
      * @return void
      */
    public function create()
    {
         return view('transaksi_deposit_kelas.create');
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
                'id_kelas'  => 'required',
            ]);

            if( $validator->fails()){
                return response()->json($validator->errors([
                    'message' => 'Data tidak ada'
                ]), 422);
            }
        
            // Mendapatkan tanggal sekarang 
            $tanggalSekarang = Carbon::now();
        
            $tahunDepositKelas = $tanggalSekarang->format('y');
            $bulanDepositKelas = $tanggalSekarang->format('m');
        
            $last_id = transaksi_deposit_kelas::max('no_struk_kelas');
            $seq = str_pad($last_id ? intval(substr($last_id, -3)) + 1 : 1, 3, '0', STR_PAD_LEFT);
            $no_struk_kelas = "{$tahunDepositKelas}.{$bulanDepositKelas}.{$seq}";
        
            
             // Penegcekan total deposit kelas saja 
            //  $deposit =transaksi_deposit_kelas::where('id_member', $request->input('id_member'))->latest()->first();
            //  if($deposit &&  $deposit->total_deposit_kelas > 0){
            //     return response()->json([
            //         'message' => 'Deposit kelas sebelumnya masih tersisa, tidak bisa menambah deposit',
            //     ], 422);
            //  }  

            $promo = promo::where('id', $request->id_promo)->first();
            $kelas = kelas::where('id', $request->id_kelas)->first();

            // Cek apakah deposit sebelumnya sudah habis + kelas sama 
            $last_deposit = transaksi_deposit_kelas::where('id_member', $request->input('id_member'))
            ->where('id_kelas', $request->input('id_kelas'))
            ->orderBy('no_struk_kelas', 'desc')
            ->first();

            if($last_deposit && $last_deposit->total_deposit_kelas > 0) {
                return response()->json([
                    'id_kelas' => ['Deposit kelas sebelumnya masih tersisa, tidak bisa menambah deposit'],
                ], 422);
            }else{
                if($promo && $promo->id == 2){
                    $jumlahDeposit =  $promo->minimal_pembelian;
                    $bonus = $promo->bonus; 
                    $totalDeposit = $jumlahDeposit + $bonus;
                    $tanggalberlaku = Carbon::now()->addMonths()->toDateString();
                    $jumlahBayar = $jumlahDeposit * $kelas->harga_kelas;
                }
                if($promo && $promo->id == 3){
                    $jumlahDeposit =  $promo->minimal_pembelian;
                    $bonus = $promo->bonus; 
                    $totalDeposit = $jumlahDeposit + $bonus;
                    $tanggalberlaku = Carbon::now()->addMonth(2)->toDateString();
                    $jumlahBayar = $jumlahDeposit * $kelas->harga_kelas;
                }
            }
            
            $depositKelas = transaksi_deposit_kelas::create([
                'no_struk_kelas'  =>  $no_struk_kelas,
                'id_member' => $request->id_member,
                'id_pegawai' => $request->id_pegawai,
                'id_promo' => $request->id_promo,
                'id_kelas' => $request->id_kelas,
                'tanggal_transaksi' =>  $tanggalSekarang = Carbon::now(), 
                'tanggal_berlaku' => $tanggalberlaku,
                'jumlah_deposit_kelas' => $jumlahDeposit,
                'jumlah_bayar_kelas' => $jumlahBayar,
                'bonus' =>$bonus,
                'total_deposit_kelas' => $totalDeposit
            ]);

            $Kelas = deposit_kelas::create([
                'id_member' => $request->id_member,
                'id_kelas' => $request->id_kelas,
                'tanggal_berlaku' => $tanggalberlaku,
                'sisa_deposit_kelas' => $totalDeposit,
            ]);
        return new TransaksiDepositKelasResource(true, 'Transaksi Berhasil Ditambahkan',  $depositKelas );
    }

    public function show($no_struk_kelas)
    {
        $depositKelas =transaksi_deposit_kelas::where('no_struk_kelas', (string) $no_struk_kelas)->latest()->first();
        if( $depositKelas){
            return response()->json([
                'status' => 'success',
                'message' => 'Data Deposit Kelas Berhasil Ditampilkan',
                'data' => $depositKelas
            ], 200);
            return new TransaksiDepositKelasResourcee(true, 'Transaksi Ditambahkan',  $depositKelas );
        } else{
            return response()->json([
                'status' => 'false',
                'message' => 'Data Deposit Kelas tidak ada',
                'data' => $depositKelas
            ], 200);
        }
    }

    public function cetakDepositKelas(string $no_struk_kelas){
        $nama = DB::table('transaksi_deposit_kelas')
        ->join('members','transaksi_deposit_kelas.id_member','=','members.id')
        ->join('pegawais','transaksi_deposit_kelas.id_pegawai','=','pegawais.id')
        ->join('promos','transaksi_deposit_kelas.id_promo','=','promos.id')
        ->join('kelas','transaksi_deposit_kelas.id_kelas','=','kelas.id')
        ->select('transaksi_deposit_kelas.no_struk_kelas',
        'members.id as id_member', 'members.nama_member', 
        'pegawais.id as id_pegawai', 'pegawais.nama_pegawai', 
        'transaksi_deposit_kelas.jumlah_deposit_kelas',
        'transaksi_deposit_kelas.jumlah_bayar_kelas',
        'transaksi_deposit_kelas.total_deposit_kelas',
        'transaksi_deposit_kelas.tanggal_berlaku',
        'kelas.nama_kelas',
        'kelas.harga_kelas',
        'promos.nama_promo',
        'transaksi_deposit_kelas.tanggal_berlaku')
        ->where('no_struk_kelas',  '=', $no_struk_kelas)->get();
        return response()->json([
            'message' => 'Berhasil',
            'data' => $nama
        ], 200);
    }
}
