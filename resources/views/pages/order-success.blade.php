@extends('layouts.app')
@section('title', 'Pesanan Berhasil - Warkop Bang Boy')

@section('content')
<div class="min-h-[70vh] flex items-center justify-center py-12">
    <div class="max-w-md w-full mx-6">
        <div class="bg-white rounded-2xl border border-dark-100 p-8 text-center">
            <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-check text-2xl text-primary-600"></i>
            </div>
            <h1 class="text-2xl font-bold text-dark-900 mb-2">Pesanan Berhasil!</h1>
            <p class="text-dark-400 text-sm mb-6">Kami akan segera memproses pesanan Anda</p>

            <div class="bg-dark-50 rounded-xl p-4 mb-5 text-left text-sm">
                <div class="grid grid-cols-2 gap-2">
                    <span class="text-dark-400">No. Pesanan</span><span class="font-semibold text-dark-900 text-right">#{{ $order->order_number }}</span>
                    <span class="text-dark-400">Nama</span><span class="font-semibold text-dark-900 text-right">{{ $order->customer_name }}</span>
                    <span class="text-dark-400">Meja</span><span class="font-semibold text-dark-900 text-right">{{ $order->customer_address }}</span>
                    <span class="text-dark-400">Total</span><span class="font-semibold text-primary-600 text-right">{{ $order->formatted_total }}</span>
                    <span class="text-dark-400">Pembayaran</span><span class="font-semibold text-dark-900 text-right">Bayar di Tempat</span>
                    <span class="text-dark-400">Status</span>
                    <span class="text-right">
                        <span class="px-2 py-0.5 text-xs font-semibold rounded-lg bg-amber-50 text-amber-600">{{ $order->status_label }}</span>
                    </span>
                </div>
            </div>

            <div class="bg-dark-50 rounded-xl p-4 mb-6 text-left text-sm">
                <p class="font-semibold text-dark-700 mb-2">Detail Pesanan</p>
                @foreach($order->items as $item)
                    <div class="flex justify-between text-dark-500 mb-1">
                        <span>{{ $item->product_name }} x{{ $item->quantity }}</span>
                        <span>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                    </div>
                @endforeach
                <hr class="my-2 border-dark-200">
                <div class="flex justify-between font-bold text-dark-900 mt-1"><span>Total</span><span>{{ $order->formatted_total }}</span></div>
            </div>

            <div class="space-y-3">
                <a href="{{ route('order.track', ['order_number' => $order->order_number]) }}"
                   class="block w-full bg-primary-500 hover:bg-primary-600 text-white py-3 rounded-xl font-semibold transition-colors text-sm">
                    <i class="fas fa-map-marker-alt mr-1"></i> Lacak Pesanan
                </a>
                <a href="{{ route('home') }}"
                   class="block w-full bg-dark-900 hover:bg-dark-800 text-white py-3 rounded-xl font-semibold transition-colors text-sm">
                    Kembali ke Menu
                </a>
            </div>

            <p class="text-xs text-dark-400 mt-4">Hubungi <a href="tel:+6287783372739" class="text-primary-600 hover:underline">0877-8337-2739</a></p>
        </div>
    </div>
</div>
@endsection
