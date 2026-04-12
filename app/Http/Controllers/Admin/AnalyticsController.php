<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AnalyticsController extends Controller
{
    public function index()
    {
        // ==================== RINGKASAN UMUM ====================
        $totalRevenue = Order::where('status', 'completed')->sum('total');
        $totalOrders = Order::where('status', '!=', 'cancelled')->count();
        $avgOrderValue = $totalOrders > 0 ? round($totalRevenue / $totalOrders) : 0;
        $totalItemsSold = OrderItem::whereHas('order', fn($q) => $q->where('status', 'completed'))->sum('quantity');

        // ==================== PREDIKSI MENU TERLARIS ====================
        // Ambil data penjualan 4 minggu terakhir per produk
        $fourWeeksAgo = Carbon::now()->subWeeks(4);
        $twoWeeksAgo = Carbon::now()->subWeeks(2);

        // Penjualan 2 minggu pertama (minggu 3-4 lalu)
        $salesOlder = OrderItem::whereHas('order', function ($q) use ($fourWeeksAgo, $twoWeeksAgo) {
            $q->where('status', 'completed')
              ->whereBetween('created_at', [$fourWeeksAgo, $twoWeeksAgo]);
        })
        ->select('product_name', DB::raw('SUM(quantity) as total_qty'))
        ->groupBy('product_name')
        ->pluck('total_qty', 'product_name')
        ->toArray();

        // Penjualan 2 minggu terakhir
        $salesRecent = OrderItem::whereHas('order', function ($q) use ($twoWeeksAgo) {
            $q->where('status', 'completed')
              ->where('created_at', '>=', $twoWeeksAgo);
        })
        ->select('product_name', DB::raw('SUM(quantity) as total_qty'))
        ->groupBy('product_name')
        ->pluck('total_qty', 'product_name')
        ->toArray();

        // Hitung tren dan prediksi (Simple Moving Average + Trend)
        $predictions = [];
        $allProductNames = array_unique(array_merge(array_keys($salesOlder), array_keys($salesRecent)));

        foreach ($allProductNames as $name) {
            $older = $salesOlder[$name] ?? 0;
            $recent = $salesRecent[$name] ?? 0;

            // Tren: perubahan dari periode lama ke baru
            $trend = $older > 0 ? round((($recent - $older) / $older) * 100) : ($recent > 0 ? 100 : 0);

            // Prediksi minggu depan = rata-rata per minggu * faktor tren
            $avgPerWeek = ($older + $recent) / 4; // 4 minggu
            $trendFactor = 1 + ($trend / 100 * 0.5); // dampak tren 50%
            $predicted = round($avgPerWeek * $trendFactor);

            $predictions[] = [
                'name' => $name,
                'recent_sales' => $recent,
                'older_sales' => $older,
                'trend' => $trend,
                'predicted' => max(0, $predicted),
            ];
        }

        // Sort by predicted descending
        usort($predictions, fn($a, $b) => $b['predicted'] - $a['predicted']);
        $topPredictions = array_slice($predictions, 0, 10);

        // ==================== ANALISIS JAM RAMAI ====================
        $hourlyData = Order::where('status', '!=', 'cancelled')
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->select(DB::raw('HOUR(created_at) as hour'), DB::raw('COUNT(*) as total_orders'), DB::raw('SUM(total) as total_revenue'))
            ->groupBy('hour')
            ->orderBy('hour')
            ->get()
            ->keyBy('hour');

        $hourlyChart = [];
        for ($h = 0; $h < 24; $h++) {
            $hourlyChart[] = [
                'hour' => sprintf('%02d:00', $h),
                'orders' => $hourlyData[$h]->total_orders ?? 0,
                'revenue' => $hourlyData[$h]->total_revenue ?? 0,
            ];
        }

        // Peak hours
        $peakHour = $hourlyData->sortByDesc('total_orders')->first();
        $peakHourLabel = $peakHour ? sprintf('%02d:00 - %02d:00', $peakHour->hour, $peakHour->hour + 1) : '-';

        // ==================== ANALISIS HARI RAMAI ====================
        $dailyData = Order::where('status', '!=', 'cancelled')
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->select(DB::raw('DAYOFWEEK(created_at) as day_num'), DB::raw('COUNT(*) as total_orders'), DB::raw('SUM(total) as total_revenue'))
            ->groupBy('day_num')
            ->orderBy('day_num')
            ->get();

        $dayNames = [1 => 'Minggu', 2 => 'Senin', 3 => 'Selasa', 4 => 'Rabu', 5 => 'Kamis', 6 => 'Jumat', 7 => 'Sabtu'];
        $dailyChart = [];
        foreach ($dailyData as $d) {
            $dailyChart[] = [
                'day' => $dayNames[$d->day_num] ?? $d->day_num,
                'orders' => $d->total_orders,
                'revenue' => $d->total_revenue,
            ];
        }

        $peakDay = $dailyData->sortByDesc('total_orders')->first();
        $peakDayLabel = $peakDay ? ($dayNames[$peakDay->day_num] ?? '-') : '-';

        // ==================== REKOMENDASI STOK ====================
        // Berdasarkan prediksi menu terlaris, rekomendasikan stok
        $stockRecommendations = [];
        foreach (array_slice($predictions, 0, 15) as $pred) {
            if ($pred['predicted'] <= 0) continue;

            // Estimasi stok yang dibutuhkan (prediksi + buffer 20%)
            $stockNeeded = ceil($pred['predicted'] * 1.2);

            $status = 'normal';
            if ($pred['trend'] > 20) $status = 'naik';
            elseif ($pred['trend'] < -20) $status = 'turun';

            $stockRecommendations[] = [
                'name' => $pred['name'],
                'predicted_weekly' => $pred['predicted'],
                'stock_needed' => $stockNeeded,
                'trend' => $pred['trend'],
                'status' => $status,
            ];
        }

        // ==================== TREN PENJUALAN 30 HARI ====================
        $dailySales = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $revenue = Order::whereDate('created_at', $date)->where('status', 'completed')->sum('total');
            $orders = Order::whereDate('created_at', $date)->where('status', '!=', 'cancelled')->count();

            $dailySales[] = [
                'date' => $date->format('d/m'),
                'revenue' => $revenue,
                'orders' => $orders,
            ];
        }

        // ==================== KATEGORI TERLARIS ====================
        $categorySales = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', 'completed')
            ->select('categories.name', DB::raw('SUM(order_items.quantity) as total_qty'), DB::raw('SUM(order_items.subtotal) as total_revenue'))
            ->groupBy('categories.name')
            ->orderByDesc('total_qty')
            ->get();

        return view('admin.analytics', compact(
            'totalRevenue', 'totalOrders', 'avgOrderValue', 'totalItemsSold',
            'topPredictions', 'hourlyChart', 'peakHourLabel',
            'dailyChart', 'peakDayLabel',
            'stockRecommendations', 'dailySales', 'categorySales'
        ));
    }
}
