@extends('layouts.app')
@section('title', 'Keranjang - Warkop Bang Boy')

@section('content')
<div class="container mx-auto px-6 py-12">
    <h1 class="text-2xl font-bold text-dark-900 mb-8">Keranjang Belanja</h1>

    @if(count($cart) > 0)
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-4">
                @foreach($cart as $id => $item)
                    <div class="bg-white rounded-2xl border border-dark-100 p-5 flex items-center gap-5">
                        <div class="w-16 h-16 bg-dark-50 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-utensils text-dark-300"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-semibold text-dark-900">{{ $item['name'] }}</h3>
                            @if(!empty($item['variant_name']))
                                <span class="inline-flex items-center gap-1 text-xs mt-0.5 px-2 py-0.5 rounded-lg
                                    {{ $item['variant_name'] == 'Panas' ? 'bg-orange-50 text-orange-600' : 'bg-blue-50 text-blue-600' }}">
                                    @if($item['variant_name'] == 'Panas')
                                        <i class="fas fa-mug-hot"></i>
                                    @else
                                        <i class="fas fa-snowflake"></i>
                                    @endif
                                    {{ $item['variant_name'] }}
                                </span>
                            @endif
                            <p class="text-primary-600 font-bold text-sm mt-1">Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                        </div>
                        <div class="flex items-center gap-3">
                            <form action="{{ route('cart.update', $id) }}" method="POST" class="flex items-center gap-2">
                                @csrf @method('PATCH')
                                <button type="submit" name="quantity" value="{{ $item['quantity'] - 1 }}"
                                        class="w-8 h-8 rounded-lg bg-dark-100 hover:bg-dark-200 flex items-center justify-center transition {{ $item['quantity'] <= 1 ? 'opacity-50' : '' }}">
                                    <i class="fas fa-minus text-xs text-dark-600"></i>
                                </button>
                                <span class="w-8 text-center font-semibold text-dark-900">{{ $item['quantity'] }}</span>
                                <button type="submit" name="quantity" value="{{ $item['quantity'] + 1 }}"
                                        class="w-8 h-8 rounded-lg bg-dark-100 hover:bg-dark-200 flex items-center justify-center transition">
                                    <i class="fas fa-plus text-xs text-dark-600"></i>
                                </button>
                            </form>
                            <form action="{{ route('cart.remove', $id) }}" method="POST">
                                @csrf @method('DELETE')
                                <button type="submit" class="w-8 h-8 rounded-lg bg-red-50 hover:bg-red-100 flex items-center justify-center transition">
                                    <i class="fas fa-trash text-xs text-red-400"></i>
                                </button>
                            </form>
                        </div>
                        <div class="text-right min-w-[100px]">
                            <span class="font-bold text-dark-900">Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</span>
                        </div>
                    </div>
                @endforeach
            </div>

            <div>
                <div class="bg-white rounded-2xl border border-dark-100 p-6 sticky top-24">
                    <h2 class="font-bold text-dark-900 mb-4">Ringkasan Pesanan</h2>
                    <div class="space-y-2 mb-4">
                        @foreach($cart as $id => $item)
                            <div class="flex justify-between text-sm">
                                <span class="text-dark-500">
                                    {{ $item['name'] }}
                                    @if(!empty($item['variant_name']))
                                        ({{ $item['variant_name'] }})
                                    @endif
                                    x{{ $item['quantity'] }}
                                </span>
                                <span class="text-dark-700">Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                    </div>
                    <hr class="border-dark-100 mb-4">
                    <div class="flex justify-between font-bold text-lg mb-6">
                        <span>Total</span>
                        <span class="text-primary-600">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    <a href="{{ route('checkout.index') }}" class="block w-full bg-dark-900 hover:bg-primary-600 text-white text-center py-3 rounded-xl font-semibold transition-colors">
                        Checkout
                    </a>
                    <form action="{{ route('cart.clear') }}" method="POST" class="mt-3">
                        @csrf @method('DELETE')
                        <button type="submit" class="w-full text-sm text-dark-400 hover:text-red-500 transition">Kosongkan Keranjang</button>
                    </form>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-20">
            <div class="w-20 h-20 bg-dark-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-shopping-bag text-3xl text-dark-300"></i>
            </div>
            <h2 class="text-xl font-bold text-dark-700 mb-2">Keranjang Kosong</h2>
            <p class="text-dark-400 mb-6">Belum ada item di keranjang</p>
            <a href="{{ route('home') }}#menu" class="bg-dark-900 hover:bg-primary-600 text-white px-6 py-3 rounded-xl font-semibold transition-colors">
                Lihat Menu
            </a>
        </div>
    @endif
</div>
@endsection
