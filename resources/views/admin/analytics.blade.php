@extends('layouts.admin')
@section('title', 'Analisis & Prediksi')

@section('content')
<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Analisis & Prediksi</h1>
        <p class="text-slate-400 text-sm mt-1">Predictive Analytics — Data 3 bulan terakhir</p>
    </div>
</div>

{{-- Stats Cards --}}
<div class="grid grid-cols-1 md:grid-cols-4 gap-5 mb-8">
    <div class="bg-white rounded-2xl border border-slate-100 p-5">
        <span class="text-xs font-medium text-slate-400 uppercase tracking-wider">Total Pendapatan</span>
        <p class="text-2xl font-bold text-slate-900 mt-2">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
    </div>
    <div class="bg-white rounded-2xl border border-slate-100 p-5">
        <span class="text-xs font-medium text-slate-400 uppercase tracking-wider">Total Pesanan</span>
        <p class="text-2xl font-bold text-slate-900 mt-2">{{ number_format($totalOrders) }}</p>
    </div>
    <div class="bg-white rounded-2xl border border-slate-100 p-5">
        <span class="text-xs font-medium text-slate-400 uppercase tracking-wider">Rata-rata per Order</span>
        <p class="text-2xl font-bold text-slate-900 mt-2">Rp {{ number_format($avgOrderValue, 0, ',', '.') }}</p>
    </div>
    <div class="bg-white rounded-2xl border border-slate-100 p-5">
        <span class="text-xs font-medium text-slate-400 uppercase tracking-wider">Total Item Terjual</span>
        <p class="text-2xl font-bold text-slate-900 mt-2">{{ number_format($totalItemsSold) }}</p>
    </div>
</div>

{{-- Tren Penjualan 30 Hari --}}
<div class="bg-white rounded-2xl border border-slate-100 p-6 mb-8">
    <h2 class="font-semibold text-slate-900 mb-1">Tren Penjualan 30 Hari Terakhir</h2>
    <p class="text-xs text-slate-400 mb-4">Metode: Simple Moving Average</p>
    <canvas id="trendChart" height="100"></canvas>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    {{-- Prediksi Menu Terlaris --}}
    <div class="bg-white rounded-2xl border border-slate-100 p-6">
        <h2 class="font-semibold text-slate-900 mb-1">Prediksi Menu Terlaris Minggu Depan</h2>
        <p class="text-xs text-slate-400 mb-4">Berdasarkan tren 4 minggu terakhir</p>
        <div class="space-y-3">
            @foreach($topPredictions as $index => $pred)
                <div class="flex items-center gap-3">
                    <span class="w-6 h-6 bg-slate-100 rounded-lg flex items-center justify-center text-xs font-bold text-slate-500">{{ $index + 1 }}</span>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-slate-700">{{ $pred['name'] }}</p>
                        <div class="flex items-center gap-2 mt-0.5">
                            <div class="flex-1 bg-slate-100 rounded-full h-1.5">
                                <div class="bg-emerald-500 h-1.5 rounded-full" style="width: {{ min(100, ($pred['predicted'] / max(1, $topPredictions[0]['predicted'])) * 100) }}%"></div>
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="text-sm font-bold text-slate-700">{{ $pred['predicted'] }}</span>
                        <span class="text-xs text-slate-400">porsi</span>
                    </div>
                    <span class="text-xs font-semibold px-2 py-0.5 rounded-lg
                        {{ $pred['trend'] > 0 ? 'bg-emerald-50 text-emerald-600' : ($pred['trend'] < 0 ? 'bg-red-50 text-red-600' : 'bg-slate-50 text-slate-500') }}">
                        {{ $pred['trend'] > 0 ? '+' : '' }}{{ $pred['trend'] }}%
                    </span>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Kategori Terlaris --}}
    <div class="bg-white rounded-2xl border border-slate-100 p-6">
        <h2 class="font-semibold text-slate-900 mb-1">Penjualan per Kategori</h2>
        <p class="text-xs text-slate-400 mb-4">Total item terjual per kategori menu</p>
        <canvas id="categoryChart" height="200"></canvas>
        <div class="mt-4 space-y-2">
            @foreach($categorySales as $cat)
                <div class="flex justify-between text-sm">
                    <span class="text-slate-600">{{ $cat->name }}</span>
                    <div class="text-right">
                        <span class="font-medium text-slate-700">{{ $cat->total_qty }} item</span>
                        <span class="text-slate-400 ml-2">Rp {{ number_format($cat->total_revenue, 0, ',', '.') }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    {{-- Analisis Jam Ramai --}}
    <div class="bg-white rounded-2xl border border-slate-100 p-6">
        <div class="flex items-center justify-between mb-1">
            <h2 class="font-semibold text-slate-900">Analisis Jam Ramai</h2>
            <span class="text-xs bg-amber-50 text-amber-600 px-2 py-1 rounded-lg font-semibold">Peak: {{ $peakHourLabel }}</span>
        </div>
        <p class="text-xs text-slate-400 mb-4">Distribusi pesanan per jam (30 hari terakhir)</p>
        <canvas id="hourlyChart" height="200"></canvas>
    </div>

    {{-- Analisis Hari Ramai --}}
    <div class="bg-white rounded-2xl border border-slate-100 p-6">
        <div class="flex items-center justify-between mb-1">
            <h2 class="font-semibold text-slate-900">Analisis Hari Ramai</h2>
            <span class="text-xs bg-blue-50 text-blue-600 px-2 py-1 rounded-lg font-semibold">Peak: {{ $peakDayLabel }}</span>
        </div>
        <p class="text-xs text-slate-400 mb-4">Distribusi pesanan per hari (30 hari terakhir)</p>
        <canvas id="dailyChart" height="200"></canvas>
    </div>
</div>

{{-- Rekomendasi Stok --}}
<div class="bg-white rounded-2xl border border-slate-100 p-6 mb-8">
    <h2 class="font-semibold text-slate-900 mb-1">Rekomendasi Stok Minggu Depan</h2>
    <p class="text-xs text-slate-400 mb-4">Berdasarkan prediksi penjualan + buffer 20%</p>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="text-left text-xs text-slate-400 uppercase tracking-wider">
                    <th class="pb-3">Menu</th>
                    <th class="pb-3 text-center">Prediksi Penjualan</th>
                    <th class="pb-3 text-center">Stok Dibutuhkan</th>
                    <th class="pb-3 text-center">Tren</th>
                    <th class="pb-3 text-center">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($stockRecommendations as $stock)
                    <tr>
                        <td class="py-3 text-sm font-medium text-slate-700">{{ $stock['name'] }}</td>
                        <td class="py-3 text-center text-sm">{{ $stock['predicted_weekly'] }} porsi/minggu</td>
                        <td class="py-3 text-center text-sm font-semibold text-slate-900">{{ $stock['stock_needed'] }} porsi</td>
                        <td class="py-3 text-center">
                            <span class="text-xs font-semibold px-2 py-0.5 rounded-lg
                                {{ $stock['trend'] > 0 ? 'bg-emerald-50 text-emerald-600' : ($stock['trend'] < 0 ? 'bg-red-50 text-red-600' : 'bg-slate-50 text-slate-500') }}">
                                @if($stock['trend'] > 0) <i class="fas fa-arrow-up mr-1"></i>
                                @elseif($stock['trend'] < 0) <i class="fas fa-arrow-down mr-1"></i>
                                @else <i class="fas fa-minus mr-1"></i> @endif
                                {{ $stock['trend'] > 0 ? '+' : '' }}{{ $stock['trend'] }}%
                            </span>
                        </td>
                        <td class="py-3 text-center">
                            <span class="text-xs font-semibold px-2 py-0.5 rounded-lg
                                @if($stock['status'] == 'naik') bg-emerald-50 text-emerald-600
                                @elseif($stock['status'] == 'turun') bg-red-50 text-red-600
                                @else bg-slate-50 text-slate-500 @endif">
                                @if($stock['status'] == 'naik') Permintaan Naik
                                @elseif($stock['status'] == 'turun') Permintaan Turun
                                @else Stabil @endif
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="bg-slate-50 rounded-2xl border border-slate-200 p-6">
    <h3 class="font-semibold text-slate-700 mb-2">Tentang Metode Prediksi</h3>
    <p class="text-sm text-slate-500 leading-relaxed">
        Prediksi menggunakan metode <strong>Simple Moving Average (SMA)</strong> dengan analisis tren. 
        Data penjualan 4 minggu terakhir dibagi menjadi 2 periode (minggu 1-2 dan minggu 3-4), 
        kemudian dihitung perubahan tren antar periode. Prediksi minggu depan dihitung dari 
        rata-rata penjualan per minggu dikali faktor tren. Rekomendasi stok ditambah buffer 20% 
        untuk mengantisipasi lonjakan permintaan.
    </p>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Tren 30 Hari
new Chart(document.getElementById('trendChart').getContext('2d'), {
    type: 'line',
    data: {
        labels: {!! json_encode(collect($dailySales)->pluck('date')) !!},
        datasets: [{
            label: 'Pendapatan',
            data: {!! json_encode(collect($dailySales)->pluck('revenue')) !!},
            borderColor: 'rgba(16, 185, 129, 1)',
            backgroundColor: 'rgba(16, 185, 129, 0.1)',
            fill: true,
            tension: 0.4,
            borderWidth: 2,
            pointRadius: 0,
            pointHitRadius: 10,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false }, tooltip: { callbacks: { label: ctx => 'Rp ' + ctx.raw.toLocaleString('id-ID') } } },
        scales: { y: { beginAtZero: true, grid: { color: '#f1f5f9' }, ticks: { callback: v => 'Rp ' + (v/1000) + 'k', font: { size: 11 } } }, x: { grid: { display: false }, ticks: { font: { size: 10 }, maxTicksLimit: 10 } } }
    }
});

// Jam Ramai
new Chart(document.getElementById('hourlyChart').getContext('2d'), {
    type: 'bar',
    data: {
        labels: {!! json_encode(collect($hourlyChart)->pluck('hour')) !!},
        datasets: [{
            label: 'Pesanan',
            data: {!! json_encode(collect($hourlyChart)->pluck('orders')) !!},
            backgroundColor: 'rgba(245, 158, 11, 0.3)',
            borderColor: 'rgba(245, 158, 11, 1)',
            borderWidth: 1,
            borderRadius: 4,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: { y: { beginAtZero: true, grid: { color: '#f1f5f9' }, ticks: { font: { size: 11 } } }, x: { grid: { display: false }, ticks: { font: { size: 9 }, maxRotation: 0 } } }
    }
});

// Hari Ramai
new Chart(document.getElementById('dailyChart').getContext('2d'), {
    type: 'bar',
    data: {
        labels: {!! json_encode(collect($dailyChart)->pluck('day')) !!},
        datasets: [{
            label: 'Pesanan',
            data: {!! json_encode(collect($dailyChart)->pluck('orders')) !!},
            backgroundColor: 'rgba(59, 130, 246, 0.3)',
            borderColor: 'rgba(59, 130, 246, 1)',
            borderWidth: 1,
            borderRadius: 6,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: { y: { beginAtZero: true, grid: { color: '#f1f5f9' }, ticks: { font: { size: 11 } } }, x: { grid: { display: false }, ticks: { font: { size: 11 } } } }
    }
});

// Kategori Pie
new Chart(document.getElementById('categoryChart').getContext('2d'), {
    type: 'doughnut',
    data: {
        labels: {!! json_encode($categorySales->pluck('name')) !!},
        datasets: [{
            data: {!! json_encode($categorySales->pluck('total_qty')) !!},
            backgroundColor: ['#10b981', '#f59e0b', '#3b82f6', '#8b5cf6', '#ef4444', '#ec4899', '#14b8a6'],
            borderWidth: 0,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { position: 'bottom', labels: { padding: 16, font: { size: 12 } } } },
        cutout: '60%',
    }
});
</script>
@endpush
