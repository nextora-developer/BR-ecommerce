<x-app-layout>
    <section class="bg-[#FAF9F6] min-h-screen pb-20">

        {{-- Header Section --}}
        <div class="bg-white border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16 text-center">
                <h2 class="text-xs font-bold uppercase tracking-[0.3em] text-[#8f6a10] mb-3">Service Guarantee</h2>
                <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 tracking-tight mb-4">
                    Returns & Refunds
                </h1>
                <p class="text-sm text-gray-500 max-w-lg mx-auto leading-relaxed">
                    Not quite right? We're here to help. Our policy is designed to be as simple and fair as possible.
                </p>
            </div>
        </div>

        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 mt-12">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">

                {{-- Left: The Policy Details --}}
                <div class="lg:col-span-2 space-y-12">

                    {{-- 1. Eligibility Section --}}
                    <section>
                        <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                            <span class="w-8 h-1 bg-[#D4AF37] rounded-full"></span>
                            Return Eligibility
                        </h2>
                        <div class="bg-white border border-gray-100 rounded-3xl p-6 md:p-8 shadow-sm">
                            <p class="text-sm text-gray-600 mb-6">To be eligible for a return, please ensure that:</p>
                            <ul class="space-y-4">
                                <li class="flex items-start gap-3">
                                    <div
                                        class="mt-1 w-5 h-5 rounded-full bg-green-50 flex-shrink-0 flex items-center justify-center">
                                        <svg class="w-3 h-3 text-green-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                    <span class="text-sm text-gray-700">The item was purchased within the last
                                        <strong>14 days</strong>.</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <div
                                        class="mt-1 w-5 h-5 rounded-full bg-green-50 flex-shrink-0 flex items-center justify-center">
                                        <svg class="w-3 h-3 text-green-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                    <span class="text-sm text-gray-700">The product is in its <strong>original
                                            packaging</strong> with all tags attached.</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <div
                                        class="mt-1 w-5 h-5 rounded-full bg-green-50 flex-shrink-0 flex items-center justify-center">
                                        <svg class="w-3 h-3 text-green-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                    <span class="text-sm text-gray-700">The product has not been used, worn, or
                                        damaged.</span>
                                </li>
                            </ul>

                            <div class="mt-8 p-4 bg-amber-50 rounded-2xl border border-amber-100">
                                <p class="text-xs text-amber-800 leading-relaxed">
                                    <strong class="uppercase tracking-wide">Exempt Goods:</strong> Personalized items,
                                    perishable goods, and certain hygiene-related products (e.g., earrings) cannot be
                                    returned.
                                </p>
                            </div>
                        </div>
                    </section>

                    {{-- 2. The Process Section --}}
                    <section>
                        <h2 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                            <span class="w-8 h-1 bg-[#D4AF37] rounded-full"></span>
                            How to Return
                        </h2>
                        <div class="space-y-6">
                            <div class="flex gap-4">
                                <span
                                    class="flex-shrink-0 w-8 h-8 rounded-full bg-gray-900 text-white flex items-center justify-center text-xs font-bold">1</span>
                                <div>
                                    <h3 class="font-bold text-gray-900">Request a Return</h3>
                                    <p class="text-sm text-gray-500 mt-1">Contact our team via email at
                                        returns@yourshop.com with your Order Number and photos of the item.</p>
                                </div>
                            </div>
                            <div class="flex gap-4">
                                <span
                                    class="flex-shrink-0 w-8 h-8 rounded-full bg-gray-900 text-white flex items-center justify-center text-xs font-bold">2</span>
                                <div>
                                    <h3 class="font-bold text-gray-900">Pack Your Items</h3>
                                    <p class="text-sm text-gray-500 mt-1">Once approved, securely pack the item. We
                                        recommend using the original shipping box to prevent damage.</p>
                                </div>
                            </div>
                            <div class="flex gap-4">
                                <span
                                    class="flex-shrink-0 w-8 h-8 rounded-full bg-gray-900 text-white flex items-center justify-center text-xs font-bold">3</span>
                                <div>
                                    <h3 class="font-bold text-gray-900">Ship it Back</h3>
                                    <p class="text-sm text-gray-500 mt-1">Send the parcel to our warehouse address
                                        provided in the email. <i>(Note: Return shipping costs are the responsibility of
                                            the customer unless the item is faulty).</i></p>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>

                {{-- Right: Refund Timeline & Contact --}}
                <div class="space-y-6">
                    <div class="bg-white border border-gray-100 rounded-3xl p-8 shadow-sm">
                        <h3 class="text-gray-900 font-bold mb-4">Refund Timeline</h3>
                        <div class="space-y-4">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Inspection</span>
                                <span class="text-gray-900 font-medium">1-2 Days</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Processing</span>
                                <span class="text-gray-900 font-medium">3-5 Days</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Bank Transfer</span>
                                <span class="text-gray-900 font-medium">Bank dependent</span>
                            </div>
                        </div>
                        <div class="mt-6 pt-6 border-t border-gray-50">
                            <p class="text-xs text-gray-400 italic">
                                Refunds will be issued via the original payment method used during purchase.
                            </p>
                        </div>
                    </div>

                    <div class="bg-[#8f6a10] rounded-3xl p-8 text-white shadow-xl">
                        <h3 class="text-lg font-bold mb-2">Faulty Item?</h3>
                        <p class="text-sm text-white/80 mb-6">
                            If you received a damaged or incorrect item, we will cover all return shipping costs.
                        </p>
                        <a href=""
                            class="block w-full text-center bg-white text-[#8f6a10] font-bold py-3 rounded-xl text-sm hover:bg-gray-50 transition-colors">
                            Report an Issue
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>
</x-app-layout>
