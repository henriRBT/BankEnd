<?php

namespace App\Http\Controllers;

use App\Models\instruktur;  
use App\Models\jadwal_harian;  
use App\Models\jadwal_umum;  
use App\Models\kelas;  
use Illuminate\Http\Request;
use App\Http\Resources\JadwalHarianResource;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Response;

class JadwalHarianController extends Controller
{
    /**
    * index
    *
    * @return void
    */
    public function index()
    {
        //get posts
        $today = Carbon::now()->startOfWeek();
        $harian = jadwal_harian::all()->where('tanggal', '>=', $today->format('d-m-Y'));
        // $harian = jadwal_harian::where('tanggal','>=', $today->format('d-m-Y'))->paginate($request->page);
        
        foreach ($harian as $index => $instruktur) {
            $harian[$index]->instruktur = instruktur::find($instruktur->id_instruktur);
        }
        foreach ($harian as $index => $kelas) {
            $harian[$index]->kelas = kelas::find($kelas->id_kelas);
        }
        return new JadwalHarianResource(true, 'list Data Jadwal Kelas Harian', $harian);
        
    }

    /**
     * show
     *
     * @param  mixed $post
     * @return void
     */
    public function show($id)
    {
        $harian = jadwal_harian::where('id', $id)->first();
        if($harian){
            return response()->json([
                'status' => 'success',
                'message' => 'Data Jadwal Berhasil Ditampilkan',
                'data' => $harian
            ], 200);

            return new JadwalHarianResource(true, 'Data Post Ditemukan!', $harian);
        } else{
            return response()->json([
                'status' => 'false',
                'message' => 'Data Jadwal tidak ada',
                'data' => $harian
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
        //Validasi Formulir
        $validator = Validator::make($request->all(), [
            'id_kelas' => 'required',
            'id_instruktur' => 'required',
            'sesi_kelas'=> 'required',
            'status'=> 'required', 
        ]);

    if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
    }
    
    // mencari jadwal umum dan mendapatkan id instruktur
    $harian = jadwal_harian::find($id);
    
    if (!$harian) {
        return response()->json([
            'success' => false,
            'message' => 'Data Jadwal not found'
        ], 404);
    }
   
    // id instruktur ketemu maka akan update
    if($harian){
        $harian->update([
            'status' => $request->status
        ]);
        return new JadwalHarianResource(true, 'Data Jadwal Berhasil di Update!', $harian);
     }
        return response()->json([
            'success' => false,
            'message' => 'Post not found'
        ], 404);
    }

    public function generateJadwal()
    {
        $jadwalHarian = jadwal_harian::where('tanggal', '>', 
        Carbon::now()->startOfWeek(Carbon::SUNDAY)->format('Y-m-d'))
            ->first();

        if(is_null($jadwalHarian)){
            $jadwalumum = jadwal_umum::class;
            $jadwal = $jadwalumum::select("*") 
            ->each(function($jadwal){
                $jadwalHarian = $jadwal->replicate();
                $jadwalHarian->tanggal = Carbon::parse('next week ' .$jadwal->hari);
                $jadwalHarian->setTable('jadwal_harians');
                $jadwalHarian->save();
            });
            return response()->json([
                'success' => true,
                'message' => 'Data Digenerate',
                'generate' => true
            ]);
        
        } else{
            return ([
                'success' => false,
                'message' => 'Data Sudah generate',
                'generate' => false
            ]);
        }

    }
}
