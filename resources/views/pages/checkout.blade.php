@extends('layouts.app')
@section('title', 'Checkout - Warkop Bang Boy')

@section('content')
<div class="container mx-auto px-6 py-12">
    <h1 class="text-2xl font-bold text-dark-900 mb-8">Checkout</h1>

    <form action="{{ route('checkout.store') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-2xl border border-dark-100 p-6">
                    <h2 class="font-bold text-dark-900 mb-4">Pesanan Anda</h2>
                    <div class="space-y-3">
                        @foreach($cart as $id => $item)
                            <div class="flex items-center justify-between p-3 bg-dark-50 rounded-xl">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-dark-200 rounded-lg flex items-center justify-center">
                                        @if($item['image']) <img src="{{ $item['image'] }}" class="w-full h-full object-cover rounded-lg">
                                        @else <i class="fas fa-utensils text-dark-400 text-xs"></i> @endif
                                    </div>
                                    <div>
                                        <p class="font-medium text-dark-900 text-sm">{{ $item['name'] }}</p>
                                        <p class="text-xs text-dark-400">{{ $item['quantity'] }}x Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                                    </div>
                                </div>
                                <span class="font-semibold text-sm">Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="bg-white rounded-2xl border border-dark-100 p-6">
                    <h2 class="font-bold text-dark-900 mb-4">Informasi Pemesan</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-dark-500 mb-1.5">Nama Lengkap *</label>
                            <input type="text" name="customer_name" required value="{{ old('customer_name') }}"
                                   class="w-full px-4 py-2.5 border border-dark-200 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:outline-none focus:border-transparent" placeholder="Masukkan nama">
                            @error('customer_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-dark-500 mb-1.5">No. Telepon *</label>
                            <input type="tel" name="customer_phone" required value="{{ old('customer_phone') }}"
                                   class="w-full px-4 py-2.5 border border-dark-200 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:outline-none focus:border-transparent" placeholder="08xxxxxxxxxx">
                            @error('customer_phone') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="mt-4">
                        <label class="block text-xs font-medium text-dark-500 mb-1.5">Email</label>
                        <input type="email" name="customer_email" value="{{ old('customer_email') }}"
                               class="w-full px-4 py-2.5 border border-dark-200 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:outline-none focus:border-transparent" placeholder="email@example.com">
                    </div>
                    <div class="mt-4">
                        <label class="block text-xs font-medium text-dark-500 mb-1.5">Nomor Meja *</label>
                        <input type="text" name="customer_address" required value="{{ old('customer_address') }}"
                               class="w-full px-4 py-2.5 border border-dark-200 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:outline-none focus:border-transparent" placeholder="Contoh: Meja 5">
                        @error('customer_address') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div class="mt-4">
                        <label class="block text-xs font-medium text-dark-500 mb-1.5">Catatan</label>
                        <textarea name="notes" rows="2"
                                  class="w-full px-4 py-2.5 border border-dark-200 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:outline-none focus:border-transparent" placeholder="Contoh: Jangan terlalu pedas">{{ old('notes') }}</textarea>
                    </div>
                </div>
            </div>

            <div>
                <div class="bg-white rounded-2xl border border-dark-100 p-6 sticky top-24">
                    <h2 class="font-bold text-dark-900 mb-4">Ringkasan</h2>
                    <div class="space-y-3 mb-4 text-sm">
                        <div class="flex justify-between text-dark-500"><span>Subtotal</span><span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span></div>
                        <hr class="border-dark-100">
                        <div class="flex justify-between font-bold text-dark-900 text-base"><span>Total</span><span class="text-primary-600">Rp {{ number_format($subtotal, 0, ',', '.') }}</span></div>
                    </div>

                    <input type="hidden" name="payment_method" value="cash">

                    <div class="bg-dark-50 rounded-xl p-3 mb-6 flex items-center gap-3 text-sm text-dark-600">
                        <i class="fas fa-money-bill-wave text-primary-500"></i>
                        <span>Pembayaran: <strong>Bayar di Tempat</strong></span>
                    </div>

                    <button type="submit" class="w-full bg-dark-900 hover:bg-primary-600 text-white py-3 rounded-xl font-semibold transition-colors text-sm">
                        Pesan Sekarang
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
