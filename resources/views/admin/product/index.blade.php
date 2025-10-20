@extends('layouts.app')

@section('content')
@php
    use Illuminate\Support\Str;

    /**
     * Build both public & storage URLs for a given image-ish value.
     * $raw can be: "abc.jpg" or "products/abc.jpg" or a full URL.
     * Returns array: ['primary' => url, 'fallback' => url] or null when empty.
     */
    function productImgUrls($raw) {
        if (!$raw) return null;

        // If it's already an absolute URL, use it as both primary/fallback
        if (Str::startsWith($raw, ['http://','https://','//'])) {
            return ['primary' => $raw, 'fallback' => $raw];
        }

        $rel = ltrim($raw, '/');
        $rel = Str::startsWith($rel, 'products/') ? $rel : 'products/' . $rel;

        // Primary tries /public/products/*
        $primary  = asset($rel);
        // Fallback tries /public/storage/products/* (after storage:link)
        $fallback = asset('storage/' . $rel);

        return compact('primary', 'fallback');
    }
@endphp

<style>
:root{
  --ink:#0f172a;--muted:#64748b;--ring:rgba(79,70,229,.18);
  --indigo:#4f46e5;--rose:#e11d48;--blue:#2563eb;--border:#e5e7eb;
}

/* Page + Heading */
.page{max-width:1120px;margin:0 auto;padding:28px 16px}
.h1{font:800 44px/1.05 ui-sans-serif,system-ui,"Segoe UI",Roboto,Ubuntu,"Helvetica Neue",Arial;color:var(--ink);letter-spacing:-.02em;margin:0}

/* Top row layout */
.page-head{display:grid;grid-template-columns:1fr auto;gap:16px;align-items:center;margin-bottom:16px}

/* Controls */
.toolbar{display:flex;gap:10px;flex-wrap:wrap;width:100%}
.toolbar input[type="search"],.toolbar select{
  border:1px solid var(--border);border-radius:.75rem;padding:.6rem .9rem;min-width:220px;outline:none;
  font:600 14px/1 ui-sans-serif;color:#0f172a;background:#fff;
}
.toolbar input[type="search"]::placeholder{color:#9aa3b2}
.toolbar input[type="search"]:focus{border-color:var(--indigo);box-shadow:0 0 0 .35rem var(--ring)}
.btn-primary{
  display:inline-flex;align-items:center;justify-content:center;padding:.6rem 1rem;
  border-radius:.7rem;background:var(--indigo);color:#fff;font-weight:800;text-decoration:none;
  box-shadow:0 6px 14px rgba(79,70,229,.25)
}
.btn-primary:hover{background:#4338ca}

/* Table */
.table-wrap{overflow:auto;background:#fff;border:1px solid #eef2f7;border-radius:1rem;box-shadow:0 8px 20px rgba(2,6,23,.06)}
.table{width:100%;border-collapse:collapse;min-width:880px}
.table thead th{
  background:#f8fafc;font:600 13px/1 ui-sans-serif;color:#475569;text-align:left;padding:12px 14px;
  border-bottom:1px solid #e2e8f0;white-space:nowrap
}
.table tbody td{padding:12px 14px;border-top:1px solid #f1f5f9;vertical-align:middle}
.table tr:hover{background:#fafafa}

/* Shared */
.thumb{width:56px;height:56px;border-radius:.6rem;object-fit:cover;border:1px solid var(--border);box-shadow:0 4px 10px rgba(2,6,23,.06);background:#f1f5f9}
.btn-sm{padding:.4rem .7rem;font-size:.8rem;font-weight:700;border-radius:.5rem;border:0;cursor:pointer}
.btn-edit{background:#2563eb;color:#fff}.btn-edit:hover{background:#1e40af}
.btn-del{background:#e11d48;color:#fff}.btn-del:hover{background:#9f1239}
.price-main{color:#4f46e5;font-weight:800}
.price-old{color:#94a3b8;text-decoration:line-through;margin-left:6px}
.badge{display:inline-flex;align-items:center;padding:.25rem .55rem;border-radius:.5rem;font-weight:700;font-size:.75rem;border:1px solid transparent}
.badge.stock{background:#ecfdf5;color:#065f46;border-color:#a7f3d0}
.badge.out{background:#fff1f2;color:#9f1239;border-color:#fecdd3}
.badge.active{background:#eef2ff;color:#3730a3;border-color:#c7d2fe}
.badge.inactive{background:#f1f5f9;color:#334155;border-color:#e2e8f0}

/* Mobile Cards */
.mobile-list{display:none}
.card{display:grid;grid-template-columns:64px 1fr;gap:12px;padding:12px;border-top:1px solid #eef2f7;background:#fff}
.card:first-child{border-top:none;border-top-left-radius:12px;border-top-right-radius:12px}
.card:last-child{border-bottom-left-radius:12px;border-bottom-right-radius:12px;box-shadow:0 8px 20px rgba(2,6,23,.06)}
.card h3{margin:0 0 4px;font:800 15px/1.2 ui-sans-serif;color:#0f172a}
.card .row{display:flex;flex-wrap:wrap;gap:8px 10px;align-items:center}
.card .meta{color:var(--muted);font:600 12px/1.2 ui-sans-serif}
.card .actions{display:flex;gap:8px;margin-top:10px}
.card .price{font-size:14px}

/* Breakpoints */
@media (max-width:640px){.table-wrap{display:none}.mobile-list{display:block}}
</style>

<div class="page">
  <div class="page-head">
    <h1 class="h1">Products</h1>
    <div style="display:flex;gap:10px;justify-content:flex-end;flex-wrap:wrap">
      <form method="GET" class="toolbar" id="prodFilterForm">
        <input id="prodLiveSearch" type="search" name="q" placeholder="Search products…" value="{{ request('q') }}"
        @php $status = request('status'); @endphp>
        <select id="prodStatusFilter" name="status">
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

  {{-- Desktop/Tablet --}}
  <div class="table-wrap">
    <table class="table">
      <thead>
        <tr>
          <th>Images</th>
          <th>Name</th>
          <th>Price</th>
          <th>Pieces</th>
          <th>Collection</th>
          <th>Stock</th>
          <th>Status</th>
          <th>Created</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody id="prodTbody">
      @forelse($products as $product)
        @php
          $statusTag = $product->is_active ? 'active' : 'inactive';
          $stockTag  = $product->stock > 0 ? 'instock' : 'out';
        @endphp
        <tr class="prod-row"
            data-name="{{ strtolower($product->name) }}"
            data-status="{{ $statusTag }}"
            data-stock="{{ $stockTag }}">
          <td>
            <div style="display:flex;gap:8px;align-items:center">
              @php
                $thumbs = is_array($product->images)
                    ? collect($product->images)->take(3)->map(fn($p) => productImgUrls($p))->filter()->all()
                    : [];
              @endphp

              @if(count($thumbs))
                @foreach($thumbs as $u)
                  <img class="thumb"
                       src="{{ $u['primary'] }}"
                       onerror="if(this.dataset.fbk!=='1'){this.dataset.fbk='1';this.src='{{ $u['fallback'] }}';}else{this.onerror=null;this.src='https://via.placeholder.com/112x112/edf2f7/cbd5e1?text=%20';}"
                       alt="img">
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
              <span class="price-old">${{ number_format($product->original_price, 2) }}</span>
            @endif
          </td>

          <td style="font-weight:600;color:#334155">{{ ucfirst($product->pieces) }}</td>
          <td style="font-weight:600;color:#334155">{{ ucfirst($product->collection) }}</td>

          <td>
            <span class="badge {{ $product->stock > 0 ? 'stock' : 'out' }}">{{ $product->stock > 0 ? $product->stock : '0' }}</span>
          </td>

          <td>
            <span class="badge {{ $product->is_active ? 'active' : 'inactive' }}">{{ $product->is_active ? 'Active' : 'Inactive' }}</span>
          </td>

          <td style="color:#64748b;font-size:13px">{{ $product->created_at->format('M d, Y') }}</td>

          <td>
            <div style="display:flex;gap:8px;flex-wrap:wrap">
              <a href="{{ route('admin.products.edit',$product) }}" class="btn-sm btn-edit">✏ Edit</a>
              <form method="POST" action="{{ route('admin.products.destroy',$product) }}" onsubmit="return confirm('Delete this product?')">
                @csrf @method('DELETE')
                <button class="btn-sm btn-del">🗑 Delete</button>
              </form>
            </div>
          </td>
        </tr>
      @empty
        <tr><td colspan="9" style="text-align:center;color:#64748b;padding:24px">No products found.</td></tr>
      @endforelse
      {{-- no-match placeholder for desktop --}}
      <tr id="prodNoMatchRow" style="display:none;"><td colspan="9" style="text-align:center;color:#64748b;padding:24px">No products match your filters.</td></tr>
      </tbody>
    </table>
  </div>

  {{-- Mobile --}}
  <div class="mobile-list" id="prodMobile">
    @forelse($products as $product)
      @php
        $imgPair = (is_array($product->images) && count($product->images)) ? productImgUrls($product->images[0]) : null;
        $statusTag = $product->is_active ? 'active' : 'inactive';
        $stockTag  = $product->stock > 0 ? 'instock' : 'out';
      @endphp
      <article class="card prod-card"
               data-name="{{ strtolower($product->name) }}"
               data-status="{{ $statusTag }}"
               data-stock="{{ $stockTag }}">
        @if($imgPair)
          <img class="thumb"
               src="{{ $imgPair['primary'] }}"
               onerror="if(this.dataset.fbk!=='1'){this.dataset.fbk='1';this.src='{{ $imgPair['fallback'] }}';}else{this.onerror=null;this.src='https://via.placeholder.com/112x112/edf2f7/cbd5e1?text=%20';}"
               alt="img">
        @else
          <div class="thumb"></div>
        @endif

        <div>
          <h3>{{ $product->name }}</h3>
          <div class="row">
            <div class="price">
              <span class="price-main">${{ number_format($product->final_price, 2) }}</span>
              @if(!is_null($product->original_price) && $product->original_price > $product->final_price)
                <span class="price-old">${{ number_format($product->original_price, 2) }}</span>
              @endif
            </div>
            <span class="meta">{{ ucfirst($product->pieces) }}</span>
            <span class="meta">{{ ucfirst($product->collection) }}</span>
            <span class="badge {{ $product->stock > 0 ? 'stock' : 'out' }}">{{ $product->stock > 0 ? $product->stock : '0' }}</span>
            <span class="badge {{ $product->is_active ? 'active' : 'inactive' }}">{{ $product->is_active ? 'Active' : 'Inactive' }}</span>
          </div>
          <div class="meta" style="margin-top:6px">Created: {{ $product->created_at->format('M d, Y') }}</div>

          <div class="actions">
            <a href="{{ route('admin.products.edit',$product) }}" class="btn-sm btn-edit">✏ Edit</a>
            <form method="POST" action="{{ route('admin.products.destroy',$product) }}" onsubmit="return confirm('Delete this product?')">
              @csrf @method('DELETE')
              <button class="btn-sm btn-del">🗑 Delete</button>
            </form>
          </div>
        </div>
      </article>
    @empty
      <div style="text-align:center;color:#64748b;padding:24px;background:#fff;border-radius:12px;border:1px solid #eef2f7">
        No products found.
      </div>
    @endforelse

    {{-- no-match placeholder for mobile --}}
    <div id="prodNoMatchMobile" style="display:none;text-align:center;color:#64748b;padding:16px">No products match your filters.</div>
  </div>

  <div style="margin-top:18px">
    {{ $products->appends(['q'=>request('q'),'status'=>request('status')])->links() }}
  </div>
</div>

{{-- Real-time filter (name + dropdown) for current page --}}
<script>
(function(){
  const searchInput = document.getElementById('prodLiveSearch');
  const statusSel   = document.getElementById('prodStatusFilter');

  const rows   = Array.from(document.querySelectorAll('.prod-row'));
  const cards  = Array.from(document.querySelectorAll('.prod-card'));

  const noRow  = document.getElementById('prodNoMatchRow');
  const noCard = document.getElementById('prodNoMatchMobile');

  const norm = s => (s || '').toLowerCase().trim();

  function matchStatus(node, wanted){
    if (!wanted) return true;
    if (wanted === 'active' || wanted === 'inactive'){
      return (node.dataset.status || '') === wanted;
    }
    if (wanted === 'instock' || wanted === 'out'){
      return (node.dataset.stock || '') === wanted;
    }
    return true;
  }

  function applyFilter(){
    const q = norm(searchInput?.value || '');
    const wanted = statusSel?.value || '';

    let shownRows = 0;
    rows.forEach(tr => {
      const nameOk = !q || (tr.dataset.name || '').includes(q);
      const statusOk = matchStatus(tr, wanted);
      const show = nameOk && statusOk;
      tr.style.display = show ? '' : 'none';
      if (show) shownRows++;
    });
    if (noRow) noRow.style.display = (shownRows === 0 && rows.length) ? '' : 'none';

    let shownCards = 0;
    cards.forEach(card => {
      const nameOk = !q || (card.dataset.name || '').includes(q);
      const statusOk = matchStatus(card, wanted);
      const show = nameOk && statusOk;
      card.style.display = show ? '' : 'none';
      if (show) shownCards++;
    });
    if (noCard) noCard.style.display = (shownCards === 0 && cards.length) ? '' : 'none';
  }

  searchInput?.addEventListener('input', applyFilter);
  statusSel?.addEventListener('change', applyFilter);

  // Run once on load, honoring any server-provided ?q= and ?status=
  applyFilter();

  // Optional: prevent accidental submit on Enter in search
  document.getElementById('prodFilterForm')?.addEventListener('submit', function(e){
    e.preventDefault();
    applyFilter();
  });
})();
</script>
@endsection
