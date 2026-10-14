<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $products = Product::with('category')->where('status', true)->latest()->take(5)->get();
        $totalProducts = Product::where('status', true)->count();

        $categories = Category::withCount([
            'products' => function ($query) {
                $query->where('status', true);
            }
        ])->orderByDesc('products_count')->take(4)->get();

        $totalCategories = Category::whereHas('products', function ($query) {
            $query->where('status', true);
        })->count();

        $customerOrders = Order::where('user_id', $user->id);
        $totalOrders = (clone $customerOrders)->count();
        $totalSpent = (clone $customerOrders)->sum('total');
        $recentOrders = (clone $customerOrders)->latest()->take(3)->get();

        $monthlySpending = collect(range(2, 0))->map(
            function ($monthsAgo) use ($user) {

                $month = Carbon::now()->startOfMonth()->subMonths($monthsAgo);
                $start = $month->copy();
                $end = $month->copy()->endOfMonth();

                $total = Order::where('user_id', $user->id)->whereBetween('created_at', [$start, $end])->sum('total');

                return [
                    'month' => $month->format('M'),
                    'total' => (float) $total,
                ];
            }
        );

        return view('dashboard', compact('user', 'products', 'totalProducts', 'totalCategories', 'totalOrders', 'totalSpent', 'recentOrders', 'monthlySpending', 'categories'));
    }

    public function admin()
    {
        $totalProducts = Product::count();
        $activeProducts = Product::where('status', true)->count();
        $inactiveProducts = Product::where('status', false)->count();
        $lowStockProducts = Product::where('stock', '>', 0)->where('stock', '<=', 5)->count();
        $outOfStockProducts = Product::where('stock', '<=', 0)->count();
        $products = Product::latest()->take(3)->get();
        $categories = Category::latest()->take(3)->get();
        $categoryData = Category::withCount('products')->orderByDesc('products_count')->get();
        $categoryNames = $categoryData->pluck('name')->values();
        $categoryProductCounts = $categoryData->pluck('products_count')->values();
        $healthyStockProducts = Product::where('stock', '>', 5)->count();

        return view('admin.dashboard', compact('totalProducts', 'activeProducts', 'inactiveProducts', 'lowStockProducts', 'outOfStockProducts', 'healthyStockProducts', 'products', 'categories', 'categoryNames', 'categoryProductCounts'));
    }
}
