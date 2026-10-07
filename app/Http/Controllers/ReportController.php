<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Vendor;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $data = $this->getReportData($request);
        return view('admin.reports.index', $data);
    }

    public function exportPdf(Request $request)
    {
        $data = $this->getReportData($request);
        $pdf = Pdf::loadView('admin.reports.pdf', $data)->setPaper('a4', 'portrait');
        return $pdf->download('fashion-hub-report-' . now()->format('Y-m-d') . '.pdf');
    }

    private function getReportData(Request $request): array
    {
        $dateFrom = $request->date_from;
        $dateTo = $request->date_to;

        $startDate = $dateFrom ? Carbon::parse($dateFrom)->startOfDay() : null;
        $endDate = $dateTo ? Carbon::parse($dateTo)->endOfDay() : null;
        $cacheKey = 'reports:' . ($startDate?->toDateString() ?? 'all') . ':' . ($endDate?->toDateString() ?? 'all');

        return Cache::remember($cacheKey, 300, function () use ($dateFrom, $dateTo, $startDate, $endDate) {

            $applyDateFilter = function ($query) use ($startDate, $endDate) {
                if ($startDate && $endDate) {
                    $query->whereBetween('created_at', [$startDate, $endDate]);
                } elseif ($startDate) {
                    $query->where('created_at', '>=', $startDate);
                } elseif ($endDate) {
                    $query->where('created_at', '<=', $endDate);
                }
            };

            $overview = Order::query()->tap($applyDateFilter)->selectRaw("
                COUNT(*) as total_orders,
                SUM(status = 'pending') as pending_orders,
                SUM(status = 'completed') as completed_orders,
                SUM(status = 'cancelled') as cancelled_orders,
                COALESCE(SUM(CASE WHEN status = 'completed' THEN total ELSE 0 END), 0) as total_revenue
            ")->first();

            $totalOrders = $overview->total_orders ?? 0;

            $catalogStats = Cache::remember('reports:catalog_stats', 3600, fn() => [
                'customers' => User::where('role', 'user')->count(),
                'products' => Product::count(),
                'categories' => Category::count(),
                'vendors' => Vendor::count(),
            ]);

            $orderTrends = Order::query()->tap($applyDateFilter)
                ->selectRaw("DATE(created_at) as date, COUNT(*) as total_orders, SUM(status='pending') as pending, SUM(status='completed') as completed, SUM(status='cancelled') as cancelled")
                ->groupByRaw('DATE(created_at)')->orderBy('date')
                ->get()->map(fn($r) => tap($r, fn($x) => $x->formatted_date = Carbon::parse($x->date)->format('d M Y')));

            $completedQuery = Order::where('status', 'completed')->tap($applyDateFilter);

            $dailySales = (clone $completedQuery)
                ->selectRaw('DATE(created_at) as date, SUM(total) as total, COUNT(*) as orders')
                ->groupByRaw('DATE(created_at)')->orderBy('date')
                ->get()->map(function ($r) {
                    $r->formatted_date = Carbon::parse($r->date)->format('d M Y');
                    $r->total_formatted = number_format($r->total, 2);
                    return $r;
                });

            $monthlySales = (clone $completedQuery)
                ->selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, SUM(total) as total, COUNT(*) as orders')
                ->groupByRaw('YEAR(created_at), MONTH(created_at)')->orderByRaw('year, month')
                ->get()->map(function ($r) {
                    $r->formatted_date = Carbon::create($r->year, $r->month, 1)->format('F Y');
                    $r->total_formatted = number_format($r->total, 2);
                    return $r;
                });

            $yearlySales = (clone $completedQuery)
                ->selectRaw('YEAR(created_at) as year, SUM(total) as total, COUNT(*) as orders')
                ->groupByRaw('YEAR(created_at)')->orderBy('year')
                ->get()->map(function ($r) {
                    $r->formatted_date = (string)$r->year;
                    $r->total_formatted = number_format($r->total, 2);
                    return $r;
                });

            $lowStockProducts = Product::where('stock', '<=', 5)->select('id', 'name', 'stock')->orderBy('stock')->limit(20)->get();
            $lowStockCount = Product::where('stock', '<=', 5)->count();

            $productPerformance = Product::select('products.id', 'products.name', 'products.price', 'products.stock')
                ->selectRaw('COALESCE(SUM(order_items.quantity),0) as total_sold')
                ->leftJoin('order_items', 'order_items.product_id', '=', 'products.id')
                ->leftJoin('orders', function ($join) use ($startDate, $endDate) {
                    $join->on('orders.id', '=', 'order_items.order_id')->where('orders.status', 'completed');
                    if ($startDate && $endDate) $join->whereBetween('orders.created_at', [$startDate, $endDate]);
                    elseif ($startDate) $join->where('orders.created_at', '>=', $startDate);
                    elseif ($endDate) $join->where('orders.created_at', '<=', $endDate);
                })
                ->groupBy('products.id', 'products.name', 'products.price', 'products.stock')
                ->orderByDesc('total_sold')->limit(10)->get()
                ->map(fn($p) => tap($p, fn($x) => $x->price_formatted = number_format($x->price, 2)));

            $topCustomers = User::where('role', 'user')->select('id', 'name', 'email')
                ->withCount(['orders as orders_count' => fn($q) => $applyDateFilter($q)])
                ->having('orders_count', '>', 0)->orderByDesc('orders_count')->limit(10)->get();

            $customerOrders = User::where('role', 'user')->select('id', 'name', 'email')
                ->whereHas('orders', fn($q) => $applyDateFilter($q))
                ->withCount(['orders as orders_count' => fn($q) => $applyDateFilter($q)])
                ->with(['latestOrder' => fn($q) => $applyDateFilter($q->select('id', 'user_id', 'created_at'))])
                ->limit(10)->get();

            $recentOrders = Order::query()->tap($applyDateFilter)
                ->select('id', 'order_number', 'user_id', 'status', 'created_at')
                ->with('user:id,name,email')->latest()->limit(10)->get()
                ->map(fn($o) => (object)[
                    'order_number' => $o->order_number,
                    'user_name' => $o->user->name ?? 'Unknown',
                    'user_email' => $o->user->email ?? '',
                    'status_label' => ucfirst($o->status),
                    'status_color' => match ($o->status) {
                        'completed' => 'emerald',
                        'pending' => 'amber',
                        'cancelled' => 'rose',
                        default => 'stone'
                    },
                    'formatted_date' => $o->created_at->format('d M Y, h:i A'),
                ]);

            return [
                'dateFrom' => $dateFrom,
                'dateTo' => $dateTo,
                'totalOrders' => $totalOrders,
                'pendingOrders' => $overview->pending_orders ?? 0,
                'completedOrders' => $overview->completed_orders ?? 0,
                'cancelledOrders' => $overview->cancelled_orders ?? 0,
                'pendingPercentage' => $totalOrders ? round(($overview->pending_orders ?? 0) / $totalOrders * 100, 1) : 0,
                'completedPercentage' => $totalOrders ? round(($overview->completed_orders ?? 0) / $totalOrders * 100, 1) : 0,
                'cancelledPercentage' => $totalOrders ? round(($overview->cancelled_orders ?? 0) / $totalOrders * 100, 1) : 0,
                'totalRevenue' => $overview->total_revenue ?? 0,
                'totalCustomers' => $catalogStats['customers'],
                'totalProducts' => $catalogStats['products'],
                'totalCategories' => $catalogStats['categories'],
                'totalVendors' => $catalogStats['vendors'],
                'orderTrends' => $orderTrends,
                'dailySales' => $dailySales,
                'monthlySales' => $monthlySales,
                'yearlySales' => $yearlySales,
                'lowStockProducts' => $lowStockProducts,
                'lowStockCount' => $lowStockCount,
                'productPerformance' => $productPerformance,
                'topCustomers' => $topCustomers,
                'customerOrders' => $customerOrders,
                'recentOrders' => $recentOrders,
            ];
        });
    }
}
