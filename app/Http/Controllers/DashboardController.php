<?php

namespace App\Http\Controllers;

use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        $products = Product::latest()->paginate(8);

        return view('dashboard', compact('products'));
    }

    public function admin()
    {
        $totalProducts = Product::count();
        $activeProducts = Product::where('status', true)->count();
        $inactiveProducts = Product::where('status', false)->count();
        $lowStockProducts = Product::where('stock', '<=', 5)->count();
        $products = Product::latest()->take(5)->get();

        return view('admin.dashboard', compact('totalProducts', 'activeProducts', 'inactiveProducts', 'lowStockProducts', 'products'));
    }
}
