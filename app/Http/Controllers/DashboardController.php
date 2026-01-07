<?php

namespace App\Http\Controllers;


use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $role = Auth::user()->role;
            if ($role === 'admin') {
                return view('admin.dashboard', [
                    'totalProducts' => Product::count(),
                    'totalUsers' => User::count(),
                    'lowStockProducts' => Product::where('stock', '<', 10)->count(),
                    'featuredProducts' => Product::orderBy('created_at', 'desc')->take(6)->get(),
                    'latestProduct' => Product::latest()->first(),
                ]);
            } elseif ($role === 'staff') {
                return view('staff.dashboard', [
                    'totalProducts' => Product::count(),
                    'lowStockProducts' => Product::where('stock', '<', 10)->count(),
                    'featuredProducts' => Product::orderBy('created_at', 'desc')->take(6)->get(),
                    'latestProduct' => Product::latest()->first(),
                ]);
            } elseif ($role === 'guest') {
                return $this->guestDashboard();
            }
        } else {
            // Public access for guest dashboard
            return $this->guestDashboard();
        }
    }

    public function reports()
    {
        $totalProducts = Product::count();

        $totalUsers = User::count();
        $lowStockProducts = Product::where('stock', '<', 10)->count();

        return view('admin.reports', compact('totalProducts', 'totalUsers', 'lowStockProducts'));
    }

    private function guestDashboard()
    {
        $featuredProducts = Product::take(6)->get();
        return view('guest.dashboard', compact('featuredProducts'));
    }
}
