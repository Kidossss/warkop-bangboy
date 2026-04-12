@extends('layouts.admin')
@section('title', 'Kelola Pesanan')

@section('content')
<h1 class="text-3xl font-bold text-gray-900 mb-6">Pesanan</h1>

{{-- Filter --}}
<div class="bg-white rounded-xl shadow p-4 mb-6">
    <form action="{{ route('admin.orders.index') }}" method="GET" class="flex flex-wrap items-center gap-4">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari no. pesanan / nama..."
               class="px-3 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:outline-none flex-1 min-w-[200px]">
        <select name="status" class="px-3 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:outline-none">
            <option value="">Semua Status</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
            <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Dikonfirmasi</option>
            <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Diproses</option>
            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
        </select>
        <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-xl transition-colors">
            <i class="fas fa-search mr-1"></i> Filter
        </button>
        <a href="{{ route('admin.orders.index') }}" class="text-gray-500 hover:text-gray-700 text-sm">Reset</a>
    </form>
</div>

<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">No. Pesanan</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Customer</th>
                <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Item</th>
                <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Total</th>
                <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Bayar</th>
                <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Status</th>
                <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Waktu</th>
                <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($orders as $order)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 font-mono text-sm">{{ $order->order_number }}</td>
                    <td class="px-6 py-4">
                        <p class="font-medium">{{ $order->customer_name }}</p>
                        <p class="text-xs text-gray-500">{{ $order->customer_phone }}</p>
                    </td>
                    <td class="px-6 py-4 text-center">{{ $order->items->count() }}</td>
                    <td class="px-6 py-4 text-center font-semibold">{{ $order->formatted_total }}</td>
                    <td class="px-6 py-4 text-center text-sm">
                        @if($order->payment_method == 'cash') COD
                        @elseif($order->payment_method == 'transfer') Transfer
                        @else E-Wallet
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="px-2 py-1 text-xs rounded-full
                            @if($order->status == 'pending') bg-yellow-100 text-yellow-800
                            @elseif($order->status == 'confirmed') bg-blue-100 text-blue-800
                            @elseif($order->status == 'processing') bg-purple-100 text-purple-800
                            @elseif($order->status == 'completed') bg-green-100 text-green-800
                            @else bg-red-100 text-red-800
                            @endif">
                            {{ $order->status_label }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center text-xs text-gray-500">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    <td class="px-6 py-4 text-center">
                        <a href="{{ route('admin.orders.show', $order) }}" class="text-blue-500 hover:text-blue-700"><i class="fas fa-eye"></i></a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="8" class="px-6 py-8 text-center text-gray-500">Belum ada pesanan</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $orders->withQueryString()->links() }}</div>
@endsection
