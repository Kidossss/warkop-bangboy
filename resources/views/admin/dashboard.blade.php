@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')
<h1 class="text-2xl font-bold text-slate-900 mb-8">Dashboard</h1>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
    <div class="bg-white rounded-2xl border border-slate-100 p-5">
        <div class="flex items-center justify-between mb-3">
            <span class="text-xs font-medium text-slate-400 uppercase tracking-wider">Pendapatan Hari Ini</span>
            <div class="w-9 h-9 bg-emerald-50 rounded-xl flex items-center justify-center"><i class="fas fa-wallet text-emerald-500 text-sm"></i></div>
        </div>
        <p class="text-2xl font-bold text-slate-900">Rp {{ number_format($todayRevenue, 0, ',', '.') }}</p>
    </div>
    <div class="bg-white rounded-2xl border border-slate-100 p-5">
        <div class="flex items-center justify-between mb-3">
            <span class="text-xs font-medium text-slate-400 uppercase tracking-wider">Pesanan Hari Ini</span>
            <div class="w-9 h-9 bg-blue-50 rounded-xl flex items-center justify-center"><i class="fas fa-receipt text-blue-500 text-sm"></i></div>
        </div>
        <p class="text-2xl font-bold text-slate-900">{{ $todayOrders }}</p>
    </div>
    <div class="bg-white rounded-2xl border border-slate-100 p-5">
        <div class="flex items-center justify-between mb-3">
            <span class="text-xs font-medium text-slate-400 uppercase tracking-wider">Pending</span>
            <div class="w-9 h-9 bg-amber-50 rounded-xl flex items-center justify-center"><i class="fas fa-clock text-amber-500 text-sm"></i></div>
        </div>
        <p class="text-2xl font-bold text-slate-900">{{ $pendingOrders }}</p>
    </div>
    <div class="bg-white rounded-2xl border border-slate-100 p-5">
        <div class="flex items-center justify-between mb-3">
            <span class="text-xs font-medium text-slate-400 uppercase tracking-wider">Total Produk</span>
            <div class="w-9 h-9 bg-purple-50 rounded-xl flex items-center justify-center"><i class="fas fa-box text-purple-500 text-sm"></i></div>
        </div>
        <p class="text-2xl font-bold text-slate-900">{{ $totalProducts }}</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <div class="bg-white rounded-2xl border border-slate-100 p-6">
        <h2 class="font-semibold text-slate-900 mb-4">Penjualan 7 Hari Terakhir</h2>
        <canvas id="salesChart" height="200"></canvas>
    </div>
    <div class="bg-white rounded-2xl border border-slate-100 p-6">
        <h2 class="font-semibold text-slate-900 mb-4">Menu Terlaris</h2>
        @if($bestSellers->count() > 0)
            <div class="space-y-3">
                @foreach($bestSellers as $index => $item)
                    <div class="flex items-center gap-3">
                        <span class="w-6 h-6 bg-slate-100 rounded-lg flex items-center justify-center text-xs font-bold text-slate-500">{{ $index + 1 }}</span>
                        <span class="flex-1 text-sm font-medium text-slate-700">{{ $item->product_name }}</span>
                        <span class="text-xs text-slate-400">{{ $item->total_sold }} terjual</span>
                        <span class="text-xs font-semibold text-slate-700">Rp {{ number_format($item->total_revenue, 0, ',', '.') }}</span>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-slate-400 text-sm text-center py-8">Belum ada data</p>
        @endif
    </div>
</div>

<div class="bg-white rounded-2xl border border-slate-100 p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="font-semibold text-slate-900">Pesanan Terbaru</h2>
        <a href="{{ route('admin.orders.index') }}" class="text-emerald-600 hover:text-emerald-700 text-xs font-medium">Lihat Semua &rarr;</a>
    </div>
    <table class="w-full">
        <thead><tr class="text-left text-xs text-slate-400 uppercase tracking-wider">
            <th class="pb-3">No. Pesanan</th><th class="pb-3">Customer</th><th class="pb-3">Total</th><th class="pb-3">Status</th><th class="pb-3">Waktu</th>
        </tr></thead>
        <tbody class="divide-y divide-slate-100">
            @forelse($recentOrders as $order)
                <tr>
                    <td class="py-3 font-mono text-xs text-slate-600">{{ $order->order_number }}</td>
                    <td class="py-3 text-sm">{{ $order->customer_name }}</td>
                    <td class="py-3 text-sm font-medium">{{ $order->formatted_total }}</td>
                    <td class="py-3"><span class="px-2 py-1 text-[10px] font-semibold rounded-lg
                        @if($order->status == 'pending') bg-amber-50 text-amber-600
                        @elseif($order->status == 'confirmed') bg-blue-50 text-blue-600
                        @elseif($order->status == 'processing') bg-purple-50 text-purple-600
                        @elseif($order->status == 'completed') bg-emerald-50 text-emerald-600
                        @else bg-red-50 text-red-600 @endif">{{ $order->status_label }}</span></td>
                    <td class="py-3 text-xs text-slate-400">{{ $order->created_at->diffForHumans() }}</td>
                </tr>
            @empty
                <tr><td colspan="5" class="py-8 text-center text-slate-400 text-sm">Belum ada pesanan</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
new Chart(document.getElementById('salesChart').getContext('2d'), {
    type: 'bar',
    data: {
        labels: {!! json_encode(collect($chartData)->pluck('date')) !!},
        datasets: [{
            label: 'Pendapatan (Rp)',
            data: {!! json_encode(collect($chartData)->pluck('revenue')) !!},
            backgroundColor: 'rgba(16, 185, 129, 0.15)',
            borderColor: 'rgba(16, 185, 129, 1)',
            borderWidth: 1.5,
            borderRadius: 8,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false }, tooltip: { callbacks: { label: ctx => 'Rp ' + ctx.raw.toLocaleString('id-ID') } } },
        scales: { y: { beginAtZero: true, grid: { color: '#f1f5f9' }, ticks: { callback: v => 'Rp ' + v.toLocaleString('id-ID'), font: { size: 11 } } }, x: { grid: { display: false }, ticks: { font: { size: 11 } } } }
    }
});
</script>
@endpush
