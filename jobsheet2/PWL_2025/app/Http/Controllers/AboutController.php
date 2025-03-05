<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function about(){
        return nl2br("NIM: 2341720197\n
        Nama: Rocky Alessandro Kristanto");
    }

}
