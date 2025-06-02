<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\UserModel;
use App\Models\PenjualanModel;
use App\Models\PenjualanDetailModel;
use App\Models\StokModel;


class WelcomeController extends Controller
{
    public function index(){
        $breadcrumb = (object)[
            'title' => 'Dashboard',
            'list' => ['Home', 'Welcome']
        ];

        $totalUsers = UserModel::count('user_id');
        $totalPenjualan = PenjualanModel::sum('total_penjualan');
        $topBarang = PenjualanDetailModel::topMostSoldBarang();
        $lowStockItems = StokModel::getLowestStockItems();
        $userCountsByRole = UserModel::select('level_id', DB::raw('count(*) as total'))
        ->with('level') // assuming relation is called 'level'
        ->groupBy('level_id')
        ->get();
    

        $activeMenu = 'dashboard';
        return view('welcome', [
            'breadcrumb' => $breadcrumb,
            'activeMenu' => $activeMenu,
            'totalUsers' => $totalUsers,
            'totalPenjualan' => $totalPenjualan,
            'topBarang' => $topBarang,
            'lowStockItems' => $lowStockItems,
            'userCountsByRole' => $userCountsByRole
            
        ]);
    }
}
