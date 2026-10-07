<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Fashion Hub Report</title>

    <style>
        @page {
            margin: 0;
            background-color: #0c0a09;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #ffffff;
            background-color: #0c0a09;
            margin: 0;
            padding: 25px;
        }

        .header {
            text-align: center;
            margin-bottom: 25px;
            padding: 20px;
            background-color: #1c1917;
            border: 1px solid #292524;
            border-radius: 8px;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #fbbf24;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .header h2 {
            margin: 5px 0 10px 0;
            font-size: 14px;
            color: #ffffff;
            font-weight: normal;
        }

        .header p {
            margin: 3px 0;
            color: #a8a29e;
            font-size: 10px;
        }

        .section {
            margin-top: 25px;
        }

        .section-title {
            font-size: 14px;
            font-weight: bold;
            color: #fbbf24;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 12px;
            border-bottom: 2px solid #fbbf24;
            padding-bottom: 4px;
        }

        h3 {
            font-size: 12px;
            color: #ffffff;
            margin-top: 15px;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .cards {
            width: 100%;
            margin-bottom: 15px;
        }

        .card {
            width: 22%;
            display: inline-block;
            vertical-align: top;
            background-color: #1c1917;
            border: 1px solid #292524;
            border-left: 3px solid #fbbf24;
            padding: 10px;
            margin-right: 1.5%;
            box-sizing: border-box;
            border-radius: 4px;
        }

        .card-title {
            font-size: 9px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #a8a29e;
            font-weight: bold;
        }

        .card-value {
            font-size: 16px;
            font-weight: bold;
            color: #ffffff;
            margin-top: 6px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: #1c1917;
        }

        th {
            background: #292524;
            color: #fbbf24;
            font-weight: bold;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: 1px solid #383532;
            padding: 8px;
        }

        td {
            border: 1px solid #292524;
            padding: 8px;
            text-align: left;
            color: #ffffff;
        }

        tr:nth-child(even) td {
            background-color: #141210;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .footer {
            margin-top: 40px;
            padding-top: 15px;
            border-top: 1px solid #292524;
            text-align: center;
            font-size: 9px;
            color: #78716c;
        }

        .no-data {
            text-align: center;
            color: #78716c;
            padding: 15px;
            font-style: italic;
        }
    </style>
</head>

<body>

    <div class="header">
        <h1>Fashion Hub</h1>
        <h2>Reports & Analytics</h2>

        @if ($dateFrom || $dateTo)
            <p>
                Report Period:
                {{ $dateFrom ? \Carbon\Carbon::parse($dateFrom)->format('d M Y') : 'Beginning' }}
                -
                {{ $dateTo ? \Carbon\Carbon::parse($dateTo)->format('d M Y') : 'Today' }}
            </p>
        @else
            <p>Complete Report</p>
        @endif

        <p>
            Generated: {{ now()->format('d M Y, h:i A') }}
        </p>
    </div>


    <div class="section">
        <div class="section-title">
            Overview
        </div>

        <div class="cards">
            <div class="card">
                <div class="card-title">Total Orders</div>
                <div class="card-value">{{ $totalOrders }}</div>
            </div>

            <div class="card">
                <div class="card-title">Total Sales</div>
                <div class="card-value">Rs. {{ number_format($totalRevenue, 2) }}</div>
            </div>

            <div class="card">
                <div class="card-title">Customers</div>
                <div class="card-value">{{ $totalCustomers }}</div>
            </div>

            <div class="card">
                <div class="card-title">Products</div>
                <div class="card-value">{{ $totalProducts }}</div>
            </div>
        </div>
    </div>


    <div class="section">
        <div class="section-title">
            Order Analytics
        </div>

        <div class="cards">
            <div class="card">
                <div class="card-title">Pending Orders</div>
                <div class="card-value">{{ $pendingOrders }}</div>
            </div>

            <div class="card">
                <div class="card-title">Completed Orders</div>
                <div class="card-value">{{ $completedOrders }}</div>
            </div>

            <div class="card">
                <div class="card-title">Cancelled Orders</div>
                <div class="card-value">{{ $cancelledOrders }}</div>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Total Orders</th>
                    <th>Pending</th>
                    <th>Completed</th>
                    <th>Cancelled</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orderTrends as $trend)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($trend->date)->format('d M Y') }}</td>
                        <td>{{ $trend->total_orders }}</td>
                        <td>{{ $trend->pending }}</td>
                        <td>{{ $trend->completed }}</td>
                        <td>{{ $trend->cancelled }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="no-data">No order data available.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>


    <div class="section">
        <div class="section-title">
            Sales Analytics
        </div>

        <h3>Daily Sales</h3>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Orders</th>
                    <th>Sales</th>
                </tr>
            </thead>
            <tbody>
                @forelse($dailySales as $sale)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($sale->date)->format('d M Y') }}</td>
                        <td>{{ $sale->orders }}</td>
                        <td>Rs. {{ number_format($sale->total, 2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="no-data">No daily sales data available.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <h3>Monthly Sales</h3>
        <table>
            <thead>
                <tr>
                    <th>Month</th>
                    <th>Orders</th>
                    <th>Sales</th>
                </tr>
            </thead>
            <tbody>
                @forelse($monthlySales as $sale)
                    <tr>
                        <td>{{ \Carbon\Carbon::create($sale->year, $sale->month, 1)->format('F Y') }}</td>
                        <td>{{ $sale->orders }}</td>
                        <td>Rs. {{ number_format($sale->total, 2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="no-data">No monthly sales data available.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <h3>Yearly Sales</h3>
        <table>
            <thead>
                <tr>
                    <th>Year</th>
                    <th>Orders</th>
                    <th>Sales</th>
                </tr>
            </thead>
            <tbody>
                @forelse($yearlySales as $sale)
                    <tr>
                        <td>{{ $sale->year }}</td>
                        <td>{{ $sale->orders }}</td>
                        <td>Rs. {{ number_format($sale->total, 2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="no-data">No yearly sales data available.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>


    <div class="section">
        <div class="section-title">
            Product Analytics
        </div>

        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Stock</th>
                </tr>
            </thead>
            <tbody>
                @forelse($productPerformance as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->stock }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="no-data">No product data available.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <h3>Low Stock Products</h3>
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Stock</th>
                </tr>
            </thead>
            <tbody>
                @forelse($lowStockProducts as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->stock }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="no-data">No low stock products.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="section">
        <div class="section-title">
            Customer Analytics
        </div>

        <h3>Top Customers</h3>
        <table>
            <thead>
                <tr>
                    <th>Customer</th>
                    <th>Email</th>
                    <th>Total Orders</th>
                </tr>
            </thead>
            <tbody>
                @forelse($topCustomers as $customer)
                    <tr>
                        <td>{{ $customer->name }}</td>
                        <td>{{ $customer->email }}</td>
                        <td>{{ $customer->orders_count }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="no-data">No customer data available.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="section">
        <div class="section-title">
            Catalog Overview
        </div>

        <div class="cards">
            <div class="card">
                <div class="card-title">Products</div>
                <div class="card-value">{{ $totalProducts }}</div>
            </div>

            <div class="card">
                <div class="card-title">Categories</div>
                <div class="card-value">{{ $totalCategories }}</div>
            </div>

            <div class="card">
                <div class="card-title">Vendors</div>
                <div class="card-value">{{ $totalVendors }}</div>
            </div>
        </div>
    </div>

    <div class="section">
        <div class="section-title">
            Recent Orders
        </div>

        <table>
            <thead>
                <tr>
                    <th>Order</th>
                    <th>Customer</th>
                    <th>Status</th>
                    <th>Total</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentOrders as $order)
                    <tr>
                        <td>{{ $order->order_number }}</td>
                        <td>{{ $order->user->name ?? 'N/A' }}</td>
                        <td>{{ ucfirst($order->status) }}</td>
                        <td>Rs. {{ number_format($order->total_amount, 2) }}</td>
                        <td>{{ $order->created_at->format('d M Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="no-data">No recent orders available.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>


    <div class="footer">
        Fashion Hub Reports & Analytics
        <br>
        Generated on {{ now()->format('d M Y, h:i A') }}
    </div>

</body>

</html>
