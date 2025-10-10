@extends('frontend.layouts.app')
@section('title','Checkout')

@section('styles')
<!-- Use Manrope everywhere (same as previous pages) -->
<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
<style>
  :root{
    --ink:#0f0f10;
    --muted:#6b7280;
    --maroon:#6B1030;          /* headings & buttons */
    --maroon-dark:#5a0d24;
    --sand:#e9d2b7;            /* card bg like product view */
    --card:#ffffff;
    --line:#ececec;
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

  /* ===== HERO (same as other pages) ===== */
  .pv-hero{
    background:#2a2a2c;color:#fff;min-height:200px;
    display:flex;align-items:center;justify-content:center;
    position:relative;overflow:hidden;text-align:center
  }
  .pv-hero .fx{position:relative;z-index:2}
  .pv-eyebrow{font:800 35px/1.1 "Manrope",system-ui;letter-spacing:.18em;text-transform:uppercase}
  .pv-ghost{
    position:absolute;inset:0;display:flex;align-items:center;justify-content:center;
    font:900 clamp(100px,16vw,200px)/.9 "Manrope";color:#ffffff12;letter-spacing:.08em;pointer-events:none
  }

  /* ===== WRAP ===== */
  .wrap{max-width:960px;margin:30px auto;background:var(--sand);border-radius:8px}
  .inner{padding:22px;display:grid;grid-template-columns:1.2fr .8fr;gap:18px}
  @media (max-width: 980px){ .inner{grid-template-columns:1fr} }
  @media (max-width: 640px){ .inner{padding:16px} }

  /* ===== LEFT: FORM ===== */
  .card{background:var(--card);border-radius:8px;overflow:hidden}
  .body{padding:18px}
  .section-title{font:900 42px/0.95 "Manrope";letter-spacing:.04em;color:var(--maroon);margin:6px 0 16px}
  .grid2{display:grid;grid-template-columns:1fr 1fr;gap:10px}
  .field{display:flex;flex-direction:column;gap:6px;margin-bottom:10px}
  .label{font:800 11px/1 "Manrope";color:#374151;text-transform:uppercase;letter-spacing:.14em}
  .input, .textarea{
    width:100%;border:1px solid #e7e5e4;border-radius:6px;background:#fff;padding:10px 12px;
    font:600 14px/1.3 "Manrope";color:#111827
  }
  .textarea{min-height:88px;resize:vertical}

  /* ===== Radios row (FIXED) ===== */
  .radio-row{display:flex;gap:16px;align-items:center;flex-wrap:wrap;margin-top:4px}
  .radio{
    display:inline-flex;align-items:center;gap:10px;
    padding:8px 12px;border:1px solid #e6d8cf;border-radius:22px;background:#fff;
  }
  .radio input{
    width:16px;height:16px;
    appearance:auto; -webkit-appearance:auto; -moz-appearance:auto;
    accent-color: var(--maroon);
    margin:0;
  }
  .radio span{font:800 12px "Manrope";letter-spacing:.08em;color:#111827}

  .help{color:var(--muted);font:600 13px/1.45 "Manrope";margin:6px 0 10px}

  .acct{border:1px dashed #e6d8cf;background:#fff;border-radius:8px;padding:12px;display:none}
  .acct.show{display:block}
  .acct h5{margin:0 0 6px;font:800 13px "Manrope";color:#374151;text-transform:uppercase;letter-spacing:.12em}
  .small{color:#6b7280;font:600 12px/1.4 "Manrope"}

  .total-row{display:flex;justify-content:flex-end;gap:10px;margin-top:10px}
  .total-row .lbl{font:800 12px "Manrope";text-transform:uppercase;letter-spacing:.12em;color:#111827}
  .total-row .amt{font:900 16px "Manrope";color:#111827}

  .actions{display:flex;gap:10px;justify-content:space-between;align-items:center;margin-top:12px;flex-wrap:wrap}
  .btn{
    display:inline-flex;align-items:center;justify-content:center;padding:11px 16px;border-radius:6px;border:0;cursor:pointer;
    font:800 12px "Manrope";text-transform:uppercase;letter-spacing:.12em;text-decoration:none
  }
  .btn-ghost{background:#fff;border:1px solid #e7e7e7;color:#111827}
  .btn-ghost:hover{background:#f7f7f7}
  .btn-maroon{background:var(--maroon);color:#fff}
  .btn-maroon:hover{background:var(--maroon-dark)}

  /* ===== RIGHT: SUMMARY ===== */
  .sum{background:#fff;border-radius:8px;overflow:hidden}
  .sum .head{padding:14px 16px;border-bottom:1px solid #f0ebe4}
  .sum .head h3{margin:0;font:900 42px/1 "Manrope";letter-spacing:.04em;color:var(--maroon);white-space:nowrap}
  .sum .content{padding:14px 16px}
  .item{display:grid;grid-template-columns:auto 1fr auto;gap:10px;align-items:center;margin-bottom:10px}
  .thumb{width:42px;height:42px;border-radius:6px;object-fit:cover;background:#000}
  .name{font:700 13px "Manrope";color:#111827}
  .sub{color:#6b7280;font:600 12px/1.3 "Manrope"}
  .price{font:800 12px "Manrope";color:#111827;white-space:nowrap}
  .grand{margin-top:10px;padding-top:10px;border-top:1px dashed #eee;display:flex;justify-content:space-between;align-items:center}
  .grand .lbl{font:800 12px "Manrope"}
  .grand .amt{font:900 14px "Manrope"}
</style>
@endsection

@php
  $cart = $cart ?? ['items'=>[], 'total'=>0];
  $user = auth()->user();
@endphp

@section('content')
  <!-- HERO -->
  <header class="pv-hero">
    <div class="fx"><div class="pv-eyebrow">CHECKOUT</div></div>
    <div class="pv-ghost">GULEY THREADS</div>
  </header>

  <!-- CONTENT -->
  <section class="wrap">
    <div class="inner">

      <!-- LEFT: FORM -->
      <div class="card">
        <form class="body" action="{{ route('checkout.store') }}" method="POST" enctype="multipart/form-data" id="checkout-form">
          @csrf

          <div class="section-title">Billing<br>Details</div>

          <div class="grid2">
            <div class="field">
              <label class="label">Name</label>
              <input class="input" type="text" name="name" value="{{ old('name', $user?->name) }}" required>
            </div>
            <div class="field">
              <label class="label">Phone</label>
              <input class="input" type="text" name="phone" value="{{ old('phone') }}" required>
            </div>
          </div>

          <div class="field">
            <label class="label">Address</label>
            <textarea class="textarea" name="address" required>{{ old('address') }}</textarea>
          </div>

          <div class="section-title" style="margin-top:6px">Payment<br>Method</div>

          <!-- FIXED: radios visible and styled -->
          <div class="radio-row" role="radiogroup" aria-label="Payment method">
            <label class="radio">
              <input type="radio" name="payment_method" value="cash"
                     {{ old('payment_method','cash')==='cash' ? 'checked' : '' }}>
              <span>Cash on Delivery</span>
            </label>

            <label class="radio">
              <input type="radio" name="payment_method" value="online"
                     {{ old('payment_method')==='online' ? 'checked' : '' }}>
              <span>Online Transfer</span>
            </label>
          </div>

          <p class="help">Choose how you want to pay.</p>

          <!-- Account details + proof (only for ONLINE) -->
          <div id="acctBox" class="acct {{ old('payment_method')==='online' ? 'show' : '' }}">
            <h5>Send to:</h5>
            <div class="small">
              Account Title: <strong>{{ $bank['title'] }}</strong><br>
              Account Number: <strong>{{ $bank['account'] }}</strong><br>
              Bank: <strong>{{ $bank['provider'] }}</strong><br>
              Accepted: JPG, PNG, WEBP. Max 4MB.
            </div>

            <div class="field" style="margin-top:10px">
              <label class="label">Upload Payment Proof (screenshot)</label>
              <input class="input" type="file" name="payment_proof" id="payment_proof" accept=".jpg,.jpeg,.png,.webp">
            </div>
          </div>

          <!-- Total row -->
          <div class="total-row">
            <span class="lbl">Total:</span>
            <span class="amt">PKR {{ number_format($cart['total'],0) }}</span>
          </div>

          <div class="actions">
            <a href="{{ route('cart.index') }}" class="btn btn-ghost">Back to Cart</a>
            <button type="submit" class="btn btn-maroon" id="submitBtn">Submit Order</button>
          </div>
        </form>
      </div>

      <!-- RIGHT: SUMMARY -->
      <aside class="sum">
        <div class="head"><h3>SUMMARY</h3></div>
        <div class="content">
          @forelse($cart['items'] as $row)
            <div class="item">
              <img class="thumb" src="{{ $row['image'] ?? 'https://via.placeholder.com/80x80/000/666?text=No+Image' }}" alt="">
              <div>
                <div class="name">{{ $row['name'] }}</div>
                <div class="sub">Qty {{ $row['qty'] }}</div>
              </div>
              <div class="price">PKR {{ number_format($row['total'],0) }}</div>
            </div>
          @empty
            <div class="small">Your cart is empty.</div>
          @endforelse

          <div class="grand">
            <span class="lbl">Grand Total:</span>
            <span class="amt">PKR {{ number_format($cart['total'],0) }}</span>
          </div>
        </div>
      </aside>

    </div>
  </section>
@endsection

@section('scripts')
<script>
  const radios  = document.querySelectorAll('input[name="payment_method"]');
  const acctBox = document.getElementById('acctBox');
  const proof   = document.getElementById('payment_proof');

  function refreshPaymentUI() {
    const val = document.querySelector('input[name="payment_method"]:checked')?.value;
    if (val === 'online') {
      acctBox.classList.add('show');
      if (proof) proof.required = true;
    } else {
      acctBox.classList.remove('show');
      if (proof) { proof.required = false; proof.value = ''; }
    }
  }
  radios.forEach(r => r.addEventListener('change', refreshPaymentUI));
  refreshPaymentUI();

  // prevent double submit
  const form = document.getElementById('checkout-form');
  const btn  = document.getElementById('submitBtn');
  form?.addEventListener('submit', () => { btn.disabled = true; btn.textContent = 'Submitting...'; });
</script>
@endsection
