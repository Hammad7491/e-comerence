@extends('layouts.app')

@section('content')
<style>
:root{
  --ink:#0f172a;--muted:#64748b;--ring:rgba(79,70,229,.18);
  --indigo:#4f46e5;--blue:#2563eb;--border:#e5e7eb;--card:#ffffff;
}
.page{max-width:1120px;margin:0 auto;padding:28px 16px}
.h1{font:800 44px/1.05 ui-sans-serif,system-ui,"Segoe UI",Roboto,Ubuntu,"Helvetica Neue",Arial;color:var(--ink);letter-spacing:-.02em;margin:0}

/* Toolbar */
.toolbar{display:flex;gap:10px;flex-wrap:wrap}
.toolbar input[type="search"]{
  border:1px solid var(--border);border-radius:.75rem;padding:.6rem .9rem;min-width:260px;outline:none;
  font:600 14px/1 ui-sans-serif;color:#0f172a;background:#fff;
}
.toolbar input[type="search"]::placeholder{color:#9aa3b2}
.toolbar input[type="search"]:focus{border-color:var(--indigo);box-shadow:0 0 0 .35rem var(--ring)}

/* Desktop table */
.table-wrap{
  overflow:auto;background:var(--card);border:1px solid #eef2f7;border-radius:1rem;
  box-shadow:0 8px 20px rgba(2,6,23,.06)
}
table{width:100%;border-collapse:collapse;min-width:880px}
thead th{
  background:#f8fafc;font:600 13px/1 ui-sans-serif;color:#475569;text-align:left;padding:12px 14px;border-bottom:1px solid #e2e8f0;white-space:nowrap
}
tbody td{padding:12px 14px;border-top:1px solid #f1f5f9;vertical-align:top}
tr:hover{background:#fafafa}

/* Bits */
.badge{display:inline-flex;align-items:center;padding:.25rem .55rem;border-radius:.5rem;font-weight:700;font-size:.75rem;border:1px solid #a7f3d0;background:#ecfdf5;color:#065f46}
.order-contact{color:#0f172a;font-weight:700}
.order-small{color:var(--muted);font-size:12px}
.proof-link{color:var(--blue);text-decoration:none;font-weight:700}
.proof-link:hover{text-decoration:underline}
.btn-sm{padding:.45rem .7rem;font-size:.8rem;font-weight:800;border-radius:.6rem;cursor:pointer;border:0}
.btn-del{background:#e11d48;color:#fff}.btn-del:hover{filter:brightness(.95)}

/* Mobile card list */
.mobile-list{display:none}
.card{
  background:#fff;border:1px solid #eef2f7;border-radius:12px;padding:12px;
  box-shadow:0 6px 16px rgba(2,6,23,.06)
}
.card + .card{margin-top:12px}
.card h3{margin:0 0 6px;font:800 16px/1.25 ui-sans-serif;color:#0f172a}
.kv{display:grid;grid-template-columns:110px 1fr;gap:6px 10px;font:600 13px/1.4 ui-sans-serif}
.kv .k{color:#475569}
.kv .v{color:#0f172a}
.row{display:flex;flex-wrap:wrap;gap:8px 10px;align-items:center}
.actions{display:flex;gap:8px;flex-wrap:wrap;margin-top:10px}

/* Responsive */
@media (max-width:1024px){
  .h1{font-size:36px}
  .toolbar input[type="search"]{min-width:200px}
}
@media (max-width:768px){
  .h1{font-size:30px;text-align:center}
  .page > .head{grid-template-columns:1fr;gap:10px;text-align:center}
  .toolbar{justify-content:center}
}
@media (max-width:640px){
  .table-wrap{display:none}
  .mobile-list{display:block}
  .toolbar input[type="search"]{min-width:150px;font-size:13px;padding:.5rem .7rem}
  .page{padding:22px 12px}
}
@media (max-width:420px){
  .h1{font-size:26px}
  .kv{grid-template-columns:96px 1fr}
  .btn-sm{padding:.4rem .6rem;font-size:.74rem}
}
</style>

<div class="page">
  <div class="head" style="display:grid;grid-template-columns:1fr auto;gap:16px;align-items:center;margin-bottom:16px">
    <h1 class="h1">Approved Orders</h1>
    <form method="GET" class="toolbar">
      <input type="search" name="q" placeholder="Search approved orders…" value="{{ request('q') }}">
      <button hidden>Filter</button>
    </form>
  </div>

  @if(session('success'))
    <div style="margin:8px 0 16px;padding:12px 14px;border-radius:.75rem;background:#ecfdf5;color:#14532d;border:1px solid #a7f3d0;">
      {{ session('success') }}
    </div>
  @endif

  {{-- Desktop / tablet table --}}
  <div class="table-wrap">
    <table>
      <thead>
        <tr>
          <th>Customer</th>
          <th>Phone</th>
          <th>Address</th>
          <th>Total</th>
          <th>Payment</th>
          <th>Proof</th>
          <th>Status</th>
          <th>Approved At</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
      @forelse($orders as $o)
        <tr>
          <td class="order-contact">{{ $o->name }}</td>
          <td>{{ $o->phone }}</td>
          <td style="max-width:260px">{{ $o->address }}</td>
          <td><strong>PKR {{ number_format($o->total,0) }}</strong></td>
          <td style="text-transform:uppercase">{{ $o->payment_method }}</td>
          <td>
            @if($o->payment_proof)
              <div style="display:flex;gap:10px;flex-wrap:wrap">
                
                <a class="proof-link" href="{{ route('admin.orders.download-proof', $o) }}">Download</a>
              </div>
            @else
              <span class="order-small">—</span>
            @endif
          </td>
          <td><span class="badge">Approved</span></td>
          <td class="order-small">{{ $o->updated_at->format('M d, Y h:i A') }}</td>
          <td>
            <form method="POST" action="{{ route('admin.orders.destroy', $o) }}"
                  onsubmit="return confirm('Delete this order? This cannot be undone.');">
              @csrf @method('DELETE')
              <button class="btn-sm btn-del">Delete</button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="9" style="text-align:center;color:#64748b;padding:24px">No approved orders yet.</td></tr>
      @endforelse
      </tbody>
    </table>
  </div>

  {{-- Mobile card list --}}
  <div class="mobile-list">
    @forelse($orders as $o)
      <article class="card">
        <h3>{{ $o->name }}</h3>
        <div class="row" style="margin-bottom:8px">
          <span class="badge">Approved</span>
          <span class="order-small">Approved at: {{ $o->updated_at->format('M d, Y h:i A') }}</span>
        </div>
        <div class="kv">
          <div class="k">Phone</div>    <div class="v">{{ $o->phone }}</div>
          <div class="k">Address</div>  <div class="v">{{ $o->address }}</div>
          <div class="k">Total</div>    <div class="v"><strong>PKR {{ number_format($o->total,0) }}</strong></div>
          <div class="k">Payment</div>  <div class="v" style="text-transform:uppercase">{{ $o->payment_method }}</div>
          <div class="k">Proof</div>
          <div class="v">
            @if($o->payment_proof)
              <a class="proof-link" href="{{ Storage::disk('public')->url($o->payment_proof) }}" target="_blank" rel="noopener">View</a>
              &nbsp;|&nbsp;
              <a class="proof-link" href="{{ route('admin.orders.download-proof', $o) }}">Download</a>
            @else
              <span class="order-small">—</span>
            @endif
          </div>
        </div>
        <div class="actions">
          <form method="POST" action="{{ route('admin.orders.destroy', $o) }}"
                onsubmit="return confirm('Delete this order? This cannot be undone.');">
            @csrf @method('DELETE')
            <button class="btn-sm btn-del" style="width:100%">Delete</button>
          </form>
        </div>
      </article>
    @empty
      <div style="text-align:center;color:#64748b;padding:16px">No approved orders yet.</div>
    @endforelse
  </div>

  <div style="margin-top:18px">
    {{ $orders->appends(['q'=>request('q')])->links() }}
  </div>
</div>
@endsection
