<?php

namespace App\Http\Controllers;

use App\Models\promo;  
use Illuminate\Http\Request;
use App\Http\Resources\PromoResource;
use Illuminate\Support\Facades\Validator;

class PromoController extends Controller
{
    
    /**
    * index
    *
    * @return void
    */
    public function index()
    {
        //get posts
        $promo = promo::all();
        return new PromoResource(true, 'list Data Promo', $promo);
    }

    /**
     * show
     *
     * @param  mixed $post
     * @return void
     */
    public function show(promo $promo)
    {
    
    return new PromoResource(true, 'Data Post Ditemukan!', $promos);
    
    }
}
