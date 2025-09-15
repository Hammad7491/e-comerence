@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-3">
        <h1 class="text-3xl font-bold text-slate-800">Products</h1>
        <a href="{{ route('admin.products.create') }}"
           class="inline-flex items-center px-4 py-2 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white font-semibold shadow">
            + Add Product
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 rounded-lg border border-green-200 bg-green-50 p-3 text-green-800">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-hidden bg-white rounded-2xl ring-1 ring-slate-100 shadow-lg">
        <table class="min-w-full divide-y divide-slate-100">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-slate-600">Image</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-slate-600">Name</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-slate-600">Price</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-slate-600">Stock</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-slate-600">Status</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-slate-600">Created</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-slate-600">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($products as $product)
                <tr>
                    <td class="px-4 py-3">
                        @php $img = $product->firstImageUrl(); @endphp
                        @if($img)
                            <img src="{{ $img }}" class="w-14 h-14 object-cover rounded-md ring-1 ring-slate-200 shadow-sm" alt="">
                        @else
                            <div class="w-14 h-14 rounded-md bg-slate-100 text-slate-400 flex items-center justify-center text-xs">N/A</div>
                        @endif
                    </td>
                    <td class="px-4 py-3 font-medium text-slate-800">{{ $product->name }}</td>
                    <td class="px-4 py-3">
                        <span class="text-indigo-600 font-bold">
                            ${{ number_format($product->final_price, 2) }}
                        </span>
                        @if(!is_null($product->original_price) && $product->original_price > $product->final_price)
                            <span class="ml-2 line-through text-slate-400">
                                ${{ number_format($product->original_price, 2) }}
                            </span>
                        @endif
                    </td>
                    <td class="px-4 py-3">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-sm
                                     {{ $product->stock > 0 ? 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200' : 'bg-rose-50 text-rose-700 ring-1 ring-rose-200' }}">
                            {{ $product->stock }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        @if($product->is_active)
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-sm bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200">Active</span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-sm bg-slate-100 text-slate-700 ring-1 ring-slate-200">Inactive</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-slate-500 text-sm">{{ $product->created_at->format('M d, Y') }}</td>
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.products.edit', $product) }}"
                               class="px-3 py-1.5 rounded-md bg-blue-600 hover:bg-blue-700 text-white text-sm">Edit</a>
                            <form method="POST" action="{{ route('admin.products.destroy', $product) }}"
                                  onsubmit="return confirm('Delete this product?')">
                                @csrf @method('DELETE')
                                <button class="px-3 py-1.5 rounded-md bg-rose-600 hover:bg-rose-700 text-white text-sm">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-4 py-8 text-center text-slate-500">No products found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $products->links() }}
    </div>
</div>
@endsection
