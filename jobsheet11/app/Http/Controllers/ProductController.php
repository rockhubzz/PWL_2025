<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function foodBeverage() { return view('categories.food-beverage'); }
    public function beautyHealth() { return view('categories.beauty-health'); }
    public function homeCare() { return view('categories.home-care'); }
    public function babyKid() { return view('categories.baby-kid'); }
}
