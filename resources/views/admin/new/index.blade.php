@extends('layouts.app')

@section('content')
<style>
:root{
  --bg:#f6f8fb; --card:#ffffff; --ink:#0f172a; --muted:#64748b;
  --primary:#5b6cff; --primary-600:#4959f2; --ring:rgba(91,108,255,.22);
  --border:#e6e8ef; --shadow:0 12px 30px rgba(15,23,42,.06);
}
body{background:var(--bg)}
.fx-wrap{max-width:980px;margin:0 auto;padding:28px 16px}
.fx-header{display:flex;gap:12px;align-items:center;justify-content:space-between;margin-bottom:18px}
.fx-title{font:800 40px/1.05 ui-sans-serif,system-ui,"Segoe UI",Roboto,Ubuntu,"Helvetica Neue",Arial;color:var(--ink);letter-spacing:-.025em}
.fx-btn{display:inline-flex;align-items:center;justify-content:center;gap:8px;padding:10px 16px;border-radius:12px;border:1px solid transparent;font-weight:900;color:#fff;background:linear-gradient(135deg,var(--primary),var(--primary-600));box-shadow:0 8px 18px rgba(91,108,255,.25);text-decoration:none}
.fx-card{background:var(--card);border:1px solid var(--border);border-radius:22px;box-shadow:var(--shadow);padding:0;overflow:hidden}
.fx-table{width:100%;border-collapse:separate;border-spacing:0}
.fx-table thead th{background:#f7f8ff;color:#111827;font-weight:800;padding:14px;border-bottom:1px solid var(--border);text-align:left}
.fx-table tbody td{padding:14px;border-bottom:1px solid var(--border);color:#0f172a}
.fx-actions{display:flex;gap:8px}
.fx-link{display:inline-flex;align-items:center;gap:6px;padding:8px 12px;border-radius:10px;text-decoration:none;font-weight:800;border:1px solid var(--border);background:#fff;color:#0f172a}
.fx-del{background:#fff0f0;border-color:#ffd2d2;color:#b42318}
.fx-empty{padding:24px;color:var(--muted);text-align:center}
.alert{margin:12px 0;padding:10px 12px;border-radius:12px}
.alert-success{background:#ecfdf5;color:#065f46;border:1px solid #a7f3d0}
</style>

<div class="fx-wrap">
  <div class="fx-header">
    <h3 class="fx-title">“What’s New” Items</h3>
    <a href="{{ route('admin.new.create') }}" class="fx-btn">+ Add New</a>
  </div>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <div class="fx-card">
    <table class="fx-table">
      <thead>
        <tr>
          
          <th style="width:110px">Image</th>
          <th>Title</th>
          <th style="width:200px">Action</th>
        </tr>
      </thead>
      <tbody>
      @forelse($items as $item)
        <tr>
          
          <td>
            @if($item->image)
              <img src="{{ asset($item->image) }}" width="80" height="80" style="object-fit:cover;border-radius:8px;">

            @else
              <span class="text-muted">No Image</span>
            @endif
          </td>
          <td style="font-weight:800">{{ $item->title }}</td>
          <td>
            <div class="fx-actions">
              <!-- Edit opens the SAME view with $item set -->
              <a class="fx-link" href="{{ route('admin.new.edit', $item->id) }}">Edit</a>

              <form action="{{ route('admin.new.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Delete this item?')">
                @csrf @method('DELETE')
                <button type="submit" class="fx-link fx-del">Delete</button>
              </form>
            </div>
          </td>
        </tr>
      @empty
        <tr><td colspan="4" class="fx-empty">No items found.</td></tr>
      @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection
