<div class="rounded-[2.5rem] bg-white border border-gray-100 p-8 shadow-sm">

    {{-- Header --}}
    <div class="flex items-center justify-between gap-4 mb-8">
        <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900">
            Check Order Status
        </h2>
        <span
            class="px-3 py-1 rounded-full bg-[#D4AF37]/10 text-[#8f6a10] text-[10px] font-black uppercase tracking-widest">
            Orders
        </span>
    </div>

    {{-- Quick Summary --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-10">
        <div class="rounded-2xl bg-[#FAF9F6] border border-gray-100 p-5">
            <div class="text-xs text-gray-500 font-black uppercase tracking-widest">
                📍 Where
            </div>
            <div class="mt-2 text-sm font-bold text-gray-900">
                My Orders
            </div>
            <p class="mt-1 text-xs text-gray-500">
                View all your orders in one place.
            </p>
        </div>

        <div class="rounded-2xl bg-[#FAF9F6] border border-gray-100 p-5">
            <div class="text-xs text-gray-500 font-black uppercase tracking-widest">
                🔎 What to do
            </div>
            <div class="mt-2 text-sm font-bold text-gray-900">
                Open an Order
            </div>
            <p class="mt-1 text-xs text-gray-500">
                Tap the order you want to check.
            </p>
        </div>

        <div class="rounded-2xl bg-[#FAF9F6] border border-gray-100 p-5">
            <div class="text-xs text-gray-500 font-black uppercase tracking-widest">
                📦 Result
            </div>
            <div class="mt-2 text-sm font-bold text-gray-900">
                Status & Details
            </div>
            <p class="mt-1 text-xs text-gray-500">
                Track progress or access digital items.
            </p>
        </div>
    </div>

    {{-- How to Access My Orders --}}
    <div class="space-y-6 mb-12">

        <h3 class="text-lg font-extrabold text-gray-900">
            How to Find My Orders
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            {{-- Desktop --}}
            <div class="rounded-2xl bg-[#FAF9F6] border border-gray-100 p-5">
                <div class="text-xs font-black uppercase tracking-widest text-gray-500 mb-2">
                    🖥️Desktop
                </div>
                <ol class="text-sm text-gray-700 space-y-2 list-decimal pl-5">
                    <li>Click your <span class="font-semibold text-gray-900">username</span> at the top-right.</li>
                    <li>Select <span class="font-semibold text-gray-900">My Orders</span>.</li>
                    <li>Tap the order you want to view.</li>
                </ol>
            </div>

            {{-- Mobile --}}
            <div class="rounded-2xl bg-[#FAF9F6] border border-gray-100 p-5">
                <div class="text-xs font-black uppercase tracking-widest text-gray-500 mb-2">
                    📱Mobile
                </div>
                <ol class="text-sm text-gray-700 space-y-2 list-decimal pl-5">
                    <li>Tap <span class="font-semibold text-gray-900">Profile</span> on the bottom menu.</li>
                    <li>Tap <span class="font-semibold text-gray-900">My Orders</span>.</li>
                    <li>Tap the order you want to view.</li>
                </ol>
            </div>

        </div>
    </div>

    {{-- Order Status Explanation --}}
    <div class="mb-12">

        <div class="flex items-center gap-3 mb-4">
            <h3 class="text-lg font-extrabold text-gray-900">
                Order Status Meaning
            </h3>
            <div class="flex-grow h-px bg-gradient-to-r from-gray-200 to-transparent"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <div class="rounded-2xl bg-[#FAF9F6] border border-gray-100 p-5">
                <span
                    class="inline-flex px-3 py-1 rounded-full text-sm font-bold bg-amber-50 text-amber-700 border border-amber-100">
                    Pending
                </span>
                <p class="mt-1 text-sm text-gray-600">
                    Order created but payment is not completed or not confirmed yet.
                </p>
            </div>

            <div class="rounded-2xl bg-[#FAF9F6] border border-gray-100 p-5">
                <span
                    class="inline-flex px-3 py-1 rounded-full text-sm font-bold bg-green-50 text-green-700 border border-green-100">
                    Paid
                </span>
                <p class="mt-1 text-sm text-gray-600">
                    Payment successful. Your order will be processed soon.
                </p>
            </div>

            <div class="rounded-2xl bg-[#FAF9F6] border border-gray-100 p-5">
                <span
                    class="inline-flex px-3 py-1 rounded-full text-sm font-bold bg-purple-50 text-purple-700 border border-purple-100">
                    Processing
                </span>
                <p class="mt-1 text-sm text-gray-600">
                    We are preparing your order (packing or processing digital content).
                </p>
            </div>

            <div class="rounded-2xl bg-[#FAF9F6] border border-gray-100 p-5">
                <span
                    class="inline-flex px-3 py-1 rounded-full text-sm font-bold bg-blue-50 text-blue-700 border border-blue-100">
                    Shipped
                </span>
                <p class="mt-1 text-sm text-gray-600">
                    Physical order has been handed to courier. Tracking details will be shown.
                </p>
            </div>

            <div class="rounded-2xl bg-[#FAF9F6] border border-gray-100 p-5">
                <span
                    class="inline-flex px-3 py-1 rounded-full text-sm font-bold bg-emerald-50 text-emerald-700 border border-emerald-100">
                    Completed
                </span>
                <p class="mt-1 text-sm text-gray-600">
                    Order is finished. For digital products, content is now available.
                </p>
            </div>

            <div class="rounded-2xl bg-[#FAF9F6] border border-gray-100 p-5">
                <div class="flex flex-wrap gap-2">
                    {{-- Failed --}}
                    <span
                        class="inline-flex px-3 py-1 rounded-full text-sm font-bold
                 bg-red-50 text-red-700 border border-red-100">
                        Failed
                    </span>

                    {{-- Cancelled --}}
                    <span
                        class="inline-flex px-3 py-1 rounded-full text-sm font-bold
                 bg-gray-50 text-gray-700 border border-gray-100">
                        Cancelled
                    </span>
                </div>
                <p class="mt-1 text-sm text-gray-600">
                    Payment failed or order was cancelled. You may try again.
                </p>
            </div>

        </div>
    </div>

    {{-- Digital Product Guide --}}
    <div class="space-y-4">

        <h3 class="text-lg font-extrabold text-gray-900">
            Digital Products
        </h3>

        <div class="rounded-2xl bg-green-50/60 border border-green-100 p-4 text-sm text-green-800">
            <strong>How to access digital items?</strong><br>
            When a <strong>digital product</strong> order is marked as
            <strong>Completed</strong>, a
            <span class="font-semibold">Track</span>
            link will appear inside the order details.
        </div>

        <div class="rounded-2xl bg-green-50/60 border border-green-100 p-4 text-sm text-green-800">
            <strong>What happens after I click Track?</strong><br>
            You’ll be redirected to the digital delivery page where you can
            view or copy your digital content (PIN / code / access details).
        </div>

        <div class="rounded-2xl bg-amber-50/60 border border-amber-100 p-4 text-sm text-amber-800">
            <strong>Track link not visible?</strong><br>
            Make sure the order status is <strong>Completed</strong>.
            If it’s still <strong>Processing</strong>, please wait a moment or contact support.
        </div>

    </div>

</div>
