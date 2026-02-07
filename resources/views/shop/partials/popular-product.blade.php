{{-- Popular products --}}
<section id="popular-products" class="relative overflow-hidden">

    <div class="relative max-w-7xl5 mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-5">

        {{-- Header --}}
        <div
            class="flex flex-row
           items-baseline
           justify-between
           gap-4 mb-5 lg:mb-5
           text-left">

            <div class="space-y-2">
                <h2 class="text-2xl sm:text-3xl font-bold text-black">
                    🔥Popular Product
                </h2>
            </div>

            <a href="{{ route('shop.index') }}"
                class="inline-flex items-center
          text-base font-bold
          text-[#D4AF37]
          hover:text-[#8f6a10] mr-5
          transition-colors duration-300">
                View More
            </a>


        </div>


        @if (isset($popular) && $popular->count())

            <div class="relative">

                {{-- Left / Right Controls (desktop & tablet) --}}
                <button type="button"
                    class="hidden sm:flex absolute -left-6 lg:-left-16 top-1/2 -translate-y-1/2 z-20
           w-11 h-11 rounded-full
           bg-black/80 text-white
           backdrop-blur
           flex items-center justify-center
           shadow-lg shadow-black/20
           transition-all duration-300
           hover:bg-black hover:scale-105
           active:scale-95"
                    data-po-desktop-prev aria-label="Previous">
                    ‹
                </button>

                <button type="button"
                    class="hidden sm:flex absolute -right-6 lg:-right-16 top-1/2 -translate-y-1/2 z-20
           w-11 h-11 rounded-full
           bg-black/80 text-white
           backdrop-blur
           flex items-center justify-center
           shadow-lg shadow-black/20
           transition-all duration-300
           hover:bg-black hover:scale-105
           active:scale-95"
                    data-po-desktop-next aria-label="Next">
                    ›
                </button>

                {{-- Grid --}}
                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4 sm:gap-6" data-po-grid>
                    @foreach ($popular as $product)
                        <div data-po-item
                            class="group relative flex flex-col bg-white rounded-2xl
                                   border border-black/[0.06]
                                   shadow-[0_10px_25px_rgba(0,0,0,0.06)]
                                   hover:shadow-[0_22px_45px_rgba(0,0,0,0.10)]
                                   hover:border-[#D4AF37]/35
                                   transition-all duration-500 overflow-hidden">

                            {{-- Image --}}
                            <a href="{{ route('shop.show', $product->slug) }}"
                                class="relative aspect-square overflow-hidden bg-[#FAFAFA]">
                                @if ($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                        class="w-full h-full object-cover transform group-hover:scale-[1.06]
                                               transition-transform duration-700 ease-out">
                                @else
                                    <div
                                        class="w-full h-full flex items-center justify-center bg-gray-50
                                               text-[10px] uppercase tracking-widest text-gray-400">
                                        No Image Available
                                    </div>
                                @endif

                                <div
                                    class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-500
                                           bg-gradient-to-t from-black/10 via-transparent to-transparent">
                                </div>

                                {{-- Popular badge --}}
                                <div class="absolute top-3 left-3 z-10">
                                    <span
                                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full
                                               text-[10px] font-extrabold uppercase tracking-[0.25em]
                                               bg-black/70 text-white backdrop-blur">
                                        <span class="inline-block w-1.5 h-1.5 rounded-full bg-[#D4AF37]"></span>
                                        Popular
                                    </span>
                                </div>
                            </a>

                            {{-- Favorite --}}
                            @auth
                                @php
                                    $isFavorited = auth()->user()->favorites->contains('product_id', $product->id);
                                @endphp
                                <form
                                    action="{{ $isFavorited ? route('account.favorites.destroy', $product) : route('account.favorites.store', $product) }}"
                                    method="POST" class="absolute top-3 right-3 z-10">
                                    @csrf
                                    @if ($isFavorited)
                                        @method('DELETE')
                                    @endif
                                    <button type="submit"
                                        class="w-9 h-9 flex items-center justify-center rounded-full
                                               bg-white/90 backdrop-blur-sm text-[#8f6a10]
                                               shadow-sm hover:bg-white hover:scale-110 transition-all active:scale-95">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            fill="{{ $isFavorited ? '#D4AF37' : 'none' }}"
                                            stroke="{{ $isFavorited ? '#D4AF37' : 'currentColor' }}" stroke-width="1.8"
                                            viewBox="0 0 24 24" class="h-5 w-5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                                        </svg>
                                    </button>
                                </form>
                            @endauth

                            {{-- Content --}}
                            <div class="flex-1 flex flex-col p-4">
                                <a href="{{ route('shop.show', $product->slug) }}" class="block flex-1 group/title">
                                    <p
                                        class="text-[10px] font-extrabold uppercase tracking-[0.22em] text-[#D4AF37] mb-1.5">
                                        {{ $product->category->name ?? 'General' }}
                                    </p>

                                    <h3
                                        class="text-sm font-semibold text-gray-900 line-clamp-2
                                               group-hover/title:text-[#8f6a10] transition-colors leading-snug">
                                        {{ $product->name }}
                                    </h3>
                                </a>

                                <div class="mt-4 flex flex-col gap-3">
                                    {{-- Price --}}
                                    <p class="text-base font-extrabold text-gray-900">
                                        @if ($product->has_variants && $product->variants->count())
                                            @php
                                                $prices = $product->variants->pluck('price')->filter();
                                                $min = $prices->min();
                                                $max = $prices->max();
                                            @endphp
                                            @if ($min == $max)
                                                RM {{ number_format($min, 2) }}
                                            @else
                                                <span
                                                    class="text-[10px] font-semibold text-gray-400 uppercase align-middle mr-1">From</span>
                                                RM {{ number_format($min, 2) }}
                                            @endif
                                        @else
                                            RM {{ number_format($product->price ?? 0, 2) }}
                                        @endif
                                    </p>

                                    {{-- Button --}}
                                    <a href="{{ route('shop.show', $product->slug) }}"
                                        class="w-full inline-flex items-center justify-center rounded-xl
                                               bg-white border border-black/[0.08]
                                               py-2.5 text-xs font-extrabold text-black/70
                                               hover:bg-[#D4AF37] hover:text-black hover:border-[#D4AF37]
                                               transition-all duration-300">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Desktop/Tablet Counter --}}
            <div class="hidden sm:flex justify-center mt-10">
                <div class="text-sm font-extrabold tracking-[0.25em] text-black/45">
                    <span data-po-desktop-current>1</span> / <span data-po-desktop-total>1</span>
                </div>
            </div>

            {{-- Mobile pager --}}
            <div class="mt-6 sm:hidden flex items-center justify-center gap-6 select-none" data-po-mobile-pager>
                <div class="mt-6 sm:hidden flex items-center justify-center gap-6 select-none" data-na-mobile-pager>
                    <button type="button"
                        class="w-9 h-9 rounded-full
           bg-black/80 text-white
           flex items-center justify-center
           shadow-md shadow-black/20
           transition-all duration-200
           hover:bg-black
           active:scale-95"
                        data-po-mobile-prev aria-label="Previous page">
                        <span class="text-lg font-bold">‹</span>
                    </button>

                    <div class="text-[11px] font-extrabold tracking-[0.25em] text-black/50">
                        <span data-po-mobile-current>1</span> / <span data-po-mobile-total>1</span>
                    </div>

                    <button type="button"
                        class="w-9 h-9 rounded-full
           bg-black/80 text-white
           flex items-center justify-center
           shadow-md shadow-black/20
           transition-all duration-200
           hover:bg-black
           active:scale-95"
                        data-po-mobile-next aria-label="Next page">
                        <span class="text-lg font-bold">›</span>
                    </button>

                </div>
            </div>

            {{-- ✅ Mobile CTA (button style) --}}
            {{-- <div class="mt-3 sm:hidden flex justify-center">
                <button type="button" onclick="window.location.href='{{ route('shop.index') }}'"
                    class="inline-flex items-center justify-center
               px-6 py-3
               rounded-xl
               bg-black text-white
               text-[11px] font-extrabold uppercase tracking-[0.25em]
               shadow-sm
               transition-all duration-300
               hover:bg-[#D4AF37] hover:text-black
               active:scale-95
               focus:outline-none">
                    View All Products
                </button>
            </div> --}}
        @else
            {{-- Empty --}}
            <div
                class="flex flex-col items-center justify-center border-2 border-dashed border-black/10
                       rounded-3xl bg-white/60 py-16 px-4">
                <div class="w-16 h-16 bg-black/5 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-black/20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
                <p class="text-black/50 font-medium text-center">
                    Popular picks will appear here once customers start exploring.
                </p>
                <a href="{{ route('shop.index') }}"
                    class="mt-4 text-sm font-extrabold text-[#8f6a10] underline underline-offset-4">
                    Browse products
                </a>
            </div>
        @endif

    </div>

    {{-- Pagination script --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const grid = document.querySelector('[data-po-grid]');
            if (!grid) return;

            const items = Array.from(grid.querySelectorAll('[data-po-item]'));

            // Desktop/Tablet controls
            const dPrev = document.querySelector('[data-po-desktop-prev]');
            const dNext = document.querySelector('[data-po-desktop-next]');
            const dCur = document.querySelector('[data-po-desktop-current]');
            const dTot = document.querySelector('[data-po-desktop-total]');

            // Mobile controls
            const mPager = document.querySelector('[data-po-mobile-pager]');
            const mPrev = document.querySelector('[data-po-mobile-prev]');
            const mNext = document.querySelector('[data-po-mobile-next]');
            const mCur = document.querySelector('[data-po-mobile-current]');
            const mTot = document.querySelector('[data-po-mobile-total]');

            const mqMobile = window.matchMedia('(max-width: 639px)'); // < sm
            const mqLgUp = window.matchMedia('(min-width: 1024px)'); // lg+

            let dPage = 1;
            let mPage = 1;

            function perPageDesktop() {
                // lg 显示 5 个；md/sm 显示 8 个（2 rows x 4）
                return mqLgUp.matches ? 5 : 8;
            }

            function renderDesktop() {
                if (mqMobile.matches) return;

                const per = perPageDesktop();
                const total = Math.max(1, Math.ceil(items.length / per));
                dPage = Math.min(dPage, total);

                const start = (dPage - 1) * per;
                const end = start + per;

                items.forEach((it, idx) => it.classList.toggle('hidden', !(idx >= start && idx < end)));

                if (dCur && dTot) {
                    dCur.textContent = String(dPage);
                    dTot.textContent = String(total);
                }

                if (dPrev && dNext) {
                    dPrev.disabled = dPage <= 1;
                    dNext.disabled = dPage >= total;
                    dPrev.classList.toggle('opacity-30', dPrev.disabled);
                    dNext.classList.toggle('opacity-30', dNext.disabled);
                }
            }

            function renderMobile() {
                if (!mqMobile.matches) {
                    if (mPager) mPager.classList.add('hidden');
                    return;
                }

                if (mPager) mPager.classList.remove('hidden');

                const per = 2; // mobile 每页 2 个
                const total = Math.max(1, Math.ceil(items.length / per));
                mPage = Math.min(mPage, total);

                const start = (mPage - 1) * per;
                const end = start + per;

                items.forEach((it, idx) => it.classList.toggle('hidden', !(idx >= start && idx < end)));

                if (mCur && mTot) {
                    mCur.textContent = String(mPage);
                    mTot.textContent = String(total);
                }

                if (mPrev && mNext) {
                    mPrev.disabled = mPage <= 1;
                    mNext.disabled = mPage >= total;
                    mPrev.classList.toggle('opacity-30', mPrev.disabled);
                    mNext.classList.toggle('opacity-30', mNext.disabled);
                }
            }

            function renderAll() {
                items.forEach(it => it.classList.remove('hidden'));

                if (mqMobile.matches) {
                    renderMobile();
                } else {
                    if (mPager) mPager.classList.add('hidden');
                    renderDesktop();
                }
            }

            if (dPrev) dPrev.addEventListener('click', () => {
                if (dPage > 1) {
                    dPage--;
                    renderAll();
                }
            });
            if (dNext) dNext.addEventListener('click', () => {
                const total = Math.max(1, Math.ceil(items.length / perPageDesktop()));
                if (dPage < total) {
                    dPage++;
                    renderAll();
                }
            });

            if (mPrev) mPrev.addEventListener('click', () => {
                if (mPage > 1) {
                    mPage--;
                    renderAll();
                }
            });
            if (mNext) mNext.addEventListener('click', () => {
                const per = 2;
                const total = Math.max(1, Math.ceil(items.length / per));
                if (mPage < total) {
                    mPage++;
                    renderAll();
                }
            });

            mqMobile.addEventListener?.('change', renderAll);
            mqLgUp.addEventListener?.('change', renderAll);
            window.addEventListener('resize', renderAll);

            renderAll();
        });
    </script>

</section>
