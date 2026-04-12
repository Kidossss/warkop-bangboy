@extends('layouts.admin')
@section('title', 'Tambah Produk')

@section('content')
<div class="flex items-center gap-4 mb-6">
    <a href="{{ route('admin.products.index') }}" class="text-gray-500 hover:text-gray-700"><i class="fas fa-arrow-left"></i></a>
    <h1 class="text-3xl font-bold text-gray-900">Tambah Produk</h1>
</div>

<div class="bg-white rounded-xl shadow p-6 max-w-2xl">
    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Produk *</label>
            <input type="text" name="name" required value="{{ old('name') }}"
                   class="w-full px-3 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:outline-none">
            @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Harga (Rp) *</label>
                <input type="number" name="price" required min="0" value="{{ old('price') }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                @error('price') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Kategori *</label>
                <select name="category_id" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                    <option value="">Pilih Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
                @error('category_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
            <textarea name="description" rows="3"
                      class="w-full px-3 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-emerald-500 focus:outline-none">{{ old('description') }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Gambar</label>
            <input type="file" name="image" accept="image/*"
                   class="w-full px-3 py-2 border border-gray-300 rounded-xl">
            @error('image') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div class="flex items-center gap-2">
            <input type="checkbox" name="is_available" value="1" id="is_available" checked>
            <label for="is_available" class="text-sm text-gray-700">Tersedia untuk dijual</label>
        </div>

        <div class="flex gap-3 pt-4">
            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-2 rounded-xl transition-colors">Simpan Produk</button>
            <a href="{{ route('admin.products.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2 rounded-xl transition-colors">Batal</a>
        </div>
    </form>
</div>
@endsection
