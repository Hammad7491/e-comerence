@extends('frontend.layouts.app')
@section('title','My Orders')

@section('styles')
<style>
  :root{
    --ink:#0f0f10;
    --muted:#6b7280;
    --maroon:#6B1030;
    --maroon-dark:#5a0d24;
    --sand:#e9d2b7;
    --card:#ffffff;
    --line:#ececec;
  }
  .fx{max-width:1100px;margin:0 auto;padding:0 18px}

  /* ===== HERO ===== */
  .pv-hero{
    background:#2a2a2c;color:#fff;min-height:200px;
    display:flex;align-items:center;justify-content:center;
    position:relative;overflow:hidden;text-align:center
  }
  .pv-hero .fx{position:relative;z-index:2}
  .pv-eyebrow{
    font:800 35px/1.1 "Inter",system-ui;letter-spacing:.18em;text-transform:uppercase
  }
  .pv-ghost{
    position:absolute;inset:0;display:flex;align-items:center;justify-content:center;
    font:900 clamp(100px,16vw,200px)/.9 "Inter";color:#ffffff12;letter-spacing:.08em;pointer-events:none
  }

  /* ===== WRAP ===== */
  .wrap{max-width:980px;margin:30px auto;background:var(--sand);border-radius:8px}
  .inner{padding:22px}
  @media (max-width:640px){ .inner{padding:16px} }

  /* Order card */
  .order{
    background:var(--card);border-radius:12px;overflow:hidden;
    border:1px solid #f0ebe4;margin-bottom:16px
  }
  .order-h{
    display:flex;gap:14px;align-items:center;justify-content:space-between;
    padding:14px 16px;border-bottom:1px solid #f4efe6;background:#fffdfb
  }
  .order-left{
    display:flex;gap:18px;align-items:center;flex-wrap:wrap
  }
  .h-meta{color:var(--muted);font:700 12px "Inter";letter-spacing:.08em;text-transform:uppercase}
  .h-strong{font:900 14px "Inter";color:#111827}

  .badge{display:inline-flex;align-items:center;gap:6px;font:800 11px/1 "Inter";
    padding:6px 10px;border-radius:999px;text-transform:uppercase;letter-spacing:.06em}
  .pending{background:#fff7ed;color:#9a3412;border:1px solid #fed7aa}
  .approved{background:#ecfdf5;color:#065f46;border:1px solid #a7f3d0}
  .rejected{background:#fff1f2;color:#9f1239;border:1px solid #fecdd3}

  .order-body{padding:10px 14px}

  /* Items table */
  .items{width:100%;border-collapse:collapse}
  .items th,.items td{padding:12px 8px}
  .items thead th{
    font:800 12px "Inter";text-transform:uppercase;letter-spacing:.12em;
    color:#374151;background:#fafafa;border-bottom:1px solid #f0f0f0;text-align:left
  }
  .items tbody td{border-top:1px solid #f6f6f6;font:600 14px "Inter";color:#111827}
  .prod{
    display:flex;align-items:center;gap:10px;min-width:220px
  }
  .thumb{
    width:48px;height:48px;border-radius:8px;object-fit:cover;background:#000;flex:0 0 auto
  }
  .pname{font-weight:700}
  .muted{color:var(--muted);font-weight:600;font-size:12px}

  .tfoot{
    display:flex;justify-content:flex-end;gap:18px;align-items:center;
    padding:12px 8px 14px;border-top:1px dashed #eee
  }
  .lab{font:800 12px "Inter";text-transform:uppercase;letter-spacing:.12em;color:#111827}
  .amt{font:900 16px "Inter";color:#111827}

  /* Mobile cards */
  @media (max-width:760px){
    .order-h{align-items:flex-start}
    .items thead{display:none}
    .items, .items tbody, .items tr, .items td{display:block;width:100%}
    .items tr{border:1px solid #f1f1f1;border-radius:10px;margin:10px 0;padding:8px;background:#fff}
    .items td{border-top:0;padding:8px 6px}
    .cell{display:block;font:800 11px "Inter";letter-spacing:.1em;color:#6b7280;
      text-transform:uppercase;margin-bottom:3px}
    .prod{min-width:0}
    .tfoot{justify-content:space-between}
  }
</style>
@endsection

@php use Illuminate\Support\Facades\Storage; @endphp

@section('content')

<!-- HERO -->
<header class="pv-hero">
  <div class="fx"><div class="pv-eyebrow">MY ORDER</div></div>
  <div class="pv-ghost">GULEY THREADS</div>
</header>

<section class="wrap">
  <div class="inner fx">

    @if($orders->isEmpty())
      <div style="background:#fff;border:1px dashed #e5e7eb;border-radius:10px;padding:24px;text-align:center;color:#6b7280;font:600 14px 'Inter'">
        You haven’t placed any orders yet.
      </div>
    @else
      @foreach($orders as $order)
        @php
          $statusClass = $order->status === 'approved' ? 'approved' : ($order->status === 'rejected' ? 'rejected' : 'pending');
        @endphp

        <article class="order">
          <!-- Order header (no order number) -->
          <div class="order-h">
            <div class="order-left">
              <div>
                <div class="h-meta">Date</div>
                <div class="h-strong">{{ $order->created_at->format('M d, Y') }}</div>
              </div>
              <div>
                <div class="h-meta">Payment</div>
                <div class="h-strong">{{ strtoupper($order->payment_method) }}</div>
              </div>
              <div>
                <div class="h-meta">Status</div>
                <span class="badge {{ $statusClass }}">{{ ucfirst($order->status ?? 'pending') }}</span>
              </div>
            </div>

            <div>
              <div class="h-meta" style="text-align:right">Grand Total</div>
              <div class="h-strong">PKR {{ number_format($order->total,0) }}</div>
            </div>
          </div>

          <!-- Items rows -->
          <div class="order-body">
            <table class="items">
              <thead>
                <tr>
                  <th>Product</th>
                  <th style="width:120px">Price</th>
                  <th style="width:80px">Qty</th>
                  <th style="width:140px">Total</th>
                </tr>
              </thead>
              <tbody>
              @foreach($order->items as $it)
                @php
                  // Try to get product image if relation exists; fall back to placeholder
                  $img = 'https://via.placeholder.com/80x80/000/666?text=No+Image';
                  if (isset($it->product)) {
                      $imgs = is_array($it->product->images ?? null) ? $it->product->images : [];
                      if (!empty($imgs)) {
                          $img = Storage::disk('public')->url($imgs[0]);
                      }
                  }
                @endphp
                <tr>
                  <td>
                    <span class="cell">Product</span>
                    <div class="prod">
                      <img class="thumb" src="{{ $img }}" alt="">
                      <div>
                        <div class="pname">{{ $it->name }}</div>
                        <div class="muted">{{ $order->created_at->format('h:i A') }}</div>
                      </div>
                    </div>
                  </td>
                  <td>
                    <span class="cell">Price</span>
                    PKR {{ number_format($it->price,0) }}
                  </td>
                  <td>
                    <span class="cell">Qty</span>
                    {{ $it->qty }}
                  </td>
                  <td>
                    <span class="cell">Total</span>
                    <strong>PKR {{ number_format($it->total,0) }}</strong>
                  </td>
                </tr>
              @endforeach
              </tbody>
            </table>

            <div class="tfoot">
              <span class="lab">Grand Total</span>
              <span class="amt">PKR {{ number_format($order->total,0) }}</span>
            </div>
          </div>
        </article>
      @endforeach

      <div style="margin-top:16px">
        {{ $orders->links() }}
      </div>
    @endif
  </div>
</section>
@endsection
