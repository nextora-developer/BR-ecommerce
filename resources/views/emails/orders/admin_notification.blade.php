<x-mail::message>
# 🛎 New Order Received

A new order has just been placed on **{{ config('app.name') }}**.

---

## 🧾 Order Summary

- **Order No:** {{ $order->order_no }}
- **Placed At:** {{ $order->created_at->format('Y-m-d H:i') }}
- **Status:** {{ ucfirst($order->status) }}
- **Payment Method:** {{ $order->payment_method_name }}

@php
    $pointsRate   = 1; // RM1 = 1pt
    $earnedPoints = (int) floor(($order->total ?? 0) * $pointsRate);
    $isCompleted  = ($order->status === 'completed');
@endphp

<x-mail::panel>
Subtotal: RM {{ number_format($order->subtotal, 2) }}<br>
Shipping Fee: RM {{ number_format($order->shipping_fee, 2) }}<br>

@if (($order->voucher_discount ?? 0) > 0)
Voucher
@if ($order->voucher_code)
({{ $order->voucher_code }})
@endif
: - RM {{ number_format($order->voucher_discount, 2) }}<br>
@endif
@if (($order->shipping_discount ?? 0) > 0)
Shipping Discount
@if ($order->voucher_code)
({{ $order->voucher_code }})
@endif
: - RM {{ number_format($order->shipping_discount, 2) }}<br>
@endif
@if (($order->points_discount ?? 0) > 0)
Points Redeemed
@if (($order->points_redeem ?? 0) > 0)
({{ number_format((int) $order->points_redeem) }} pts)
@endif
: - RM {{ number_format((float) $order->points_discount, 2) }}<br>
@endif

<hr style="border:none;border-top:1px solid rgba(0,0,0,0.08);margin:12px 0;">

<strong>Grand Total: RM {{ number_format($order->total, 2) }}</strong><br>

{{ $isCompleted ? 'Points Earned' : 'Will Earn Points' }}:
<strong>+{{ number_format($earnedPoints) }} pts</strong><br>
</x-mail::panel>

---

## 👤 Customer Details

- **Name:** {{ $order->customer_name }}
- **Phone:** {{ $order->customer_phone }}
- **Email:** {{ $order->customer_email }}

---

## 📦 Shipping Address

{{ $order->address_line1 }}<br>
@if($order->address_line2)
{{ $order->address_line2 }}<br>
@endif
{{ $order->postcode }} {{ $order->city }}, {{ $order->state }}<br>
{{ $order->country }}

---

## 🛍 Items

<x-mail::table>
| # | Product | Variant | Qty | Unit Price | Line Total |
|:-:|:--------|:--------|:---:|-----------:|-----------:|
@foreach ($order->items as $index => $item)
| {{ $index + 1 }} | {{ $item->product_name }} | {{ $item->variant_label ?? '-' }} | {{ $item->qty }} | RM {{ number_format($item->unit_price, 2) }} | RM {{ number_format($item->unit_price * $item->qty, 2) }} |
@endforeach
</x-mail::table>

<x-mail::button :url="route('admin.orders.show', $order)">
Open in Admin Panel
</x-mail::button>

Thanks,<br>
{{ config('app.name') }} Admin
</x-mail::message>
