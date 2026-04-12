@extends('layouts.app')
@section('title', 'Lacak Pesanan - Warkop Bang Boy')

@section('content')
<div class="container mx-auto px-6 py-12">
    <div class="max-w-lg mx-auto">
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-dark-900">Lacak Pesanan</h1>
            <p class="text-dark-400 text-sm mt-2">Masukkan nomor pesanan untuk cek status</p>
        </div>

        <form action="{{ route('order.track') }}" method="GET" class="bg-white rounded-2xl border border-dark-100 p-6 mb-6">
            <div class="flex gap-3">
                <input type="text" name="order_number" required value="{{ request('order_number') }}"
                       class="flex-1 px-4 py-2.5 border border-dark-200 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:outline-none focus:border-transparent"
                       placeholder="Contoh: WB202604120001">
                <button type="submit" class="bg-dark-900 hover:bg-primary-600 text-white px-5 py-2.5 rounded-xl font-semibold transition-colors text-sm">
                    <i class="fas fa-search mr-1"></i> Cari
                </button>
            </div>
        </form>

        @if(isset($order))
            <div class="bg-white rounded-2xl border border-dark-100 p-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <p class="text-xs text-dark-400">No. Pesanan</p>
                        <p class="font-bold text-dark-900">#{{ $order->order_number }}</p>
                    </div>
                    <span class="px-3 py-1 text-xs font-semibold rounded-lg
                        @if($order->status == 'pending') bg-amber-50 text-amber-600
                        @elseif($order->status == 'confirmed') bg-blue-50 text-blue-600
                        @elseif($order->status == 'processing') bg-purple-50 text-purple-600
                        @elseif($order->status == 'completed') bg-emerald-50 text-emerald-600
                        @else bg-red-50 text-red-600 @endif">
                        {{ $order->status_label }}
                    </span>
                </div>

                {{-- Progress Steps --}}
                <div class="flex items-center justify-between mb-8 px-2">
                    @php
                        $steps = ['pending', 'confirmed', 'processing', 'completed'];
                        $currentIndex = array_search($order->status, $steps);
                        if ($order->status == 'cancelled') $currentIndex = -1;
                    @endphp
                    @foreach($steps as $index => $step)
                        <div class="flex flex-col items-center flex-1">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold
                                @if($order->status == 'cancelled') bg-red-100 text-red-500
                                @elseif($index <= $currentIndex) bg-primary-500 text-white
                                @else bg-dark-100 text-dark-400 @endif">
                                @if($order->status == 'cancelled')
                                    <i class="fas fa-times"></i>
                                @elseif($index < $currentIndex)
                                    <i class="fas fa-check"></i>
                                @else
                                    {{ $index + 1 }}
                                @endif
                            </div>
                            <p class="text-[10px] text-dark-400 mt-1.5 text-center">
                                @if($step == 'pending') Menunggu
                                @elseif($step == 'confirmed') Dikonfirmasi
                                @elseif($step == 'processing') Diproses
                                @else Selesai @endif
                            </p>
                        </div>
                        @if($index < 3)
                            <div class="flex-1 h-0.5 -mt-4 {{ $index < $currentIndex ? 'bg-primary-500' : 'bg-dark-100' }}"></div>
                        @endif
                    @endforeach
                </div>

                @if($order->status == 'cancelled')
                    <div class="bg-red-50 rounded-xl p-3 mb-6 text-center text-sm text-red-600">
                        <i class="fas fa-times-circle mr-1"></i> Pesanan ini telah dibatalkan
                    </div>
                @endif

                {{-- Order Details --}}
                <div class="space-y-2 mb-4">
                    @foreach($order->items as $item)
                        <div class="flex justify-between text-sm">
                            <span class="text-dark-600">{{ $item->product_name }} x{{ $item->quantity }}</span>
                            <span class="text-dark-900">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                        </div>
                    @endforeach
                </div>
                <hr class="border-dark-100 mb-3">
                <div class="flex justify-between font-bold text-dark-900">
                    <span>Total</span>
                    <span class="text-primary-600">{{ $order->formatted_total }}</span>
                </div>

                <div class="mt-6 pt-4 border-t border-dark-100 text-xs text-dark-400 space-y-1">
                    <p><i class="fas fa-user w-4"></i> {{ $order->customer_name }}</p>
                    <p><i class="fas fa-chair w-4"></i> {{ $order->customer_address }}</p>
                    <p><i class="fas fa-clock w-4"></i> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        @elseif(request('order_number'))
            <div class="bg-white rounded-2xl border border-dark-100 p-8 text-center">
                <div class="w-14 h-14 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-search text-red-400"></i>
                </div>
                <p class="text-dark-700 font-medium">Pesanan tidak ditemukan</p>
                <p class="text-dark-400 text-sm mt-1">Pastikan nomor pesanan sudah benar</p>
            </div>
        @endif
    </div>
</div>
@endsection
