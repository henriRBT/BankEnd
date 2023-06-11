<?php

namespace App\Http\Controllers;

use App\Models\instruktur;
use App\Models\jadwal_harian;    
use Illuminate\Http\Request;
use App\Http\Resources\InstrukturResource;
use Illuminate\Support\Facades\Validator;
use PDF;
class InstrukturController extends Controller
{
    /**
    * index
    *
    * @return void
    */
    public function index()
    {
        //get posts
        $instruktur = instruktur::all();
        return new InstrukturResource(true, 'list Data Instruktur', $instruktur);
    }

       /**
      * create
      *
      * @return void
      */
      public function create()
      {
         return view('instruktur.create');
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
        'nama_instruktur' => 'required|',
        'alamat_instruktur'    => 'required',
        'no_telepon'  => 'required',
        'tanggal_lahir'  => 'required',
        'email'  => 'required',
        'username'  => 'required|unique:instrukturs'
    ]);

    if( $validator->fails()){
        return response()->json($validator->errors(), 422);
    }

    // untuk bcrypty password di database
     $password= bcrypt('password');
  
    //Fungsi Menambah Data ke dalam Database
    $instruktur = instruktur::create([
        'nama_instruktur' => $request->nama_instruktur,
        'alamat_instruktur' => $request->alamat_instruktur,
        'no_telepon'  => $request->no_telepon, 
        'tanggal_lahir'  => $request->tanggal_lahir, 
        'email'  => $request->email, 
        'username'  => $request->username, 
        'password'  =>  $password
    ]);

        return new InstrukturResource(true, 'Data Instruktur Berhasil Ditambahkan', $instruktur);
    }

    /**
     * show
     *
     * @param  mixed $post
     * @return void
     */
    public function show(instruktur $instruktur)
    {
        return new InstrukturResource(true, 'Data Post Ditemukan!', $instruktur);
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
            'nama_instruktur' => 'required',
            'alamat_instruktur'    => 'required',
            'no_telepon'  => 'required',
            'tanggal_lahir'  => 'required'

        ]);

    if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
    }

    // mencari id instruktur ada atau tidak 
    $instruktur = instruktur::find($id);
    if (!$instruktur) {
        return response()->json([
            'success' => false,
            'message' => 'Data Instruktur not found'
        ], 404);
    }

    // id instruktur ketemu maka akan update
    if($instruktur){
        $instruktur->update([
            'nama_instruktur' => $request->nama_instruktur,
            'alamat_instruktur' => $request->alamat_instruktur,
            'no_telepon'  => $request->no_telepon, 
            'tanggal_lahir'  => $request->tanggal_lahir, 
           
        ]);
        return new InstrukturResource(true, 'Data Instruktur Berhasil di Update!', $instruktur);
     }
        return response()->json([
            'success' => false,
            'message' => 'Post not found'
        ], 404);
    }

    public function destroy(instruktur $instruktur)
    {
        if($instruktur) {
            $instruktur->delete();
   
            return response()->json([
               'success' => true,
               'message' => 'Instruktur deleted'
               ], 200);
         }
   
        return new InstrukturResource(true, 'Data Instruktur Berhasil di Delete!', null);
    }
}
