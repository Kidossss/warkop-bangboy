@extends('layouts.admin')
@section('title', 'Kelola Kategori')

@section('content')
<h1 class="text-3xl font-bold text-gray-900 mb-6">Kategori</h1>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    {{-- Form Tambah --}}
    <div>
        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Tambah Kategori</h2>
            <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama *</label>
                    <input type="text" name="name" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:outline-none"
                           placeholder="Contoh: Kopi">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                    <textarea name="description" rows="2"
                              class="w-full px-3 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:outline-none"
                              placeholder="Deskripsi singkat"></textarea>
                </div>
                <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white py-2 rounded-xl transition-colors">
                    <i class="fas fa-plus mr-1"></i> Tambah
                </button>
            </form>
        </div>
    </div>

    {{-- Daftar Kategori --}}
    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl shadow overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Nama</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Deskripsi</th>
                        <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Produk</th>
                        <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($categories as $category)
                        <tr>
                            <td class="px-6 py-4 font-medium">{{ $category->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $category->description ?? '-' }}</td>
                            <td class="px-6 py-4 text-center">
                                <span class="bg-emerald-100 text-emerald-800 px-2 py-1 rounded-full text-xs">{{ $category->products_count }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Yakin hapus kategori ini?')">
                                    @csrf @method('DELETE')
                                    <button class="text-red-500 hover:text-red-700 text-sm"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="px-6 py-8 text-center text-gray-500">Belum ada kategori</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
