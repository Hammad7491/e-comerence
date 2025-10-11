@extends('frontend.layouts.app')
@section('title','Your Cart')

@section('styles')
<!-- Load Manrope to match previous pages -->
<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
<style>
  :root{
    --ink:#0f0f10;
    --muted:#6b7280;
    --maroon:#6B1030;        /* heading/buttons */
    --maroon-dark:#5a0d24;
    --line:#ececec;
    --card:#ffffff;
    --sand:#e9d2b7;
  }

  /* Global typography */
  html, body{
    font-family:"Manrope", system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans";
    color:var(--ink);
    -webkit-font-smoothing:antialiased;
    -moz-osx-font-smoothing:grayscale;
    text-rendering:optimizeLegibility;
  }

  .fx{max-width:1100px;margin:0 auto;padding:0 18px}

  /* ===== HERO ===== */
  .cart-hero{
    background:#2a2a2c;color:#fff;min-height:200px;
    display:flex;align-items:center;justify-content:center;
    position:relative;overflow:hidden;text-align:center;
  }
  .cart-hero .eyebrow{
    font:800 35px/1.1 "Manrope",system-ui;letter-spacing:.18em;text-transform:uppercase;
  }
  .cart-hero .ghost{
    position:absolute;inset:0;display:flex;align-items:center;justify-content:center;
    font:900 clamp(100px,16vw,200px)/.9 "Manrope";color:#ffffff12;letter-spacing:.08em;pointer-events:none
  }

  /* ===== WRAP ===== */
  .cart-wrap{max-width:960px;margin:30px auto;background:var(--sand);border-radius:6px}
  .cart-inner{padding:22px}
  @media (max-width: 640px){ .cart-inner{padding:16px} }

  .cart-title{font:800 22px/1.2 "Manrope";margin:0 0 12px;color:var(--maroon)}
  .alert-ok{
    background:#e7f5ee;color:#0f5132;padding:10px 12px;border-radius:6px;margin-bottom:12px;
    font:600 13px "Manrope";
  }

  /* ===== TABLE ===== */
  .cart-table{width:100%;border-collapse:collapse;background:var(--card);border-radius:8px;overflow:hidden}
  .cart-table th, .cart-table td{padding:14px;vertical-align:middle}
  .cart-table thead th{
    font:800 12px/1 "Manrope";text-transform:uppercase;letter-spacing:.12em;
    color:#374151;background:#fafafa;border-bottom:1px solid var(--line)
  }
  .cart-table tbody td{
    border-bottom:1px solid #f3f4f6;font:600 14px/1.5 "Manrope";color:#111827
  }
  .cart-item{display:flex;align-items:center;gap:12px}
  .cart-thumb{width:52px;height:52px;border-radius:6px;object-fit:cover;background:#000}
  .cart-muted{color:var(--muted);font-weight:600;font-size:13px}

  /* hide responsive labels by default (desktop/tablet) */
  .cell-label{display:none}

  /* ===== FOOTER TOTAL ===== */
  .cart-total{
    display:flex;align-items:center;justify-content:flex-end;gap:22px;padding:14px 0 0;
  }
  .cart-total .label{
    font:800 13px "Manrope";color:#111827;text-transform:uppercase;letter-spacing:.12em
  }
  .cart-total .amount{font:900 18px "Manrope";color:#111827}

  /* ===== CTA ROW ===== */
  .cta-row{
    display:flex;align-items:center;justify-content:space-between;gap:12px;margin-top:18px;flex-wrap:wrap
  }
  .btn{
    display:inline-flex;align-items:center;justify-content:center;gap:8px;
    padding:12px 18px;border-radius:6px;border:0;cursor:pointer;text-decoration:none;
    font:800 12px/1 "Manrope";text-transform:uppercase;letter-spacing:.12em;
  }
  .btn-maroon{background:var(--maroon);color:#fff}
  .btn-maroon:hover{background:var(--maroon-dark)}
  .btn-ghost{background:#ffffff;color:#111827;border:1px solid #e7e7e7}
  .btn-ghost:hover{background:#f7f7f7}

  /* Remove button (subtle outline) */
  .btn-outline{
    background:#fff;border:1px solid #e6d8cf;color:#5a2a2a;padding:10px 14px;border-radius:6px;
    font:800 11px/1 "Manrope";letter-spacing:.1em;text-transform:uppercase;
  }
  .btn-outline:hover{background:#f8f3ef}

  /* ===== EMPTY STATE ===== */
  .empty{
    background:#fff;border:1px dashed #e5e7eb;border-radius:8px;padding:28px;text-align:center;color:var(--muted);
    font:600 14px "Manrope";
  }

  /* ===== MOBILE (cards) ===== */
  @media (max-width: 760px){
    .cart-table thead{display:none}
    .cart-table, .cart-table tbody, .cart-table tr, .cart-table td{display:block;width:100%}
    .cart-table tr{background:#fff;margin-bottom:10px;border:1px solid #f0f0f0;border-radius:8px;overflow:hidden}
    .cart-table td{border-bottom:1px solid #f5f5f5}
    .cart-table td:last-child{border-bottom:0}
    .cart-row{display:grid;grid-template-columns:1fr auto;gap:10px;align-items:center}
    .cart-row .meta{grid-column:1/-1;margin-top:-6px}
    .cell-label{
      display:block;           /* show only on mobile */
      font:800 11px "Manrope";letter-spacing:.1em;color:#6b7280;
      text-transform:uppercase;margin-bottom:4px
    }
  }
</style>
@endsection

@php
  $cart = $cart ?? ['items'=>[], 'total'=>0];
@endphp

@section('content')
  <!-- HERO -->
  <header class="cart-hero">
    <div class="eyebrow">YOUR CART</div>
    <div class="ghost">GULEY THREADS</div>
  </header>

  <section class="cart-wrap">
    <div class="cart-inner fx">
      @if(session('success'))
        <div class="alert-ok">{{ session('success') }}</div>
      @endif

      <h1 class="cart-title">Order Summary</h1>

      @if(empty($cart['items']))
        <div class="empty">Your cart is empty.</div>
      @else
        <table class="cart-table">
          <thead>
            <tr>
              <th>Product</th>
              <th style="width:120px">Price</th>
              <th style="width:90px">Qty</th>
              <th style="width:140px">Total</th>
              <th style="width:120px">Action</th>
            </tr>
          </thead>
          <tbody>
          @foreach($cart['items'] as $row)
            <tr>
              <td>
                <div class="cart-item cart-row">
                  <img class="cart-thumb" src="{{ $row['image'] ?? 'https://via.placeholder.com/80x80/000/666?text=No+Image' }}" alt="">
                  <div>
                    <div>{{ $row['name'] }}</div>
                  </div>
                </div>
              </td>
              <td>
                <span class="cell-label">Price</span>
                PKR {{ number_format($row['price'],0) }}
              </td>
              <td>
                <span class="cell-label">Qty</span>
                {{ $row['qty'] }}
              </td>
              <td>
                <span class="cell-label">Total</span>
                <strong>PKR {{ number_format($row['total'],0) }}</strong>
              </td>
              <td>
                <span class="cell-label">Action</span>
                <form method="POST" action="{{ route('cart.remove', $row['product_id']) }}" onsubmit="return confirm('Remove this item?')">
                  @csrf
                  @method('DELETE')
                  
                </form>
              </td>
            </tr>
          @endforeach
          </tbody>
        </table>

        <div class="cart-total">
          <span class="label">Grand Total</span>
          <span class="amount">PKR {{ number_format($cart['total'],0) }}</span>
        </div>

        <div class="cta-row">
          <a href="{{ route('home') }}" class="btn btn-ghost">Continue Shopping</a>
          @auth
            <a href="{{ url('/checkout') }}" class="btn btn-maroon">Proceed to Checkout</a>
          @else
            <a href="{{ route('loginform') }}" class="btn btn-maroon">Login to Checkout</a>
          @endauth
        </div>
      @endif
    </div>
  </section>
@endsection
