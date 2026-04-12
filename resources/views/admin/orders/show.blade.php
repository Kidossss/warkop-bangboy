@extends('layouts.admin')
@section('title', 'Detail Pesanan #' . $order->order_number)

@section('content')
<div class="flex items-center gap-4 mb-6">
    <a href="{{ route('admin.orders.index') }}" class="text-gray-500 hover:text-gray-700"><i class="fas fa-arrow-left"></i></a>
    <h1 class="text-3xl font-bold text-gray-900">Pesanan #{{ $order->order_number }}</h1>
    <span class="px-3 py-1 text-sm rounded-full
        @if($order->status == 'pending') bg-yellow-100 text-yellow-800
        @elseif($order->status == 'confirmed') bg-blue-100 text-blue-800
        @elseif($order->status == 'processing') bg-purple-100 text-purple-800
        @elseif($order->status == 'completed') bg-green-100 text-green-800
        @else bg-red-100 text-red-800
        @endif">
        {{ $order->status_label }}
    </span>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="lg:col-span-2 space-y-6">
        {{-- Item Pesanan --}}
        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Item Pesanan</h2>
            <table class="w-full">
                <thead>
                    <tr class="text-left text-sm text-gray-500 border-b">
                        <th class="pb-3">Produk</th>
                        <th class="pb-3 text-center">Harga</th>
                        <th class="pb-3 text-center">Qty</th>
                        <th class="pb-3 text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($order->items as $item)
                        <tr>
                            <td class="py-3 font-medium">{{ $item->product_name }}</td>
                            <td class="py-3 text-center text-sm">Rp {{ number_format($item->product_price, 0, ',', '.') }}</td>
                            <td class="py-3 text-center">{{ $item->quantity }}</td>
                            <td class="py-3 text-right font-semibold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="border-t">
                    <tr class="font-bold text-lg"><td colspan="3" class="py-2 text-right">Total</td><td class="py-2 text-right text-emerald-600">{{ $order->formatted_total }}</td></tr>
                </tfoot>
            </table>
        </div>

        {{-- Info Customer --}}
        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Informasi Customer</h2>
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div><span class="text-gray-500">Nama:</span><p class="font-medium">{{ $order->customer_name }}</p></div>
                <div><span class="text-gray-500">Telepon:</span><p class="font-medium">{{ $order->customer_phone }}</p></div>
                <div><span class="text-gray-500">Email:</span><p class="font-medium">{{ $order->customer_email ?? '-' }}</p></div>
                <div><span class="text-gray-500">Pembayaran:</span><p class="font-medium">Bayar di Tempat</p></div>
                <div><span class="text-gray-500">Nomor Meja:</span><p class="font-medium">{{ $order->customer_address }}</p></div>
                @if($order->notes)
                    <div><span class="text-gray-500">Catatan:</span><p class="font-medium">{{ $order->notes }}</p></div>
                @endif
            </div>
        </div>
    </div>

    {{-- Update Status --}}
    <div>
        <div class="bg-white rounded-xl shadow p-6 sticky top-8">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Update Status</h2>
            <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST" class="space-y-3">
                @csrf @method('PATCH')
                @php
                    $statuses = [
                        'pending' => 'Menunggu',
                        'confirmed' => 'Dikonfirmasi',
                        'processing' => 'Diproses',
                        'completed' => 'Selesai',
                        'cancelled' => 'Dibatalkan',
                    ];
                @endphp
                @foreach($statuses as $value => $label)
                    <label class="flex items-center gap-3 p-3 border rounded-xl cursor-pointer hover:bg-gray-50
                        {{ $order->status == $value ? 'border-emerald-500 bg-emerald-50' : '' }}">
                        <input type="radio" name="status" value="{{ $value }}" {{ $order->status == $value ? 'checked' : '' }}>
                        <span>{{ $label }}</span>
                    </label>
                @endforeach
                <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white py-2 rounded-xl transition-colors mt-4">
                    Update Status
                </button>
            </form>

            <div class="mt-6 pt-4 border-t text-sm text-gray-500">
                <p>Dibuat: {{ $order->created_at->format('d/m/Y H:i') }}</p>
                <p>Diupdate: {{ $order->updated_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
