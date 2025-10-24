@extends('frontend.layouts.app')

@section('title', 'Product View')

@section('styles')
<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
<style>
html, body{
  font-family:"Manrope", system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans";
  color:#0f0f10;
  background:#f7f6f3;
  -webkit-font-smoothing:antialiased;
  -moz-osx-font-smoothing:grayscale;
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
  font:900 clamp(120px,18vw,240px)/.9 "Manrope"; color:#ffffff14; letter-spacing:.08em; pointer-events:none;
}

/* ===== PRODUCT CONTAINER ===== */
.pv-wrap{
  max-width:1000px; margin:50px auto; background:#e9d2b7;
  border-radius:10px; box-shadow:0 10px 25px rgba(0,0,0,0.08);
}
.pv-inner{
  display:grid; grid-template-columns:1.1fr .9fr;
  gap:30px; padding:32px;
}
@media (max-width: 980px){
  .pv-wrap{margin:30px 12px}
  .pv-inner{grid-template-columns:1fr; padding:22px}
}

/* ===== IMAGE GALLERY ===== */
.pv-media{ display:flex; flex-direction:column; align-items:center; gap:16px; }

/* Main viewer with blurred, color-matched backdrop */
.pv-main{
  --bg-img: none;                 /* set from JS */
  position:relative;
  width:100%;
  height:450px;
  border-radius:10px;
  overflow:hidden;
  background:#e6d0b4;             /* warm fallback, no white */
  display:grid; place-items:center;
  box-shadow:0 6px 18px rgba(0,0,0,.08);
  isolation:isolate;              /* keep backdrop behind the image */
}
.pv-main::before{
  content:"";
  position:absolute; inset:-15%;
  background:var(--bg-img) center/cover no-repeat;
  filter:blur(28px) saturate(1.05) brightness(.95);
  transform:scale(1.1);
  z-index:1;
}
.pv-main::after{
  content:"";
  position:absolute; inset:0;
  background:radial-gradient(ellipse at center, transparent 35%, rgba(0,0,0,.18) 100%);
  z-index:2;
}
.pv-main img{
  position:relative; z-index:3;
  max-width:100%; max-height:100%;
  object-fit:contain;             /* keep full image */
  transition:transform .28s ease;
  filter:drop-shadow(0 6px 16px rgba(0,0,0,.22));
}
.pv-main img:hover{ transform:scale(1.03); }

/* Thumbnails — single horizontal line */
.pv-thumbs{
  display:flex; gap:12px; justify-content:center; flex-wrap:nowrap;
  overflow-x:auto; scrollbar-width:none; width:100%;
  padding-bottom:2px;
}
.pv-thumbs::-webkit-scrollbar{ display:none; }
.pv-thumb{
  flex:0 0 auto; width:92px; height:92px; border-radius:8px;
  overflow:hidden; background:transparent; border:2px solid transparent;
  cursor:pointer; transition:border .2s ease, transform .2s ease;
}
.pv-thumb img{
  width:100%; height:100%; object-fit:cover; background:transparent;
}
.pv-thumb:hover{ transform:translateY(-2px); border-color:#6a0f2a; }
.pv-thumb.active{ border-color:#6a0f2a; box-shadow:0 0 0 2px #6a0f2a33; }

/* ===== RIGHT INFO ===== */
.pv-title{ font:800 20px/1.3 "Manrope"; color:#2a2a2c; margin:4px 0 6px; }
.pv-meta{ color:#6b6b6b; font:600 13px/1.5 "Manrope"; margin-bottom:10px; }
.pv-price{ float:right; color:#2a2a2c; font:800 13px "Manrope"; }
.pv-old{ color:#8e8e8e; text-decoration:line-through; font-weight:700; margin-left:8px; }
.pv-stock{ margin:6px 0 12px; font:700 11px/1 "Manrope"; }
.pv-stock.good{ color:#215e2a; }
.pv-stock.bad{ color:#8b1a1a; }

.pv-opts{ display:flex; gap:10px; align-items:center; margin:8px 0 12px; }
.pv-size{ appearance:none; border:1px solid #c9b79d; background:#f5e4c6; padding:6px 10px; font:600 12px "Manrope"; border-radius:4px; }
.pv-qty{ display:inline-flex; border:1px solid #c9b79d; border-radius:4px; overflow:hidden; }
.pv-qty button{ width:28px; height:28px; font-weight:800; background:#f5e4c6; border:0; cursor:pointer; }
.pv-qty input{ width:34px; height:28px; text-align:center; border:0; background:#f5e4c6; font:700 12px "Manrope"; }

.pv-btn{
  display:block; width:220px; height:40px; border:0; margin:8px 0; cursor:pointer;
  font:800 12px/40px "Manrope"; text-transform:uppercase; letter-spacing:.08em;
  background:#6a0f2a; color:#fff; border-radius:4px; transition:background .25s;
}
.pv-btn:hover{ background:#8b1638; }
.pv-btn[disabled]{ opacity:.6; cursor:not-allowed; }

.pv-sec{ margin-top:24px; }
.pv-sec h4{
  font:900 26px/1 "Manrope"; letter-spacing:.15em; color:#2a2a2c;
  margin:6px 0 10px; text-transform:uppercase;
}
.pv-sec .bar{ width:36px; height:2px; background:#a91b28; margin:6px 0 14px; }
.pv-spec{ font:600 13px/1.7 "Manrope"; color:#2a2a2c; }


.pv-btn{
  display:block; width:220px; height:40px; border:0; margin:8px 0; cursor:pointer;
  font:800 12px/40px "Manrope"; text-transform:uppercase; letter-spacing:.08em;
  background:#6a0f2a; color:#fff; border-radius:4px; transition:background .25s;
  text-align:center;           /* <-- add this */
}

</style>
@endsection

@php
$images = $product->imageUrls();
$mainImage = $images[0] ?? asset('images/placeholder.jpg');
$name = $product->name ?? '';
$finalPrice = isset($product->final_price) ? number_format($product->final_price, 0) : null;
$finalPriceRaw = (float) ($product->final_price ?? 0);
$origPrice = (!is_null($product->original_price) && $product->original_price > $product->final_price)
    ? number_format($product->original_price, 0) : null;
$piecesText = $product->pieces ? ucwords(str_replace('-', ' ', $product->pieces)) : null;
$collection = $product->collection ? ucwords($product->collection).' Collection' : null;
$desc = trim((string)($product->description ?? ''));
$stock = (int)($product->stock ?? 0);
$inStock = $stock > 0;
@endphp

@section('content')
<header class="pv-hero">
  <div class="fx">
    <div class="pv-eyebrow">PRODUCT VIEW</div>
    <div class="pv-path">WOMENS • HAND EMBROIDERY • UNSTITCHED</div>
  </div>
  <div class="pv-ghost">GULEY THREADS</div>
</header>

<section class="pv-wrap">
  <div class="pv-inner">
    <!-- LEFT: GALLERY -->
    <div class="pv-media">
      <div class="pv-main" id="pv-main" style="--bg-img:url('{{ $mainImage }}')">
        <img id="pv-main-img" src="{{ $mainImage }}" alt="{{ $name }}">
      </div>

      <div class="pv-thumbs" id="pv-thumbs">
        @foreach($images as $i => $thumb)
          <button class="pv-thumb {{ $i === 0 ? 'active' : '' }}" type="button"
                  onclick="changeImage('{{ $thumb }}', this)">
            <img src="{{ $thumb }}" alt="thumbnail {{ $i+1 }}">
          </button>
        @endforeach
      </div>
    </div>

    <!-- RIGHT: INFO -->
    <div>
      <div class="pv-title">{{ $name }}</div>
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
        <select class="pv-size">
          <option value="" disabled selected>Size</option>
          <option>XS</option><option>S</option><option>M</option><option>L</option><option>XL</option>
        </select>

        <div class="pv-qty">
          <button type="button" id="pv-dec">-</button>
          <input type="text" id="pv-qty" value="1" readonly>
          <button type="button" id="pv-inc">+</button>
        </div>
      </div>

      <form action="{{ route('cart.store') }}" method="POST">
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
          {!! nl2br(e($desc ?: 'No product description available.')) !!}
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

@section('scripts')
<script>
/* Change main image + backdrop and mark active thumb */
function changeImage(src, btn){
  const img  = document.getElementById('pv-main-img');
  const main = document.getElementById('pv-main');
  img.src = src;
  main.style.setProperty('--bg-img', `url("${src}")`);
  document.querySelectorAll('.pv-thumb').forEach(t => t.classList.remove('active'));
  btn?.classList.add('active');
}

/* Quantity + total */
const qty = document.getElementById('pv-qty');
const formQty = document.getElementById('form-qty');
const totalLbl = document.getElementById('pv-total');
const unitPrice = {{ $finalPriceRaw }};

document.getElementById('pv-dec')?.addEventListener('click', () => {
  qty.value = Math.max(1, (parseInt(qty.value) || 1) - 1);
  updateTotal();
});
document.getElementById('pv-inc')?.addEventListener('click', () => {
  qty.value = (parseInt(qty.value) || 1) + 1;
  updateTotal();
});

function updateTotal() {
  const q = Math.max(1, parseInt(qty.value) || 1);
  formQty.value = q;
  totalLbl.textContent = 'PKR ' + Math.round(unitPrice * q).toLocaleString();
}
updateTotal();
</script>
@endsection
