<?php

namespace App\Http\Controllers;

use App\Models\instruktur;  
use App\Models\jadwal_harian; 
use App\Models\izin;  
use Illuminate\Http\Request;
use App\Http\Resources\IzinResource;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class IzinController extends Controller
{
    public function index()
    {
        //get posts
        $izin = izin::all();
        foreach ($izin as $index => $instruktur) {
            $izin[$index]->instruktur = instruktur::find($instruktur->id_instruktur);
        }

        foreach ($izin as $index => $jadwal_harian) {
            $izin[$index]->jadwal_harian = jadwal_harian::find($jadwal_harian->id_jadwal_harian);
        }
        
        return new IzinResource(true, 'list Data Izin', $izin);
    }

    
     /**
     * show
     *
     * @param  mixed $post
     * @return void
     */
    public function show($id)
    {
        $izin = izin::where('id', $id)->first();
        if($izin){
            return response()->json([
                'status' => 'success',
                'message' => 'Data Izin Ditampilkan',
                'data' => $izin
            ], 200);

            return new IzinResource(true, 'Data Post Ditemukan!',$izin);
        } else{
            return response()->json([
                'status' => 'false',
                'message' => 'Data Jadwal tidak ada',
                'data' => $izin
            ], 200);
        }
        
    }

     /**
      * create
      *
      * @return void
      */
      public function create()
      {
         return view('izin.create');
      }


    public function store(Request $request){
        //Validasi Formulir
        $validator = Validator::make($request->all(), [
            'id_instruktur' => 'required',
            'id_jadwal_harian'    => 'required',
            'keterangan'  => 'required'
        ]);

        if( $validator->fails()){
            return response()->json($validator->errors(), 422);
        }
        
        $tanggalSekarang = Carbon::now();
        //Fungsi Menambah Data ke dalam Database
        $izin = izin::create([
            'id_instruktur' => $request->id_instruktur,
            'id_jadwal_harian' => $request->id_jadwal_harian,
            'tanggal_buat' => $tanggalSekarang,
            'keterangan'  => $request->keterangan, 
            'status'  => '', 
            'tanggal_konfirmasi'  => 0, 
        ]);
        
        return new IzinResource(true, 'Data Izin Instruktur Berhasil Ditambahkan', $izin);
    }

     /**
      * store
      *
      * @param Request $request
      * @return void
     */
    public function update(Request $request, $id){
    $izin = izin::find($id);
    
    if (!$izin) {
        return response()->json([
            'success' => false,
            'message' => 'Data Izin not found'
        ], 404);
    }
   
    $izin->update([
        'id_jadwal_harian' => $request->id_jadwal_harian,
        'status' => $request->status,
        'tanggal_konfirmasi' =>  Carbon::now()
    ]);
    jadwal_harian::where('id', $request->id_jadwal_harian)->update(['status' =>  $request->status]);

    return new IzinResource(true, 'Data Izin Berhasil di Update!', $izin);
    
        return response()->json([
            'success' => false,
            'message' => 'Post not found'
        ], 404);
    }

}
