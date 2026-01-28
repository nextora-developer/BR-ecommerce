<x-app-layout>
    <div class="bg-[#F9F7F2] min-h-screen">
        <div class="max-w-7xl5 mx-auto px-4 sm:px-6 lg:px-8 py-6 lg:py-8">

            {{-- Header + 小标题 --}}
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-6">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-semibold text-gray-900">Shop</h1>
                    <p class="text-sm text-gray-500">
                        Browse Shop products and find what you need.
                    </p>
                </div>

                <div class="flex items-center gap-3">
                    {{-- Mobile Filter Button --}}
                    <button type="button" id="openFilters"
                        class="lg:hidden inline-flex items-center gap-2.5 rounded-2xl border border-[#D4AF37]/20 bg-white px-5 py-3 text-[11px] font-black uppercase tracking-widest text-[#8f6a10] shadow-[0_10px_20px_rgba(212,175,55,0.08)] active:scale-[0.96] transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M10.5 6h9m-9 6h9m-9 6h9M4.5 6h.01M4.5 12h.01M4.5 18h.01" />
                        </svg>
                        Filter
                    </button>

                    <div class="text-xs sm:text-sm text-gray-500">
                        Showing <span class="font-semibold text-gray-800">{{ $products->total() }}</span> items
                    </div>
                </div>
            </div>

            {{-- 3|7 Layout --}}
            <div class="grid grid-cols-1 lg:grid-cols-10 gap-6 lg:gap-8">

                {{-- ✅ LEFT: Filter Sidebar (Desktop only) --}}
                <aside class="hidden lg:block lg:col-span-2">
                    <div class="lg:sticky lg:top-24 max-h-[calc(100vh-7rem)] flex flex-col gap-5">

                        {{-- =========================
                            Search + Sort (Compact)
                            ========================= --}}
                        <div class="shrink-0">
                            <form method="GET" action="{{ route('shop.index') }}"
                                class="bg-white border border-black/[0.06] rounded-[2rem] p-5 shadow-[0_15px_40px_-15px_rgba(0,0,0,0.05)] transition-all duration-300 focus-within:shadow-[0_20px_50px_-10px_rgba(212,175,55,0.1)]">

                                <div class="flex items-center gap-3 mb-5">
                                    <div
                                        class="flex h-9 w-9 items-center justify-center rounded-2xl bg-[#D4AF37]/5 text-[#8f6a10]">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m21 21-4.35-4.35M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-[13px] font-bold text-gray-900 tracking-tight">Quick Filter</h3>
                                        <p class="text-[10px] text-gray-400 uppercase tracking-widest font-medium">
                                            Refine View</p>
                                    </div>
                                </div>

                                <div class="space-y-4">
                                    {{-- Sort Dropdown --}}
                                    <div>
                                        <label
                                            class="block text-[10px] uppercase tracking-[0.15em] text-gray-400 font-bold mb-2 ml-1">Order
                                            By</label>
                                        <select name="sort"
                                            class="w-full rounded-xl border-gray-100 bg-gray-50/50 px-4 py-2.5 text-xs font-medium text-gray-700 focus:bg-white focus:border-[#D4AF37] focus:ring-0 transition-all">
                                            <option value="">Default Selection</option>
                                            <option value="latest" @selected(request('sort') === 'latest')>Newest Arrivals</option>
                                            <option value="price_asc" @selected(request('sort') === 'price_asc')>Price: Low → High
                                            </option>
                                            <option value="price_desc" @selected(request('sort') === 'price_desc')>Price: High → Low
                                            </option>
                                        </select>
                                    </div>

                                    <input type="hidden" name="category" value="{{ request('category') }}">
                                    <input type="hidden" name="q" value="{{ request('q') }}">

                                    <div class="flex gap-2 pt-1">
                                        <button type="submit"
                                            class="flex-1 px-4 py-2.5 rounded-xl bg-[#D4AF37] text-white text-[11px] font-bold uppercase tracking-widest hover:bg-[#b8942f] transition-all duration-300 shadow-sm shadow-[#D4AF37]/30">
                                            Apply
                                        </button>
                                        <a href="{{ route('shop.index') }}"
                                            class="px-4 py-2.5 rounded-xl border border-gray-100 text-[11px] font-bold uppercase tracking-widest text-gray-400 hover:bg-gray-50 transition-all">
                                            Reset
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>

                        {{-- =========================
                            Categories (Independent Scroll)
                            ========================= --}}
                        <div class="flex-1 min-h-0 flex flex-col">
                            <div
                                class="bg-white border border-black/[0.06] rounded-[2rem] shadow-[0_15px_40px_-15px_rgba(0,0,0,0.05)] overflow-hidden flex flex-col h-full transition-all duration-300">

                                {{-- Fixed Header --}}
                                <div class="p-5 border-b border-gray-50 shrink-0 bg-white/80 backdrop-blur-md z-10">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex h-9 w-9 items-center justify-center rounded-2xl bg-[#D4AF37]/5 text-[#8f6a10]">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M4 6h16M4 12h16M4 18h16" />
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="text-[13px] font-bold text-gray-900 tracking-tight">Categories
                                            </h3>
                                            <p class="text-[10px] text-gray-400 uppercase tracking-widest font-medium">
                                                Browse Archive</p>
                                        </div>
                                    </div>
                                </div>

                                @php
                                    $activeCat = request('category');
                                    $baseQuery = ['q' => request('q'), 'sort' => request('sort')];
                                @endphp

                                {{-- Scrollable Content --}}
                                <div class="flex-1 overflow-y-auto custom-scrollbar p-4 space-y-2">
                                    {{-- All Products --}}
                                    <a href="{{ route('shop.index', array_filter($baseQuery)) }}"
                                        class="flex items-center justify-between rounded-xl px-4 py-3 transition-all duration-300 group
                                        {{ empty($activeCat) ? 'bg-[#D4AF37] text-white shadow-lg shadow-black/10' : 'text-gray-600 hover:bg-gray-50' }}">
                                        <div class="flex items-center gap-3">
                                            <span
                                                class="h-1.5 w-1.5 rounded-full {{ empty($activeCat) ? 'bg-white' : 'bg-gray-300 group-hover:bg-[#D4AF37]' }}"></span>
                                            <span class="text-xs font-bold uppercase tracking-wider">All Products</span>
                                        </div>
                                        <span
                                            class="text-[10px] font-black {{ empty($activeCat) ? 'text-white' : 'text-gray-300' }}">
                                            {{ $products->total() }}
                                        </span>
                                    </a>

                                    {{-- Tree Structure --}}
                                    @isset($categories)
                                        <div class="mt-4 space-y-1">
                                            @foreach ($categories as $parent)
                                                @php
                                                    $isParentActive = $activeCat === $parent->slug;
                                                    $isChildActiveUnderParent =
                                                        $parent->children?->contains(
                                                            fn($c) => $c->slug === $activeCat,
                                                        ) ?? false;
                                                    $open = $isParentActive || $isChildActiveUnderParent;
                                                @endphp

                                                <details class="group/parent" @if ($open) open @endif>
                                                    <summary
                                                        class="list-none cursor-pointer flex items-center justify-between rounded-xl px-4 py-3 transition-colors hover:bg-gray-50">
                                                        <div class="flex items-center gap-3 min-w-0">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="h-3 w-3 text-gray-300 transition-transform group-open/parent:rotate-90"
                                                                fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                                stroke-width="3">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M9 5l7 7-7 7" />
                                                            </svg>
                                                            <span
                                                                class="text-[13px] font-bold truncate {{ $isParentActive ? 'text-[#8f6a10]' : 'text-gray-700' }}">
                                                                {{ $parent->name }}
                                                            </span>
                                                        </div>
                                                        <span
                                                            class="text-[10px] font-bold text-gray-300 group-hover/parent:text-[#D4AF37]">
                                                            {{ $parent->products_count }}
                                                        </span>
                                                    </summary>

                                                    <div class="ml-7 mt-1 pl-3 border-l border-gray-100 space-y-1 pb-2">
                                                        {{-- Parent "View All" --}}
                                                        <a href="{{ route('shop.index', array_filter($baseQuery + ['category' => $parent->slug])) }}"
                                                            class="block text-[11px] font-bold py-2 px-3 rounded-lg transition-all {{ $isParentActive ? 'bg-[#D4AF37]/10 text-[#8f6a10]' : 'text-gray-400 hover:text-gray-900' }}">
                                                            View Entire Collection
                                                        </a>

                                                        @foreach ($parent->children as $child)
                                                            @php $isChildActive = ($activeCat === $child->slug); @endphp
                                                            <a href="{{ route('shop.index', array_filter($baseQuery + ['category' => $child->slug])) }}"
                                                                class="flex items-center justify-between px-3 py-2 rounded-lg text-[12px] transition-all
                                                                {{ $isChildActive ? 'text-[#8f6a10] font-bold' : 'text-gray-500 hover:text-black hover:bg-gray-50' }}">
                                                                <span class="truncate">{{ $child->name }}</span>
                                                                <span
                                                                    class="text-[9px] opacity-40">{{ $child->products_count }}</span>
                                                            </a>
                                                        @endforeach
                                                    </div>
                                                </details>
                                            @endforeach
                                        </div>
                                    @endisset
                                </div>
                            </div>
                        </div>

                    </div>
                </aside>

                {{-- ✅ RIGHT: Product Grid (7) --}}
                <section class="lg:col-span-8">

                    @if ($products->count())
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-4 gap-4 sm:gap-6">
                            @foreach ($products as $product)
                                <div
                                    class="group relative flex flex-col bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:border-[#D4AF37]/40 transition-all duration-500 overflow-hidden">

                                    <a href="{{ route('shop.show', $product->slug) }}"
                                        class="relative aspect-square overflow-hidden bg-gray-50">
                                        @if ($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}"
                                                alt="{{ $product->name }}" loading="lazy"
                                                class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700 ease-out">
                                        @else
                                            <div
                                                class="w-full h-full flex items-center justify-center bg-gray-50 text-[10px] uppercase tracking-widest text-gray-400">
                                                No Image Available
                                            </div>
                                        @endif

                                        <div
                                            class="absolute inset-0 bg-black/0 group-hover:bg-black/5 transition-colors duration-500">
                                        </div>
                                    </a>

                                    {{-- ❤️ Favorite Button --}}
                                    @auth
                                        @php
                                            $isFavorited = auth()
                                                ->user()
                                                ->favorites->contains('product_id', $product->id);
                                        @endphp
                                        <form
                                            action="{{ $isFavorited ? route('account.favorites.destroy', $product) : route('account.favorites.store', $product) }}"
                                            method="POST" class="absolute top-3 right-3 z-10"
                                            onclick="event.stopPropagation();">
                                            @csrf
                                            @if ($isFavorited)
                                                @method('DELETE')
                                            @endif

                                            <button type="submit"
                                                onclick="event.preventDefault(); event.stopPropagation(); this.closest('form').submit();"
                                                class="w-9 h-9 flex items-center justify-center rounded-full bg-white/90 backdrop-blur-sm text-[#8f6a10] shadow-sm hover:bg-white hover:scale-110 transition-all active:scale-95">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    fill="{{ $isFavorited ? '#D4AF37' : 'none' }}"
                                                    stroke="{{ $isFavorited ? '#D4AF37' : 'currentColor' }}"
                                                    stroke-width="1.8" viewBox="0 0 24 24" class="h-5 w-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                                                </svg>
                                            </button>
                                        </form>
                                    @endauth

                                    <div class="flex-1 flex flex-col p-4">
                                        <a href="{{ route('shop.show', $product->slug) }}"
                                            class="block flex-1 group/title">
                                            <p
                                                class="text-[10px] font-bold uppercase tracking-[0.2em] text-[#D4AF37] mb-1.5">
                                                {{ $product->category->name ?? 'General' }}
                                            </p>

                                            <h3
                                                class="text-sm font-semibold text-gray-900 line-clamp-2 group-hover/title:text-[#8f6a10] transition-colors leading-snug">
                                                {{ $product->name }}
                                            </h3>
                                        </a>

                                        <div class="mt-4 flex flex-col gap-3">
                                            <p class="text-base font-bold text-gray-900">
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
                                                            class="text-[10px] font-medium text-gray-400 uppercase align-middle mr-1">
                                                            From
                                                        </span>
                                                        RM {{ number_format($min, 2) }}
                                                    @endif
                                                @else
                                                    RM {{ number_format($product->price ?? 0, 2) }}
                                                @endif
                                            </p>

                                            <a href="{{ route('shop.show', $product->slug) }}"
                                                class="w-full inline-flex items-center justify-center rounded-xl bg-gray-50 border border-gray-200 py-2.5 text-xs font-bold text-gray-700 hover:bg-[#D4AF37] hover:text-white hover:border-[#D4AF37] transition-all duration-300">
                                                View Details
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-8">
                            {{ $products->withQueryString()->links() }}
                        </div>
                    @else
                        <div
                            class="mt-2 flex flex-col items-center justify-center border-2 border-dashed border-gray-200 rounded-3xl bg-white/50 py-16 px-4">
                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            </div>
                            <p class="text-gray-500 font-medium text-center">
                                No products found. Try adjusting your filters.
                            </p>
                            <a href="{{ route('shop.index') }}"
                                class="mt-4 text-sm font-bold text-[#8f6a10] underline underline-offset-4">
                                Back to shop
                            </a>
                        </div>
                    @endif

                </section>
            </div>

            {{-- ✅ Custom Scrollbar (works for desktop + mobile sheet) --}}
            <style>
                .custom-scrollbar::-webkit-scrollbar {
                    width: 4px;
                }

                .custom-scrollbar::-webkit-scrollbar-track {
                    background: transparent;
                }

                .custom-scrollbar::-webkit-scrollbar-thumb {
                    background: rgba(0, 0, 0, 0.05);
                    border-radius: 10px;
                }

                .custom-scrollbar:hover::-webkit-scrollbar-thumb {
                    background: rgba(212, 175, 55, 0.2);
                }
            </style>

            {{-- ✅ Mobile Filters Bottom Sheet --}}
            <div id="filterSheet" class="lg:hidden fixed inset-0 z-[60] hidden">
                {{-- Backdrop --}}
                <div id="filterBackdrop"
                    class="absolute inset-0 bg-black/40 backdrop-blur-[2px] opacity-0 transition-opacity duration-200">
                </div>

                {{-- Panel --}}
                <div id="filterPanel"
                    class="absolute bottom-0 left-0 right-0 translate-y-full transition-transform duration-300 ease-out">
                    <div
                        class="bg-[#F9F7F2] rounded-t-[2rem] border-t border-black/[0.08] shadow-[0_-25px_60px_-25px_rgba(0,0,0,0.35)]">
                        {{-- Top bar --}}
                        <div class="px-5 pt-4 pb-3 flex items-center justify-between">
                            <div>
                                <div class="text-lg font-semibold text-gray-900">Shop Filters</div>
                            </div>

                            <button type="button" id="closeFilters"
                                class="w-10 h-10 rounded-2xl bg-white border border-black/[0.06] flex items-center justify-center text-gray-700 active:scale-95">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        {{-- Content (scroll area) --}}
                        <div class="px-4 pb-5 max-h-[75vh] overflow-y-auto custom-scrollbar">
                            <div class="grid gap-4">

                                {{-- =========================
                                    Quick Filter (Mobile)
                                    ========================= --}}
                                <div class="shrink-0">
                                    <form method="GET" action="{{ route('shop.index') }}"
                                        class="bg-white border border-black/[0.06] rounded-[2rem] p-5 shadow-[0_15px_40px_-15px_rgba(0,0,0,0.05)] transition-all duration-300 focus-within:shadow-[0_20px_50px_-10px_rgba(212,175,55,0.1)]">

                                        <div class="flex items-center gap-3 mb-5">
                                            <div
                                                class="flex h-9 w-9 items-center justify-center rounded-2xl bg-[#D4AF37]/5 text-[#8f6a10]">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                    stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="m21 21-4.35-4.35M10.5 18a7.5 7.5 0 1 1 0-15 7.5 7.5 0 0 1 0 15z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <h3 class="text-[13px] font-bold text-gray-900 tracking-tight">Quick
                                                    Filter</h3>
                                            </div>
                                        </div>

                                        <div class="space-y-4">
                                            <div>
                                                <label
                                                    class="block text-[10px] uppercase tracking-[0.15em] text-gray-400 font-bold mb-2 ml-1">Order
                                                    By</label>
                                                <select name="sort"
                                                    class="w-full rounded-xl border-gray-100 bg-gray-50/50 px-4 py-2.5 text-xs font-medium text-gray-700 focus:bg-white focus:border-[#D4AF37] focus:ring-0 transition-all">
                                                    <option value="">Default Selection</option>
                                                    <option value="latest" @selected(request('sort') === 'latest')>Newest Arrivals
                                                    </option>
                                                    <option value="price_asc" @selected(request('sort') === 'price_asc')>Price: Low →
                                                        High</option>
                                                    <option value="price_desc" @selected(request('sort') === 'price_desc')>Price: High
                                                        → Low</option>
                                                </select>
                                            </div>

                                            <input type="hidden" name="category" value="{{ request('category') }}">
                                            <input type="hidden" name="q" value="{{ request('q') }}">

                                            <div class="flex gap-2 pt-1">
                                                <button type="submit"
                                                    class="flex-1 px-4 py-2.5 rounded-xl bg-[#D4AF37] text-white text-[11px] font-bold uppercase tracking-widest hover:bg-[#b8942f] transition-all duration-300 shadow-sm shadow-[#D4AF37]/30">
                                                    Apply
                                                </button>
                                                <a href="{{ route('shop.index') }}"
                                                    class="px-4 py-2.5 rounded-xl border border-gray-100 text-[11px] font-bold uppercase tracking-widest text-gray-400 hover:bg-gray-50 transition-all">
                                                    Reset
                                                </a>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                {{-- =========================
                                    Categories (Mobile)
                                    ========================= --}}
                                <div
                                    class="bg-white border border-black/[0.06] rounded-[2rem] shadow-[0_15px_40px_-15px_rgba(0,0,0,0.05)] overflow-hidden">
                                    <div class="p-5 border-b border-gray-50 bg-white/80 backdrop-blur-md">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="flex h-9 w-9 items-center justify-center rounded-2xl bg-[#D4AF37]/5 text-[#8f6a10]">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                    stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M4 6h16M4 12h16M4 18h16" />
                                                </svg>
                                            </div>
                                            <div>
                                                <h3 class="text-[13px] font-bold text-gray-900 tracking-tight">
                                                    Categories</h3>
                                                <p
                                                    class="text-[10px] text-gray-400 uppercase tracking-widest font-medium">
                                                    Browse Archive</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="p-4 space-y-2">
                                        <a href="{{ route('shop.index', array_filter($baseQuery)) }}"
                                            class="flex items-center justify-between rounded-xl px-4 py-3 transition-all duration-300 group
                                            {{ empty($activeCat) ? 'bg-[#D4AF37] text-white shadow-lg shadow-black/10' : 'text-gray-600 hover:bg-gray-50' }}">
                                            <div class="flex items-center gap-3">
                                                <span
                                                    class="h-1.5 w-1.5 rounded-full {{ empty($activeCat) ? 'bg-white' : 'bg-gray-300 group-hover:bg-[#D4AF37]' }}"></span>
                                                <span class="text-xs font-bold uppercase tracking-wider">All
                                                    Products</span>
                                            </div>
                                            <span
                                                class="text-[10px] font-black {{ empty($activeCat) ? 'text-white' : 'text-gray-300' }}">
                                                {{ $products->total() }}
                                            </span>
                                        </a>

                                        @isset($categories)
                                            <div class="mt-4 space-y-1">
                                                @foreach ($categories as $parent)
                                                    @php
                                                        $isParentActive = $activeCat === $parent->slug;
                                                        $isChildActiveUnderParent =
                                                            $parent->children?->contains(
                                                                fn($c) => $c->slug === $activeCat,
                                                            ) ?? false;
                                                        $open = $isParentActive || $isChildActiveUnderParent;
                                                    @endphp

                                                    <details class="group/parent"
                                                        @if ($open) open @endif>
                                                        <summary
                                                            class="list-none cursor-pointer flex items-center justify-between rounded-xl px-4 py-3 transition-colors hover:bg-gray-50">
                                                            <div class="flex items-center gap-3 min-w-0">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    class="h-3 w-3 text-gray-300 transition-transform group-open/parent:rotate-90"
                                                                    fill="none" viewBox="0 0 24 24"
                                                                    stroke="currentColor" stroke-width="3">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        d="M9 5l7 7-7 7" />
                                                                </svg>
                                                                <span
                                                                    class="text-[13px] font-bold truncate {{ $isParentActive ? 'text-[#8f6a10]' : 'text-gray-700' }}">
                                                                    {{ $parent->name }}
                                                                </span>
                                                            </div>
                                                            <span
                                                                class="text-[10px] font-bold text-gray-300 group-hover/parent:text-[#D4AF37]">
                                                                {{ $parent->products_count }}
                                                            </span>
                                                        </summary>

                                                        <div
                                                            class="ml-7 mt-1 pl-3 border-l border-gray-100 space-y-1 pb-2">
                                                            <a href="{{ route('shop.index', array_filter($baseQuery + ['category' => $parent->slug])) }}"
                                                                class="block text-[11px] font-bold py-2 px-3 rounded-lg transition-all {{ $isParentActive ? 'bg-[#D4AF37]/10 text-[#8f6a10]' : 'text-gray-400 hover:text-gray-900' }}">
                                                                View Entire Collection
                                                            </a>

                                                            @foreach ($parent->children as $child)
                                                                @php $isChildActive = ($activeCat === $child->slug); @endphp
                                                                <a href="{{ route('shop.index', array_filter($baseQuery + ['category' => $child->slug])) }}"
                                                                    class="flex items-center justify-between px-3 py-2 rounded-lg text-[12px] transition-all
                                                                    {{ $isChildActive ? 'text-[#8f6a10] font-bold' : 'text-gray-500 hover:text-black hover:bg-gray-50' }}">
                                                                    <span class="truncate">{{ $child->name }}</span>
                                                                    <span
                                                                        class="text-[9px] opacity-40">{{ $child->products_count }}</span>
                                                                </a>
                                                            @endforeach
                                                        </div>
                                                    </details>
                                                @endforeach
                                            </div>
                                        @endisset
                                    </div>
                                </div>
                            </div>

                            <div class="mt-5 grid grid-cols-2 gap-3">
                                <a href="{{ route('shop.index') }}"
                                    class="text-center rounded-2xl border border-black/[0.08] bg-white py-3 text-xs font-bold uppercase tracking-widest text-gray-600">
                                    Reset
                                </a>
                                <button type="button" id="applyAndClose"
                                    class="rounded-2xl bg-[#D4AF37] py-3 text-xs font-bold uppercase tracking-widest text-white shadow-sm shadow-[#D4AF37]/30 active:scale-[0.99]">
                                    Done
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ✅ Bottom Sheet JS --}}
            <script>
                (function() {
                    const sheet = document.getElementById('filterSheet');
                    const panel = document.getElementById('filterPanel');
                    const backdrop = document.getElementById('filterBackdrop');

                    const openBtn = document.getElementById('openFilters');
                    const closeBtn = document.getElementById('closeFilters');
                    const doneBtn = document.getElementById('applyAndClose');

                    if (!sheet || !panel || !backdrop || !openBtn) return;

                    function openSheet() {
                        sheet.classList.remove('hidden');
                        requestAnimationFrame(() => {
                            backdrop.classList.remove('opacity-0');
                            panel.classList.remove('translate-y-full');
                            document.documentElement.classList.add('overflow-hidden');
                        });
                    }

                    function closeSheet() {
                        backdrop.classList.add('opacity-0');
                        panel.classList.add('translate-y-full');
                        document.documentElement.classList.remove('overflow-hidden');
                        setTimeout(() => sheet.classList.add('hidden'), 220);
                    }

                    openBtn.addEventListener('click', openSheet);
                    backdrop.addEventListener('click', closeSheet);
                    closeBtn && closeBtn.addEventListener('click', closeSheet);
                    doneBtn && doneBtn.addEventListener('click', closeSheet);

                    document.addEventListener('keydown', (e) => {
                        if (e.key === 'Escape' && !sheet.classList.contains('hidden')) closeSheet();
                    });
                })();
            </script>

        </div>
    </div>
</x-app-layout>
