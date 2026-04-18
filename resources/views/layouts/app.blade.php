<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Warkop Bang Boy')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: { 50:'#f0fdf4',100:'#dcfce7',200:'#bbf7d0',300:'#86efac',400:'#4ade80',500:'#22c55e',600:'#16a34a',700:'#15803d',800:'#166534',900:'#14532d' },
                        dark: { 50:'#f8fafc',100:'#f1f5f9',200:'#e2e8f0',300:'#cbd5e1',400:'#94a3b8',500:'#64748b',600:'#475569',700:'#334155',800:'#1e293b',900:'#0f172a',950:'#020617' },
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Plus Jakarta Sans', sans-serif; }
        html { scroll-behavior: smooth; }
    </style>
</head>
<body class="bg-dark-50 min-h-screen flex flex-col">
    <nav class="bg-dark-900/95 backdrop-blur-md text-white sticky top-0 z-50 border-b border-dark-700/50">
        <div class="container mx-auto px-6">
            <div class="flex justify-between items-center h-16">
                <a href="{{ route('home') }}" class="text-xl font-bold tracking-tight">
                    <span class="text-primary-400">Warkop</span> Bang Boy
                </a>
                <div class="flex items-center gap-8">
                    <a href="{{ route('home') }}" class="text-sm text-dark-300 hover:text-white transition">Home</a>
                    <a href="{{ route('home') }}#menu" class="text-sm text-dark-300 hover:text-white transition">Menu</a>
                    <a href="{{ route('home') }}#about" class="text-sm text-dark-300 hover:text-white transition">Tentang</a>
                    <a href="{{ route('admin.dashboard') }}" class="text-xs bg-dark-700 hover:bg-dark-600 text-dark-200 px-3 py-1.5 rounded-full transition">Admin</a>
                    <a href="{{ route('cart.index') }}" class="relative text-dark-300 hover:text-white transition">
                        <i class="fas fa-shopping-bag"></i>
                        @php $cartCount = count(session('cart', [])); @endphp
                        @if($cartCount > 0)
                            <span class="absolute -top-2 -right-2.5 bg-primary-500 text-white text-[10px] font-bold rounded-full w-4 h-4 flex items-center justify-center">{{ $cartCount }}</span>
                        @endif
                    </a>
                </div>
            </div>
        </div>
    </nav>

    @if(session('success'))
        <div class="bg-primary-50 border-b border-primary-200 text-primary-800 px-4 py-3 text-center text-sm" id="flash-msg">
            <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-50 border-b border-red-200 text-red-700 px-4 py-3 text-center text-sm">
            <i class="fas fa-exclamation-circle mr-1"></i> {{ session('error') }}
        </div>
    @endif

    <main class="flex-1">
        @yield('content')
    </main>

    <footer class="bg-dark-900 text-dark-400 pt-16 pb-8">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 mb-12">
                <div>
                    <h3 class="text-white text-lg font-bold mb-4"><span class="text-primary-400">Warkop</span> Bang Boy</h3>
                    <p class="text-sm leading-relaxed mb-4">Kedai kopi & tempat nongkrong favorit di Semper, Jakarta Utara. Menu lengkap, harga terjangkau!</p>
                    <div class="flex items-center gap-1 text-sm">
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star text-yellow-400"></i>
                        <i class="fas fa-star-half-alt text-yellow-400"></i>
                        <span class="text-dark-400 ml-2">4.4 / 5 (50 ulasan)</span>
                    </div>
                </div>
                <div>
                    <h4 class="text-white text-sm font-semibold uppercase tracking-wider mb-4">Jam Buka</h4>
                    <p class="text-sm mb-1">Senin - Minggu</p>
                    <p class="text-primary-400 font-semibold">Buka 24 Jam Nonstop</p>
                </div>
                <div>
                    <h4 class="text-white text-sm font-semibold uppercase tracking-wider mb-4">Kontak & Lokasi</h4>
                    <p class="text-sm mb-2"><i class="fas fa-phone text-primary-400 w-5"></i> 0877-8337-2739</p>
                    <p class="text-sm mb-3"><i class="fas fa-map-marker-alt text-primary-400 w-5"></i> Jl. Tipar Cakung No.212, Semper Barat, Jakarta Utara 14130</p>
                    <a href="https://wa.me/6287783372739" target="_blank" class="inline-flex items-center gap-2 bg-primary-600 hover:bg-primary-700 text-white text-xs px-4 py-2 rounded-lg transition">
                        <i class="fab fa-whatsapp"></i> Chat WhatsApp
                    </a>
                </div>
            </div>
            <div class="border-t border-dark-800 pt-6 text-center text-xs text-dark-500">
                &copy; {{ date('Y') }} Warkop Bang Boy. All rights reserved.
            </div>
        </div>
    </footer>

    <script>
        setTimeout(() => { const f = document.getElementById('flash-msg'); if (f) f.style.display = 'none'; }, 3000);
    </script>
    @stack('scripts')
</body>
</html>
