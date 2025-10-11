@extends('layouts.app')

@section('content')
<div class="page" style="max-width:820px;margin:0 auto;padding:28px 16px">
  <h1 class="h1" style="font:800 36px/1.1 ui-sans-serif;color:#0f172a;margin-bottom:16px">My Profile</h1>

  @if(session('success'))
    <div style="margin:8px 0 16px;padding:12px 14px;border-radius:.75rem;background:#ecfdf5;color:#14532d;border:1px solid #a7f3d0;">
      {{ session('success') }}
    </div>
  @endif

  
    <div style="margin:8px 0 16px;padding:12px 14px;border-radius:.75rem;background:#fef2f2;color:#7f1d1d;border:1px solid #fecaca;">
      <ul style="margin:0;padding-left:18px">
        @foreach ($errors->all() as $error)
          <li style="font-size:14px">{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form method="POST" action="{{ route('profile.update') }}" class="fx-card" style="background:#fff;border:1px solid #e6e8ef;border-radius:16px;padding:20px">
    @csrf @method('PUT')

    <div style="display:grid;gap:16px">
      <label>
        <div style="font-weight:700;color:#0f172a;margin-bottom:6px">Name</div>
        <input type="text" name="name" required value="{{ old('name', $user->name) }}"
               class="fx-input" style="width:100%;padding:12px;border:1px solid #e5e7eb;border-radius:10px">
      </label>

      <label>
        <div style="font-weight:700;color:#0f172a;margin-bottom:6px">Email</div>
        <input type="email" name="email" required value="{{ old('email', $user->email) }}"
               class="fx-input" style="width:100%;padding:12px;border:1px solid #e5e7eb;border-radius:10px">
      </label>

      <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
        <label>
          <div style="font-weight:700;color:#0f172a;margin-bottom:6px">Current Password</div>
          <input type="password" name="current_password" autocomplete="current-password"
                 class="fx-input" style="width:100%;padding:12px;border:1px solid #e5e7eb;border-radius:10px">
          <small style="color:#64748b">Only required if changing password.</small>
        </label>

        <label>
          <div style="font-weight:700;color:#0f172a;margin-bottom:6px">New Password</div>
          <input type="password" name="password" autocomplete="new-password"
                 class="fx-input" style="width:100%;padding:12px;border:1px solid #e5e7eb;border-radius:10px">
        </label>
      </div>

      <label>
        <div style="font-weight:700;color:#0f172a;margin-bottom:6px">Confirm New Password</div>
        <input type="password" name="password_confirmation" autocomplete="new-password"
               class="fx-input" style="width:100%;padding:12px;border:1px solid #e5e7eb;border-radius:10px">
      </label>

      <div style="margin-top:8px">
        <button class="fx-btn" style="padding:12px 18px;border-radius:12px;background:#4f46e5;color:#fff;font-weight:800;border:0">
          Save Changes
        </button>
      </div>
    </div>
  </form>
</div>
@endsection
