<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;

class StaffController extends Controller
{
    public function users()
    {
        return view('guest.access_denied');
    }

    public function reports()
    {
        $totalProducts = Product::count();
        $totalUsers = User::count();
        $lowStockProducts = Product::where('stock', '<', 10)->count();

        return view('staff.reports', compact('totalProducts', 'totalUsers', 'lowStockProducts'));
    }
}
