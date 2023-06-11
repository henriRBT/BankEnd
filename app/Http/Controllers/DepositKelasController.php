<?php

namespace App\Http\Controllers;

// use App\Models\member;  
// use App\Models\kelas;  
// use App\Models\deposit_kelas;  
// use App\Models\pegawai;  
// use Illuminate\Http\Request;
// use App\Http\Resources\DepositKelasResource;
// use Illuminate\Support\Facades\Validator;
// use Carbon\Carbon;
// use Illuminate\Support\Facades\DB;
// use PDF;
class DepositKelasController extends Controller
{
     /**
    * index
    *
    * @return void
    */
 
    public function index()
    {
        //get posts
        $depositkelas = deposit_kelas::all();

        foreach ( $depositkelas as $index => $member) {
             $depositkelas[$index]->member = member::find($member->id_member);
        }
        foreach ($depositkelas as $index => $pegawai) {
            $depositkelas[$index]->pegawa = pegawai::find($pegawai->id_pegawai);
        }
        foreach ( $depositkelas as $index =>  $kelas) {
             $depositkelas[$index]->kelas = kelas::find( $kelas->id_kelas);
        }
        foreach ($depositkelas as $index => $promo) {
            $depositkelas[$index]->promo = promo::find($promo->id);
        }
        return new DepositKelasResource(true, 'list Data Kelas',  $depositkelas);
    }

    /**
      * create
      *
      * @return void
      */
    public function create()
    {
         return view('deposit_kelas.create');
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
      }

    
}
