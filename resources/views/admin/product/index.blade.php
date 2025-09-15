@extends('layouts.app')

@section('content')
<style>
:root{--ink:#0f172a;--muted:#64748b;--ring:rgba(79,70,229,.18);--indigo:#4f46e5;--rose:#e11d48;--blue:#2563eb}
.page{max-width:1120px;margin:0 auto;padding:28px 16px}
.h1{font:800 44px/1.05 ui-sans-serif,system-ui,"Segoe UI",Roboto,Ubuntu,"Helvetica Neue",Arial;color:var(--ink);letter-spacing:-.02em}
.toolbar{display:flex;gap:10px;flex-wrap:wrap}
.toolbar input[type="search"],.toolbar select{border:1px solid #e5e7eb;border-radius:.75rem;padding:.6rem .9rem;min-width:220px;outline:none}
.toolbar input[type="search"]:focus{border-color:var(--indigo);box-shadow:0 0 0 .35rem var(--ring)}
.btn-primary{display:inline-flex;align-items:center;justify-content:center;padding:.6rem 1rem;border-radius:.7rem;background:var(--indigo);color:#fff;font-weight:800;text-decoration:none;box-shadow:0 6px 14px rgba(79,70,229,.25)}
.badge{display:inline-flex;align-items:center;padding:.25rem .55rem;border-radius:.5rem;font-weight:700;font-size:.75rem}
.badge.stock{background:#ecfdf5;color:#065f46;border:1px solid #a7f3d0}
.badge.out{background:#fff1f2;color:#9f1239;border:1px solid #fecdd3}
.badge.active{background:#eef2ff;color:#3730a3;border:1px solid #c7d2fe}
.badge.inactive{background:#f1f5f9;color:#334155;border:1px solid #e2e8f0}
.table-wrap{overflow:hidden;background:#fff;border:1px solid #eef2f7;border-radius:1rem;box-shadow:0 8px 20px rgba(2,6,23,.06)}
table{width:100%;border-collapse:collapse}
thead th{background:#f8fafc;font:600 13px/1 ui-sans-serif;color:#475569;text-align:left;padding:12px 14px;border-bottom:1px solid #e2e8f0}
tbody td{padding:12px 14px;border-top:1px solid #f1f5f9}
tr:hover{background:#fafafa}
.thumb{width:56px;height:56px;border-radius:.6rem;object-fit:cover;border:1px solid #e5e7eb;box-shadow:0 4px 10px rgba(2,6,23,.06);background:#f1f5f9}
.btn-sm{padding:.4rem .7rem;font-size:.8rem;font-weight:700;border-radius:.5rem}
.btn-edit{background:#2563eb;color:#fff}.btn-edit:hover{background:#1e40af}
.btn-del{background:#e11d48;color:#fff}.btn-del:hover{background:#9f1239}
.price-main{color:#4f46e5;font-weight:800}
.price-old{color:#94a3b8;text-decoration:line-through}
</style>

<div class="page">
  <div style="display:grid;grid-template-columns:1fr auto;gap:16px;align-items:center;margin-bottom:16px">
    <h1 class="h1">Products</h1>
    <div style="display:flex;gap:10px;justify-content:flex-end;flex-wrap:wrap">
      <form method="GET" class="toolbar">
        <input type="search" name="q" placeholder="Search products…" value="{{ request('q') }}">
        <select name="status" onchange="this.form.submit()">
          @php $status = request('status'); @endphp
          <option value="">All</option>
          <option value="active"   @selected($status==='active')>Active</option>
          <option value="inactive" @selected($status==='inactive')>Inactive</option>
          <option value="instock"  @selected($status==='instock')>In stock</option>
          <option value="out"      @selected($status==='out')>Out of stock</option>
        </select>
        <button hidden>Filter</button>
      </form>
      <a href="{{ route('admin.products.create') }}" class="btn-primary">+ Add Product</a>
    </div>
  </div>

  @if(session('success'))
    <div style="margin:8px 0 16px;padding:12px 14px;border-radius:.75rem;background:#ecfdf5;color:#14532d;border:1px solid #a7f3d0;">
      {{ session('success') }}
    </div>
  @endif

  <div class="table-wrap">
    <table>
      <thead>
        <tr>
          <th>Images</th>
          <th>Name</th>
          <th>Price</th>
          <th>Stock</th>
          <th>Status</th>
          <th>Created</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
      @forelse($products as $product)
        <tr>
          <td>
            <div style="display:flex;gap:8px;align-items:center">
              @php
                $urls = is_array($product->images)
                  ? collect($product->images)->take(3)->map(fn($p)=>Storage::disk('public')->url($p))->all()
                  : [];
              @endphp
              @if(count($urls))
                @foreach($urls as $u)
                  <img class="thumb" src="{{ $u }}" alt="img" onerror="this.removeAttribute('src');">
                @endforeach
              @else
                <div class="thumb"></div>
              @endif
            </div>
          </td>
          <td style="font-weight:700;color:#0f172a">{{ $product->name }}</td>
          <td>
            <span class="price-main">${{ number_format($product->final_price, 2) }}</span>
            @if(!is_null($product->original_price) && $product->original_price > $product->final_price)
              <span class="price-old" style="margin-left:6px">${{ number_format($product->original_price, 2) }}</span>
            @endif
          </td>
          <td>
            <span class="badge {{ $product->stock > 0 ? 'stock' : 'out' }}">{{ $product->stock > 0 ? $product->stock : '0' }}</span>
          </td>
          <td>
            <span class="badge {{ $product->is_active ? 'active' : 'inactive' }}">{{ $product->is_active ? 'Active' : 'Inactive' }}</span>
          </td>
          <td style="color:#64748b;font-size:13px">{{ $product->created_at->format('M d, Y') }}</td>
          <td>
            <div style="display:flex;gap:8px">
              <a href="{{ route('admin.products.edit',$product) }}" class="btn-sm btn-edit">✏ Edit</a>
              <form method="POST" action="{{ route('admin.products.destroy',$product) }}"
                    onsubmit="return confirm('Delete this product?')">
                @csrf @method('DELETE')
                <button class="btn-sm btn-del">🗑 Delete</button>
              </form>
            </div>
          </td>
        </tr>
      @empty
        <tr><td colspan="7" style="text-align:center;color:#64748b;padding:24px">No products found.</td></tr>
      @endforelse
      </tbody>
    </table>
  </div>

  <div style="margin-top:18px">
    {{ $products->appends(['q'=>request('q'),'status'=>request('status')])->links() }}
  </div>
</div>
@endsection
