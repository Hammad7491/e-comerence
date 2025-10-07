@extends('frontend.layouts.app')
@section('title','Change Password')

@section('styles')
<style>
  :root{
    --ink:#0f0f10;
    --muted:#6b7280;
    --maroon:#6B1030;
    --card:#ffffff;
  }
  .wrap-psd{
    min-height: calc(100vh - 120px);
    display:flex; align-items:center; justify-content:center;
    padding:40px 16px;
    background:#f7f7f8;
  }
  .card-psd{
    width: min(560px, 95vw);
    background: var(--card);
    border-radius: 16px;
    box-shadow: 0 30px 80px rgba(15,23,42,.10);
    padding: 28px 24px 24px;
  }
  .title-psd{
    text-align:center; 
    color:var(--maroon); 
    font:800 17px/1 "Inter",system-ui;
    letter-spacing:.02em; 
    margin:4px 0 10px;
  }
  .sub-psd{
    text-align:center; 
    color:var(--muted); 
    font:600 14px/1.4 "Inter";
    margin-bottom: 18px;
  }
  .field{margin-bottom:14px}
  .input{
    width:100%; height:52px; border:1px solid #eef0f2; border-radius:12px;
    background:#fafafa; padding:0 16px; font:600 14px "Inter"; color:#111827;
    outline:none;
  }
  .input:focus{border-color:#d9dbe0; background:#fff; box-shadow:0 0 0 3px rgba(107,16,48,.08)}
  .btn{
    width:100%; height:52px; border:0; border-radius:12px; cursor:pointer;
    background:var(--maroon); color:#fff; font:800 14px "Inter"; letter-spacing:.04em;
  }
  .alert-ok{
    background:#e7f5ee; color:#0f5132; border:1px solid #a7f3d0;
    padding:10px 12px; border-radius:10px; margin-bottom:14px; font:600 13px "Inter";
  }
  .err{
    color:#b91c1c; font:600 12px "Inter"; margin-top:6px;
  }
</style>
@endsection

@section('content')
<section class="wrap-psd">
  <div class="card-psd">
    <h3 class="title-psd">Change Password</h3>
    <div class="sub-psd">Enter your current and new password</div>

    @if(session('success'))
      <div class="alert-ok">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('password.update') }}">
      @csrf

      <div class="field">
        <input class="input" type="password" name="current_password" placeholder="Current Password" required>
        @error('current_password') <div class="err">{{ $message }}</div> @enderror
      </div>

      <div class="field">
        <input class="input" type="password" name="password" placeholder="New Password" required>
        @error('password') <div class="err">{{ $message }}</div> @enderror
      </div>

      <div class="field">
        <input class="input" type="password" name="password_confirmation" placeholder="Confirm New Password" required>
        @error('password_confirmation') <div class="err">{{ $message }}</div> @enderror
      </div>

      <button class="btn" type="submit">Update Password</button>
    </form>
  </div>
</section>
@endsection
