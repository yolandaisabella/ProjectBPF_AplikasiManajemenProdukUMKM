<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get dashboard statistics
        $totalProducts = Product::count();
        $lowStockProducts = Product::where('stock', '<', 10)->count();
        $totalCategories = Product::distinct('category')->count('category');
        $totalValue = Product::sum(DB::raw('price * stock'));

        // Get recent products (last 5)
        $recentProducts = Product::orderBy('created_at', 'desc')->take(5)->get();

        return view('admin.dashboard', compact(
            'totalProducts',
            'lowStockProducts',
            'totalCategories',
            'totalValue',
            'recentProducts'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
