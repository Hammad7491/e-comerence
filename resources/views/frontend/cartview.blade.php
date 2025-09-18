@extends('frontend.layouts.app')
@section('title','Your Cart')

@section('content')
<div class="fx-container" style="max-width:960px;margin:30px auto">
  @if(session('success'))
    <div style="background:#e7f5ee;color:#0f5132;padding:10px 12px;border-radius:4px;margin-bottom:12px">
      {{ session('success') }}
    </div>
  @endif

  <h1 style="font:800 24px 'Inter',sans-serif;margin-bottom:16px">Your Cart</h1>

  @php $cart = $cart ?? ['items'=>[], 'total'=>0]; @endphp
  @if(empty($cart['items']))
    <p style="color:#6b7280">Your cart is empty.</p>
  @else
    <table style="width:100%;border-collapse:collapse;margin-top:14px">
      <thead>
        <tr style="text-align:left;border-bottom:1px solid #e5e7eb">
          <th style="padding:8px">Product</th>
          <th style="padding:8px">Price</th>
          <th style="padding:8px">Qty</th>
          <th style="padding:8px">Total</th>
        </tr>
      </thead>
      <tbody>
        @foreach($cart['items'] as $row)
          <tr style="border-bottom:1px solid #f1f1f1">
            <td style="padding:8px;display:flex;gap:10px;align-items:center">
              @if(!empty($row['image']))
                <img src="{{ $row['image'] }}" alt="" style="width:48px;height:48px;object-fit:cover;border-radius:4px">
              @endif
              {{ $row['name'] }}
            </td>
            <td style="padding:8px">PKR {{ number_format($row['price'],0) }}</td>
            <td style="padding:8px">{{ $row['qty'] }}</td>
            <td style="padding:8px;font-weight:700">PKR {{ number_format($row['total'],0) }}</td>
          </tr>
        @endforeach
      </tbody>
      <tfoot>
        <tr>
          <td colspan="3" style="padding:12px;text-align:right;font-weight:800">Grand Total</td>
          <td style="padding:12px;font-weight:800">PKR {{ number_format($cart['total'],0) }}</td>
        </tr>
      </tfoot>
    </table>
  @endif
</div>
@endsection
