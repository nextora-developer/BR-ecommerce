<x-app-layout>
    <div class="bg-[#FAF9F6] min-h-screen py-10">
        <div class="max-w-7xl5 mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Breadcrumb --}}
            <nav class="flex items-center gap-2 text-xs font-medium uppercase tracking-widest text-gray-400 mb-8">
                <a href="{{ route('home') }}" class="hover:text-[#8f6a10] transition-colors">Home</a>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M9 5l7 7-7 7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <a href="{{ route('account.orders.index') }}" class="hover:text-[#8f6a10]">Orders</a>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M9 5l7 7-7 7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <span class="text-gray-900">{{ $order->order_no }}</span>

            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">

                <aside class="hidden lg:block lg:col-span-1">
                    @include('account.partials.sidebar')
                </aside>

                <main class="lg:col-span-3 space-y-5">

                    {{-- Header --}}
                    <section class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
                        <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-3 md:gap-4">

                            {{-- 左侧：订单号 + 时间 --}}
                            <div>
                                <h1
                                    class="text-xl md:text-2xl font-semibold text-[#0A0A0C] flex flex-col md:flex-row md:items-center gap-1 md:gap-2">
                                    <span>Order</span>
                                    <span class="text-[#8f6a10] break-all">
                                        #{{ $order->order_no }}
                                    </span>
                                </h1>


                                <p class="text-sm text-gray-500 mt-1">
                                    Placed on {{ $order->created_at->format('d M Y, H:i') }}
                                </p>
                            </div>

                            @php
                                $colors = [
                                    'pending' => 'bg-amber-50 text-amber-700 border-amber-100',
                                    'paid' => 'bg-green-50 text-green-700 border-green-100',
                                    'processing' => 'bg-purple-50 text-purple-700 border-purple-100',
                                    'shipped' => 'bg-blue-50 text-blue-700 border-blue-100',
                                    'completed' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                                    'cancelled' => 'bg-gray-50 text-gray-700 border-gray-100',
                                    'failed' => 'bg-red-50 text-red-700 border-red-100',
                                ];
                            @endphp

                            {{-- 右侧：状态 + 按钮（手机会自动掉到第二行） --}}
                            <div class="flex items-center gap-2 md:gap-3 mt-1 md:mt-0">

                                {{-- Status Badge --}}
                                <span
                                    class="px-3 py-1 rounded-full text-xs md:text-sm font-medium shadow-sm
                   {{ $colors[$order->status] ?? 'bg-gray-100 text-gray-500' }}">
                                    {{ ucfirst($order->status) }}
                                </span>

                                {{-- Order Received Button（只在 shipped 时出现） --}}
                                @if ($order->status === 'shipped')
                                    <form method="POST" action="{{ route('account.orders.complete', $order) }}">
                                        @csrf
                                        <button
                                            class="inline-flex items-center gap-1.5 px-3 md:px-4 py-1.5 md:py-2 rounded-xl
                           bg-emerald-600 text-white text-xs md:text-sm font-semibold
                           hover:bg-emerald-700 active:scale-95 transition">
                                            <span class="text-sm">✓</span>
                                            <span>Order Received</span>
                                        </button>
                                    </form>
                                @endif

                                {{-- Invoice PDF --}}
                                <a href="{{ route('account.orders.invoice.pdf', $order) }}" target="_blank"
                                    class="inline-flex items-center gap-1.5 px-3 md:px-4 py-1.5 md:py-2 rounded-xl
                                            bg-gray-900 text-white text-xs md:text-sm font-semibold
                                            hover:bg-black active:scale-95 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 3v12m0 0l3.75-3.75M12 15l-3.75-3.75M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5" />
                                    </svg>
                                    <span>Invoice PDF</span>
                                </a>


                            </div>

                        </div>


                        {{-- 🔥 REFINED ORDER STATUS BAR --}}
                        @php
                            $allSteps = [
                                'pending' => [
                                    'label' => 'Pending',
                                    'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
                                ],
                                'paid' => [
                                    'label' => 'Paid',
                                    'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
                                ],
                                'processing' => [
                                    'label' => 'Processing',
                                    'icon' =>
                                        'M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z',
                                ],
                                'shipped' => [
                                    'label' => 'Shipped',
                                    'icon' =>
                                        'M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4',
                                ],
                                'completed' => [
                                    'label' => 'Received',
                                    'icon' => 'M5 13l4 4L19 7',
                                ],

                                // 🟡 Cancelled
                                'cancelled' => [
                                    'label' => 'Cancelled',
                                    'icon' => 'M12 2a10 10 0 110 20 10 10 0 010-20M9 9l6 6M15 9l-6 6',
                                ],

                                // 🔴 Failed
                                'failed' => [
                                    'label' => 'Failed',
                                    'icon' => 'M6 18L18 6M6 6l12 12',
                                ],
                            ];

                            $status = $order->status;

                            // ⭐ 默认不显示 cancelled / failed
                            $steps = $allSteps;
                            unset($steps['cancelled'], $steps['failed']);

                            // ⭐ cancelled / failed 才追加
                            if ($status === 'cancelled') {
                                $steps['cancelled'] = $allSteps['cancelled'];
                            }
                            if ($status === 'failed') {
                                $steps['failed'] = $allSteps['failed'];
                            }

                            $orderFlow = array_keys($steps);
                            $currentIndex = array_search($status, $orderFlow);
                        @endphp

                        <div class="mt-10 mb-12 px-1 sm:px-2">
                            <div class="flex items-center">
                                @foreach ($steps as $key => $data)
                                    @php
                                        $index = array_search($key, $orderFlow);
                                        $isDone = $index <= $currentIndex;
                                        $isLast = $loop->last;
                                    @endphp

                                    <div class="flex items-center {{ !$isLast ? 'flex-1' : '' }}">
                                        {{-- Step Point --}}
                                        <div class="relative flex flex-col items-center">
                                            <div
                                                class="w-8 h-8 sm:w-10 sm:h-10
                               rounded-xl sm:rounded-2xl
                               flex items-center justify-center transition-all duration-500 border
                        {{ $isDone
                            ? 'bg-black border-black text-white shadow-lg shadow-black/20'
                            : 'bg-white border-gray-300 text-gray-500' }}">

                                                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="1.5" d="{{ $data['icon'] }}" />
                                                </svg>
                                            </div>

                                            {{-- Label (mobile tighter) --}}
                                            <div class="absolute -bottom-7 whitespace-nowrap">
                                                <span
                                                    class="text-[8px] sm:text-[9px]
                                   font-black uppercase
                                   tracking-[0.12em] sm:tracking-[0.2em]
                                   transition-colors duration-300
                            {{ $isDone ? 'text-black' : 'text-gray-500' }}">
                                                    {{ $data['label'] }}
                                                </span>
                                            </div>
                                        </div>

                                        {{-- Connector Line (mobile shorter) --}}
                                        @if (!$isLast)
                                            <div
                                                class="h-[2px]
                               mx-1 sm:mx-2 md:mx-4
                               rounded-full overflow-hidden bg-gray-100
                               w-4 sm:w-6 md:flex-1 flex-none">
                                                <div
                                                    class="h-full transition-all duration-1000 ease-out
                            {{ $isDone && $currentIndex > $index ? 'w-full bg-[#D4AF37]' : 'w-0' }}">
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- 🔥 END STATUS BAR --}}

                        {{-- 3 : 2 Layout --}}
                        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 pt-6">

                            {{-- 🟡 LEFT: Details --}}
                            <div class="lg:col-span-8 space-y-8">

                                {{-- Top grid: Customer + Shipping/Digital --}}
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                                    {{-- Customer Card --}}
                                    <div
                                        class="group rounded-3xl border border-gray-200 bg-white/60 backdrop-blur-md p-8 shadow-sm transition-all hover:shadow-md">
                                        <div class="flex items-center justify-between border-b border-gray-200 pb-4">
                                            <h2 class="text-xs font-black text-gray-600 tracking-[0.2em] uppercase">
                                                Customer Info
                                            </h2>
                                            <div class="h-1.5 w-1.5 rounded-full bg-amber-400 ring-4 ring-amber-50">
                                            </div>
                                        </div>

                                        <div class="mt-6">
                                            <p class="text-xl font-bold text-gray-900 tracking-tight">
                                                {{ $order->customer_name }}
                                            </p>

                                            <div class="mt-4 space-y-3">
                                                <div class="flex flex-col">
                                                    <span
                                                        class="text-[10px] font-bold text-gray-600 uppercase tracking-wider">Phone</span>
                                                    <span
                                                        class="text-sm font-semibold text-gray-700">{{ $order->customer_phone }}</span>
                                                </div>
                                                <div class="flex flex-col">
                                                    <span
                                                        class="text-[10px] font-bold text-gray-600 uppercase tracking-wider">Email</span>
                                                    <span
                                                        class="text-sm font-semibold text-gray-700 break-all">{{ $order->customer_email }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Shipping / Digital Card --}}
                                    <div
                                        class="rounded-3xl border border-gray-200 bg-white/60 backdrop-blur-md p-8 shadow-sm">
                                        @php
                                            $isDigitalOrder = $order->items->contains(
                                                fn($it) => (bool) ($it->product->is_digital ?? false),
                                            );

                                            $hasAnyDigitalPayload = $order->items->contains(
                                                fn($it) => !empty($it->digital_payload),
                                            );
                                        @endphp


                                        <div class="flex items-center justify-between border-b border-gray-200 pb-4">
                                            <h2 class="text-xs font-black text-gray-600 tracking-[0.2em] uppercase">
                                                {{ $isDigitalOrder ? 'Digital Info' : 'Shipping Address' }}
                                            </h2>
                                            @if ($isDigitalOrder && $order->status === 'completed' && $order->fulfillment_note)
                                                <button type="button" onclick="openDigitalModal({{ $order->id }})"
                                                    class="text-xs font-black text-emerald-700 hover:text-emerald-900 uppercase tracking-widest transition-colors">
                                                    Track →
                                                </button>
                                            @elseif ($order->shipping_courier || $order->tracking_number)
                                                <button type="button" onclick="openTrackingModal({{ $order->id }})"
                                                    class="text-xs font-black text-indigo-600 hover:text-indigo-800 uppercase tracking-widest transition-colors">
                                                    Track →
                                                </button>
                                            @endif
                                        </div>

                                        <div class="mt-6">
                                            @if ($isDigitalOrder)
                                                <div class="space-y-4">

                                                    {{-- 🟡 No digital field required --}}
                                                    @if (!$hasAnyDigitalPayload)
                                                        <div
                                                            class="rounded-2xl border border-blue-100 bg-blue-50/50 p-5 shadow-sm">
                                                            <div class="flex gap-3">
                                                                <div class="shrink-0 text-blue-500">
                                                                    <svg class="h-5 w-5" fill="none"
                                                                        viewBox="0 0 24 24" stroke-width="2"
                                                                        stroke="currentColor">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round"
                                                                            d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                                                                    </svg>
                                                                </div>

                                                                <div class="space-y-1">
                                                                    <h4
                                                                        class="text-xs font-bold uppercase tracking-widest text-blue-700">
                                                                        No digital details are required
                                                                    </h4>
                                                                    <p
                                                                        class="text-sm leading-relaxed text-blue-900/80">
                                                                        Your digital item will be delivered once the
                                                                        admin completes the fulfillment.
                                                                        A Track link will appear here when it’s
                                                                        available.
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    {{-- 🔽 Existing payload rendering --}}
                                                    @foreach ($order->items as $it)
                                                        @php
                                                            $payload = is_string($it->digital_payload)
                                                                ? json_decode($it->digital_payload, true)
                                                                : $it->digital_payload;
                                                        @endphp

                                                        @if (!empty($payload))
                                                            <div
                                                                class="rounded-2xl bg-gray-50/50 p-4 ring-1 ring-gray-100">
                                                                <div class="flex justify-between items-center mb-3">
                                                                    <span
                                                                        class="text-[12px] font-black text-amber-800 uppercase tracking-tighter truncate max-w-[150px]">
                                                                        {{ $it->product_name }}
                                                                    </span>
                                                                </div>

                                                                <div class="space-y-2">
                                                                    @foreach ($payload as $k => $v)
                                                                        <div
                                                                            class="flex justify-between text-xs border-b border-white/50 pb-1 last:border-0">
                                                                            <span class="text-gray-600 capitalize">
                                                                                {{ str_replace('_', ' ', $k) }}
                                                                            </span>
                                                                            <span class="font-bold text-gray-900">
                                                                                {{ is_array($v) ? 'Data' : $v }}
                                                                            </span>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            @else
                                                <div class="text-sm leading-relaxed text-gray-700">
                                                    <div class="text-base font-bold text-gray-900 mb-1">
                                                        {{ $order->address_line1 }}</div>
                                                    @if ($order->address_line2)
                                                        <div>{{ $order->address_line2 }}</div>
                                                    @endif
                                                    <div class="mt-2 font-medium">
                                                        {{ $order->postcode }} {{ $order->city }}<br>
                                                        {{ $order->state }}
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                {{-- Remark Card --}}
                                <div
                                    class="rounded-3xl border border-gray-200 bg-white/40 backdrop-blur-sm p-6 shadow-sm">
                                    <h2 class="text-xs font-black text-gray-600 tracking-[0.2em] uppercase mb-3">
                                        Order Remark
                                    </h2>
                                    <div class="rounded-2xl bg-white/50 p-4 border border-gray-100">
                                        <p
                                            class="text-sm leading-relaxed {{ $order->remark ? 'text-gray-800 font-medium' : 'text-gray-400' }}">
                                            {{ $order->remark ? trim($order->remark) : 'No instructions provided by customer.' }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            {{-- 🟣 RIGHT: Summary --}}
                            <div class="lg:col-span-4">
                                <div
                                    class="lg:sticky lg:top-24 rounded-[2rem] border border-amber-200 bg-gradient-to-b from-amber-50/80 to-white p-8 shadow-xl shadow-amber-900/5">

                                    <div class="flex items-center justify-between border-b border-amber-200 pb-6">
                                        <h2 class="font-black text-gray-900 text-lg tracking-tight">Order Summary</h2>
                                        <div
                                            class="bg-amber-100 px-3 py-1 rounded-full text-[10px] font-black text-amber-700 tracking-tighter">
                                            MYR</div>
                                    </div>

                                    <div class="mt-6 space-y-4">
                                        {{-- Line Items --}}
                                        @php
                                            $isCompleted = $order->status === 'completed';
                                            $earnedPoints = (int) floor($order->subtotal ?? 0);
                                        @endphp


                                        <div class="space-y-3 text-sm">

                                            {{-- Subtotal --}}
                                            <div class="flex justify-between items-center text-gray-600">
                                                <span>Subtotal</span>
                                                <span class="font-bold text-gray-900">RM
                                                    {{ number_format($order->subtotal, 2) }}</span>
                                            </div>

                                            {{-- Shipping (show even if 0 for clarity) --}}
                                            <div
                                                class="flex justify-between items-center {{ $order->shipping_fee > 0 ? 'text-gray-500' : 'text-gray-600' }}">
                                                <span>Shipping Fee</span>
                                                <span class="font-bold text-gray-900">RM
                                                    {{ number_format($order->shipping_fee, 2) }}</span>
                                            </div>

                                            {{-- Handling Fee --}}
                                            @if (($order->handling_fee ?? 0) > 0)
                                                <div class="flex justify-between items-center text-gray-600">
                                                    <span>Handling Fee</span>
                                                    <span class="font-bold text-gray-900">RM
                                                        {{ number_format((float) $order->handling_fee, 2) }}</span>
                                                </div>
                                            @endif

                                            {{-- Voucher Discount --}}
                                            @if ($order->voucher_discount > 0)
                                                <div
                                                    class="flex justify-between items-center text-emerald-600 font-bold">
                                                    <span class="flex items-center gap-1.5">
                                                        Discount
                                                        @if ($order->voucher_code)
                                                            <span
                                                                class="text-[10px] font-black text-emerald-700/80 tracking-tight">
                                                                ({{ $order->voucher_code }})
                                                            </span>
                                                        @endif
                                                    </span>
                                                    <span>-RM {{ number_format($order->voucher_discount, 2) }}</span>
                                                </div>
                                            @endif

                                            {{-- Shipping Discount --}}
                                            @if (($order->shipping_discount ?? 0) > 0)
                                                <div
                                                    class="flex justify-between items-center text-emerald-600 font-bold">
                                                    <span>Shipping Discount</span>
                                                    <span>-RM
                                                        {{ number_format((float) $order->shipping_discount, 2) }}</span>
                                                </div>
                                            @endif

                                            {{-- Points Redeemed --}}
                                            @if (($order->points_discount ?? 0) > 0)
                                                <div
                                                    class="flex justify-between items-center text-emerald-600 font-bold">
                                                    <span class="flex items-center gap-2">
                                                        Points Redeemed
                                                        @if (($order->points_redeem ?? 0) > 0)
                                                            <span
                                                                class="text-[10px] font-black text-emerald-700/80 tracking-tight">
                                                                {{ number_format((int) $order->points_redeem) }} pts
                                                            </span>
                                                        @endif
                                                    </span>
                                                    <span>-RM
                                                        {{ number_format((float) $order->points_discount, 2) }}</span>
                                                </div>
                                            @endif
                                        </div>


                                        <div class="my-6 border-t border-dashed border-amber-300"></div>

                                        {{-- Grand Total --}}
                                        <div class="flex items-end justify-between py-2">
                                            <span
                                                class="text-xs font-black text-gray-600 uppercase tracking-widest pb-1">Total</span>
                                            <span class="text-4xl font-black text-gray-900 tracking-tighter">
                                                RM {{ number_format($order->total, 2) }}
                                            </span>
                                        </div>

                                        {{-- Points Badge --}}
                                        <div class="rounded-2xl bg-gray-900 p-4 flex justify-between items-center">
                                            <span class="text-xs font-bold text-gray-400">
                                                {{ $isCompleted ? 'Earned Points' : 'Will Earn' }}
                                            </span>
                                            <span class="text-sm font-black text-amber-400">
                                                +{{ number_format($earnedPoints) }} PTS
                                            </span>
                                        </div>

                                    </div>

                                    {{-- Payment Footer --}}
                                    <div class="mt-8 pt-6 border-t border-amber-200">
                                        <div class="flex flex-col gap-4">
                                            <div class="flex justify-between items-center">
                                                <span
                                                    class="text-[10px] font-black text-gray-600 uppercase tracking-widest">Method</span>
                                                <span
                                                    class="text-xs font-bold text-gray-700">{{ $order->payment_method_name }}</span>
                                            </div>

                                            @if ($order->payment_receipt_path)
                                                <div class="grid grid-cols-2 gap-3">
                                                    <button onclick="openReceiptModal({{ $order->id }})"
                                                        class="py-2.5 rounded-xl border border-gray-200 bg-white text-[11px] font-black text-gray-700 shadow-sm hover:bg-gray-50 transition-all">
                                                        VIEW RECEIPT
                                                    </button>
                                                    <a href="{{ asset('storage/' . $order->payment_receipt_path) }}"
                                                        download
                                                        class="py-2.5 rounded-xl bg-amber-500 text-[11px] font-black text-white text-center shadow-md shadow-amber-500/20 hover:bg-amber-600 transition-all">
                                                        DOWNLOAD
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>



                        {{-- Items --}}
                        <h2 class="font-semibold text-[#0A0A0C] text-base mt-8 mb-4">Items</h2>

                        {{-- 📱 Mobile：改成卡片列表 --}}
                        <div class="space-y-3 md:hidden">
                            @foreach ($order->items as $item)
                                <div class="rounded-2xl border border-gray-200 bg-white/80 p-4 flex gap-3">

                                    {{-- Image / Placeholder --}}
                                    @if ($item->product?->image)
                                        <img src="{{ asset('storage/' . $item->product->image) }}"
                                            class="w-14 h-14 rounded-xl object-cover flex-shrink-0">
                                    @else
                                        <div
                                            class="w-14 h-14 rounded-xl bg-gray-100 border border-gray-200 flex items-center justify-center flex-shrink-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-300"
                                                fill="none" viewBox="0 0 24 24" stroke-width="1.8"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                                            </svg>
                                        </div>
                                    @endif

                                    <div class="flex-1 space-y-1">
                                        {{-- 名称 + variant --}}
                                        <div>
                                            <p class="text-sm font-medium text-gray-900 leading-snug">
                                                {{ $item->product_name }}
                                            </p>
                                            @if ($item->variant_label)
                                                <p class="text-xs text-gray-500">
                                                    {{ $item->variant_label }}
                                                </p>
                                            @endif
                                        </div>

                                        {{-- 小 summary 行 --}}
                                        <div class="mt-2 grid grid-cols-2 gap-x-4 gap-y-1 text-xs">
                                            <div class="text-gray-500">Qty</div>
                                            <div class="text-right text-gray-900 font-medium">
                                                {{ $item->qty }}
                                            </div>

                                            <div class="text-gray-500">Unit Price</div>
                                            <div class="text-right text-gray-900">
                                                RM {{ number_format($item->unit_price, 2) }}
                                            </div>

                                            <div class="text-gray-500">Subtotal</div>
                                            <div class="text-right font-semibold text-gray-900">
                                                RM {{ number_format($item->unit_price * $item->qty, 2) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- 💻 Desktop：保留 table --}}
                        <div class="hidden md:block border rounded-2xl overflow-hidden">
                            <table class="w-full text-base">
                                <thead class="bg-gray-50 text-sm text-gray-500">
                                    <tr>
                                        <th class="text-left px-4 py-3">Product</th>
                                        <th class="text-right px-4 py-3">Qty</th>
                                        <th class="text-right px-4 py-3">Unit Price</th>
                                        <th class="text-right px-4 py-3">Subtotal</th>
                                    </tr>
                                </thead>

                                <tbody class="divide-y divide-gray-100 text-base">
                                    @foreach ($order->items as $item)
                                        <tr>
                                            <td class="px-4 py-3 text-gray-900 flex items-center gap-3">
                                                {{-- Product image OR icon placeholder --}}
                                                @if ($item->product?->image)
                                                    <img src="{{ asset('storage/' . $item->product->image) }}"
                                                        class="w-12 h-12 rounded object-cover">
                                                @else
                                                    <div
                                                        class="w-12 h-12 rounded bg-gray-100 border border-gray-200 flex items-center justify-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="w-6 h-6 text-gray-300" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.8"
                                                            stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                                                        </svg>
                                                    </div>
                                                @endif

                                                <div>
                                                    {{ $item->product_name }}

                                                    @if ($item->variant_label)
                                                        <div class="text-sm text-gray-500">
                                                            {{ $item->variant_label }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </td>

                                            <td class="px-4 py-3 text-right text-gray-700">
                                                {{ $item->qty }}
                                            </td>

                                            <td class="px-4 py-3 text-right text-gray-700">
                                                RM {{ number_format($item->unit_price, 2) }}
                                            </td>

                                            <td class="px-4 py-3 text-right font-semibold text-gray-900">
                                                RM {{ number_format($item->unit_price * $item->qty, 2) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </section>

                </main>
            </div>
        </div>
    </div>

    @if ($order->payment_receipt_path)
        <div id="receiptModal-{{ $order->id }}" class="fixed inset-0 z-50 hidden bg-black/50">
            {{-- 点击背景关闭 --}}
            <div class="flex items-center justify-center min-h-screen"
                onclick="closeReceiptModal({{ $order->id }})">
                {{-- 内容卡片，阻止冒泡 --}}
                <div class="bg-white rounded-2xl shadow-xl max-w-xl w-[90%] overflow-hidden"
                    onclick="event.stopPropagation()">
                    <div class="flex items-center justify-between px-4 py-3 border-b border-gray-100">
                        <h3 class="text-sm font-semibold text-gray-900">
                            Payment Receipt
                        </h3>
                        <button type="button" class="text-gray-400 hover:text-gray-600"
                            onclick="closeReceiptModal({{ $order->id }})">
                            ✕
                        </button>
                    </div>

                    <div class="p-4">
                        <img src="{{ asset('storage/' . $order->payment_receipt_path) }}" alt="Payment receipt"
                            class="max-h-[70vh] w-auto mx-auto rounded-lg shadow-sm">
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if ($order->shipping_courier || $order->tracking_number)
        <div id="trackingModal-{{ $order->id }}" class="fixed inset-0 z-50 hidden bg-black/50">
            {{-- 点击背景关闭 --}}
            <div class="flex items-center justify-center min-h-screen"
                onclick="closeTrackingModal({{ $order->id }})">

                {{-- 内容卡片，阻止冒泡 --}}
                <div class="bg-white rounded-2xl shadow-xl max-w-md w-[90%] overflow-hidden"
                    onclick="event.stopPropagation()">

                    <div class="flex items-center justify-between px-4 py-3 border-b border-gray-100">
                        <h3 class="text-sm font-semibold text-gray-900">
                            Tracking Information
                        </h3>
                        <button type="button" class="text-gray-400 hover:text-gray-600"
                            onclick="closeTrackingModal({{ $order->id }})">
                            ✕
                        </button>
                    </div>

                    <div class="p-4 space-y-3 text-sm text-gray-900">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Courier</span>
                            <span class="font-semibold">
                                {{ $order->shipping_courier ?? '-' }}
                            </span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-gray-600">Tracking No.</span>
                            <span class="font-semibold">
                                {{ $order->tracking_number ?? '-' }}
                            </span>
                        </div>

                        @if ($order->shipped_at)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Shipped At</span>
                                <span class="font-semibold">
                                    {{ \Illuminate\Support\Carbon::parse($order->shipped_at)->timezone('Asia/Kuala_Lumpur')->format('d M Y, h:i A') }}
                                </span>
                            </div>
                        @endif

                        @if ($order->tracking_number)
                            <div class="pt-2">
                                <a target="_blank"
                                    href="https://www.tracking.my/{{ urlencode($order->tracking_number) }}"
                                    class="inline-flex items-center px-3 py-1.5 rounded-lg bg-indigo-600
                                      text-white text-xs font-semibold hover:bg-indigo-700">
                                    Track Parcel
                                </a>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    @endif

    @php
        $isDigitalOrder = $order->items->contains(fn($it) => (bool) ($it->product?->is_digital ?? false));
    @endphp

    @if ($order->fulfillment_note)
        <div id="digitalModal-{{ $order->id }}" class="fixed inset-0 z-50 hidden bg-black/50">
            {{-- 点击背景关闭 --}}
            <div class="flex items-center justify-center min-h-screen sm:pt-24"
                onclick="closeDigitalModal({{ $order->id }})">

                {{-- 内容卡片，阻止冒泡 --}}
                <div class="bg-white rounded-2xl shadow-xl max-w-md w-[92%] overflow-hidden"
                    onclick="event.stopPropagation()">

                    <div class="flex items-center justify-between px-4 py-3 border-b border-gray-100">
                        <h3 class="text-sm font-semibold text-gray-900">
                            Digital Delivery
                        </h3>
                        <button type="button" class="text-gray-400 hover:text-gray-600"
                            onclick="closeDigitalModal({{ $order->id }})">
                            ✕
                        </button>
                    </div>

                    <div class="p-4 space-y-4 text-sm text-gray-900">

                        {{-- Fulfilled At --}}
                        <div class="flex justify-between">
                            <span class="text-gray-600">Fulfilled At</span>
                            <span class="font-semibold">
                                {{ $order->digital_fulfilled_at
                                    ? \Illuminate\Support\Carbon::parse($order->digital_fulfilled_at)->timezone('Asia/Kuala_Lumpur')->format('d M Y, h:i A')
                                    : '-' }}
                            </span>
                        </div>

                        {{-- PIN Codes --}}
                        {{-- <div class="pt-2 border-t border-gray-100">
                            <div class="flex items-center justify-between my-2">
                                <span class="text-gray-600 font-medium">PIN Code(s)</span>
                            </div>

                            @if (!empty($pins))
                                <div class="space-y-2">
                                    @foreach ($pins as $i => $pin)
                                        <div
                                            class="flex items-center justify-between gap-3 rounded-xl bg-gray-50 border border-gray-200 px-3 py-2">
                                            <div class="min-w-0">
                                                <div
                                                    class="text-[10px] font-black text-gray-500 uppercase tracking-widest">
                                                    PIN {{ $i + 1 }}
                                                </div>
                                                <div class="text-sm font-black text-gray-900 break-all">
                                                    {{ $pin }}
                                                </div>
                                            </div>

                                            <button type="button" onclick="copyText(@js($pin))"
                                                class="shrink-0 inline-flex items-center px-3 py-1.5 rounded-lg
                                                   bg-gray-900 text-white text-[11px] font-black hover:bg-black active:scale-95 transition">
                                                Copy
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="rounded-xl bg-amber-50 border border-amber-100 p-3 text-amber-900">
                                    PIN code(s) not available yet. Please check again later.
                                </div>
                            @endif
                        </div> --}}

                        {{-- Note --}}
                        @if (!empty($order->fulfillment_note))
                            <div class="pt-2 border-t border-gray-100">
                                <div class="flex items-center justify-between mb-2">
                                    <div class="text-gray-600 font-medium">Note</div>

                                    {{-- 可选：太长时给个小提示 --}}
                                    <span class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">
                                        Scroll
                                    </span>
                                </div>

                                <div
                                    class="note-scroll rounded-xl bg-gray-50 border border-gray-200 p-3 text-gray-800 whitespace-pre-line
           max-h-44 sm:max-h-56 overflow-y-auto">
                                    {{ trim($order->fulfillment_note) }}
                                </div>
                            </div>
                        @endif


                    </div>
                </div>

            </div>
        </div>
    @endif

    <style>
        .note-scroll::-webkit-scrollbar {
            width: 8px;
        }

        .note-scroll::-webkit-scrollbar-thumb {
            background-color: #d1d5db;
            /* gray-300 */
            border-radius: 9999px;
        }

        .note-scroll::-webkit-scrollbar-track {
            background: transparent;
        }
    </style>


    <script>
        function openReceiptModal(orderId) {
            const el = document.getElementById('receiptModal-' + orderId);
            if (el) {
                el.classList.remove('hidden');
            }
        }

        function closeReceiptModal(orderId) {
            const el = document.getElementById('receiptModal-' + orderId);
            if (el) {
                el.classList.add('hidden');
            }
        }

        // 👇 新增这两个
        function openTrackingModal(orderId) {
            const el = document.getElementById('trackingModal-' + orderId);
            if (el) {
                el.classList.remove('hidden');
            }
        }

        function closeTrackingModal(orderId) {
            const el = document.getElementById('trackingModal-' + orderId);
            if (el) {
                el.classList.add('hidden');
            }
        }

        function openDigitalModal(orderId) {
            const el = document.getElementById('digitalModal-' + orderId);
            if (el) el.classList.remove('hidden');
        }

        function closeDigitalModal(orderId) {
            const el = document.getElementById('digitalModal-' + orderId);
            if (el) el.classList.add('hidden');
        }
    </script>

    <script>
        function notifySuccess(message) {
            const isMobile = window.matchMedia('(max-width: 640px)').matches;

            if (!isMobile) {
                Swal.fire({
                    icon: 'success',
                    title: message,
                    toast: true,
                    position: 'bottom-end',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true,
                });
            } else {
                const bar = document.createElement('div');
                bar.innerHTML = `
        <div class="fixed left-1/2 bottom-24 -translate-x-1/2 z-[9999]
                    bg-black text-white
                    px-5 py-3 rounded-full
                    text-sm font-semibold
                    shadow-xl
                    flex items-center gap-2
                    animate-[fadeUp_.25s_ease-out]">
          <span class="inline-block w-2 h-2 rounded-full bg-emerald-400"></span>
          ${escapeHtml(message)}
        </div>
      `;
                document.body.appendChild(bar);
                setTimeout(() => bar.remove(), 2200);
            }
        }

        function notifyError(message) {
            const isMobile = window.matchMedia('(max-width: 640px)').matches;

            if (!isMobile) {
                Swal.fire({
                    icon: 'error',
                    title: message,
                    toast: true,
                    position: 'bottom-end',
                    showConfirmButton: false,
                    timer: 2200,
                    timerProgressBar: true,
                });
            } else {
                const bar = document.createElement('div');
                bar.innerHTML = `
        <div class="fixed left-1/2 bottom-24 -translate-x-1/2 z-[9999]
                    bg-black text-white
                    px-5 py-3 rounded-full
                    text-sm font-semibold
                    shadow-xl
                    flex items-center gap-2
                    animate-[fadeUp_.25s_ease-out]">
          <span class="inline-block w-2 h-2 rounded-full bg-red-400"></span>
          ${escapeHtml(message)}
        </div>
      `;
                document.body.appendChild(bar);
                setTimeout(() => bar.remove(), 2400);
            }
        }

        // 防止 message 里有 < > 破坏 HTML
        function escapeHtml(str) {
            return String(str)
                .replaceAll('&', '&amp;')
                .replaceAll('<', '&lt;')
                .replaceAll('>', '&gt;')
                .replaceAll('"', '&quot;')
                .replaceAll("'", '&#039;');
        }
    </script>

    <style>
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translate(-50%, 12px);
            }

            to {
                opacity: 1;
                transform: translate(-50%, 0);
            }
        }
    </style>


    <script>
        async function copyText(text) {
            if (!text) return;

            try {
                if (navigator.clipboard && window.isSecureContext) {
                    await navigator.clipboard.writeText(text);
                } else {
                    const ta = document.createElement('textarea');
                    ta.value = text;
                    ta.setAttribute('readonly', '');
                    ta.style.position = 'fixed';
                    ta.style.top = '-9999px';
                    document.body.appendChild(ta);
                    ta.select();
                    document.execCommand('copy');
                    document.body.removeChild(ta);
                }

                notifySuccess('Copied!');
            } catch (e) {
                console.error(e);
                notifyError('Copy failed. Please copy manually.');
            }
        }
    </script>



</x-app-layout>
