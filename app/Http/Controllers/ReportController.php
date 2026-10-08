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
                COALESCE(
                    SUM(
                        CASE
                            WHEN status = 'completed'
                            THEN total
                            ELSE 0
                        END
                    ),
                    0
                ) as total_revenue
            ")->first();

        $totalOrders = $overview->total_orders ?? 0;

        $totalCustomers = User::where('role', 'user')->count();
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $totalVendors = Vendor::count();

        $orderTrends = Order::query()->tap($applyDateFilter)->selectRaw("
                DATE(created_at) as date,
                COUNT(*) as total_orders,
                SUM(status = 'pending') as pending,
                SUM(status = 'completed') as completed,
                SUM(status = 'cancelled') as cancelled
            ")
            ->groupByRaw('DATE(created_at)')
            ->orderBy('date')
            ->get()
            ->map(function ($r) {
                $r->formatted_date = Carbon::parse(
                    $r->date
                )->format('d M Y');

                return $r;
            });

        $completedQuery = Order::where('status', 'completed')->tap($applyDateFilter);

        $dailySales = (clone $completedQuery)->selectRaw("
                DATE(created_at) as date,
                SUM(total) as total,
                COUNT(*) as orders
            ")
            ->groupByRaw('DATE(created_at)')
            ->orderBy('date')
            ->get()
            ->map(function ($r) {
                $r->formatted_date = Carbon::parse(
                    $r->date
                )->format('d M Y');

                $r->total_formatted = number_format(
                    $r->total,
                    2
                );

                return $r;
            });

        $monthlySales = (clone $completedQuery)->selectRaw("
                YEAR(created_at) as year,
                MONTH(created_at) as month,
                SUM(total) as total,
                COUNT(*) as orders
            ")->groupByRaw(
            'YEAR(created_at), MONTH(created_at)'
        )->orderByRaw(
            'year, month'
        )->get()->map(function ($r) {

            $r->formatted_date = Carbon::create(
                $r->year,
                $r->month,
                1
            )->format('F Y');

            $r->total_formatted = number_format(
                $r->total,
                2
            );

            return $r;
        });

        $yearlySales = (clone $completedQuery)->selectRaw("
                YEAR(created_at) as year,
                SUM(total) as total,
                COUNT(*) as orders
            ")
            ->groupByRaw(
                'YEAR(created_at)'
            )
            ->orderBy('year')
            ->get()
            ->map(function ($r) {

                $r->formatted_date = (string) $r->year;
                $r->total_formatted = number_format(
                    $r->total,
                    2
                );

                return $r;
            });

        $lowStockProducts = Product::where('stock', '<=', 5)->select('id', 'name', 'stock')->orderBy('stock')->paginate(5, ['*'], 'low_stock_page')->withQueryString();
        $lowStockCount = Product::where('stock', '<=', 5)->count();

        $productPerformance = Product::select('products.id', 'products.name', 'products.price', 'products.stock')
            ->selectRaw('COALESCE(SUM(order_items.quantity), 0) as total_sold')
            ->leftJoin('order_items', 'order_items.product_id', '=', 'products.id')
            ->leftJoin(
                'orders',
                function ($join) use (
                    $startDate,
                    $endDate
                ) {

                    $join->on('orders.id', '=', 'order_items.order_id')->where('orders.status', 'completed');

                    if ($startDate && $endDate) {

                        $join->whereBetween('orders.created_at', [$startDate, $endDate]);
                    } elseif ($startDate) {

                        $join->where('orders.created_at', '>=', $startDate);
                    } elseif ($endDate) {

                        $join->where('orders.created_at', '<=', $endDate);
                    }
                }
            )
            ->groupBy('products.id', 'products.name', 'products.price', 'products.stock')
            ->orderByDesc('total_sold')
            ->paginate(5, ['*'], 'products_page')->withQueryString();

        $productPerformance->getCollection()->transform(function ($p) {
            $p->price_formatted = number_format(
                $p->price,
                2
            );

            return $p;
        });

        $topCustomers = User::where('role', 'user')->select('id', 'name', 'email')
            ->withCount([
                'orders as orders_count' => function ($q) use (
                    $applyDateFilter
                ) {
                    $applyDateFilter($q);
                }
            ])->having('orders_count', '>', 0)->orderByDesc('orders_count')->paginate(5, ['*'], 'customers_page')->withQueryString();

        $customerOrders = User::where('role', 'user')->select('id', 'name', 'email')
            ->whereHas(
                'orders',
                function ($q) use (
                    $applyDateFilter
                ) {
                    $applyDateFilter($q);
                }
            )->withCount([
                'orders as orders_count' => function ($q) use (
                    $applyDateFilter
                ) {
                    $applyDateFilter($q);
                }
            ])->with([
                'latestOrder' => function ($q) use (
                    $dateFrom,
                    $dateTo
                ) {

                    $q->select(['orders.id', 'orders.user_id', 'orders.created_at']);

                    if ($dateFrom) {
                        $q->whereDate('orders.created_at', '>=', $dateFrom);
                    }

                    if ($dateTo) {
                        $q->whereDate('orders.created_at', '<=', $dateTo);
                    }
                }
            ])->orderByDesc('orders_count')->paginate(5, ['*'], 'customer_orders_page')->withQueryString();


        $recentOrders = Order::query()->tap($applyDateFilter)->select('id', 'order_number', 'user_id', 'status', 'created_at')->with('customer:id,name,email')->latest()->paginate(5, ['*'], 'recent_orders_page')->withQueryString();
        $recentOrders->getCollection()->transform(function ($order) {
            return (object) [
                'order_number' => $order->order_number,
                'user_name' => $order->customer?->name ?? 'Unknown',
                'user_email' => $order->customer?->email ?? '',
                'status_label' => ucfirst($order->status),
                'status_color' => match ($order->status) {
                    'completed' => 'emerald',
                    'pending' => 'amber',
                    'cancelled' => 'rose',
                    default => 'stone',
                },
                'formatted_date' => Carbon::parse($order->created_at)->format('d M Y, h:i A')
            ];
        });

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
            'totalCustomers' => $totalCustomers,
            'totalProducts' => $totalProducts,
            'totalCategories' => $totalCategories,
            'totalVendors' => $totalVendors,
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
    }
}
