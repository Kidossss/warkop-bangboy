<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin - Warkop Bang Boy')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>* { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-slate-50 min-h-screen">
    <div class="flex">
        <aside class="w-60 bg-slate-900 text-white min-h-screen fixed">
            <div class="p-6 border-b border-slate-700/50">
                <h2 class="font-bold text-lg"><span class="text-emerald-400">Warkop</span> Bang Boy</h2>
                <p class="text-slate-500 text-xs mt-1">Admin Panel</p>
            </div>
            <nav class="mt-2 px-3 space-y-1">
                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm transition {{ request()->routeIs('admin.dashboard') ? 'bg-emerald-500/10 text-emerald-400' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                    <i class="fas fa-chart-pie w-4 text-center"></i> Dashboard
                </a>
                <a href="{{ route('admin.analytics') }}"
                   class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm transition {{ request()->routeIs('admin.analytics') ? 'bg-emerald-500/10 text-emerald-400' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                    <i class="fas fa-chart-line w-4 text-center"></i> Analisis & Prediksi
                </a>
                <a href="{{ route('admin.orders.index') }}"
                   class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm transition {{ request()->routeIs('admin.orders.*') ? 'bg-emerald-500/10 text-emerald-400' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                    <i class="fas fa-receipt w-4 text-center"></i> Pesanan
                    @php $pendingCount = \App\Models\Order::where('status', 'pending')->count(); @endphp
                    @if($pendingCount > 0)
                        <span class="bg-red-500 text-[10px] font-bold rounded-full px-1.5 py-0.5 ml-auto">{{ $pendingCount }}</span>
                    @endif
                </a>
                <a href="{{ route('admin.products.index') }}"
                   class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm transition {{ request()->routeIs('admin.products.*') ? 'bg-emerald-500/10 text-emerald-400' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                    <i class="fas fa-box w-4 text-center"></i> Produk
                </a>
                <a href="{{ route('admin.categories.index') }}"
                   class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm transition {{ request()->routeIs('admin.categories.*') ? 'bg-emerald-500/10 text-emerald-400' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                    <i class="fas fa-tags w-4 text-center"></i> Kategori
                </a>
                <div class="border-t border-slate-700/50 my-3"></div>
                <a href="{{ route('home') }}" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm text-slate-400 hover:text-white hover:bg-slate-800 transition">
                    <i class="fas fa-globe w-4 text-center"></i> Lihat Website
                </a>
                <form action="{{ route('logout') }}" method="POST">@csrf
                    <button type="submit" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm text-red-400 hover:text-red-300 hover:bg-red-500/10 transition w-full">
                        <i class="fas fa-sign-out-alt w-4 text-center"></i> Logout
                    </button>
                </form>
            </nav>
            <div class="absolute bottom-4 left-0 right-0 px-6">
                <div class="bg-slate-800 rounded-xl p-3 text-xs text-slate-500">
                    <i class="fas fa-user-circle mr-1"></i> {{ auth()->user()->name ?? '' }}
                </div>
            </div>
        </aside>

        <main class="ml-60 flex-1 p-8 min-h-screen">
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl mb-6 text-sm" id="flash-msg">
                    <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl mb-6 text-sm">
                    <i class="fas fa-exclamation-circle mr-1"></i> {{ session('error') }}
                </div>
            @endif
            @yield('content')
        </main>
    </div>
    <script>setTimeout(() => { const f = document.getElementById('flash-msg'); if (f) f.style.display = 'none'; }, 3000);</script>
    @stack('scripts')
</body>
</html>
