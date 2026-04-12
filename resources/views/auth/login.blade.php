<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Warkop Bangboy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>* { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full mx-6">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-slate-900"><span class="text-emerald-500">Warkop</span> Bangboy</h1>
            <p class="text-slate-400 text-sm mt-2">Masuk ke Panel Admin</p>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 p-8">
            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl mb-4 text-sm">
                    <i class="fas fa-exclamation-circle mr-1"></i> {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-medium text-slate-500 mb-1.5">Email</label>
                    <input type="email" name="email" required value="{{ old('email') }}"
                           class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 focus:outline-none focus:border-transparent"
                           placeholder="admin@warkopbangboy.com">
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-500 mb-1.5">Password</label>
                    <input type="password" name="password" required
                           class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500 focus:outline-none focus:border-transparent"
                           placeholder="Masukkan password">
                </div>
                <div class="flex items-center">
                    <input type="checkbox" name="remember" id="remember" class="rounded border-slate-300 text-emerald-500 focus:ring-emerald-500 mr-2">
                    <label for="remember" class="text-xs text-slate-500">Ingat saya</label>
                </div>
                <button type="submit" class="w-full bg-slate-900 hover:bg-emerald-600 text-white py-3 rounded-xl font-semibold transition-colors text-sm">
                    Masuk
                </button>
            </form>

            <div class="mt-4 text-center">
                <a href="{{ route('home') }}" class="text-slate-400 hover:text-emerald-600 text-sm transition">&larr; Kembali ke Website</a>
            </div>
        </div>
    </div>
</body>
</html>
