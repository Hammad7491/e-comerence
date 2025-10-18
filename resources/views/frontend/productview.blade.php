@extends('frontend.layouts.app')

@section('title', 'Product View')

@section('styles')
<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
<style>
html, body{
  font-family:"Manrope", system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans";
  color:#0f0f10;
  -webkit-font-smoothing:antialiased;
  -moz-osx-font-smoothing:grayscale;
  text-rendering:optimizeLegibility;
}

/* ===== HERO ===== */
.pv-hero{
  background:#2a2a2c; color:#fff; min-height:300px;
  display:flex; align-items:center; justify-content:center;
  position:relative; overflow:hidden; text-align:center;
}
.pv-hero .fx{ position:relative; z-index:2; }
.pv-eyebrow{ font:800 30px/1.2 "Manrope"; letter-spacing:.18em; text-transform:uppercase; margin-bottom:6px; }
.pv-path{ color:#cfcfcf; font:600 18px/1.3 "Manrope"; letter-spacing:.12em; text-transform:uppercase; }
.pv-ghost{
  position:absolute; inset:0; display:flex; align-items:center; justify-content:center;
  font:900 clamp(120px,18vw,240px)/.9 "Manrope"; color:#ffffff14; letter-spacing:.08em; z-index:1; pointer-events:none;
}

/* ===== CONTENT ===== */
.pv-wrap{ max-width:960px; margin:40px auto; background:#e9d2b7; border-radius:6px; }
.pv-inner{ display:grid; grid-template-columns:1.1fr .9fr; gap:28px; padding:26px; }
@media (max-width: 980px){ .pv-wrap{margin:28px 12px} .pv-inner{grid-template-columns:1fr; padding:22px} }

/* LEFT: main image + thumbs with blurred fill */
.pv-media{ display:flex; flex-direction:column; gap:14px; }
.pv-main{
  height:390px; border-radius:4px; overflow:hidden; position:relative; isolation:isolate;
  display:grid; place-items:center; background:#000;
}
.pv-main::before{
  content:""; position:absolute; inset:0;
  background: var(--bg-img) center/cover no-repeat;
  filter: blur(24px) brightness(.55); transform: scale(1.15); z-index:0;
}
.pv-main img{ position:relative; z-index:1; max-width:100%; max-height:100%; object-fit:contain; }

.pv-thumbs{ display:grid; grid-template-columns:repeat(2,1fr); gap:10px; } /* EXACTLY 2 THUMBS */
.pv-thumb{ height:88px; border-radius:3px; overflow:hidden; background:#000; position:relative; cursor:pointer; border:0; padding:0; }
.pv-thumb::before{ content:""; position:absolute; inset:0; background: var(--bg) center/cover no-repeat; filter: blur(16px) brightness(.6); transform:scale(1.12); }
.pv-thumb img{ position:relative; z-index:1; width:100%; height:100%; object-fit:contain; }

/* RIGHT: details */
.pv-title{ font:700 16px/1.3 "Manrope"; color:#2a2a2c; margin:4px 0 6px; }
.pv-meta{ color:#6b6b6b; font:600 12px/1.5 "Manrope"; margin-bottom:12px; }
.pv-price{ float:right; color:#2a2a2c; font:800 12px "Manrope"; }
.pv-old{ color:#8e8e8e; text-decoration:line-through; font-weight:700; margin-left:8px; }
.pv-stock{ margin:6px 0 12px; font:700 11px/1 "Manrope"; }
.pv-stock.good{ color:#215e2a; }
.pv-stock.bad{ color:#8b1a1a; }

.pv-opts{ display:flex; gap:10px; align-items:center; margin:8px 0 12px; }
.pv-size{ appearance:none; border:1px solid #c9b79d; background:#e9d2b7; padding:6px 10px; font:600 12px "Manrope"; }
.pv-qty{ display:inline-flex; border:1px solid #c9b79d; }
.pv-qty button{ width:28px; height:28px; font-weight:800; background:#e9d2b7; border:0; cursor:pointer; }
.pv-qty input{ width:34px; height:28px; text-align:center; border:0; background:#e9d2b7; font:700 12px "Manrope"; }

.pv-btn{ display:block; width:220px; height:34px; border:0; margin:8px 0; cursor:pointer;
  font:800 11px/34px "Manrope"; text-transform:uppercase; letter-spacing:.08em; text-align:left; padding:0 12px; }
.pv-btn--cart{ background:#6a0f2a; color:#fff; }
.pv-btn[disabled]{ opacity:.6; cursor:not-allowed; }

.pv-sec{ margin-top:16px; }
.pv-sec h4{ font:900 28px/1 "Manrope"; letter-spacing:.18em; color:#2a2a2c; margin:6px 0 10px; text-transform:uppercase; }
.pv-sec .bar{ width:32px; height:2px; background:#a91b28; margin:6px 0 14px; }
.pv-spec{ font:600 12px/1.7 "Manrope"; color:#2a2a2c; }
</style>
@endsection

@php
    use Illuminate\Support\Str;
    use Illuminate\Support\Facades\Storage;

    /* ---------- Resolver (same as Home page) ---------- */
    function resolveImageUrl($raw) {
        $placeholder = 'https://via.placeholder.com/900x650/ffffff/aaaaaa?text=No+Image';
        if (!$raw) return $placeholder;

        if (Str::startsWith($raw, ['http://','https://','//'])) {
            return $raw;
        }

        $rel = ltrim($raw, '/');
        if (Str::startsWith($rel, 'storage/')) {
            $rel = ltrim(Str::after($rel, 'storage/'), '/'); // normalize to public disk path
        }
        $rel = Str::startsWith($rel, 'products/') ? $rel : ('products/' . $rel);

        // Prefer storage disk (requires php artisan storage:link)
        if (Storage::disk('public')->exists($rel)) {
            return Storage::url($rel); // /storage/products/...
        }

        // Fallback to /public/products/...
        if (file_exists(public_path($rel))) {
            return asset($rel);
        }

        // Last resort
        return asset('storage/'.$rel);
    }

    /* ---------- Collect & resolve images ---------- */
    $raws = [];

    if (method_exists($product, 'imageUrls')) {
        try { $raws = array_merge($raws, (array) $product->imageUrls(6)); } catch (\Throwable $e) {}
    }
    if (method_exists($product, 'firstImageUrl')) {
        try { $raws[] = $product->firstImageUrl(); } catch (\Throwable $e) {}
    }

    foreach (['image_url','image','thumbnail','thumb','cover','feature_image'] as $k) {
        if (!empty($product->{$k})) $raws[] = $product->{$k};
    }

    $imgs = $product->images ?? null;
    if (is_string($imgs)) {
        $decoded = json_decode($imgs, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            $raws = array_merge($raws, $decoded);
        } elseif (Str::contains($imgs, ',')) {
            $raws = array_merge($raws, array_map('trim', explode(',', $imgs)));
        } elseif (trim($imgs) !== '') {
            $raws[] = trim($imgs);
        }
    } elseif (is_array($imgs)) {
        $raws = array_merge($raws, $imgs);
    }

    // Unique while preserving order
    $uniq = [];
    foreach ($raws as $r) { if ($r && !isset($uniq[(string)$r])) $uniq[(string)$r] = $r; }
    $raws = array_values($uniq);

    // Resolve to absolute URLs
    $urls = [];
    foreach ($raws as $r) { $urls[] = resolveImageUrl($r); }
    if (empty($urls)) { $urls[] = 'https://via.placeholder.com/900x650/ffffff/aaaaaa?text=No+Image'; }

    $mainUrl = $urls[0];                   // main image
    $thumbs  = array_slice($urls, 1, 2);   // EXACTLY 2 thumbnails

    // Product fields
    $name          = $product->name ?? '';
    $finalPrice    = isset($product->final_price) ? number_format($product->final_price, 0) : null;
    $finalPriceRaw = (float) ($product->final_price ?? 0);
    $origPrice     = (!is_null($product->original_price) && $product->original_price > $product->final_price)
                        ? number_format($product->original_price, 0) : null;
    $piecesText    = $product->pieces ? ucwords(str_replace('-', ' ', $product->pieces)) : null;
    $collection    = $product->collection ? ucwords($product->collection).' Collection' : null;
    $desc          = trim((string)($product->description ?? ''));
    $stock         = (int)($product->stock ?? 0);
    $inStock       = $stock > 0;
@endphp

@section('content')
  {{-- ===== HERO ===== --}}
  <header class="pv-hero">
    <div class="fx">
      <div class="pv-eyebrow">PRODUCT VIEW</div>
      <div class="pv-path">WOMENS • HAND EMBROIDERY • UNSTITCHED</div>
    </div>
    <div class="pv-ghost">GULEY THREADS</div>
  </header>

  {{-- ===== CONTENT ===== --}}
  <section class="pv-wrap">
    <div class="pv-inner">
      {{-- LEFT: GALLERY --}}
      <div class="pv-media">
        <div class="pv-main" style="--bg-img: url('{{ $mainUrl }}')">
          <img id="pv-main-img" src="{{ $mainUrl }}" alt="{{ $name }}">
        </div>

        <div class="pv-thumbs">
          @foreach($thumbs as $i => $u)
            <button class="pv-thumb" type="button" style="--bg: url('{{ $u }}')" data-src="{{ $u }}" aria-label="thumb {{ $i+1 }}">
              <img src="{{ $u }}" alt="thumb {{ $i+1 }}">
            </button>
          @endforeach

          {{-- pad with placeholders to keep 2 boxes always --}}
          @for ($i = count($thumbs); $i < 2; $i++)
            <div class="pv-thumb" style="--bg: url('https://via.placeholder.com/300x300/000000/666?text=No+Image')">
              <img src="https://via.placeholder.com/300x300/ffffff/aaaaaa?text=No+Image" alt="thumb placeholder">
            </div>
          @endfor
        </div>
      </div>

      {{-- RIGHT: INFO --}}
      <div>
        @if($name)
          <div class="pv-title">{{ $name }}</div>
        @endif

        <div class="pv-meta">
          @if($collection) {{ $collection }}<br>@endif
          @if($piecesText) {{ $piecesText }}@endif
          @if($finalPrice)
            <span class="pv-price">PKR {{ $finalPrice }}</span>
            @if($origPrice)<span class="pv-old">PKR {{ $origPrice }}</span>@endif
          @endif
        </div>

        <div class="pv-stock {{ $inStock ? 'good' : 'bad' }}">
          {{ $inStock ? "In stock: $stock" : 'Out of stock' }}
        </div>

        <div class="pv-opts">
          <select class="pv-size" aria-label="Select Size">
            <option value="" disabled selected>Size</option>
            <option>XS</option><option>S</option><option>M</option><option>L</option><option>XL</option>
          </select>

          <div class="pv-qty">
            <button type="button" id="pv-dec">-</button>
            <input type="text" id="pv-qty" value="1" readonly>
            <button type="button" id="pv-inc">+</button>
          </div>
        </div>

        <form action="{{ route('cart.store') }}" method="POST" class="pv-atc-form" style="margin:0">
          @csrf
          <input type="hidden" name="product_id" value="{{ $product->id }}">
          <input type="hidden" name="qty" id="form-qty" value="1">
          <button type="submit" class="pv-btn pv-btn--cart" {{ $inStock ? '' : 'disabled' }}>Add To Cart</button>
        </form>

        <div style="margin-top:6px;font:800 12px 'Manrope';color:#2a2a2c">
          Total: <span id="pv-total">PKR {{ number_format($finalPriceRaw, 0) }}</span>
        </div>

        <div class="pv-sec">
          <h4>Details</h4>
          <div class="bar"></div>
          <div class="pv-spec">
            @if($desc)
              {!! nl2br(e($desc)) !!}
            @endif
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection

@section('scripts')
<script>
// Swap main image from thumb (and update the blurred bg)
document.querySelectorAll('.pv-thumb[data-src]').forEach(btn=>{
  btn.addEventListener('click', ()=>{
    const src = btn.getAttribute('data-src');
    const mainImg = document.getElementById('pv-main-img');
    const mainBox = mainImg.closest('.pv-main');
    if (!src) return;
    mainImg.src = src;
    mainBox.style.setProperty('--bg-img', `url("${src}")`);
  });
});

// Qty + live total
const qty = document.getElementById('pv-qty');
document.getElementById('pv-dec')?.addEventListener('click', ()=> {
  qty.value = Math.max(1, (parseInt(qty.value)||1) - 1);
  updateTotals();
});
document.getElementById('pv-inc')?.addEventListener('click', ()=> {
  qty.value = (parseInt(qty.value)||1) + 1;
  updateTotals();
});
const unitPrice = {{ $finalPriceRaw }};
const formQty   = document.getElementById('form-qty');
const totalLbl  = document.getElementById('pv-total');
function updateTotals(){
  const q = Math.max(1, parseInt(qty.value)||1);
  if (formQty) formQty.value = q;
  if (totalLbl) totalLbl.textContent = 'PKR ' + Math.round(unitPrice * q).toLocaleString();
}
updateTotals();
</script>
@endsection
