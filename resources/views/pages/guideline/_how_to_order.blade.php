<div class="rounded-[2.5rem] bg-white border border-gray-100 p-8 shadow-sm">

    {{-- Header --}}
    <div class="flex items-center justify-between gap-4 mb-8">
        <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900">
            How to Order
        </h2>
        <span
            class="px-3 py-1 rounded-full bg-[#D4AF37]/10 text-[#8f6a10] text-[10px] font-black uppercase tracking-widest">
            Ordering
        </span>
    </div>

    {{-- Quick Summary --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-10">

        <div class="rounded-2xl bg-[#FAF9F6] border border-gray-100 p-5">
            <div class="text-xs text-gray-500 font-black uppercase tracking-widest">
                🛍️ Step 1
            </div>
            <div class="mt-2 text-sm font-bold text-gray-900">
                Browse Products
            </div>
            <p class="mt-1 text-xs text-gray-500">
                Explore available products and categories.
            </p>
        </div>

        <div class="rounded-2xl bg-[#FAF9F6] border border-gray-100 p-5">
            <div class="text-xs text-gray-500 font-black uppercase tracking-widest">
                ➕ Step 2
            </div>
            <div class="mt-2 text-sm font-bold text-gray-900">
                Add to Cart
            </div>
            <p class="mt-1 text-xs text-gray-500">
                Select quantity / variant and add to cart.
            </p>
        </div>

        <div class="rounded-2xl bg-[#FAF9F6] border border-gray-100 p-5">
            <div class="text-xs text-gray-500 font-black uppercase tracking-widest">
                💳 Step 3
            </div>
            <div class="mt-2 text-sm font-bold text-gray-900">
                Checkout & Pay
            </div>
            <p class="mt-1 text-xs text-gray-500">
                Fill details and complete payment.
            </p>
        </div>

        <div class="rounded-2xl bg-[#FAF9F6] border border-gray-100 p-5">
            <div class="text-xs text-gray-500 font-black uppercase tracking-widest">
                📦 Step 4
            </div>
            <div class="mt-2 text-sm font-bold text-gray-900">
                Order Processing
            </div>
            <p class="mt-1 text-xs text-gray-500">
                Track status in your account.
            </p>
        </div>

    </div>

    {{-- Detailed Steps --}}
    <div class="space-y-8">

        {{-- Step 1 --}}
        <div class="flex gap-4">
            <div
                class="flex-shrink-0 w-10 h-10 rounded-full bg-[#D4AF37]/15 text-[#8f6a10] font-extrabold flex items-center justify-center">
                1
            </div>
            <div>
                <h3 class="font-bold text-gray-900 mb-1">
                    Browse & Select Product
                </h3>
                <p class="text-sm text-gray-600 leading-relaxed">
                    Visit the shop page, browse through categories, and open the product you wish to purchase.
                </p>
            </div>
        </div>

        {{-- Step 2 --}}
        <div class="flex gap-4">
            <div
                class="flex-shrink-0 w-10 h-10 rounded-full bg-[#D4AF37]/15 text-[#8f6a10] font-extrabold flex items-center justify-center">
                2
            </div>
            <div>
                <h3 class="font-bold text-gray-900 mb-1">
                    Add to Cart
                </h3>
                <p class="text-sm text-gray-600 leading-relaxed">
                    Choose the correct variant (if any), set quantity, then click
                    <span class="font-semibold text-gray-900">Add to Cart</span>.
                </p>
            </div>
        </div>

        {{-- Step 3 --}}
        <div class="flex gap-4">
            <div
                class="flex-shrink-0 w-10 h-10 rounded-full bg-[#D4AF37]/15 text-[#8f6a10] font-extrabold flex items-center justify-center">
                3
            </div>
            <div>
                <h3 class="font-bold text-gray-900 mb-1">
                    Checkout & Payment
                </h3>
                <p class="text-sm text-gray-600 leading-relaxed">
                    Review your cart, fill in delivery details, and complete payment using the available payment
                    methods.
                </p>
                <p class="mt-2 text-xs text-gray-500 italic">
                    You will receive an order confirmation once payment is successful.
                </p>
            </div>
        </div>

        {{-- Step 4 --}}
        <div class="flex gap-4">
            <div
                class="flex-shrink-0 w-10 h-10 rounded-full bg-[#D4AF37]/15 text-[#8f6a10] font-extrabold flex items-center justify-center">
                4
            </div>

            <div class="w-full">
                <h3 class="font-bold text-gray-900 mb-1">
                    Track Your Order
                </h3>

                <p class="text-sm text-gray-600 leading-relaxed">
                    You can check your order status anytime from <span class="font-semibold text-gray-900">My
                        Orders</span>.
                </p>

                <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                    {{-- Desktop --}}
                    <div class="rounded-2xl bg-[#FAF9F6] border border-gray-100 p-4">
                        <div class="text-xs font-black uppercase tracking-widest text-gray-500 mb-2">
                            🖥️Desktop
                        </div>
                        <ol class="text-sm text-gray-700 space-y-2 list-decimal pl-5">
                            <li>Look at the <span class="font-semibold text-gray-900">top-right</span> corner.</li>
                            <li>Click your <span class="font-semibold text-gray-900">username</span> to open the
                                dropdown.</li>
                            <li>Select <span class="font-semibold text-gray-900">My Orders</span>.</li>
                        </ol>
                    </div>

                    {{-- Mobile --}}
                    <div class="rounded-2xl bg-[#FAF9F6] border border-gray-100 p-4">
                        <div class="text-xs font-black uppercase tracking-widest text-gray-500 mb-2">
                            📱Mobile
                        </div>
                        <ol class="text-sm text-gray-700 space-y-2 list-decimal pl-5">
                            <li>Tap <span class="font-semibold text-gray-900">Profile</span> on the bottom menu.</li>
                            <li>Tap <span class="font-semibold text-gray-900">My Orders</span>.</li>
                        </ol>
                    </div>
                </div>

                <div class="mt-4 rounded-2xl bg-white border border-gray-100 p-4">
                    <div class="text-xs font-black uppercase tracking-widest text-gray-500 mb-2">
                        Order Status
                    </div>
                    <p class="text-sm text-gray-700 leading-relaxed">
                        You’ll see statuses like
                        <span class="font-semibold">Pending</span>,
                        <span class="font-semibold">Processing</span>,
                        <span class="font-semibold">Shipped</span>,
                        or
                        <span class="font-semibold">Completed</span>.
                        Tap an order to view full details and tracking (if available).
                    </p>
                </div>
            </div>
        </div>


    </div>

    {{-- Common Questions --}}
    <div class="mt-12 space-y-4">

        <h3 class="text-lg font-extrabold text-gray-900">
            Common Questions
        </h3>

        <div class="rounded-2xl bg-blue-50/60 border border-blue-100 p-4 text-sm text-blue-700">
            <strong>Why is my order still pending?</strong><br>
            Pending means payment has not been completed or confirmed yet.
        </div>

        <div class="rounded-2xl bg-blue-50/60 border border-blue-100 p-4 text-sm text-blue-700">
            <strong>Payment deducted but no order?</strong><br>
            Please wait a few minutes and refresh. If the issue persists, contact support with your payment reference.
        </div>

    </div>

</div>
