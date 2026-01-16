<x-mail::message>
# ✅ Order Marked as Completed

A customer has confirmed they have received the order.

---

## 🧾 Order Info

- **Order No:** {{ $order->order_no }}
- **Customer:** {{ $order->customer_name }} ({{ $order->customer_email }})
- **Status:** {{ ucfirst($oldStatus) }} → **{{ ucfirst($newStatus) }}**
- **Confirmed At:** {{ now()->format('Y-m-d H:i') }}

@php
    $pointsRate   = 1; // RM1 = 1pt
    $earnedPoints = (int) floor(($order->total ?? 0) * $pointsRate);
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

<strong>Total Paid: RM {{ number_format($order->total, 2) }}</strong><br>

Points Earned:
<strong>+{{ number_format($earnedPoints) }} pts</strong><br>

Payment Method:
<strong>{{ $order->payment_method_name }}</strong>
</x-mail::panel>

<x-mail::button :url="route('admin.orders.show', $order)">
Open in Admin Panel
</x-mail::button>

Thanks,<br>
{{ config('app.name') }} System
</x-mail::message>
