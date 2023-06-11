<?php

namespace App\Http\Controllers\Api;

use App\Models\pegawai;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Sessions;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        $pegawai = pegawai::all();
        if(count($pegawai)>0){
            return response([
                'message' => 'Retrieve All Success',
                'data' => $pegawai
            ], 200);
        }


        return response([
            'message'=> 'Empty',
            'data' =>null
        ], 400);
       
    }

    public function login(Request $request){
        $loginData = $request->all();

        $validate = validator::make($loginData, [
            'username' => 'required',
            'password' => 'required'
        ]);

        if($validate->fails()){
            return response(['message' => $validate->errors()], 400);
        }

       
        $pegawai = pegawai::where('username', $request->username)->first(); 

        if (!$pegawai || !Hash::check($request->password, $pegawai->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Login Failed!',
            ]);
        }
       

        return response([
            'success' => true,
            'message' => 'Login Success!',
            'data'    => $pegawai,
            'token'   => $pegawai->createToken('authToken')->accessToken    
           
        ]);
    }

    
    public function logout(Request $request)
    {
        if ($request->user()) { 
            $request->user()->tokens()->delete();
        }

        return response()->json([
            'success' => true,
            'message' => 'Logout Success!',  
        ]);
       
    }
    public function show($id)
    {
        $pegawai = pegawai::find($id);
        
        if(!is_null($pegawai)){
            return response([
                'message'=> 'Retrieve User Success',
                'data' => $pegawai
            ],200);
        }
      

        return response([
            'message'=> 'User Not Found', 
            'data' => null
        ], 404);
    }

    public function showPegawai(pegawai $pegawai)
    {
        $pegawai = pegawai::all();
        return response()->json([
            'message' => 'List Data Pegawai',
            'data' => $pegawai
        ]);
    }
}
