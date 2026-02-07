@php
    // ✅ 先用静态数据（以后你要接 DB：把这里换成 $reviews from controller）
    $reviews =
        $reviews ??
        collect([
            [
                'name' => 'Aina',
                'title' => 'Fast delivery & premium packaging',
                'body' => 'Everything arrived nicely packed and feels premium. Definitely ordering again.',
                'rating' => 5,
                'meta' => 'Verified purchase • Essentials',
            ],
            [
                'name' => 'Haziq',
                'title' => 'Smooth checkout, legit product',
                'body' => 'Payment was smooth and the product is genuine. Support was responsive too.',
                'rating' => 5,
                'meta' => 'Verified purchase • Vouchers',
            ],
            [
                'name' => 'Sofia',
                'title' => 'Great value for money',
                'body' => 'Good quality and reasonable pricing. Redeeming vouchers was easy.',
                'rating' => 4,
                'meta' => 'Verified purchase • Top-ups',
            ],
            [
                'name' => 'Daniel',
                'title' => 'Clean UI, easy to find items',
                'body' => 'The site is easy to navigate, and product details are clear. Nice experience.',
                'rating' => 5,
                'meta' => 'Verified purchase • Essentials',
            ],
            [
                'name' => 'Farah',
                'title' => 'Instant delivery for digital items',
                'body' => 'Bought a digital product and received it almost instantly. Very convenient.',
                'rating' => 5,
                'meta' => 'Verified purchase • Digital',
            ],
            [
                'name' => 'Adam',
                'title' => 'Reliable and trustworthy store',
                'body' => 'Order process was clear and transparent. Feels like a trustworthy platform.',
                'rating' => 4,
                'meta' => 'Verified purchase • General',
            ],
        ]);

@endphp

<section id="reviews">
    <div class="max-w-7xl5 mx-auto px-4 sm:px-6 lg:px-8 py-10 lg:py-14">

        {{-- Header --}}
        <div class="flex items-end justify-between gap-6 mb-6 lg:mb-8">
            <div>
                <div
                    class="inline-flex items-center gap-2 rounded-full px-3 py-1.5
                            text-[11px] font-black uppercase tracking-[0.22em]
                            bg-[#D4AF37]/10 text-[#8f6a10] border border-[#D4AF37]/20">
                    <span class="h-1.5 w-1.5 rounded-full bg-[#D4AF37]"></span>
                    Reviews
                </div>
                <h2 class="mt-3 text-2xl sm:text-3xl font-black tracking-tight text-black">
                    Loved by shoppers across Malaysia
                </h2>
            </div>

            <a href="{{ route('shop.index') }}"
                class="hidden sm:inline-flex items-center text-[11px] font-black uppercase tracking-[0.22em]
                       text-black/60 hover:text-[#8f6a10] transition">
                Shop now <span class="ml-2 text-black/30">→</span>
            </a>
        </div>

        {{-- Mobile: horizontal scroll | Desktop: grid --}}
        <div class="sm:hidden -mx-4 px-4 overflow-x-auto scrollbar-hide" data-reviews-scroll>
            <div class="flex gap-4 min-w-max pb-2">
                @foreach ($reviews as $r)
                    <div class="w-[290px]">
                        @include('shop.partials._review-card', ['r' => $r])
                    </div>
                @endforeach
            </div>
        </div>

        <div class="hidden sm:grid grid-cols-2 lg:grid-cols-3 gap-5 lg:gap-6">
            @foreach ($reviews->take(6) as $r)
                @include('shop.partials._review-card', ['r' => $r])
            @endforeach
        </div>

        {{-- Bottom trust strip --}}
        {{-- <div class="mt-8 lg:mt-10 rounded-3xl border border-black/[0.06] bg-white/70 backdrop-blur px-6 py-5">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="h-11 w-11 rounded-2xl bg-[#D4AF37]/12 flex items-center justify-center">
                        <span class="text-[#8f6a10] font-black">★</span>
                    </div>
                    <div>
                        <div class="text-sm font-black text-black">Trusted experience</div>
                        <div class="text-xs text-black/60">Secure payments • Fast fulfilment • Friendly support</div>
                    </div>
                </div>

                <a href="{{ route('shop.index') }}"
                    class="inline-flex items-center justify-center rounded-2xl px-6 py-3
                           bg-black text-white font-black text-xs uppercase tracking-[0.22em]
                           hover:bg-black/90 transition">
                    Browse Products
                </a>
            </div>
        </div> --}}

    </div>
</section>
