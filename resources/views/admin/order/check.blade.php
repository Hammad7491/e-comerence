@extends('layouts.app')

@section('content')
<style>
:root{--ink:#0f172a;--muted:#64748b;--ring:rgba(79,70,229,.18);--indigo:#4f46e5;--rose:#e11d48;--green:#16a34a}
.page{max-width:1120px;margin:0 auto;padding:28px 16px}
.h1{font:800 44px/1.05 ui-sans-serif,system-ui,"Segoe UI",Roboto,Ubuntu,"Helvetica Neue",Arial;color:var(--ink);letter-spacing:-.02em}
.toolbar{display:flex;gap:10px;flex-wrap:wrap}
.toolbar input[type="search"],.toolbar select{border:1px solid #e5e7eb;border-radius:.75rem;padding:.6rem .9rem;min-width:220px;outline:none}
.toolbar input[type="search"]:focus{border-color:var(--indigo);box-shadow:0 0 0 .35rem var(--ring)}
.table-wrap{overflow:hidden;background:#fff;border:1px solid #eef2f7;border-radius:1rem;box-shadow:0 8px 20px rgba(2,6,23,.06)}
table{width:100%;border-collapse:collapse}
thead th{background:#f8fafc;font:600 13px/1 ui-sans-serif;color:#475569;text-align:left;padding:12px 14px;border-bottom:1px solid #e2e8f0}
tbody td{padding:12px 14px;border-top:1px solid #f1f5f9}
tr:hover{background:#fafafa}
.badge{display:inline-flex;align-items:center;padding:.25rem .55rem;border-radius:.5rem;font-weight:700;font-size:.75rem}
.badge.pending{background:#fff7ed;color:#9a3412;border:1px solid #fed7aa}
.badge.approved{background:#ecfdf5;color:#065f46;border:1px solid #a7f3d0}
.badge.rejected{background:#fff1f2;color:#9f1239;border:1px solid #fecdd3}
.btn-sm{padding:.4rem .7rem;font-size:.8rem;font-weight:700;border-radius:.5rem}
.btn-approve{background:var(--green);color:#fff}.btn-approve:hover{filter:brightness(.95)}
.btn-reject{background:var(--rose);color:#fff}.btn-reject:hover{filter:brightness(.95)}
.order-contact{color:#0f172a;font-weight:700}
.order-small{color:var(--muted);font-size:12px}
.proof-link{color:#2563eb;text-decoration:none;font-weight:700}
.proof-link:hover{text-decoration:underline}
</style>

<div class="page">
  <div style="display:grid;grid-template-columns:1fr auto;gap:16px;align-items:center;margin-bottom:16px">
    <h1 class="h1">Order List</h1>
    <form method="GET" class="toolbar">
      <input type="search" name="q" placeholder="Search orders…" value="{{ request('q') }}">
      <select name="status" onchange="this.form.submit()">
        @php $status = request('status'); @endphp
        <option value="">Pending (default)</option>
        <option value="pending"  @selected($status==='pending')>Pending</option>
        <option value="approved" @selected($status==='approved')>Approved</option>
        <option value="rejected" @selected($status==='rejected')>Rejected</option>
      </select>
      <button hidden>Filter</button>
    </form>
  </div>

  @if(session('success'))
    <div style="margin:8px 0 16px;padding:12px 14px;border-radius:.75rem;background:#ecfdf5;color:#14532d;border:1px solid #a7f3d0;">
      {{ session('success') }}
    </div>
  @endif

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
      <tbody>
      @forelse($orders as $o)
        <tr>
          <td class="order-contact">
            {{ $o->name }}
            <div class="order-small">{{ optional($o->user)->email }}</div>
          </td>
          <td>{{ $o->phone }}</td>
          <td style="max-width:260px">{{ $o->address }}</td>
          <td><strong>PKR {{ number_format($o->total,0) }}</strong></td>
          <td style="text-transform:uppercase">{{ $o->payment_method }}</td>
          <td>
           <td>
  @if($o->payment_proof)
    <div style="display:flex;gap:10px;flex-wrap:wrap">
      <a class="proof-link" href="{{ Storage::disk('public')->url($o->payment_proof) }}" target="_blank" rel="noopener">View</a>
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
      </tbody>
    </table>
  </div>

  <div style="margin-top:18px">
    {{ $orders->appends(['q'=>request('q'),'status'=>request('status')])->links() }}
  </div>
</div>
@endsection
