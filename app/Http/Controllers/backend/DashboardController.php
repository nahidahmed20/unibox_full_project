<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Expense;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // ================= SALES METRICS =================
        $todayOrderSales = Order::whereDate('created_at', today())
            ->whereIn('status', ['completed', 'delivered'])
            ->sum('total');

        $todayPosSales = Sale::whereDate('sale_date', today())->sum('grand_total');
        $todayTotalSales = (float) ($todayOrderSales + $todayPosSales);

        $thisMonthOrderSales = Order::whereMonth('created_at', today()->month)
            ->whereYear('created_at', today()->year)
            ->whereIn('status', ['completed', 'delivered'])
            ->sum('total');

        $thisMonthPosSales = Sale::whereMonth('sale_date', today()->month)
            ->whereYear('sale_date', today()->year)
            ->sum('grand_total');

        $thisMonthTotalSales = (float) ($thisMonthOrderSales + $thisMonthPosSales);

        $totalRevenue = (float) (Order::whereIn('status', ['completed', 'delivered'])->sum('total') + Sale::sum('grand_total'));

        // ================= EXPENSES =================
        $todayExpenses = (float) Expense::whereDate('date', today())->sum('amount');
        $thisMonthExpenses = (float) Expense::whereMonth('date', today()->month)
            ->whereYear('date', today()->year)
            ->sum('amount');

        // ================= ORDERS PIPELINE =================
        $pendingOrdersCount = Order::where('status', 'pending')->count();
        $processingOrdersCount = Order::whereIn('status', ['processing', 'confirmed'])->count();
        $completedOrdersCount = Order::whereIn('status', ['completed', 'delivered'])->count();
        $cancelledOrdersCount = Order::whereIn('status', ['cancelled', 'return'])->count();
        $totalOrdersCount = Order::count();
        $newOrdersCount = $pendingOrdersCount;

        // ================= INVENTORY & CUSTOMERS =================
        $customersCount = Customer::count();
        $totalProducts = Product::count();
        $productStock = (int) Product::sum('stock');
        $lowStockCount = Product::where('stock', '<=', DB::raw('COALESCE(alert_quantity, 5)'))->count();

        $lowStockProducts = Product::with('category')
            ->where('stock', '<=', DB::raw('COALESCE(alert_quantity, 5)'))
            ->orderBy('stock', 'asc')
            ->take(5)
            ->get();

        // ================= 7-DAY REVENUE TREND =================
        $chartLabels = [];
        $chartData = [];
        $orderChartData = [];
        $posChartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $orderSale = (float) Order::whereDate('created_at', $date)
                ->whereIn('status', ['completed', 'delivered'])
                ->sum('total');
            $posSale = (float) Sale::whereDate('sale_date', $date)->sum('grand_total');

            $chartLabels[] = $date->format('d M');
            $orderChartData[] = $orderSale;
            $posChartData[] = $posSale;
            $chartData[] = $orderSale + $posSale;
        }

        // ================= 12-MONTH REVENUE OVERVIEW =================
        $yearLabels = [];
        $yearData = [];
        for ($month = 1; $month <= 12; $month++) {
            $orderSale = (float) Order::whereYear('created_at', today()->year)
                ->whereMonth('created_at', $month)
                ->whereIn('status', ['completed', 'delivered'])
                ->sum('total');

            $posSale = (float) Sale::whereYear('sale_date', today()->year)
                ->whereMonth('sale_date', $month)
                ->sum('grand_total');

            $yearLabels[] = Carbon::create()->month($month)->format('M');
            $yearData[] = $orderSale + $posSale;
        }

        // ================= TOP SELLING PRODUCTS =================
        $topSellingItems = OrderItem::select(
            'product_id',
            'product_name',
            DB::raw('SUM(quantity) as total_qty'),
            DB::raw('SUM(total) as total_sales')
        )
            ->groupBy('product_id', 'product_name')
            ->orderByDesc('total_qty')
            ->with('product')
            ->take(5)
            ->get();

        // ================= RECENT DATA =================
        $recentOrders = Order::with('items.product')->latest()->take(7)->get();
        $recentSales = Sale::with('customer')->latest()->take(5)->get();

        return view('dashboard', compact(
            'newOrdersCount',
            'pendingOrdersCount',
            'processingOrdersCount',
            'completedOrdersCount',
            'cancelledOrdersCount',
            'totalOrdersCount',
            'customersCount',
            'totalProducts',
            'productStock',
            'lowStockCount',
            'lowStockProducts',
            'todayTotalSales',
            'todayOrderSales',
            'todayPosSales',
            'thisMonthTotalSales',
            'totalRevenue',
            'todayExpenses',
            'thisMonthExpenses',
            'chartLabels',
            'chartData',
            'orderChartData',
            'posChartData',
            'yearLabels',
            'yearData',
            'topSellingItems',
            'recentOrders',
            'recentSales'
        ));
    }
}
