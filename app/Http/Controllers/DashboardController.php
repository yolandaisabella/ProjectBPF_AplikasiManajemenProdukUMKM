<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $role = Auth::user()->role;
            if ($role === 'admin') {
                return view('admin.dashboard', [
                    'totalProducts' => Item::count(),
                    'totalCategories' => Category::count(),
                    'totalUsers' => User::count(),
                    'lowStockProducts' => Item::where('stock', '<', 10)->count(),
                    'featuredProducts' => Item::with('category')->take(6)->get(),
                ]);
            } elseif ($role === 'staff') {
                return view('staff.dashboard', [
                    'totalProducts' => Item::count(),
                    'lowStockProducts' => Item::where('stock', '<', 10)->count(),
                    'featuredProducts' => Item::with('category')->take(6)->get(),
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
        $totalProducts = Item::count();
        $totalCategories = Category::count();
        $totalUsers = User::count();
        $lowStockProducts = Item::where('stock', '<', 10)->count();

        return view('admin.reports', compact('totalProducts', 'totalCategories', 'totalUsers', 'lowStockProducts'));
    }

    private function guestDashboard()
    {
        $featuredProducts = Item::with('category')->take(6)->get();
        return view('guest.dashboard', compact('featuredProducts'));
    }
}
