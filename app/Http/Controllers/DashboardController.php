<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;

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
        $lowStockProducts = Product::where('stock', '>', 0)->where('stock', '<=', 5)->count();
        $outOfStockProducts = Product::where('stock', '<=', 0)->count();
        $products = Product::latest()->take(5)->get();
        $categories = Category::latest()->take(5)->get();
        $categoryData = Category::withCount('products')->orderByDesc('products_count')->get();
        $categoryNames = $categoryData->pluck('name')->values();
        $categoryProductCounts = $categoryData->pluck('products_count')->values();
        $healthyStockProducts = Product::where('stock', '>', 5)->count();

        return view('admin.dashboard', compact('totalProducts', 'activeProducts', 'inactiveProducts', 'lowStockProducts', 'outOfStockProducts', 'healthyStockProducts', 'products', 'categories', 'categoryNames', 'categoryProductCounts'));
    }
}
