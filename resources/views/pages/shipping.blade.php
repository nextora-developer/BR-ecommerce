<x-app-layout>
    <section class="bg-[#FAF9F6] min-h-screen pb-20">

        {{-- Header Section --}}
        <div class="bg-white border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16 text-center">
                <h2 class="text-xs font-bold uppercase tracking-[0.3em] text-[#8f6a10] mb-3">Logistics</h2>
                <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 tracking-tight mb-4">
                    Shipping & Delivery
                </h1>
                <p class="text-sm text-gray-500 max-w-lg mx-auto leading-relaxed">
                    Everything you need to know about how we get your favorite items from our shop to your doorstep.
                </p>
            </div>
        </div>

        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 mt-12">

            {{-- Quick Summary Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-16">
                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm text-center">
                    <div
                        class="w-12 h-12 bg-[#FAF9F6] rounded-full flex items-center justify-center mx-auto mb-4 text-[#8f6a10]">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-900">Processing Time</h3>
                    <p class="text-sm text-gray-500 mt-2">Orders ship within 1–2 business days.</p>
                </div>

                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm text-center">
                    <div
                        class="w-12 h-12 bg-[#FAF9F6] rounded-full flex items-center justify-center mx-auto mb-4 text-[#8f6a10]">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-900">Courier Partners</h3>
                    <p class="text-sm text-gray-500 mt-2">DHL, FedEx, and NinjaVan.</p>
                </div>

                <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm text-center">
                    <div
                        class="w-12 h-12 bg-[#FAF9F6] rounded-full flex items-center justify-center mx-auto mb-4 text-[#8f6a10]">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-900">Secure Packing</h3>
                    <p class="text-sm text-gray-500 mt-2">Eco-friendly & double-layered protection.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">

                {{-- Left: Detailed Info --}}
                <div class="lg:col-span-2 space-y-12">

                    {{-- Shipping Rates Table --}}
                    <section>
                        <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                            <span class="w-8 h-1 bg-[#D4AF37] rounded-full"></span>
                            Shipping Rates & Estimates
                        </h2>
                        <div class="overflow-hidden border border-gray-100 rounded-2xl bg-white shadow-sm">
                            <table class="w-full text-left text-sm">
                                <thead class="bg-gray-50 border-b border-gray-100">
                                    <tr>
                                        <th class="px-6 py-4 font-bold text-gray-900">Region</th>
                                        <th class="px-6 py-4 font-bold text-gray-900">Delivery Time</th>
                                        <th class="px-6 py-4 font-bold text-gray-900 text-right">Cost</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    <tr>
                                        <td class="px-6 py-4 font-medium text-gray-700">West Malaysia</td>
                                        <td class="px-6 py-4 text-gray-500">1 – 3 Business Days</td>
                                        <td class="px-6 py-4 text-right font-bold text-[#8f6a10]">RM 8.00</td>
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-4 font-medium text-gray-700">East Malaysia</td>
                                        <td class="px-6 py-4 text-gray-500">3 – 7 Business Days</td>
                                        <td class="px-6 py-4 text-right font-bold text-[#8f6a10]">RM 15.00</td>
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-4 font-medium text-gray-700">Singapore</td>
                                        <td class="px-6 py-4 text-gray-500">5 – 10 Business Days</td>
                                        <td class="px-6 py-4 text-right font-bold text-[#8f6a10]">RM 35.00</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="bg-[#8f6a10]/5 px-6 py-3">
                                <p class="text-[11px] text-[#8f6a10] font-bold text-center uppercase tracking-widest">
                                    ✨ Free Shipping on orders over RM 150 (West Malaysia only)
                                </p>
                            </div>
                        </div>
                    </section>

                    {{-- Important Notes --}}
                    <section class="space-y-6">
                        <h2 class="text-xl font-bold text-gray-900">Things to Note</h2>
                        <div class="prose prose-sm text-gray-600 max-w-none space-y-4">
                            <p>
                                <strong>Tracking Your Order:</strong> Once your order has been dispatched, you will
                                receive an email containing a tracking link. Please allow up to 24 hours for the
                                tracking information to update.
                            </p>
                            <p>
                                <strong>Customs & Duties:</strong> For international orders (including Singapore),
                                please note that your order may be subject to import duties and taxes which are applied
                                when the delivery reaches that destination. We have no control over these charges.
                            </p>
                        </div>
                    </section>
                </div>

                {{-- Right: Sidebar Help --}}
                <div class="space-y-6">
                    <div class="bg-white rounded-3xl p-8 text-gray-900 shadow-xl border border-black/5">
                        <h3 class="text-lg font-bold mb-4">Track Order</h3>

                        <p class="text-xs text-gray-500 mb-6 leading-relaxed">
                            Already have a tracking number? Enter it below to see the status.
                        </p>

                        <form action="#" class="space-y-3">
                            <input type="text" placeholder="e.g. MY123456789"
                                class="w-full bg-gray-50 border border-gray-200 rounded-xl
                      px-4 py-3 text-sm
                      text-gray-900 placeholder-gray-400
                      focus:outline-none focus:ring-2 focus:ring-[#D4AF37] focus:border-[#D4AF37]">

                            <button
                                class="w-full bg-[#D4AF37] hover:bg-[#b8962d]
                   text-gray-900 font-bold py-3 rounded-xl
                   text-sm transition-colors">
                                Track Now
                            </button>
                        </form>
                    </div>


                    <div class="bg-white border border-gray-100 rounded-3xl p-8 shadow-sm">
                        <h3 class="text-gray-900 font-bold mb-2">Need help?</h3>
                        <p class="text-xs text-gray-500 mb-6">If your package is delayed or lost, please contact us
                            immediately.</p>
                        <a href="mailto:shipping@yourshop.com"
                            class="flex items-center gap-3 text-sm font-bold text-[#8f6a10] hover:underline">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            shipping@yourshop.com
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>
</x-app-layout>
