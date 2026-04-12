@extends('layouts.app')
@section('title', 'Keranjang - Warkop Bang Boy')

@section('content')
<div class="container mx-auto px-6 py-12">
    <h1 class="text-2xl font-bold text-dark-900 mb-8">Keranjang Belanja</h1>

    @if(count($cart) > 0)
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl border border-dark-100 overflow-hidden">
                    <table class="w-full">
                        <thead class="bg-dark-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-dark-500 uppercase tracking-wider">Produk</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold text-dark-500 uppercase tracking-wider">Harga</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold text-dark-500 uppercase tracking-wider">Qty</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold text-dark-500 uppercase tracking-wider">Subtotal</th>
                                <th class="px-6 py-4 w-12"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-dark-100">
                            @foreach($cart as $id => $item)
                                <tr class="hover:bg-dark-50/50">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 bg-dark-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                                @if($item['image'])
                                                    <img src="{{ $item['image'] }}" class="w-full h-full object-cover rounded-xl">
                                                @else
                                                    <i class="fas fa-utensils text-dark-400 text-xs"></i>
                                                @endif
                                            </div>
                                            <span class="font-medium text-dark-900 text-sm">{{ $item['name'] }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center text-sm text-dark-500">Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
                                    <td class="px-6 py-4">
                                        <form action="{{ route('cart.update', $id) }}" method="POST" class="flex justify-center">
                                            @csrf @method('PATCH')
                                            <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1"
                                                   class="w-16 text-center border border-dark-200 rounded-lg px-2 py-1.5 text-sm focus:ring-2 focus:ring-primary-500 focus:outline-none"
                                                   onchange="this.form.submit()">
                                        </form>
                                    </td>
                                    <td class="px-6 py-4 text-center font-semibold text-sm text-dark-900">Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</td>
                                    <td class="px-6 py-4">
                                        <form action="{{ route('cart.remove', $id) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-dark-400 hover:text-red-500 transition"><i class="fas fa-trash-alt text-xs"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="flex justify-between mt-4">
                    <a href="{{ route('home') }}#menu" class="text-dark-500 hover:text-primary-600 text-sm transition"><i class="fas fa-arrow-left mr-1"></i> Lanjut Belanja</a>
                    <form action="{{ route('cart.clear') }}" method="POST">@csrf @method('DELETE')
                        <button type="submit" class="text-red-400 hover:text-red-600 text-sm transition"><i class="fas fa-trash mr-1"></i> Kosongkan</button>
                    </form>
                </div>
            </div>

            <div>
                <div class="bg-white rounded-2xl border border-dark-100 p-6 sticky top-24">
                    <h2 class="font-bold text-dark-900 mb-4">Ringkasan</h2>
                    <div class="space-y-3 mb-6 text-sm">
                        <div class="flex justify-between text-dark-500"><span>Total ({{ count($cart) }} item)</span><span>Rp {{ number_format($total, 0, ',', '.') }}</span></div>
                        <hr class="border-dark-100">
                        <div class="flex justify-between font-bold text-dark-900 text-base"><span>Total Bayar</span><span class="text-primary-600">Rp {{ number_format($total, 0, ',', '.') }}</span></div>
                    </div>
                    <a href="{{ route('checkout.index') }}" class="block w-full bg-dark-900 hover:bg-primary-600 text-white text-center py-3 rounded-xl font-semibold transition-colors text-sm">
                        Checkout <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-24">
            <div class="w-20 h-20 bg-dark-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-shopping-bag text-2xl text-dark-300"></i>
            </div>
            <h2 class="text-xl font-bold text-dark-800 mb-2">Keranjang Kosong</h2>
            <p class="text-dark-400 mb-6 text-sm">Belum ada item di keranjang Anda</p>
            <a href="{{ route('home') }}#menu" class="inline-block bg-dark-900 hover:bg-primary-600 text-white px-6 py-3 rounded-xl font-semibold transition-colors text-sm">Lihat Menu</a>
        </div>
    @endif
</div>
@endsection
