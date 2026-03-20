<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\PointTransaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class AdminReportController extends Controller
{
    private function resolveRange(Request $request): array
    {
        $range = $request->get('range', '30d');
        $startDateInput = $request->get('start_date');
        $endDateInput   = $request->get('end_date');

        $end   = now();
        $start = now()->subDays(29)->startOfDay();
        $label = 'Last 30 Days';

        switch ($range) {
            case 'today':
                $start = now()->startOfDay();
                $end   = now()->endOfDay();
                $label = 'Today';
                break;

            case '7d':
                $start = now()->subDays(6)->startOfDay();
                $end   = now()->endOfDay();
                $label = 'Last 7 Days';
                break;

            case '30d':
                $start = now()->subDays(29)->startOfDay();
                $end   = now()->endOfDay();
                $label = 'Last 30 Days';
                break;

            case 'custom':
                if ($startDateInput && $endDateInput) {
                    $start = Carbon::parse($startDateInput)->startOfDay();
                    $end   = Carbon::parse($endDateInput)->endOfDay();
                    $label = $start->format('d M Y') . ' - ' . $end->format('d M Y');
                } else {
                    $range = '30d';
                }
                break;
        }

        return [$range, $start, $end, $label];
    }

    public function index(Request $request)
    {
        [$activeRange, $start, $end, $reportRangeLabel] = $this->resolveRange($request);

        $ordersQuery = Order::query()
            ->whereNotNull('created_at')
            ->whereBetween('created_at', [$start, $end]);

        $revenueOrdersQuery = (clone $ordersQuery)->revenue();

        $totalSales = (clone $revenueOrdersQuery)->sum('total');
        $totalOrders = (clone $ordersQuery)->count();

        $days = max($start->diffInDays($end) + 1, 1);
        $ordersPerDay = $days > 0 ? $totalOrders / $days : 0;

        $revenueOrdersCount = (clone $revenueOrdersQuery)->count();
        $averageOrderValue = $revenueOrdersCount > 0
            ? $totalSales / $revenueOrdersCount
            : 0;

        $newCustomers = User::query()
            ->where('is_admin', false)
            ->whereBetween('created_at', [$start, $end])
            ->count();

        $salesByStatusCollection = (clone $ordersQuery)
            ->selectRaw('status, COUNT(*) as orders, SUM(total) as total')
            ->groupBy('status')
            ->get();

        $statusTotalSales = (float) $salesByStatusCollection->sum('total');

        $salesByStatus = $salesByStatusCollection
            ->mapWithKeys(function ($row) {
                return [
                    $row->status => [
                        'orders' => (int) $row->orders,
                        'total'  => (float) $row->total,
                    ],
                ];
            })
            ->toArray();

        $salesByPaymentCollection = (clone $revenueOrdersQuery)
            ->selectRaw('payment_method_name as payment_method, COUNT(*) as orders, SUM(total) as total')
            ->groupBy('payment_method_name')
            ->get();

        $salesByPayment = $salesByPaymentCollection
            ->mapWithKeys(function ($row) {
                return [
                    $row->payment_method ?? 'Unknown' => [
                        'orders' => (int) $row->orders,
                        'total'  => (float) $row->total,
                    ],
                ];
            })
            ->toArray();

        $topProducts = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->whereNotNull('orders.created_at')
            ->whereBetween('orders.created_at', [$start, $end])
            ->whereIn('orders.status', Order::REVENUE_STATUSES)
            ->selectRaw('products.name as name, SUM(order_items.qty) as qty, SUM(order_items.unit_price) as total')
            ->groupBy('products.name')
            ->orderByDesc('qty')
            ->limit(10)
            ->get()
            ->map(function ($row) {
                return [
                    'name'  => $row->name,
                    'qty'   => (int) $row->qty,
                    'total' => (float) $row->total,
                ];
            })
            ->toArray();

        return view('admin.reports.index', [
            'activeRange'        => $activeRange,
            'reportRangeLabel'   => $reportRangeLabel,
            'totalSales'         => $totalSales,
            'statusTotalSales'   => $statusTotalSales,
            'totalOrders'        => $totalOrders,
            'ordersPerDay'       => $ordersPerDay,
            'averageOrderValue'  => $averageOrderValue,
            'newCustomers'       => $newCustomers,
            'salesByStatus'      => $salesByStatus,
            'salesByPayment'     => $salesByPayment,
            'topProducts'        => $topProducts,
        ]);
    }

    public function export(Request $request)
    {
        [$range, $start, $end, $reportRangeLabel] = $this->resolveRange($request);

        $ordersQuery = Order::query()
            ->whereNotNull('created_at')
            ->whereBetween('created_at', [$start, $end]);

        $revenueOrdersQuery = (clone $ordersQuery)->revenue();

        $rawDaily = (clone $revenueOrdersQuery)
            ->selectRaw('DATE(created_at) as date, COUNT(*) as orders, SUM(total) as total')
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date')
            ->get()
            ->keyBy('date');

        $period = CarbonPeriod::create(
            $start->copy()->startOfDay(),
            $end->copy()->startOfDay()
        );

        $dailyStats = [];

        foreach ($period as $date) {
            $key = $date->format('Y-m-d');
            $row = $rawDaily->get($key);

            $ordersCount = $row ? (int) $row->orders : 0;
            $totalSales  = $row ? (float) $row->total : 0.0;
            $avgOrder    = $ordersCount > 0 ? $totalSales / $ordersCount : 0.0;

            $dailyStats[] = [
                'date'        => $key,
                'orders'      => $ordersCount,
                'total_sales' => $totalSales,
                'avg_order'   => $avgOrder,
            ];
        }

        $filename = 'daily_sales_' . now()->format('Ymd_His') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($dailyStats, $reportRangeLabel) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, ['Daily Sales Report (Revenue Only)', $reportRangeLabel]);
            fputcsv($handle, []);

            fputcsv($handle, ['Date', 'Orders', 'Total Sales', 'Average Order Value']);

            foreach ($dailyStats as $day) {
                fputcsv($handle, [
                    $day['date'],
                    $day['orders'],
                    number_format($day['total_sales'], 2, '.', ''),
                    number_format($day['avg_order'], 2, '.', ''),
                ]);
            }

            fclose($handle);
        };

        return response()->streamDownload($callback, $filename, $headers);
    }

    public function exportOrderReferralRewardsReport(Request $request)
    {
        [$range, $start, $end, $reportRangeLabel] = $this->resolveRange($request);

        $mode = $request->get('mode', 'daily'); // daily / monthly

        $orders = Order::query()
            ->with(['user'])
            ->revenue() // ✅ 关键！！
            ->whereBetween('created_at', [$start, $end])
            ->latest('created_at')
            ->get();

        $orderIds = $orders->pluck('id')->filter()->values();

        $purchasePointsByOrder = PointTransaction::query()
            ->selectRaw('order_id, SUM(points) as total_points')
            ->whereIn('order_id', $orderIds)
            ->where('type', 'earn')
            ->where('source', 'purchase')
            ->groupBy('order_id')
            ->pluck('total_points', 'order_id');

        $filename = 'order_rewards_report_' . now()->format('Ymd_His') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($orders, $purchasePointsByOrder, $reportRangeLabel, $mode) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, ['Order Rewards Report', $reportRangeLabel, strtoupper($mode)]);
            fputcsv($handle, []);

            if ($mode === 'monthly') {
                fputcsv($handle, [
                    'Month',
                    'Total Orders',
                    'Total Subtotal (RM)',
                    'Total Shipping Fee (RM)',
                    'Total Sales (RM)',
                    'Total Voucher Discount (RM)',
                    'Total Shipping Discount (RM)',
                    'Total Points Redeemed',
                    'Total Points Discount (RM)',
                    'Total Purchase Points Earned',
                    'Total Purchase Points Cost (RM)',
                    'Net Amount (RM)',
                ]);

                $grouped = $orders->groupBy(function ($order) {
                    return optional($order->created_at)->format('Y-m');
                });

                foreach ($grouped as $month => $items) {
                    $totalOrders = $items->count();

                    $totalSubtotal = (float) $items->sum(fn($order) => (float) $order->subtotal);
                    $totalShippingFee = (float) $items->sum(fn($order) => (float) $order->shipping_fee);
                    $totalSales = (float) $items->sum(fn($order) => (float) $order->total);
                    $totalVoucherDiscount = (float) $items->sum(fn($order) => (float) ($order->voucher_discount ?? 0));
                    $totalShippingDiscount = (float) $items->sum(fn($order) => (float) ($order->shipping_discount ?? 0));
                    $totalPointsRedeemed = (int) $items->sum(fn($order) => (int) ($order->points_redeem ?? 0));
                    $totalPointsDiscount = (float) $items->sum(fn($order) => (float) ($order->points_discount ?? 0));

                    $totalPurchasePointsEarned = (int) $items->sum(function ($order) use ($purchasePointsByOrder) {
                        return (int) ($purchasePointsByOrder[$order->id] ?? 0);
                    });

                    // 规则：100 points = RM1
                    $totalPurchasePointsCost = (float) ($totalPurchasePointsEarned / 100);

                    // total 已经扣了 points_discount，所以这里只再扣 purchase reward cost
                    $netAmount = $totalSales - $totalPurchasePointsCost;

                    fputcsv($handle, [
                        $month,
                        $totalOrders,
                        number_format($totalSubtotal, 2, '.', ''),
                        number_format($totalShippingFee, 2, '.', ''),
                        number_format($totalSales, 2, '.', ''),
                        number_format($totalVoucherDiscount, 2, '.', ''),
                        number_format($totalShippingDiscount, 2, '.', ''),
                        $totalPointsRedeemed,
                        number_format($totalPointsDiscount, 2, '.', ''),
                        $totalPurchasePointsEarned,
                        number_format($totalPurchasePointsCost, 2, '.', ''),
                        number_format($netAmount, 2, '.', ''),
                    ]);
                }
            } else {
                fputcsv($handle, [
                    'Order Date',
                    'Order No',
                    'Customer Name',
                    'Customer Email',
                    'Customer Phone',
                    'Order Status',
                    'Payment Method',
                    'Subtotal (RM)',
                    'Shipping Fee (RM)',
                    'Voucher Discount (RM)',
                    'Shipping Discount (RM)',
                    'Total (RM)',
                    'Points Redeemed',
                    'Points Discount (RM)',
                    'Purchase Points Earned',
                    'Purchase Points Cost (RM)',
                    'Net Amount (RM)',
                ]);

                foreach ($orders as $order) {
                    $purchaseEarnedPoints = (int) ($purchasePointsByOrder[$order->id] ?? 0);

                    // 规则：100 points = RM1
                    $purchasePointsCost = (float) ($purchaseEarnedPoints / 100);

                    // total 已经扣掉 points_discount，所以不再重复扣 redeem
                    $netAmount = (float) $order->total - $purchasePointsCost;

                    fputcsv($handle, [
                        optional($order->created_at)->format('Y-m-d H:i:s'),
                        $order->order_no,
                        $order->customer_name,
                        $order->customer_email,
                        $order->customer_phone,
                        $order->status,
                        $order->payment_method_name,
                        number_format((float) $order->subtotal, 2, '.', ''),
                        number_format((float) $order->shipping_fee, 2, '.', ''),
                        number_format((float) ($order->voucher_discount ?? 0), 2, '.', ''),
                        number_format((float) ($order->shipping_discount ?? 0), 2, '.', ''),
                        number_format((float) $order->total, 2, '.', ''),
                        (int) ($order->points_redeem ?? 0),
                        number_format((float) ($order->points_discount ?? 0), 2, '.', ''),
                        $purchaseEarnedPoints,
                        number_format($purchasePointsCost, 2, '.', ''),
                        number_format($netAmount, 2, '.', ''),
                    ]);
                }
            }

            fclose($handle);
        };

        return response()->streamDownload($callback, $filename, $headers);
    }
}
