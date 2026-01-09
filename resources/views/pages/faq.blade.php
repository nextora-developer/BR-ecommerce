<x-app-layout>
    <section class="bg-[#FAF9F6] min-h-screen">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24">

            {{-- Title & Header --}}
            <div class="text-center mb-12">
                <h2 class="text-base font-bold uppercase tracking-widest text-[#8f6a10] mb-3">Support</h2>
                <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 tracking-tight">
                    Frequently Asked Questions
                </h1>
            </div>

            {{-- FAQ List --}}
            <div class="space-y-4" x-data="{ active: null }">

                {{-- Question 1 --}}
                <div
                    class="bg-white border border-gray-100 rounded-2xl overflow-hidden shadow-sm transition-all duration-300 hover:border-[#D4AF37]/30">
                    <button @click="active !== 1 ? active = 1 : active = null"
                        class="w-full flex items-center justify-between px-6 py-5 text-left focus:outline-none">
                        <span class="font-bold text-gray-900">How long does delivery take?</span>
                        <svg class="w-5 h-5 text-gray-400 transition-transform duration-300"
                            :class="active === 1 ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="active === 1" x-collapse x-cloak
                        class="px-6 pb-5 text-sm leading-relaxed text-gray-600">
                        Orders are typically processed within 24 hours. Once shipped, delivery usually takes <strong>1–3
                            working days</strong> for local orders. You will receive a tracking number via email as soon
                        as your package is on its way.
                    </div>
                </div>

                {{-- Question 2 --}}
                <div
                    class="bg-white border border-gray-100 rounded-2xl overflow-hidden shadow-sm transition-all duration-300 hover:border-[#D4AF37]/30">
                    <button @click="active !== 2 ? active = 2 : active = null"
                        class="w-full flex items-center justify-between px-6 py-5 text-left focus:outline-none">
                        <span class="font-bold text-gray-900">Can I return my order?</span>
                        <svg class="w-5 h-5 text-gray-400 transition-transform duration-300"
                            :class="active === 2 ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="active === 2" x-collapse x-cloak
                        class="px-6 pb-5 text-sm leading-relaxed text-gray-600">
                        Yes, we accept returns within 14 days of delivery for eligible items in their original, unused
                        condition. Please note that certain sale items or personalized goods may be final sale. Contact
                        our support team to initiate a return request.
                    </div>
                </div>

                {{-- Question 3 --}}
                <div
                    class="bg-white border border-gray-100 rounded-2xl overflow-hidden shadow-sm transition-all duration-300 hover:border-[#D4AF37]/30">
                    <button @click="active !== 3 ? active = 3 : active = null"
                        class="w-full flex items-center justify-between px-6 py-5 text-left focus:outline-none">
                        <span class="font-bold text-gray-900">How do I contact support?</span>
                        <svg class="w-5 h-5 text-gray-400 transition-transform duration-300"
                            :class="active === 3 ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="active === 3" x-collapse x-cloak
                        class="px-6 pb-5 text-sm leading-relaxed text-gray-600">
                        Our team is here to help! You can reach us via:
                        <ul class="mt-3 space-y-2">
                            <li class="flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#D4AF37]"></span>
                                <strong>WhatsApp:</strong> +60 12-345 6789
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#D4AF37]"></span>
                                <strong>Email:</strong> support@yourshop.com
                            </li>
                        </ul>
                    </div>
                </div>

            </div>

            {{-- Support CTA --}}
            <div class="mt-16 text-center bg-white rounded-3xl p-8 border border-gray-100 shadow-sm">
                <h3 class="text-lg font-bold text-gray-900 mb-2">Still have questions?</h3>
                <p class="text-sm text-gray-500 mb-6">If you couldn't find the answer you're looking for, please get in
                    touch with our friendly team.</p>
                <div class="flex flex-wrap items-center justify-center gap-4">
                    <a href="https://wa.me/yourlink"
                        class="inline-flex items-center px-6 py-3 rounded-full bg-[#25D366] text-white text-sm font-bold hover:opacity-90 transition">
                        Chat on WhatsApp
                    </a>
                </div>
            </div>

        </div>
    </section>
</x-app-layout>
