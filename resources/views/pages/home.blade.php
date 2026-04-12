@extends('layouts.app')
@section('title', 'Warkop Bang Boy - Kedai Kopi 24 Jam Jakarta Utara')

@section('content')
{{-- Hero --}}
<section class="relative min-h-[90vh] flex items-center justify-center overflow-hidden">
    <div class="absolute inset-0 bg-dark-950/70 z-10"></div>
    <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('/uploads/warkop-bangboy.jpeg')"></div>
    <div class="relative z-20 text-center text-white px-6 max-w-3xl mx-auto">
        <span class="inline-block bg-primary-500/20 text-primary-300 text-xs font-semibold uppercase tracking-widest px-4 py-1.5 rounded-full mb-6 border border-primary-500/30">Buka 24 Jam</span>
        <h1 class="text-5xl md:text-7xl font-bold mb-6 leading-tight">
            Warkop<br><span class="text-primary-400">Bang Boy</span>
        </h1>
        <p class="text-lg md:text-xl text-dark-300 mb-10 max-w-xl mx-auto">
            Kedai kopi & tempat nongkrong favorit di Semper, Jakarta Utara
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="#menu" class="bg-primary-500 hover:bg-primary-600 text-white px-8 py-3.5 rounded-full font-semibold transition-all hover:shadow-lg hover:shadow-primary-500/25">
                Lihat Menu
            </a>
            <a href="#about" class="bg-white/10 hover:bg-white/20 text-white px-8 py-3.5 rounded-full font-semibold transition-all backdrop-blur-sm border border-white/20">
                Tentang Kami
            </a>
        </div>
    </div>
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 z-20 animate-bounce">
        <i class="fas fa-chevron-down text-white/50"></i>
    </div>
</section>

{{-- Features --}}
<section class="py-20 bg-white">
    <div class="container mx-auto px-6">
        <div class="text-center mb-12">
            <span class="text-primary-600 text-xs font-semibold uppercase tracking-widest">Kenapa Warkop Bang Boy?</span>
            <h2 class="text-3xl font-bold text-dark-900 mt-2">Yang Bikin Betah Nongkrong</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-5">
            <div class="p-6 rounded-2xl bg-dark-50 border border-dark-100 hover:border-emerald-200 hover:bg-emerald-50/50 transition-all duration-300 cursor-default">
                <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center mb-4">
                    <i class="fas fa-mug-hot text-lg text-emerald-600"></i>
                </div>
                <h3 class="text-lg font-bold text-dark-900 mb-2">Kedai Kopi</h3>
                <p class="text-dark-500 text-sm leading-relaxed">Kopi saring, signature, V60, dan aneka minuman sachet</p>
            </div>
            <div class="p-6 rounded-2xl bg-dark-50 border border-dark-100 hover:border-amber-200 hover:bg-amber-50/50 transition-all duration-300 cursor-default">
                <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center mb-4">
                    <i class="fas fa-clock text-lg text-amber-600"></i>
                </div>
                <h3 class="text-lg font-bold text-dark-900 mb-2">24 Jam Nonstop</h3>
                <p class="text-dark-500 text-sm leading-relaxed">Buka setiap hari tanpa libur, dari pagi sampai pagi lagi</p>
            </div>
            <div class="p-6 rounded-2xl bg-dark-50 border border-dark-100 hover:border-blue-200 hover:bg-blue-50/50 transition-all duration-300 cursor-default">
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mb-4">
                    <i class="fas fa-utensils text-lg text-blue-600"></i>
                </div>
                <h3 class="text-lg font-bold text-dark-900 mb-2">Menu Lengkap</h3>
                <p class="text-dark-500 text-sm leading-relaxed">Indomie, nasi goreng, omelet, cemilan, dan 55+ menu lainnya</p>
            </div>
            <div class="p-6 rounded-2xl bg-dark-50 border border-dark-100 hover:border-violet-200 hover:bg-violet-50/50 transition-all duration-300 cursor-default">
                <div class="w-12 h-12 bg-violet-100 rounded-xl flex items-center justify-center mb-4">
                    <i class="fas fa-location-dot text-lg text-violet-600"></i>
                </div>
                <h3 class="text-lg font-bold text-dark-900 mb-2">Lokasi Strategis</h3>
                <p class="text-dark-500 text-sm leading-relaxed">Simpang Lima Semper, samping Alfamidi Tipar Cakung 2</p>
            </div>
        </div>
    </div>
</section>

{{-- Menu --}}
<section id="menu" class="py-20 bg-dark-50">
    <div class="container mx-auto px-6">
        <div class="text-center mb-14">
            <span class="text-primary-600 text-xs font-semibold uppercase tracking-widest">Menu Kami</span>
            <h2 class="text-3xl md:text-4xl font-bold text-dark-900 mt-2">Pilih Favoritmu</h2>
        </div>

        @foreach($categories as $category)
            @if($category->products->count() > 0)
                <div class="mb-14">
                    <div class="flex items-center gap-3 mb-6">
                        <h3 class="text-xl font-bold text-dark-800">{{ $category->name }}</h3>
                        <div class="flex-1 h-px bg-dark-200"></div>
                        <span class="text-xs text-dark-400 bg-dark-100 px-3 py-1 rounded-full">{{ $category->products->count() }} item</span>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
                        @foreach($category->products as $product)
                            <div class="bg-white rounded-2xl overflow-hidden hover:shadow-lg transition-all duration-300 group border border-dark-100 hover:border-primary-200">
                                <div class="h-44 bg-gradient-to-br from-dark-100 to-dark-50 overflow-hidden relative">
                                    @if($product->image)
                                        <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <i class="fas fa-utensils text-4xl text-dark-300"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="p-4">
                                    <h4 class="font-semibold text-dark-900 mb-1">{{ $product->name }}</h4>
                                    <p class="text-dark-400 text-xs mb-3 line-clamp-2">{{ $product->description }}</p>
                                    <div class="flex justify-between items-center">
                                        <span class="text-primary-600 font-bold">{{ $product->formatted_price }}</span>
                                        <form action="{{ route('cart.add', $product) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="bg-dark-900 hover:bg-primary-600 text-white w-9 h-9 rounded-xl flex items-center justify-center transition-colors">
                                                <i class="fas fa-plus text-xs"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</section>

{{-- About --}}
<section id="about" class="py-20 bg-white">
    <div class="container mx-auto px-6">
        <div class="text-center mb-14">
            <span class="text-primary-600 text-xs font-semibold uppercase tracking-widest">Tentang Kami</span>
            <h2 class="text-3xl md:text-4xl font-bold text-dark-900 mt-2">Warkop Bang Boy</h2>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-start">
            <div>
                <p class="text-dark-500 mb-6 leading-relaxed">
                    Warkop Bang Boy adalah kedai kopi yang berlokasi di kawasan Semper, Jakarta Utara. 
                    Kami hadir sebagai tempat nongkrong favorit warga sekitar dengan menyajikan berbagai menu 
                    mulai dari aneka minuman, kopi signature, indomie, makanan berat, sampai cemilan — semua 
                    dengan harga yang sangat bersahabat.
                </p>
                <p class="text-dark-500 mb-8 leading-relaxed">
                    Dengan konsep buka 24 jam nonstop setiap hari, Warkop Bang Boy siap menemani Anda 
                    kapan saja — baik untuk nongkrong santai, begadang, kerja tugas, atau sekedar 
                    menikmati secangkir kopi hangat di tengah malam.
                </p>

                <div class="flex gap-8 mb-10">
                    <div>
                        <div class="text-3xl font-bold text-dark-900">{{ $products->count() }}+</div>
                        <div class="text-dark-400 text-sm mt-1">Menu</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold text-dark-900">24</div>
                        <div class="text-dark-400 text-sm mt-1">Jam Buka</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold text-dark-900">4.4</div>
                        <div class="text-dark-400 text-sm mt-1">Rating Google</div>
                    </div>
                    <div>
                        <div class="text-3xl font-bold text-dark-900">50+</div>
                        <div class="text-dark-400 text-sm mt-1">Ulasan</div>
                    </div>
                </div>

                {{-- Info Detail --}}
                <div class="space-y-4">
                    <div class="flex items-start gap-4 p-4 bg-dark-50 rounded-2xl">
                        <div class="w-10 h-10 bg-primary-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-map-marker-alt text-primary-600"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-dark-900 text-sm">Alamat</h4>
                            <p class="text-dark-500 text-sm">Jalan Tipar Cakung No.212 RT 01/01 Semper Barat, Samping Alfamidi Tipar Cakung 2 Semper, Simpang Lima Semper, Jakarta Utara, DKI Jakarta 14130</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4 p-4 bg-dark-50 rounded-2xl">
                        <div class="w-10 h-10 bg-primary-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-phone text-primary-600"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-dark-900 text-sm">Telepon</h4>
                            <p class="text-dark-500 text-sm">0877-8337-2739</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4 p-4 bg-dark-50 rounded-2xl">
                        <div class="w-10 h-10 bg-primary-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-clock text-primary-600"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-dark-900 text-sm">Jam Operasional</h4>
                            <p class="text-dark-500 text-sm">Buka 24 Jam — Senin sampai Minggu</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4 p-4 bg-dark-50 rounded-2xl">
                        <div class="w-10 h-10 bg-primary-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-star text-primary-600"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-dark-900 text-sm">Rating Google</h4>
                            <p class="text-dark-500 text-sm">4.4 dari 5 bintang — berdasarkan 50 ulasan Google</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                {{-- Image --}}
                <div class="rounded-3xl overflow-hidden">
                    <img src="/uploads/warkop-bangboy.jpeg" alt="Interior Warkop Bang Boy" class="w-full h-[350px] object-cover">
                </div>

                {{-- Google Maps Embed --}}
                <div class="rounded-2xl overflow-hidden border border-dark-100">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.7!2d106.9!3d-6.13!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNsKwMDcnNDguMCJTIDEwNsKwNTQnMDAuMCJF!5e0!3m2!1sid!2sid!4v1700000000000" 
                        width="100%" 
                        height="250" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>

                {{-- CTA --}}
                <div class="bg-primary-50 rounded-2xl p-6 text-center border border-primary-100">
                    <h4 class="font-bold text-dark-900 mb-2">Mau pesan langsung?</h4>
                    <p class="text-dark-500 text-sm mb-4">Hubungi kami via WhatsApp untuk pesan antar</p>
                    <a href="https://wa.me/6287783372739" target="_blank" 
                       class="inline-flex items-center gap-2 bg-primary-500 hover:bg-primary-600 text-white px-6 py-2.5 rounded-xl font-semibold transition-colors text-sm">
                        <i class="fab fa-whatsapp text-lg"></i> Chat WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
