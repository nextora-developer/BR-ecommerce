<x-app-layout>
    <div class="bg-[#F9F7F2] min-h-screen">
        <div class="max-w-7xl5 mx-auto px-6 py-8 lg:py-10">

            {{-- Page Header --}}
            <div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div>
                    <h2 class="text-3xl md:text-4xl font-bold text-black">Available Vouchers</h2>
                    <p class="mt-2 text-sm text-black/45 max-w-xl">
                        Apply voucher codes at checkout to enjoy instant savings, exclusive rewards, and special offers
                        available for a limited time.
                    </p>
                </div>


                <form method="GET" action="{{ route('vouchers.index') }}" class="w-full md:w-[360px]">
                    <label class="block text-[11px] uppercase tracking-wide text-black/40 mb-2 font-bold">
                        Search
                    </label>

                    <div class="relative">
                        <input id="voucherSearch" name="q" value="{{ request('q') }}"
                            placeholder="Search by code or name..."
                            class="w-full rounded-2xl border border-black/5 bg-white/80 backdrop-blur
                   px-4 py-3 pr-20 text-sm text-black/70
                   focus:border-[#D4AF37]/60 focus:ring-[#D4AF37]/20 focus:outline-none">

                        {{-- Clear --}}
                        <button type="button" id="clearSearch"
                            class="absolute right-14 top-1/2 -translate-y-1/2
                   hidden text-[11px] font-black uppercase tracking-widest
                   text-black/30 hover:text-black transition">
                            Clear
                        </button>

                        {{-- Submit --}}
                        <button type="submit"
                            class="absolute right-2 top-1/2 -translate-y-1/2
                   px-3 py-1.5 rounded-xl bg-black text-white
                   text-xs font-bold hover:bg-black/90 transition">
                            Go
                        </button>
                    </div>
                </form>

            </div>

            {{-- ✅ Section Wrapper (改成你参考那段的 “Premium Ticket” 风格) --}}
            <section class="relative py-2 overflow-hidden">
                <div class="relative z-10 px-0 py-0">

                    @if ($vouchers->count())

                        {{-- ✅ Apply Voucher Steps --}}
                        <div
                            class="mb-12 rounded-[2rem] bg-white border border-black/[0.03] p-6 md:p-8 shadow-[0_8px_30px_rgb(0,0,0,0.02)]">
                            <div class="mb-8 text-center">
                                <h3 class="text-2xl font-black text-black">
                                    How to Apply Voucher
                                </h3>
                            </div>


                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 relative">

                                @foreach ([['1', 'Copy Code', 'Tap copy on any voucher ticket.'], ['2', 'Fill Cart', 'Add your favorite items to bag.'], ['3', 'Paste it', 'Find the voucher box at checkout.'], ['4', 'Activate', 'Tap apply & watch prices drop.']] as $step)
                                    <div
                                        class="relative group rounded-2xl border border-black/[0.04] bg-gray-50/30 p-5 hover:bg-white hover:border-[#D4AF37]/20 hover:shadow-xl hover:shadow-[#D4AF37]/5 transition-all duration-300">
                                        <div class="flex flex-col gap-4">
                                            {{-- Step Number with Glow --}}
                                            <div class="relative">
                                                <div
                                                    class="w-10 h-10 rounded-xl bg-white shadow-sm border border-black/[0.03] text-[#D4AF37] font-black flex items-center justify-center text-sm z-10 relative group-hover:bg-[#D4AF37] group-hover:text-white transition-colors duration-300">
                                                    {{ $step[0] }}
                                                </div>
                                                {{-- Decorative background number --}}
                                                <span
                                                    class="absolute -top-2 -left-1 text-4xl font-black text-black/[0.02] select-none group-hover:text-[#D4AF37]/5 transition-colors">{{ $step[0] }}</span>
                                            </div>

                                            <div class="space-y-1">
                                                <h4
                                                    class="text-sm font-bold text-black group-hover:text-[#8f6a10] transition-colors">
                                                    {{ $step[1] }}</h4>
                                                <p
                                                    class="text-[12px] leading-relaxed text-black/40 font-medium group-hover:text-black/60 transition-colors">
                                                    {{ $step[2] }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="grid grid-cols-1 xl:grid-cols-2 gap-10">
                            @foreach ($vouchers as $v)
                                @php
                                    $minSpend = !is_null($v->min_spend) ? number_format($v->min_spend, 0) : null;
                                    $startDate = !empty($v->starts_at)
                                        ? \Carbon\Carbon::parse($v->starts_at)->format('d M Y')
                                        : '';
                                    $endDate = !empty($v->expires_at)
                                        ? \Carbon\Carbon::parse($v->expires_at)->format('d M Y')
                                        : '';
                                @endphp

                                <div
                                    class="group relative flex flex-col sm:flex-row min-h-[260px] transition-all duration-500 hover:-translate-y-1">
                                    {{-- Left Side: Main Body --}}
                                    <div
                                        class="flex-1 bg-white p-8 sm:p-10 rounded-t-[2rem] sm:rounded-l-[2rem] sm:rounded-tr-none
                                               border border-black/[0.06] border-r-0 relative overflow-hidden">

                                        {{-- Decorative iteration --}}
                                        <div
                                            class="absolute -right-2 -bottom-6 text-[10rem] font-serif font-bold text-black/[0.03] select-none pointer-events-none">
                                            {{ $loop->iteration }}
                                        </div>

                                        <div class="relative z-10 flex flex-col h-full justify-between">
                                            <div>
                                                <div class="flex items-center gap-3 mb-6">
                                                    <span
                                                        class="text-[10px] uppercase tracking-[0.3em] font-black text-[#D4AF37]">
                                                        Available Reward
                                                    </span>
                                                    <div class="h-px w-8 bg-[#D4AF37]/30"></div>
                                                </div>

                                                <h3
                                                    class="text-3xl font-serif text-black mb-3 group-hover:text-[#8f6a10] transition-colors duration-300">
                                                    {{ $v->name ?? 'Curated Discount' }}
                                                </h3>

                                                <div class="space-y-2">
                                                    @if ($minSpend)
                                                        <p class="text-sm text-black/50 font-medium tracking-tight">
                                                            With any purchase above
                                                            <span
                                                                class="text-black font-bold border-b border-[#D4AF37]/40">
                                                                RM{{ $minSpend }}
                                                            </span>
                                                        </p>
                                                    @endif

                                                    @if (!empty($v->expires_at))
                                                        <p
                                                            class="text-xs text-black/40 uppercase tracking-[0.2em] font-bold flex items-center gap-2">
                                                            <span class="w-1 h-1 rounded-full bg-black/20"></span>
                                                            Valid until
                                                            {{ \Carbon\Carbon::parse($v->expires_at)->format('d M Y') }}
                                                        </p>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="mt-8 flex items-center gap-4">
                                                <a href="{{ route('shop.index') }}"
                                                    class="group/link flex items-center gap-2 text-sm font-black uppercase tracking-widest text-black">
                                                    <span>Explore Store</span>
                                                    <svg class="w-4 h-4 transition-transform group-hover/link:translate-x-1"
                                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Perforated Divider (跟参考那段一样) --}}
                                    <div
                                        class="relative w-full sm:w-16 h-10 sm:h-auto
                                               bg-white sm:bg-white
                                               border-y border-black/[0.06] sm:border-y sm:border-x-0
                                               flex items-center sm:flex-col sm:justify-between overflow-hidden">

                                        {{-- Notch A --}}
                                        <div
                                            class="absolute left-[-20px] top-1/2 -translate-y-1/2 sm:left-1/2 sm:top-[-20px] sm:-translate-x-1/2 sm:translate-y-0
                                                   w-10 h-10 rounded-full bg-[#F9F7F2] border border-black/[0.05]
                                                   shadow-[inset_0_-4px_6px_rgba(0,0,0,0.02)]">
                                        </div>

                                        {{-- dotted line --}}
                                        <div
                                            class="w-full h-px sm:w-px sm:h-full border-t-[3px] sm:border-t-0 sm:border-l-[3px] border-dotted border-black/10">
                                        </div>

                                        {{-- Notch B --}}
                                        <div
                                            class="absolute right-[-20px] top-1/2 -translate-y-1/2 sm:right-auto sm:left-1/2 sm:bottom-[-20px] sm:top-auto sm:-translate-x-1/2 sm:translate-y-0
                                                   w-10 h-10 rounded-full bg-[#F9F7F2] border border-black/[0.05]
                                                   shadow-[inset_0_4px_6px_rgba(0,0,0,0.02)]">
                                        </div>
                                    </div>

                                    {{-- Right Side: Dark Velvet Stub --}}
                                    <div
                                        class="w-full sm:w-[240px] bg-[#111] p-8 rounded-b-[2rem] sm:rounded-r-[2rem] sm:rounded-bl-none
                                               flex flex-col items-center justify-center relative overflow-hidden shadow-xl">

                                        {{-- Noise (建议换本地) --}}
                                        <div class="absolute inset-0 opacity-[0.15] pointer-events-none mix-blend-overlay"
                                            style="background-image:url('/images/noise/asfalt-dark.png');"></div>

                                        <div class="relative w-full text-center z-10">
                                            <p
                                                class="text-[9px] uppercase tracking-[0.4em] font-bold text-[#D4AF37] mb-5">
                                                Click to copy
                                            </p>

                                            <button type="button" data-copy-voucher="{{ $v->code }}"
                                                class="voucher-button group/btn w-full bg-white/10 border border-white/20 p-5 rounded-2xl
                                                       backdrop-blur-sm hover:bg-white/20 hover:border-[#D4AF37]/50 transition-all duration-300 active:scale-95 relative overflow-hidden">

                                                <span
                                                    class="block text-xl font-mono font-bold tracking-[0.2em] text-white group-hover/btn:scale-105 transition-transform">
                                                    {{ $v->code }}
                                                </span>

                                                {{-- Success Overlay --}}
                                                <div
                                                    class="copy-indicator absolute inset-0 bg-gradient-to-r from-[#D4AF37] to-[#B8860B]
                                                           flex items-center justify-center translate-y-full transition-transform duration-500">
                                                    <span
                                                        class="text-black text-[10px] font-black uppercase tracking-tighter">
                                                        Copied to Clipboard
                                                    </span>
                                                </div>
                                            </button>

                                            <button type="button"
                                                class="mt-6 text-[10px] font-bold text-white/40 hover:text-[#D4AF37]
                                                       uppercase tracking-[0.2em] transition-all flex items-center justify-center gap-2 mx-auto"
                                                data-open-terms="1" data-terms-title="{{ $v->name ?? 'Voucher' }}"
                                                data-terms-code="{{ $v->code }}"
                                                data-terms-min="{{ $minSpend ?? '' }}"
                                                data-terms-start="{{ $startDate }}"
                                                data-terms-end="{{ $endDate }}">
                                                <span>Terms & Conditions</span>
                                                <div class="w-1 h-1 rounded-full bg-[#D4AF37]"></div>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-10">
                            {{ $vouchers->links() }}
                        </div>
                    @else
                        <div
                            class="relative overflow-hidden rounded-3xl bg-white border border-gray-100 p-12 text-center shadow-sm">
                            {{-- Decorative Background Element --}}
                            <div
                                class="absolute -top-10 -right-10 w-32 h-32 bg-gray-50 rounded-full blur-3xl opacity-50">
                            </div>
                            <div
                                class="absolute -bottom-10 -left-10 w-32 h-32 bg-amber-50 rounded-full blur-3xl opacity-50">
                            </div>

                            <div class="relative z-10 flex flex-col items-center">
                                {{-- Icon --}}
                                <div
                                    class="mb-6 flex h-20 w-20 items-center justify-center rounded-2xl bg-gray-50 text-gray-300">
                                    <svg class="h-10 w-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 012-2h10a2 2 0 012 2v14a2 2 0 01-2 2H7a2 2 0 01-2-2V5z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M10 9l-2 2 2 2M14 9l2 2-2 2" />
                                    </svg>
                                </div>

                                {{-- Text Content --}}
                                <h3 class="text-lg font-bold text-gray-900">No vouchers available</h3>
                                <p class="mx-auto mt-2 max-w-xs text-sm text-gray-500 leading-relaxed">
                                    It looks like your voucher collection is empty at the moment. Check back later for
                                    exclusive rewards!
                                </p>

                                {{-- Action Button --}}
                                <a href="{{ route('shop.index') }}"
                                    class="mt-8 inline-flex items-center gap-2 rounded-full bg-gray-900 px-8 py-3 text-sm font-bold text-white transition-all hover:bg-gray-800 hover:shadow-lg active:scale-95">
                                    <span>Browse Products</span>
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </section>
        </div>

        {{-- ✅ Terms Modal (single instance) --}}
        <div id="termsModal" class="fixed inset-0 z-[999] hidden">
            {{-- overlay --}}
            <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" data-close-terms></div>

            {{-- panel --}}
            <div class="relative min-h-screen flex items-center justify-center p-4">
                <div class="w-full max-w-xl rounded-3xl bg-white shadow-2xl border border-black/10 overflow-hidden">
                    {{-- header --}}
                    <div class="px-6 py-5 border-b border-black/10 flex items-start justify-between gap-4">
                        <div class="min-w-0">
                            <p class="text-[11px] uppercase tracking-[0.28em] font-bold text-[#D4AF37]">
                                Voucher Details
                            </p>
                            <h3 id="termsTitle" class="mt-1 text-xl font-bold text-black truncate">
                                Terms & Conditions
                            </h3>
                            <p class="mt-1 text-xs text-black/50">
                                Code: <span id="termsCode" class="font-mono font-bold text-black/70"></span>
                            </p>
                        </div>

                        <button type="button"
                            class="shrink-0 w-10 h-10 rounded-full bg-black/5 hover:bg-black/10 transition flex items-center justify-center"
                            aria-label="Close" data-close-terms>
                            <svg class="w-5 h-5 text-black/60" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    {{-- body --}}
                    <div class="px-6 py-6 space-y-6">
                        <div>
                            <h4 class="text-sm font-extrabold text-black mb-3">Terms & Conditions</h4>
                            <ul id="termsList" class="space-y-2 text-sm text-black/60"></ul>
                        </div>

                        <div class="h-px bg-black/10"></div>

                        <div>
                            <h4 class="text-sm font-extrabold text-black mb-3">How to Use</h4>
                            <ol class="space-y-2 text-sm text-black/60 list-decimal list-inside">
                                <li>Copy the voucher code by clicking the button.</li>
                                <li>Add items to your cart and proceed to checkout.</li>
                                <li>Paste the code in the <span class="font-semibold text-black/70">"Voucher"</span>
                                    field.</li>
                                <li>Click <span class="font-semibold text-black/70">"Apply"</span> to enjoy your
                                    discount.</li>
                            </ol>
                        </div>
                    </div>

                    {{-- footer --}}
                    <div class="px-6 py-5 border-t border-black/10 flex flex-col sm:flex-row gap-3 sm:justify-end">
                        <a href="{{ route('shop.index') }}"
                            class="w-full sm:w-auto inline-flex items-center justify-center px-5 py-3 rounded-2xl
                                   bg-black text-white text-xs font-black uppercase tracking-widest hover:bg-black/90 transition">
                            Shop Now
                        </a>
                        <button type="button" data-close-terms
                            class="w-full sm:w-auto inline-flex items-center justify-center px-5 py-3 rounded-2xl
                                   bg-white border border-black/10 text-xs font-black uppercase tracking-widest hover:bg-black/5 transition">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- ✅ Scripts: 合并（copy + modal） --}}
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                // Copy voucher
                document.querySelectorAll('[data-copy-voucher]').forEach(btn => {
                    btn.addEventListener('click', async (e) => {
                        e.preventDefault();
                        e.stopPropagation();

                        const code = btn.getAttribute('data-copy-voucher');
                        const indicator = btn.querySelector('.copy-indicator');

                        const showCopied = () => {
                            if (!indicator) return;
                            indicator.classList.remove('translate-y-full');
                            btn.style.borderColor = '#D4AF37';
                            setTimeout(() => {
                                indicator.classList.add('translate-y-full');
                                btn.style.borderColor = '';
                            }, 1800);
                        };

                        try {
                            if (navigator.clipboard && window.isSecureContext) {
                                await navigator.clipboard.writeText(code);
                                showCopied();
                                return;
                            }

                            const ta = document.createElement('textarea');
                            ta.value = code;
                            ta.setAttribute('readonly', '');
                            ta.style.position = 'fixed';
                            ta.style.left = '-9999px';
                            document.body.appendChild(ta);
                            ta.select();
                            const ok = document.execCommand('copy');
                            document.body.removeChild(ta);

                            ok ? showCopied() : alert('Copy failed. Please copy manually: ' + code);
                        } catch (err) {
                            console.error(err);
                            alert('Copy failed. Please copy manually: ' + code);
                        }
                    }, true);
                });

                // Terms modal
                const modal = document.getElementById('termsModal');
                if (!modal) return;

                const titleEl = document.getElementById('termsTitle');
                const codeEl = document.getElementById('termsCode');
                const listEl = document.getElementById('termsList');

                const openModal = () => {
                    modal.classList.remove('hidden');
                    document.body.classList.add('overflow-hidden');
                };
                const closeModal = () => {
                    modal.classList.add('hidden');
                    document.body.classList.remove('overflow-hidden');
                };

                document.querySelectorAll('[data-open-terms]').forEach(btn => {
                    btn.addEventListener('click', (e) => {
                        e.preventDefault();
                        e.stopPropagation();

                        const tTitle = btn.getAttribute('data-terms-title') || 'Voucher';
                        const tCode = btn.getAttribute('data-terms-code') || '';
                        const tMin = btn.getAttribute('data-terms-min') || '';
                        const tStart = btn.getAttribute('data-terms-start') || '';
                        const tEnd = btn.getAttribute('data-terms-end') || '';

                        titleEl.textContent = tTitle;
                        codeEl.textContent = tCode;

                        const terms = [];
                        if (tMin) terms.push(`Minimum purchase required: RM ${tMin}`);
                        terms.push('Cannot be combined with other vouchers');

                        if (tStart && tEnd) terms.push(`Valid from ${tStart} to ${tEnd}`);
                        else if (tEnd) terms.push(`Valid until ${tEnd}`);

                        listEl.innerHTML = terms.map(line => `
                            <li class="flex items-start gap-3">
                                <span class="mt-2 w-1.5 h-1.5 rounded-full bg-[#D4AF37]"></span>
                                <span>${line}</span>
                            </li>
                        `).join('');

                        openModal();
                    }, true);
                });

                modal.querySelectorAll('[data-close-terms]').forEach(el => el.addEventListener('click', closeModal));
                document.addEventListener('keydown', (e) => {
                    if (e.key === 'Escape' && !modal.classList.contains('hidden')) closeModal();
                });
            });
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const input = document.getElementById('voucherSearch');
                const clearBtn = document.getElementById('clearSearch');

                if (!input || !clearBtn) return;

                const toggleClear = () => {
                    clearBtn.classList.toggle('hidden', !input.value);
                };

                toggleClear();

                input.addEventListener('input', toggleClear);

                clearBtn.addEventListener('click', () => {
                    input.value = '';
                    input.form.submit(); // 如果你不想自动 submit，这行删掉
                });
            });
        </script>

    </div>
</x-app-layout>
