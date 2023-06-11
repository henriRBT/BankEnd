<?php

namespace App\Http\Controllers;

use App\Models\instruktur;  
use App\Models\jadwal_umum;  
use App\Models\kelas;  
use Illuminate\Http\Request;
use App\Http\Resources\JadwalUmumResource;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;


class JadwalUmumController extends Controller
{
    /**
    * index
    *
    * @return void
    */
    public function index()
    {
        //get posts
        
        $jadwal = jadwal_umum::all();
        foreach ($jadwal as $index => $instruktur) {
            $jadwal[$index]->instruktur = instruktur::find($instruktur->id_instruktur);
        }
        foreach ($jadwal as $index => $kelas) {
            $jadwal[$index]->kelas = kelas::find($kelas->id_kelas);
        }
        return new JadwalUmumResource(true, 'list Data Jadwal Kelas Umum', $jadwal);
    }

     /**
      * create
      *
      * @return void
      */
      public function create()
      {
         return view('jadwal_umum.create');
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
            'id_kelas' => 'required',
            'id_instruktur' => 'required',
            'hari' => 'required',
            'sesi_kelas'=> 'required'
        ]);

        if( $validator->fails()){
            return response()->json($validator->errors(), 422);
        }

        $inputTime = Carbon::createFromFormat('H:i', $request->sesi_kelas);
        // Memeriksa jika menit bukan 00 atau 30
        if ($inputTime->minute != 0 && $inputTime->minute != 30) {
            return response()->json([
                'sesi_kelas' => ['Sesi Kelas Tidak Bisa']
            ], 422);
        }
        
        // Cek jadwal instruktur
        $jadwalInstruktur = jadwal_umum::where([
            ['id_instruktur', $request->id_instruktur],
            ['hari', $request->hari],
            ['sesi_kelas','>', Carbon::parse($request->sesi_kelas)->subHour()->format('H:i')],
            ['sesi_kelas','<', Carbon::parse($request->sesi_kelas)->addHour()->format('H:i')]
        ])->count();
        

        if($jadwalInstruktur > 0){
            return response()->json([
                'id_instruktur'=> ['Jadwal instruktur bertabrakan dengan jadwal yang sudah ada']
            ], 422);
        }

      
        $jadwal = jadwal_umum::create([
            'id_kelas' => $request->id_kelas,
            'id_instruktur' => $request->id_instruktur,
            'hari'  => $request->hari, 
            'sesi_kelas'  => $request->sesi_kelas, 
        ]);
        
        return new JadwalUmumResource(true, 'Data Jadwal Umum Berhasil Ditambahkan', $jadwal);
    }

     /**
     * show
     *
     * @param  mixed $post
     * @return void
     */
    public function show($id)
    {
        $jadwal = jadwal_umum::where('id', $id)->first();
        if($jadwal){
            return response()->json([
                'status' => 'success',
                'message' => 'Data Jadwal Berhasil Ditampilkan',
                'data' => $jadwal
            ], 200);
            return new JadwalUmumResource(true, 'Data Post Ditemukan!', $jadwal);
        } else{
            return response()->json([
                'status' => 'false',
                'message' => 'Data Jadwal tidak ada',
                'data' => $jadwal
            ], 200);
        }
        
    }

  
    /**
      * store
      *
      * @param Request $request
      * @return void
    */
    public function update(Request $request, $id){

        $jadwal = jadwal_umum::where('id', $id)->first();
        
        //Validasi Formulir
        $validator = Validator::make($request->all(), [
            'id_kelas' => 'required',
            'id_instruktur' => 'required',
            'hari' => 'required',
            'sesi_kelas'=> 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        
        $inputTime = Carbon::createFromFormat('H:i:s', $request->sesi_kelas);
        // Memeriksa jika menit bukan 00 atau 30
        if ($inputTime->minute != 0 && $inputTime->minute != 30) {
            return response()->json([
                'sesi_kelas' => ['Sesi Kelas Tidak Bisa']
            ], 422);
        }
        
        // Cek jadwal instruktur
        $jadwalInstruktur = jadwal_umum::where([
            ['id_instruktur', $request->id_instruktur],
            ['hari', $request->hari],
            ['sesi_kelas','>', Carbon::parse($request->sesi_kelas)->subHour()->format('H:i')],
            ['sesi_kelas','<', Carbon::parse($request->sesi_kelas)->addHour()->format('H:i')]
        ])->count();
        

        if($jadwalInstruktur > 0){
            return response()->json([
                'id_instruktur'=> ['Jadwal instruktur bertabrakan dengan jadwal yang sudah ada']
            ], 422);
        }

        if (!$jadwal) {
            return response()->json([
                'success' => false,
                'message' => 'Data Jadwal not found'
            ], 404);
        }

        // id instruktur ketemu maka akan update
        if($jadwal){
            $jadwal->update([
                'id_kelas' => $request->id_kelas,
                'id_instruktur' => $request->id_instruktur,
                'hari' => $request->hari,
                'sesi_kelas' => $request->sesi_kelas
            ]);
            return new JadwalUmumResource(true, 'Data Jadwal Berhasil di Update!', $jadwal);
        }
            return response()->json([
                'success' => false,
                'message' => 'Post not found'
            ], 404);
    }

    public function destroy($id)
    {
        $jadwal = jadwal_umum::where('id', $id)->first();
        if(jadwal_umum::where('id', $id)->first()->delete()){
           return response()->json([
                'success' => true,
                'message' => 'Jadwal deleted',
                'data' =>$jadwal
            ], 200);
        }
        return new JadwalUmumResource(true, 'Data Jadwal Berhasil di Delete!', null);
    }
}
