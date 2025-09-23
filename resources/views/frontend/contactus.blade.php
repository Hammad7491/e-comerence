@extends('frontend.layouts.app')
@section('title','Contact Us')

@section('styles')
<style>
  :root{
    --ink:#0f0f10;
    --muted:#656b74;
    --ring:#e9e7e2;
  }
  .fx{max-width:1180px;margin:0 auto;padding:0 18px}

  /* ===== HERO (same as Brand) ===== */
  .brand-hero{
    background:#2a2a2c;
    color:#fff;
    min-height:200px;
    display:flex;
    align-items:center;
    justify-content:center;
    position:relative;
    overflow:hidden;
    text-align:center;
  }
  .brand-hero .eyebrow{
    font:800 35px/1.1 "Inter",system-ui;
    letter-spacing:.18em;
    text-transform:uppercase;
  }
  .brand-hero .ghost{
    position:absolute;
    inset:0;
    display:flex;
    align-items:center;
    justify-content:center;
    font:900 clamp(100px,16vw,200px)/.9 "Inter";
    color:#ffffff12;
    letter-spacing:.08em;
    pointer-events:none;
  }

  /* ===== BODY ===== */
  .wrap{background:#fff}
  .block{padding:44px 0 16px}
  .grid-2{display:grid;grid-template-columns:1fr 1fr;gap:40px}

  /* ===== Contact Card & Form ===== */
  .card{
    border:1px solid var(--ring);
    background:#fff;
    border-radius:10px;
    box-shadow:0 1px 0 rgba(0,0,0,.02);
  }
  .card .hd{
    padding:18px 18px 0;
    font:800 12px/1 "Inter";
    letter-spacing:.18em;
    color:#79808a;
    text-transform:uppercase;
  }
  .card .bd{padding:18px}
  .stack > * + *{margin-top:14px}

  .form-grid{display:grid;grid-template-columns:1fr 1fr;gap:14px}
  .form-grid .span-2{grid-column:1 / -1}

  label{
    display:block;
    font:600 12px/1.2 "Inter";
    color:#434a55;
    margin-bottom:8px;
    letter-spacing:.02em
  }
  .input, .select, .textarea{
    width:100%;
    border:1px solid var(--ring);
    border-radius:8px;
    padding:12px 12px;
    font:600 14px/1.4 "Inter";
    color:#111;
    background:#fff;
    outline:none;
  }
  .textarea{min-height:140px;resize:vertical}
  .input:focus, .select:focus, .textarea:focus{
    box-shadow:0 0 0 3px rgba(16,163,127,.12);
    border-color:#10a37f;
  }

  .muted{color:#6b7280;font:600 13px/1.6 "Inter"}
  .btn{
    appearance:none;border:0;border-radius:10px;padding:12px 16px;
    font:800 13px/1 "Inter";letter-spacing:.06em;text-transform:uppercase;
    background:#111;color:#fff;cursor:pointer
  }
  .btn[disabled]{opacity:.6;cursor:not-allowed}

  .note{font:600 12px/1.5 "Inter";color:#6b7280}

  .alert{
    border-radius:10px;
    padding:12px 14px;
    background:#f0fdf4;
    border:1px solid #dcfce7;
    color:#14532d;
    font:600 13px/1.5 "Inter";
    margin-bottom:16px;
  }
  .error{
    margin-top:6px;
    font:600 12px/1.4 "Inter";
    color:#b91c1c;
  }

  /* ===== Responsive ===== */
  @media (max-width: 980px){
    .grid-2{grid-template-columns:1fr;gap:26px}
    .form-grid{grid-template-columns:1fr}
    .form-grid .span-2{grid-column:auto}
  }
</style>
@endsection

@section('content')
  <!-- HERO -->
  <header class="brand-hero">
    <div class="eyebrow">CONTACT US</div>
    <div class="ghost">GULEY THREADS</div>
  </header>

  <!-- BODY -->
  <section class="wrap">
    <div class="fx block">
      <div class="grid-2">
        <!-- Left: Contact Details -->
        <aside class="card">
          <div class="hd">Reach us</div>
          <div class="bd stack">
            <p class="muted">
              We’d love to hear from you. Whether it’s a custom request, order help, or a partnership idea — drop us a message.
            </p>
            <div>
              <div style="font:700 14px/1.4 Inter;color:#111;margin-bottom:6px">Email</div>
              <a href="mailto:hello@guleythreads.com" style="font:600 14px/1.6 Inter;color:#0a0a0a">hello@guleythreads.com</a>
            </div>
            <div>
              <div style="font:700 14px/1.4 Inter;color:#111;margin-bottom:6px">Phone / WhatsApp</div>
              <a href="tel:+92XXXXXXXXXX" style="font:600 14px/1.6 Inter;color:#0a0a0a">+92 XX XXX XXXX</a>
            </div>
            <div>
              <div style="font:700 14px/1.4 Inter;color:#111;margin-bottom:6px">Hours</div>
              <p class="muted" style="margin:0">Mon–Sat, 10:00–18:00 (PKT)</p>
            </div>
            <div>
              <div style="font:700 14px/1.4 Inter;color:#111;margin-bottom:6px">Studio</div>
              <p class="muted" style="margin:0">
                Hand-Embroidery Studio, Karachi, Pakistan
              </p>
            </div>
          </div>
        </aside>

        <!-- Right: Form -->
        <div class="card">
          <div class="hd">Send a message</div>
          <div class="bd">
            @if (session('status'))
              <div class="alert">{{ session('status') }}</div>
            @endif

            <form method="POST" action="" novalidate>
              @csrf

              <!-- honeypot (simple anti-bot) -->
              <input type="text" name="website" tabindex="-1" autocomplete="off" style="position:absolute;left:-9999px;height:0;width:0" aria-hidden="true">

              <div class="form-grid">
                <div>
                  <label for="name">Full Name</label>
                  <input id="name" name="name" type="text" class="input" value="{{ old('name') }}" required>
                  @error('name')<div class="error">{{ $message }}</div>@enderror
                </div>

                <div>
                  <label for="email">Email</label>
                  <input id="email" name="email" type="email" class="input" value="{{ old('email') }}" required>
                  @error('email')<div class="error">{{ $message }}</div>@enderror
                </div>

                <div>
                  <label for="phone">Phone (optional)</label>
                  <input id="phone" name="phone" type="tel" class="input" value="{{ old('phone') }}">
                  @error('phone')<div class="error">{{ $message }}</div>@enderror
                </div>

                <div>
                  <label for="inquiry_type">Inquiry Type</label>
                  <select id="inquiry_type" name="inquiry_type" class="select">
                    <option value="">Select one…</option>
                    <option value="order_support" @selected(old('inquiry_type')==='order_support')>Order support</option>
                    <option value="custom_request" @selected(old('inquiry_type')==='custom_request')>Custom request</option>
                    <option value="wholesale" @selected(old('inquiry_type')==='wholesale')>Wholesale / Partnership</option>
                    <option value="general" @selected(old('inquiry_type')==='general')>General question</option>
                  </select>
                  @error('inquiry_type')<div class="error">{{ $message }}</div>@enderror
                </div>

                <div>
                  <label for="order_number">Order # (optional)</label>
                  <input id="order_number" name="order_number" type="text" class="input" value="{{ old('order_number') }}" placeholder="e.g., GT-2025-00123">
                  @error('order_number')<div class="error">{{ $message }}</div>@enderror
                </div>

                <div class="span-2">
                  <label for="subject">Subject</label>
                  <input id="subject" name="subject" type="text" class="input" value="{{ old('subject') }}" required>
                  @error('subject')<div class="error">{{ $message }}</div>@enderror
                </div>

                <div class="span-2">
                  <label for="message">Message</label>
                  <textarea id="message" name="message" class="textarea" required>{{ old('message') }}</textarea>
                  @error('message')<div class="error">{{ $message }}</div>@enderror
                </div>

                <div class="span-2" style="display:flex;gap:10px;align-items:flex-start">
                  <input id="consent" name="consent" type="checkbox" value="1" style="margin-top:3px">
                  <label for="consent" style="margin:0">
                    I agree to be contacted regarding my inquiry and understand my data will be handled according to the privacy policy.
                  </label>
                </div>
                @error('consent')<div class="error span-2">{{ $message }}</div>@enderror

                <div class="span-2" style="display:flex;align-items:center;justify-content:space-between;margin-top:6px">
                  <span class="note">We usually reply within 1–2 business days.</span>
                  <button type="submit" class="btn">Send Message</button>
                </div>
              </div>
            </form>

            <p class="note" style="margin-top:12px">
              Need quick help about an existing order? Include your order number for faster support.
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection
