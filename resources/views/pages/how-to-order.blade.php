<x-app-layout>
    <section class="bg-[#FAF9F6] min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24">

            {{-- Header --}}
            <div class="text-center mb-16">
                <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 tracking-tight mb-4">
                    How to Order
                </h1>
                <p class="text-gray-500 max-w-lg mx-auto">
                    Your journey from finding the perfect item to having it delivered to your doorstep.
                </p>
            </div>

            {{-- Steps Grid/Timeline --}}
            <div class="relative">
                {{-- Decorative Line (Hidden on Mobile) --}}
                <div class="hidden md:block absolute left-[2.25rem] top-4 bottom-4 w-0.5 bg-gray-200"></div>

                <div class="space-y-12">
                    @php
                        $steps = [
                            [
                                'title' => 'Browse Products',
                                'desc' => 'Explore our collection and choose the items you love.',
                                'icon' => 'M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z',
                            ],
                            [
                                'title' => 'Add to Cart',
                                'desc' => 'Select your preferred size or variant and add them to your shopping bag.',
                                'icon' => 'M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z',
                            ],
                            [
                                'title' => 'Secure Checkout',
                                'desc' =>
                                    'Click the cart icon to review your items and proceed to enter your shipping details.',
                                'icon' =>
                                    'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z',
                            ],
                            [
                                'title' => 'Make Payment',
                                'desc' => 'Choose your preferred payment method and complete the transaction securely.',
                                'icon' =>
                                    'M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z',
                            ],
                            [
                                'title' => 'Order Confirmation',
                                'desc' =>
                                    'Sit back and relax! You will receive an email confirmation and tracking number shortly.',
                                'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
                            ],
                        ];
                    @endphp

                    @foreach ($steps as $index => $step)
                        <div class="relative flex flex-col md:flex-row gap-6 md:gap-10 group">
                            {{-- Step Number/Icon --}}
                            <div class="relative z-10 flex-shrink-0">
                                <div
                                    class="w-12 h-12 md:w-16 md:h-16 rounded-full bg-white border-2 border-[#D4AF37] flex items-center justify-center shadow-sm group-hover:bg-[#D4AF37] group-hover:text-white transition-colors duration-300">
                                    <svg class="w-6 h-6 md:w-8 md:h-8" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="{{ $step['icon'] }}" />
                                    </svg>
                                </div>
                                <span
                                    class="absolute -top-2 -right-2 md:hidden bg-[#8f6a10] text-white text-[10px] font-bold px-2 py-0.5 rounded-full">
                                    Step {{ $index + 1 }}
                                </span>
                            </div>

                            {{-- Text Content --}}
                            <div class="flex-1 pt-1 md:pt-4">
                                <div
                                    class="hidden md:block text-[10px] font-bold uppercase tracking-[0.2em] text-[#8f6a10] mb-1">
                                    Step {{ $index + 1 }}
                                </div>
                                <h2 class="text-xl font-bold text-gray-900 mb-2">
                                    {{ $step['title'] }}
                                </h2>
                                <p class="text-gray-600 text-sm md:text-base leading-relaxed max-w-2xl">
                                    {{ $step['desc'] }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Footer CTA --}}
            <div class="mt-20 pt-10 border-t border-gray-200 text-center">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Ready to start shopping?</h3>
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="{{ route('shop.index') }}"
                        class="px-8 py-3 bg-gray-900 text-white rounded-full font-semibold hover:bg-black transition shadow-lg">
                        Go to Shop
                    </a>
                    <a href="#"
                        class="px-8 py-3 bg-white border border-gray-200 text-gray-700 rounded-full font-semibold hover:bg-gray-50 transition">
                        Have Questions?
                    </a>
                </div>
            </div>

        </div>
    </section>
</x-app-layout>
