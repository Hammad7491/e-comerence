@extends('layouts.app')

@section('content')
<style>
:root{
  --ink:#0f172a;--muted:#64748b;--ring:rgba(79,70,229,.18);
  --indigo:#4f46e5;--rose:#e11d48;--green:#16a34a;--border:#e5e7eb;
  --card:#ffffff;--bg:#f8fafc;
}

/* Page shell */
.page{max-width:1120px;margin:0 auto;padding:28px 16px}
.h1{font:800 44px/1.05 ui-sans-serif,system-ui,"Segoe UI",Roboto,Ubuntu,"Helvetica Neue",Arial;color:var(--ink);letter-spacing:-.02em;margin:0}

/* Toolbar */
.toolbar{display:flex;gap:10px;flex-wrap:wrap}
.toolbar input[type="search"],.toolbar select{
  border:1px solid var(--border);border-radius:.75rem;padding:.6rem .9rem;min-width:220px;outline:none;
  font:600 14px/1 ui-sans-serif;color:#0f172a;background:#fff;
}
.toolbar input[type="search"]::placeholder{color:#9aa3b2}
.toolbar input[type="search"]:focus{border-color:var(--indigo);box-shadow:0 0 0 .35rem var(--ring)}

/* Desktop table */
.table-wrap{
  overflow:auto;background:var(--card);border:1px solid #eef2f7;border-radius:1rem;box-shadow:0 8px 20px rgba(2,6,23,.06)
}
table{width:100%;border-collapse:collapse;min-width:880px}
thead th{
  background:#f8fafc;font:600 13px/1 ui-sans-serif;color:#475569;text-align:left;padding:12px 14px;
  border-bottom:1px solid #e2e8f0;white-space:nowrap
}
tbody td{padding:12px 14px;border-top:1px solid #f1f5f9;vertical-align:top}
tr:hover{background:#fafafa}

/* Badges + buttons */
.badge{display:inline-flex;align-items:center;padding:.25rem .55rem;border-radius:.5rem;font-weight:700;font-size:.75rem;border:1px solid transparent}
.badge.pending{background:#fff7ed;color:#9a3412;border-color:#fed7aa}
.badge.approved{background:#ecfdf5;color:#065f46;border-color:#a7f3d0}
.badge.rejected{background:#fff1f2;color:#9f1239;border-color:#fecdd3}

.btn-sm{padding:.45rem .7rem;font-size:.8rem;font-weight:800;border-radius:.6rem;border:0;cursor:pointer}
.btn-approve{background:var(--green);color:#fff}.btn-approve:hover{filter:brightness(.95)}
.btn-reject{background:var(--rose);color:#fff}.btn-reject:hover{filter:brightness(.95)}

.order-contact{color:#0f172a;font-weight:700}
.order-small{color:var(--muted);font-size:12px}
.proof-link{color:#2563eb;text-decoration:none;font-weight:700}
.proof-link:hover{text-decoration:underline}

/* MOBILE CARD LIST (shown under 640px) */
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
  .toolbar input[type="search"],.toolbar select{min-width:180px}
}
@media (max-width:768px){
  .h1{font-size:30px;text-align:center}
  .page > .head{grid-template-columns:1fr;gap:10px;text-align:center}
  .toolbar{justify-content:center}
}
@media (max-width:640px){
  .table-wrap{display:none}
  .mobile-list{display:block}
  .toolbar input[type="search"],.toolbar select{min-width:150px;font-size:13px;padding:.5rem .7rem}
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
    <h1 class="h1">Order List</h1>
    <form method="GET" class="toolbar" id="searchForm">
      <input id="liveSearch" type="search" name="q" placeholder="Search orders…" value="{{ request('q') }}">
      
      <button hidden>Filter</button>
    </form>
  </div>

  @if(session('success'))
    <div style="margin:8px 0 16px;padding:12px 14px;border-radius:.75rem;background:#ecfdf5;color:#14532d;border:1px solid #a7f3d0;">
      {{ session('success') }}
    </div>
  @endif

  {{-- Desktop / Tablet table --}}
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
          <th>Placed</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody id="ordersTbody">
      @forelse($orders as $o)
        <tr class="order-row" data-name="{{ Str::lower($o->name) }}">
          <td class="order-contact">
            {{ $o->name }}
            <div class="order-small">{{ optional($o->user)->email }}</div>
          </td>
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
          <td><span class="badge {{ $o->status }}">{{ ucfirst($o->status) }}</span></td>
          <td class="order-small">{{ $o->created_at->format('M d, Y h:i A') }}</td>
          <td>
            <div style="display:flex;gap:8px;flex-wrap:wrap">
              @if($o->status !== 'approved')
                <form method="POST" action="{{ route('admin.orders.approve',$o) }}">
                  @csrf @method('PATCH')
                  <button class="btn-sm btn-approve" onclick="return confirm('Approve this order?')">Approve</button>
                </form>
              @endif
              @if($o->status !== 'rejected')
                <form method="POST" action="{{ route('admin.orders.reject',$o) }}">
                  @csrf @method('PATCH')
                  <button class="btn-sm btn-reject" onclick="return confirm('Reject this order?')">Reject</button>
                </form>
              @endif
            </div>
          </td>
        </tr>
      @empty
        <tr><td colspan="9" style="text-align:center;color:#64748b;padding:24px">No orders found.</td></tr>
      @endforelse
      {{-- dynamic placeholder when filtering yields zero rows on this page --}}
      <tr id="noMatchRow" style="display:none;"><td colspan="9" style="text-align:center;color:#64748b;padding:24px">No orders found.</td></tr>
      </tbody>
    </table>
  </div>

  {{-- Mobile card view --}}
  <div class="mobile-list" id="ordersMobile">
    @forelse($orders as $o)
      <article class="card order-card" data-name="{{ Str::lower($o->name) }}">
        <h3>{{ $o->name }}</h3>
        <div class="row" style="margin-bottom:8px">
          <span class="badge {{ $o->status }}">{{ ucfirst($o->status) }}</span>
          <span class="order-small">Placed: {{ $o->created_at->format('M d, Y h:i A') }}</span>
        </div>

        <div class="kv">
          <div class="k">Email</div>     <div class="v">{{ optional($o->user)->email ?? '—' }}</div>
          <div class="k">Phone</div>     <div class="v">{{ $o->phone }}</div>
          <div class="k">Address</div>   <div class="v">{{ $o->address }}</div>
          <div class="k">Total</div>     <div class="v"><strong>PKR {{ number_format($o->total,0) }}</strong></div>
          <div class="k">Payment</div>   <div class="v" style="text-transform:uppercase">{{ $o->payment_method }}</div>
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
          @if($o->status !== 'approved')
            <form method="POST" action="{{ route('admin.orders.approve',$o) }}">
              @csrf @method('PATCH')
              <button class="btn-sm btn-approve" onclick="return confirm('Approve this order?')">Approve</button>
            </form>
          @endif
          @if($o->status !== 'rejected')
            <form method="POST" action="{{ route('admin.orders.reject',$o) }}">
              @csrf @method('PATCH')
              <button class="btn-sm btn-reject" onclick="return confirm('Reject this order?')">Reject</button>
            </form>
          @endif
        </div>
      </article>
    @empty
      <div style="text-align:center;color:#64748b;padding:16px">No orders found.</div>
    @endforelse

    {{-- dynamic placeholder for mobile when filtering yields zero cards --}}
    <div id="noMatchMobile" style="display:none;text-align:center;color:#64748b;padding:16px">No orders found.</div>
  </div>

  <div style="margin-top:18px">
    {{ $orders->appends(['q'=>request('q'),'status'=>request('status')])->links() }}
  </div>
</div>

{{-- Real-time search by customer name (client-side, current page) --}}
<script>
  (function(){
    const input   = document.getElementById('liveSearch');
    const form    = document.getElementById('searchForm');
    const rows    = Array.from(document.querySelectorAll('.order-row'));
    const cards   = Array.from(document.querySelectorAll('.order-card'));
    const noRow   = document.getElementById('noMatchRow');
    const noMob   = document.getElementById('noMatchMobile');

    if (!input) return;

    // prevent full page submit if user presses Enter — we do realtime filter
    form?.addEventListener('submit', function(e){
      e.preventDefault();
    });

    const filter = () => {
      const q = (input.value || '').trim().toLowerCase();

      let shownRows = 0;
      rows.forEach(tr => {
        const name = (tr.dataset.name || '').toLowerCase();
        const match = !q || name.includes(q);
        tr.style.display = match ? '' : 'none';
        if (match) shownRows++;
      });
      if (noRow) noRow.style.display = (shownRows === 0 && rows.length) ? '' : 'none';

      let shownCards = 0;
      cards.forEach(card => {
        const name = (card.dataset.name || '').toLowerCase();
        const match = !q || name.includes(q);
        card.style.display = match ? '' : 'none';
        if (match) shownCards++;
      });
      if (noMob) noMob.style.display = (shownCards === 0 && cards.length) ? '' : 'none';
    };

    // live as you type
    input.addEventListener('input', filter);

    // run once on load (handles when value comes from ?q=…)
    filter();
  })();
</script>
@endsection
