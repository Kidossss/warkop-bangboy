@extends('layouts.admin')
@section('title', 'Kelola Produk')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold text-gray-900">Produk</h1>
    <a href="{{ route('admin.products.create') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-xl transition-colors">
        <i class="fas fa-plus mr-1"></i> Tambah Produk
    </a>
</div>

<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Produk</th>
                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Kategori</th>
                <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Harga</th>
                <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Status</th>
                <th class="px-6 py-3 text-center text-sm font-semibold text-gray-700">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            @forelse($products as $product)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            @if($product->image)
                                <img src="{{ $product->image }}" class="w-10 h-10 object-cover rounded">
                            @else
                                <div class="w-10 h-10 bg-emerald-100 rounded flex items-center justify-center"><i class="fas fa-coffee text-emerald-400"></i></div>
                            @endif
                            <div>
                                <p class="font-medium">{{ $product->name }}</p>
                                <p class="text-xs text-gray-500 line-clamp-1">{{ $product->description }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm">{{ $product->category->name ?? '-' }}</td>
                    <td class="px-6 py-4 text-center">{{ $product->formatted_price }}</td>
                    <td class="px-6 py-4 text-center">
                        <span class="px-2 py-1 text-xs rounded-full {{ $product->is_available ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $product->is_available ? 'Tersedia' : 'Habis' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <a href="{{ route('admin.products.edit', $product) }}" class="text-blue-500 hover:text-blue-700 mr-3"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus produk ini?')">
                            @csrf @method('DELETE')
                            <button class="text-red-500 hover:text-red-700"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="px-6 py-8 text-center text-gray-500">Belum ada produk</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $products->links() }}</div>
@endsection
