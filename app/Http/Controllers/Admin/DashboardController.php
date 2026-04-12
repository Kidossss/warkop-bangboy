<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $totalRevenue = Order::where('status', 'completed')->sum('total');
        $todayOrders = Order::whereDate('created_at', today())->count();
        $todayRevenue = Order::whereDate('created_at', today())->where('status', 'completed')->sum('total');
        $pendingOrders = Order::where('status', 'pending')->count();

        // Pesanan terbaru
        $recentOrders = Order::latest()->take(5)->get();

        // Menu terlaris
        $bestSellers = DB::table('order_items')
            ->select('product_name', DB::raw('SUM(quantity) as total_sold'), DB::raw('SUM(subtotal) as total_revenue'))
            ->groupBy('product_name')
            ->orderByDesc('total_sold')
            ->take(5)
            ->get();

        // Data chart - penjualan 7 hari terakhir
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $revenue = Order::whereDate('created_at', $date)
                ->where('status', 'completed')
                ->sum('total');
            $orderCount = Order::whereDate('created_at', $date)->count();

            $chartData[] = [
                'date' => $date->format('d/m'),
                'revenue' => $revenue,
                'orders' => $orderCount,
            ];
        }

        return view('admin.dashboard', compact(
            'totalProducts',
            'totalOrders',
            'totalRevenue',
            'todayOrders',
            'todayRevenue',
            'pendingOrders',
            'recentOrders',
            'bestSellers',
            'chartData'
        ));
    }
}
