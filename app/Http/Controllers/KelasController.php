<?php

namespace App\Http\Controllers;

use App\Models\kelas;  
use Illuminate\Http\Request;
use App\Http\Resources\KelasResource;
use Illuminate\Support\Facades\Validator;

class KelasController extends Controller
{
    /**
    * index
    *
    * @return void
    */
    public function index()
    {
        //get posts
        $kelas = kelas::all();
        return new KelasResource(true, 'list Data Kelas', $kelas);
    }

    /**
     * show
     *
     * @param  mixed $post
     * @return void
     */
    public function show(kelas $kelas)
    {
    
    return new KelasResource(true, 'Data Post Ditemukan!', $kelas);
    
    }
}
