<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index(){
        return "Selamat Datang";
    }

    public function about(){
        return nl2br("NIM: 2341720197\n
        Nama: Rocky Alessandro Kristanto");
    }

    public function articles($id){
        return "Halaman Artikel dengan ID" . $id;
    }
}
