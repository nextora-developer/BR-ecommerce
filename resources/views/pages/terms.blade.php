<x-app-layout>
    <section class="bg-[#FAF9F6] min-h-screen pb-20">

        {{-- Header Section --}}
        <div class="bg-white border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16 text-center">
                <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 tracking-tight mb-4">
                    Terms of Service
                </h1>
                <p class="text-sm text-gray-500 font-medium">
                    Effective Date: January 01, 2026
                </p>
            </div>
        </div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 mt-12">

            {{-- Quick Summary Box (The TL;DR) --}}
            <div class="mb-12 bg-[#8f6a10]/5 border border-[#D4AF37]/20 rounded-3xl p-6 md:p-8">
                <h2 class="text-[#8f6a10] font-bold text-sm uppercase tracking-widest mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    The Short Version
                </h2>
                <div class="grid md:grid-cols-2 gap-6">
                    <ul class="space-y-2 text-sm text-gray-700">
                        <li class="flex items-center gap-2">
                            <span class="text-[#D4AF37]">•</span> By using our site, you agree to these rules.
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="text-[#D4AF37]">•</span> You must be 18+ or have parent consent to shop.
                        </li>
                    </ul>
                    <ul class="space-y-2 text-sm text-gray-700">
                        <li class="flex items-center gap-2">
                            <span class="text-[#D4AF37]">•</span> Prices can change, but we'll honor your paid order.
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="text-[#D4AF37]">•</span> Respect our designs; they are our intellectual
                            property.
                        </li>
                    </ul>
                </div>
            </div>

            {{-- Full Content --}}
            <div
                class="bg-white border border-gray-100 rounded-3xl p-8 md:p-12 shadow-sm prose prose-sm prose-gray max-w-none">

                <section class="mb-10">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">1. Acceptance of Terms</h2>
                    <p class="text-gray-600 leading-relaxed">
                        By accessing and placing an order with <strong>{{ config('app.name') }}</strong>, you confirm
                        that you are in agreement with and bound by the terms of service contained in the Terms &
                        Conditions outlined below. These terms apply to the entire website and any email or other type
                        of communication between you and us.
                    </p>
                </section>

                <section class="mb-10">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">2. Accuracy of Information</h2>
                    <p class="text-gray-600 leading-relaxed">
                        While we strive to be as accurate as possible, we do not warrant that product descriptions or
                        other content on this site are error-free. If a product offered by us is not as described, your
                        sole remedy is to return it in unused condition per our <a href="{{ route('returns') }}"
                            class="text-[#8f6a10] font-bold">Returns Policy</a>.
                    </p>
                </section>

                <section class="mb-10">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">3. Orders and Pricing</h2>
                    <p class="text-gray-600 leading-relaxed">
                        We reserve the right to refuse or cancel any order for any reason including limitations on
                        quantities available for purchase, inaccuracies, or errors in product or pricing information.
                    </p>
                    <ul class="mt-4 list-disc pl-5 space-y-2 text-gray-600">
                        <li>All prices are listed in RM (Malaysian Ringgit).</li>
                        <li>Payments must be cleared before shipping.</li>
                        <li>We reserve the right to modify prices without prior notice.</li>
                    </ul>
                </section>

                <section class="mb-10">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">4. Intellectual Property</h2>
                    <p class="text-gray-600 leading-relaxed">
                        All content included on this site, such as text, graphics, logos, images, and software, is the
                        property of <strong>{{ config('app.name') }}</strong> and protected by international copyright
                        laws. You may not reproduce, duplicate, copy, sell, or otherwise exploit our content for any
                        commercial purpose without express written consent.
                    </p>
                </section>

                <section class="mb-10">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">5. Limitation of Liability</h2>
                    <p class="text-gray-600 leading-relaxed italic">
                        In no event shall {{ config('app.name') }} be liable for any direct, indirect, incidental, or
                        consequential damages resulting from the use or inability to use our services or products.
                    </p>
                </section>

                <section class="mb-10">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">6. Governing Law</h2>
                    <p class="text-gray-600 leading-relaxed">
                        These terms shall be governed by and construed in accordance with the laws of
                        <strong>Malaysia</strong>, without regard to its conflict of law provisions.
                    </p>
                </section>

                <div class="mt-16 pt-8 border-t border-gray-100 text-center">
                    <p class="text-xs text-gray-400">
                        Questions about the Terms of Service? Reach out to us at
                        <a href="mailto:legal@yourshop.com" class="text-[#8f6a10] font-bold">legal@yourshop.com</a>
                    </p>
                </div>

            </div>
        </div>
    </section>
</x-app-layout>
