<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\Order;
use App\Models\Purchase;
use App\Models\Sale;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function totalIncome(Request $request)
    {
        $queryOrders = Order::where('status', 'completed');
        $queryReturns = Order::where('status', 'return');
        $querySales = Sale::query();
        $queryExpenses = Expense::query();

        // ========================
        // PERIOD FILTER
        // ========================
        if ($request->filled('period')) {

            switch ($request->period) {

                case 'today':
                    $date = now()->toDateString();

                    $queryOrders->whereDate('created_at', $date);
                    $queryReturns->whereDate('updated_at', $date);
                    $querySales->whereDate('sale_date', $date);
                    $queryExpenses->whereDate('date', $date);
                    break;

                case 'month':
                    $month = now()->month;
                    $year = now()->year;

                    $queryOrders->whereMonth('created_at', $month)->whereYear('created_at', $year);
                    $queryReturns->whereMonth('updated_at', $month)->whereYear('updated_at', $year);
                    $querySales->whereMonth('sale_date', $month)->whereYear('sale_date', $year);
                    $queryExpenses->whereMonth('date', $month)->whereYear('date', $year);
                    break;

                case 'year':
                    $year = now()->year;

                    $queryOrders->whereYear('created_at', $year);
                    $queryReturns->whereYear('updated_at', $year);
                    $querySales->whereYear('sale_date', $year);
                    $queryExpenses->whereYear('date', $year);
                    break;
            }
        }

        // ========================
        // CUSTOM DATE RANGE
        // ========================
        if ($request->filled('start_date') && $request->filled('end_date')) {

            $start = $request->start_date.' 00:00:00';
            $end = $request->end_date.' 23:59:59';

            $queryOrders->whereBetween('created_at', [$start, $end]);
            $queryReturns->whereBetween('updated_at', [$start, $end]);
            $querySales->whereBetween('sale_date', [$start, $end]);
            $queryExpenses->whereBetween('date', [$start, $end]);
        }

        // ========================
        // CALCULATION
        // ========================
        $orderIncome = $queryOrders->sum('total');
        $posIncome = $querySales->sum('paid_amount');
        $totalExpenses = $queryExpenses->sum('amount');

        $totalReturnPenalty = $queryReturns->sum('return_charge');

        $totalIncome = ($orderIncome + $posIncome) - ($totalExpenses + $totalReturnPenalty);

        // ========================
        // RESPONSE (AJAX)
        // ========================
        if ($request->ajax()) {
            return response()->json([
                'orderIncome' => $orderIncome,
                'posIncome' => $posIncome,
                'totalExpenses' => $totalExpenses,
                'totalReturnPenalty' => $totalReturnPenalty,
                'totalIncome' => $totalIncome,
            ]);
        }

        // ========================
        // VIEW
        // ========================
        return view('backend.reports.total_income', compact(
            'orderIncome',
            'posIncome',
            'totalExpenses',
            'totalReturnPenalty',
            'totalIncome'
        ));
    }

    public function salesReport(Request $request)
    {
        $query = Sale::query()->with('customer');
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('sale_date', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59']);
        } elseif ($request->filled('start_date')) {
            $query->where('sale_date', '>=', $request->start_date . ' 00:00:00');
        } elseif ($request->filled('end_date')) {
            $query->where('sale_date', '<=', $request->end_date . ' 23:59:59');
        }
        $sales = $query->latest('sale_date')->get();

        return view('backend.reports.sales', compact('sales'));
    }

    // Purchase Report
    public function purchaseReport(Request $request)
    {
        $query = Purchase::query()->with('supplier');
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('purchase_date', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59']);
        } elseif ($request->filled('start_date')) {
            $query->where('purchase_date', '>=', $request->start_date . ' 00:00:00');
        } elseif ($request->filled('end_date')) {
            $query->where('purchase_date', '<=', $request->end_date . ' 23:59:59');
        }
        $purchases = $query->latest('purchase_date')->get();

        return view('backend.reports.purchase', compact('purchases'));
    }

    // Low Stock Alert Report
    public function lowStock(Request $request)
    {
        $products = \App\Models\Product::where('status', 1)
            ->where(function ($q) {
                $q->whereRaw('stock <= COALESCE(alert_quantity, 5)');
            })
            ->with(['category', 'brand'])
            ->orderBy('stock', 'asc')
            ->get();

        $outOfStockCount = $products->where('stock', '<=', 0)->count();
        $lowStockCount = $products->where('stock', '>', 0)->count();
        $totalItems = $products->count();

        return view('backend.reports.low_stock', compact('products', 'outOfStockCount', 'lowStockCount', 'totalItems'));
    }

    // E-commerce Online Orders Report
    public function orderReport(Request $request)
    {
        $query = Order::query()->with(['items', 'customer']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59']);
        } elseif ($request->filled('start_date')) {
            $query->where('created_at', '>=', $request->start_date . ' 00:00:00');
        } elseif ($request->filled('end_date')) {
            $query->where('created_at', '<=', $request->end_date . ' 23:59:59');
        }

        $orders = $query->latest()->paginate(25)->withQueryString();

        $baseQuery = Order::query();
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $baseQuery->whereBetween('created_at', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59']);
        } elseif ($request->filled('start_date')) {
            $baseQuery->where('created_at', '>=', $request->start_date . ' 00:00:00');
        } elseif ($request->filled('end_date')) {
            $baseQuery->where('created_at', '<=', $request->end_date . ' 23:59:59');
        }
        $totalOrders = (clone $baseQuery)->count();
        $totalCompleted = (clone $baseQuery)->where('status', 'completed')->count();
        $totalReturned = (clone $baseQuery)->where('status', 'return')->count();
        $totalRevenue = (clone $baseQuery)->where('status', 'completed')->sum('total');

        return view('backend.reports.order_report', compact(
            'orders', 'totalOrders', 'totalCompleted', 'totalReturned', 'totalRevenue'
        ));
    }

    // Top Selling Products Report
    public function topProducts(Request $request)
    {
        $topProducts = \App\Models\OrderItem::select(
                'order_items.product_id',
                'order_items.product_name',
                \Illuminate\Support\Facades\DB::raw('SUM(order_items.quantity) as total_sold'),
                \Illuminate\Support\Facades\DB::raw('SUM(order_items.total) as total_revenue')
            )
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->whereNotIn('orders.status', ['cancelled'])
            ->groupBy('order_items.product_id', 'order_items.product_name')
            ->orderByDesc('total_sold')
            ->take(20)
            ->with(['product.category'])
            ->get();

        return view('backend.reports.top_products', compact('topProducts'));
    }
}

