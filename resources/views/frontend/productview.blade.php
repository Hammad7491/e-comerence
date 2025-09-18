@extends('frontend.layouts.app')

@section('title', 'Product View')

@section('styles')
<style>
/* ============== PRODUCT VIEW — HERO (centered like reference) ============== */
.pv-hero{
  background:#2a2a2c;
  color:#fff;
  min-height:300px;                 /* tall banner */
  display:flex; align-items:center; justify-content:center;
  position:relative; overflow:hidden; text-align:center;
}
.pv-hero .fx{ position:relative; z-index:2; }
.pv-eyebrow{
  font:800 30px/1.2 "Inter",system-ui;
  letter-spacing:.18em; text-transform:uppercase; margin-bottom:6px;
}
.pv-path{
  color:#cfcfcf; font:600 18px/1.3 "Inter";
  letter-spacing:.12em; text-transform:uppercase;
}
/* Huge ghost word behind */
.pv-ghost{
  position:absolute; inset:0; display:flex; align-items:center; justify-content:center;
  font:900 clamp(120px,18vw,240px)/.9 "Inter",system-ui;
  color:#ffffff14; letter-spacing:.08em; z-index:1; pointer-events:none;
}

/* ============== CONTENT CARD (proportions like reference) ============== */
.pv-wrap{ max-width:960px; margin:40px auto; background:#e9d2b7; border-radius:6px; }
.pv-inner{ display:grid; grid-template-columns:1.1fr .9fr; gap:28px; padding:26px; }
@media (max-width: 980px){ .pv-wrap{margin:28px 12px} .pv-inner{grid-template-columns:1fr; padding:22px} }

/* ============== LEFT: MEDIA with blurred fill ============== */
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

.pv-thumbs{ display:grid; grid-template-columns:repeat(3,1fr); gap:10px; }
.pv-thumb{ height:88px; border-radius:3px; overflow:hidden; background:#000; position:relative; cursor:pointer; }
.pv-thumb::before{ content:""; position:absolute; inset:0; background: var(--bg) center/cover no-repeat; filter: blur(16px) brightness(.6); transform:scale(1.12); }
.pv-thumb img{ position:relative; z-index:1; width:100%; height:100%; object-fit:contain; }

/* ============== RIGHT: DETAILS ============== */
.pv-title{ font:700 16px/1.3 "Inter"; color:#2a2a2c; margin:4px 0 6px; }
.pv-meta{ color:#6b6b6b; font:600 12px/1.5 "Inter"; margin-bottom:12px; }
.pv-price{ float:right; color:#2a2a2c; font:800 12px "Inter"; }
.pv-old{ color:#8e8e8e; text-decoration:line-through; font-weight:700; margin-left:8px; }
.pv-stock{ margin:6px 0 12px; font:700 11px/1 "Inter"; }
.pv-stock.good{ color:#215e2a; }
.pv-stock.bad{ color:#8b1a1a; }

.pv-opts{ display:flex; gap:10px; align-items:center; margin:8px 0 12px; }
.pv-size{ appearance:none; border:1px solid #c9b79d; background:#e9d2b7; padding:6px 10px; font:600 12px "Inter"; }
.pv-qty{ display:inline-flex; border:1px solid #c9b79d; }
.pv-qty button{ width:28px; height:28px; font-weight:800; background:#e9d2b7; border:0; cursor:pointer; }
.pv-qty input{ width:34px; height:28px; text-align:center; border:0; background:#e9d2b7; font:700 12px "Inter"; }

/* buttons look like reference: flat maroon */
.pv-btn{ display:block; width:220px; height:34px; border:0; margin:8px 0; cursor:pointer;
  font:800 11px/34px "Inter"; text-transform:uppercase; letter-spacing:.08em; text-align:left; padding:0 12px; }
.pv-btn--cart{ background:#6a0f2a; color:#fff; }
.pv-btn--wish{ background:#4c1a25; color:#fff; }
.pv-btn[disabled]{ opacity:.6; cursor:not-allowed; }

/* details heading like reference */
.pv-sec{ margin-top:16px; }
.pv-sec h4{ font:900 28px/1 "Inter"; letter-spacing:.18em; color:#2a2a2c; margin:6px 0 10px; text-transform:uppercase; }
.pv-sec .bar{ width:32px; height:2px; background:#a91b28; margin:6px 0 14px; }
.pv-spec{ font:600 12px/1.7 "Inter"; color:#2a2a2c; }
</style>
@endsection

@php
  $imgs        = $product->imageUrls(3);
  $main        = $imgs[0] ?? $product->firstImageUrl();
  $name        = $product->name ?? '';
  $finalPrice  = isset($product->final_price) ? number_format($product->final_price, 0) : null;
  $origPrice   = (!is_null($product->original_price) && $product->original_price > $product->final_price)
                  ? number_format($product->original_price, 0) : null;
  $piecesText  = $product->pieces ? ucwords(str_replace('-', ' ', $product->pieces)) : null;
  $collection  = $product->collection ? ucwords($product->collection).' Collection' : null;
  $desc        = trim((string)($product->description ?? ''));
  $stock       = (int)($product->stock ?? 0);
  $inStock     = $stock > 0;
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
        <div class="pv-main" style="--bg-img: url('{{ $main }}')">
          @if($main)
            <img id="pv-main-img" src="{{ $main }}" alt="{{ $name }}">
          @else
            <img id="pv-main-img" src="https://via.placeholder.com/600x600/000000/999999?text=No+Image" alt="No image">
          @endif
        </div>

        <div class="pv-thumbs">
          @foreach($imgs as $i => $u)
            <button class="pv-thumb" type="button" style="--bg: url('{{ $u }}')" data-src="{{ $u }}" aria-label="thumb {{ $i+1 }}">
              <img src="{{ $u }}" alt="thumb {{ $i+1 }}">
            </button>
          @endforeach
          @for ($i = count($imgs); $i < 3; $i++)
            <div class="pv-thumb" style="--bg: url('https://via.placeholder.com/300x300/000000/666?text=No+Image')">
              <img src="https://via.placeholder.com/300x300/000000/666?text=No+Image" alt="thumb placeholder">
            </div>
          @endfor
        </div>
      </div>

      {{-- RIGHT: INFO (only show fields that exist in backend) --}}
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

        <button class="pv-btn pv-btn--cart" {{ $inStock ? '' : 'disabled' }}>Add To Cart</button>
        <button class="pv-btn pv-btn--wish">Add To Wishlist</button>

        <div class="pv-sec">
          <h4>Details</h4>
          <div class="bar"></div>
          <div class="pv-spec">
            {{-- ONLY description here (original price removed as requested) --}}
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
// Thumbnail -> main image swap
document.querySelectorAll('.pv-thumb[data-src]').forEach(btn=>{
  btn.addEventListener('click', ()=>{
    const src = btn.getAttribute('data-src');
    const mainImg = document.getElementById('pv-main-img');
    const mainBox = mainImg.closest('.pv-main');
    mainImg.src = src;
    mainBox.style.setProperty('--bg-img', `url('${src}')`);
  });
});

// Qty controls
const qty = document.getElementById('pv-qty');
document.getElementById('pv-dec')?.addEventListener('click', ()=> {
  qty.value = Math.max(1, (parseInt(qty.value)||1) - 1);
});
document.getElementById('pv-inc')?.addEventListener('click', ()=> {
  qty.value = (parseInt(qty.value)||1) + 1;
});
</script>
@endsection
