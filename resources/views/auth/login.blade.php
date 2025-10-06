@extends('frontend.layouts.app')
@section('title','Sign In')

@section('styles')
<link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Inter:wght@400;600;700;800;900&display=swap" rel="stylesheet">
<style>
  :root{
    --ink:#0f0f10;
    --muted:#8b8f96;
    --line:#ececec;
    --maroon:#6a0f2a;
    --maroon-dark:#5b112d;
  }

  .fx{max-width:1180px;margin:0 auto;padding:0 18px}

  /* =============== HERO ================= */
  .hero{
    background:#181818; color:#fff; min-height:320px;
    display:flex; align-items:center; justify-content:center;
    position:relative; overflow:hidden; text-align:center;
  }
  .hero .wrap{position:relative; z-index:2}
  .hero .ghost{
    position:absolute; inset:0; display:flex; align-items:center; justify-content:center;
    font:900 clamp(140px,19vw,260px)/.9 "Inter",system-ui; color:#ffffff0f; letter-spacing:.08em; pointer-events:none;
  }
  .eyebrow{
    font:900 14px/1.1 "Inter"; letter-spacing:.32em; text-transform:uppercase;
    color:#d8d8d8; margin-bottom:12px;
  }
  .title{
    font:900 40px/1.05 "Inter"; letter-spacing:.10em; text-transform:uppercase;
    white-space:nowrap; /* single line */
  }
  .sub{
    margin-top:14px; color:#cfcfcf; font:800 11px/1 "Inter"; letter-spacing:.26em; text-transform:uppercase;
  }

  /* ============== BODY (centered form) ============== */
  .section{background:#fff}
  .center{padding:64px 0 84px}
  .form-wrap{max-width:520px;margin:0 auto}
  .col-title{
    font:800 11px/1 "Inter"; letter-spacing:.24em; text-transform:uppercase; color:#6d6d73; margin:0 0 14px;
  }

  .input{
    width:100%; height:36px;
    border:1px solid #e3e3e3; border-radius:0; background:#fff;
    padding:8px 10px; font:600 12px/1.2 "Inter"; color:#111; margin-bottom:12px;
  }
  .input::placeholder{color:#b8b9bd}
  .input:focus{outline:none; border-color:#cfcfcf; box-shadow:0 0 0 2px #f4f4f4}
  .input.is-invalid{border-color:#cf3c3c}

  .row-actions{display:flex; align-items:center; gap:14px; margin-top:8px}

  .btn{
    height:32px; padding:0 20px; border:0; border-radius:0; cursor:pointer;
    font:900 10px/32px "Inter"; letter-spacing:.18em; text-transform:uppercase;
  }
  .btn-maroon{background:var(--maroon); color:#fff}
  .btn-maroon:hover{background:var(--maroon-dark)}

  .link{
    font:700 10px/1.2 "Inter"; color:#9a9aa0; text-decoration:none;
  }
  .link:hover{color:#6d6d73; text-decoration:underline}

  .alert-ok{
    background:#f0fdf4; color:#14532d; border:1px solid #dcfce7; border-radius:6px;
    font:600 12px/1.5 "Inter"; padding:10px 12px; margin:0 0 12px;
  }
  .alert-err{
    background:#fef2f2; color:#7f1d1d; border:1px solid #fecaca; border-radius:6px;
    font:600 12px/1.5 "Inter"; padding:10px 12px; margin:0 0 12px;
  }

  .stripe{height:1px; background:var(--line)}
</style>
@endsection

@section('content')

  {{-- ============== HERO ============== --}}
  <header class="hero">
    <div class="wrap">
      <div class="eyebrow">WELCOME TO</div>
      <div class="title">GULEY THREADS</div>
      <div class="sub">SIGN IN</div>
    </div>
    <div class="ghost">GULEY THREADS</div>
  </header>

  {{-- ============== SIGN IN (center) ============== --}}
  <section class="section">
    <div class="fx center">
      <div class="form-wrap">
        <div class="col-title">SIGN IN</div>

        @if(session('status'))
          <div class="alert-ok">{{ session('status') }}</div>
        @endif

        @if ($errors->any())
          <div class="alert-err">
            <ul style="margin:0;padding-left:18px">
              @foreach ($errors->all() as $error)
                <li style="font-size:12px">{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form method="POST" action="{{ route('login') }}" novalidate>
          @csrf
          <input type="email"
                 name="email"
                 class="input @error('email') is-invalid @enderror"
                 placeholder="Your Email."
                 value="{{ old('email') }}"
                 required>

          <input type="password"
                 name="password"
                 class="input @error('password') is-invalid @enderror"
                 placeholder="Your password."
                 required>

          <div class="row-actions">
            <button type="submit" class="btn btn-maroon">Sign In</button>

            @if (\Illuminate\Support\Facades\Route::has('password.request'))
              <a href="{{ route('password.request') }}" class="link">Forgot your Password</a>
            @endif
          </div>
        </form>
      </div>
    </div>
    <div class="stripe"></div>
  </section>

@endsection
