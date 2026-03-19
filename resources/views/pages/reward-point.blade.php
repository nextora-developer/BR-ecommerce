<x-app-layout>
    <section class="bg-[#FAF9F6] min-h-screen pb-24 text-gray-900 selection:bg-[#D4AF37]/30">

        {{-- Header / Hero Section --}}
        <div class="relative bg-white overflow-hidden border-b border-gray-100">
            <div class="absolute top-[-10%] right-[-5%] w-[500px] h-[500px] bg-[#D4AF37]/5 rounded-full blur-[100px]">
            </div>
            <div class="absolute bottom-[-10%] left-[-5%] w-[300px] h-[300px] bg-[#D4AF37]/10 rounded-full blur-[80px]">
            </div>

            <div class="max-w-7xl mx-auto px-6 py-16 relative z-10">
                <div class="flex flex-col items-center text-center">
                    <span
                        class="inline-flex items-center gap-2 px-4 py-1 rounded-full bg-white border border-[#D4AF37]/30 text-[#8f6a10] text-[11px] font-bold uppercase tracking-[0.25em] mb-8 shadow-sm">
                        <span class="relative flex h-2 w-2">
                            <span
                                class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#D4AF37] opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-[#D4AF37]"></span>
                        </span>
                        Premium Rewards
                    </span>

                    <h1 class="text-5xl md:text-7xl font-black tracking-tight mb-8 leading-[1.1] text-gray-900">
                        Unlimited.<br>
                        <span
                            class="text-transparent bg-clip-text bg-gradient-to-r from-[#D4AF37] via-[#B8860B] to-[#D4AF37]">
                            1% Cashback.
                        </span>
                    </h1>

                    <p class="text-gray-500 max-w-2xl mx-auto text-lg md:text-xl leading-relaxed mb-10">
                        Experience a rewards system designed for simplicity. Earn 1% on every purchase with no caps, no
                        tiers, and no expiration dates.
                    </p>

                    <div class="flex flex-col sm:flex-row gap-4 w-full justify-center">
                        <a href="{{ route('shop.index') }}"
                            class="group relative px-8 py-4 bg-gray-900 text-white rounded-2xl font-bold overflow-hidden transition-all hover:pr-12">
                            <span class="relative z-10">Start Shopping</span>
                            <span
                                class="absolute right-4 top-1/2 -translate-y-1/2 opacity-0 group-hover:opacity-100 transition-all">→</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-6xl mx-auto px-6">
            {{-- Feature Grid --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 -mt-12 relative z-20">
                @php
                    $features = [
                        ['label' => 'Flat Cashback', 'value' => '1%', 'icon' => 'percent'],
                        ['label' => 'No Limit', 'value' => '∞', 'icon' => 'infinity'],
                        ['label' => 'No Expiry', 'value' => 'Lifetime', 'icon' => 'clock'],
                        ['label' => 'Start Anytime', 'value' => 'RM0', 'icon' => 'wallet'],
                    ];
                @endphp

                @foreach ($features as $f)
                    <div
                        class="bg-white/80 backdrop-blur-md p-8 rounded-3xl border border-white shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-[0_8px_30px_rgba(212,175,55,0.1)] transition-all duration-300 group">

                        {{-- ICON --}}
                        <div
                            class="w-12 h-12 mb-4 rounded-2xl bg-[#D4AF37]/10 flex items-center justify-center group-hover:scale-110 transition">
                            <i data-lucide="{{ $f['icon'] }}" class="w-5 h-5 text-[#D4AF37]"></i>
                        </div>

                        {{-- VALUE --}}
                        <div class="text-3xl font-black text-gray-900 group-hover:text-[#D4AF37] transition-colors">
                            {{ $f['value'] }}
                        </div>

                        {{-- LABEL --}}
                        <div class="text-sm font-bold uppercase tracking-widest text-gray-400 mt-1">
                            {{ $f['label'] }}
                        </div>
                    </div>
                @endforeach
            </div>


            {{-- Process Steps: The Narrative Journey --}}
            {{-- Section Title --}}
            <div class="max-w-3xl mx-auto px-6 pt-24 text-center">
                <span
                    class="inline-flex items-center gap-2 px-4 py-1 rounded-full bg-white border border-[#D4AF37]/20 text-[#8f6a10] text-[11px] font-bold uppercase tracking-[0.25em] mb-5 shadow-sm">
                    Cashback Journey
                </span>

                <h2 class="text-4xl md:text-5xl font-black tracking-tight text-gray-900 mb-4">
                    How <span class="text-[#D4AF37]">Cashback Works ?</span>
                </h2>

                <p class="text-gray-500 text-lg md:text-xl leading-relaxed max-w-2xl mx-auto">
                    A simple three-step experience designed to turn everyday shopping into long-term value.
                </p>
            </div>

            {{-- Steps Section --}}
            <div class="py-24 md:py-24 relative max-w-5xl mx-auto px-6">

                {{-- Vertical Center Line (Desktop) --}}
                <div
                    class="hidden md:block absolute left-1/2 top-0 bottom-0 w-px bg-gradient-to-b from-transparent via-gray-200 to-transparent -translate-x-1/2">
                </div>

                <div class="space-y-24 md:space-y-40">

                    {{-- Step 01 --}}
                    <div class="relative flex flex-col md:flex-row items-center gap-12 group">
                        <div class="md:w-1/2 md:text-right order-2 md:order-1">
                            <div
                                class="inline-flex px-3 py-1 rounded-lg bg-gray-50 text-[#D4AF37] text-[10px] font-bold uppercase tracking-widest mb-4 border border-gray-100">
                                Step One</div>
                            <h3 class="text-3xl font-black text-gray-900 mb-4 tracking-tight">Create Your Account</h3>
                            <p class="text-gray-500 text-lg leading-relaxed">
                                Join <span class="text-gray-900 font-bold">brif.my</span> and activate your rewards
                                wallet instantly.
                                Your account is ready to start earning from your very first purchase.
                            </p>
                        </div>

                        {{-- Center Orb --}}
                        <div class="relative z-10 order-1 md:order-2">
                            <div
                                class="w-16 h-16 rounded-full bg-white border-4 border-[#FAF9F6] shadow-xl flex items-center justify-center ring-1 ring-gray-100 transition-all duration-500 group-hover:scale-110 group-hover:ring-[#D4AF37]/30">
                                <span class="text-lg font-black text-gray-300 group-hover:text-[#D4AF37]">01</span>
                            </div>
                        </div>

                        <div class="md:w-1/2 order-3">
                            <div
                                class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm max-w-[280px] mx-auto md:mx-0 rotate-2 group-hover:rotate-0 transition-transform duration-500">
                                <div class="flex items-center gap-3 mb-3">
                                    <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center">
                                        <div class="w-2 h-2 rounded-full bg-green-500"></div>
                                    </div>
                                    <div class="h-2 w-24 bg-gray-100 rounded-full"></div>
                                </div>
                                <div class="space-y-2">
                                    <div class="h-2 w-full bg-gray-50 rounded-full"></div>
                                    <div class="h-2 w-2/3 bg-gray-50 rounded-full"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Step 02 --}}
                    <div class="relative flex flex-col md:flex-row items-center gap-12 group">
                        <div class="md:w-1/2 order-3 md:order-1 flex justify-end">
                            <div
                                class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm max-w-[280px] mx-auto md:mx-0 -rotate-2 group-hover:rotate-0 transition-transform duration-500">
                                <div class="flex justify-between items-center mb-4">
                                    <div class="w-10 h-10 bg-gray-50 rounded-lg"></div>
                                    <div class="text-[#D4AF37] font-bold text-xs">+ RM 12.50</div>
                                </div>
                                <div
                                    class="h-10 w-full bg-gray-900 rounded-xl flex items-center justify-center text-[10px] text-white font-bold tracking-widest uppercase">
                                    Checkout
                                </div>
                            </div>
                        </div>

                        {{-- Center Orb --}}
                        <div class="relative z-10 order-1 md:order-2">
                            <div
                                class="w-16 h-16 rounded-full bg-white border-4 border-[#FAF9F6] shadow-xl flex items-center justify-center ring-1 ring-gray-100 transition-all duration-500 group-hover:scale-110 group-hover:ring-[#D4AF37]/30">
                                <span class="text-lg font-black text-gray-300 group-hover:text-[#D4AF37]">02</span>
                            </div>
                        </div>

                        <div class="md:w-1/2 md:text-left order-2">
                            <div
                                class="inline-flex px-3 py-1 rounded-lg bg-gray-50 text-[#D4AF37] text-[10px] font-bold uppercase tracking-widest mb-4 border border-gray-100">
                                Step Two</div>
                            <h3 class="text-3xl font-black text-gray-900 mb-4 tracking-tight">Shop Like Normal</h3>
                            <p class="text-gray-500 text-lg leading-relaxed">
                                No extra steps. No activation needed. Simply shop the products you love and let the
                                system track your
                                <span class="text-gray-900 font-bold">1% cashback</span> automatically.
                            </p>
                        </div>
                    </div>

                    {{-- Step 03 --}}
                    <div class="relative flex flex-col md:flex-row items-center gap-12 group">
                        <div class="md:w-1/2 md:text-right order-2 md:order-1">
                            <div
                                class="inline-flex px-3 py-1 rounded-lg bg-[#D4AF37]/10 text-[#8f6a10] text-[10px] font-bold uppercase tracking-widest mb-4 border border-[#D4AF37]/20">
                                The Result</div>
                            <h3 class="text-3xl font-black text-gray-900 mb-4 tracking-tight">Earn Automatically</h3>
                            <p class="text-gray-500 text-lg leading-relaxed">
                                Once your order is completed, your cashback is credited instantly. No expiry, no limits
                                — use it anytime
                                or let it grow for future savings.
                            </p>
                        </div>

                        {{-- Center Orb --}}
                        <div class="relative z-10 order-1 md:order-2">
                            <div
                                class="w-20 h-20 rounded-full bg-gray-900 border-8 border-[#FAF9F6] shadow-2xl flex items-center justify-center transition-all duration-500 group-hover:scale-110">
                                <span class="text-xl font-black text-[#D4AF37]">03</span>
                            </div>
                        </div>

                        <div class="md:w-1/2 order-3">
                            <div
                                class="relative bg-gradient-to-br from-gray-900 to-black p-6 rounded-[2rem] shadow-2xl max-w-[280px] mx-auto md:mx-0 group-hover:-translate-y-2 transition-transform duration-500">
                                <div class="text-gray-400 text-[10px] uppercase font-bold tracking-widest mb-1">
                                    Available Rewards</div>
                                <div class="text-2xl font-black text-white">RM 240.85</div>
                                <div class="mt-4 flex justify-end">
                                    <div class="w-8 h-8 rounded-full bg-[#D4AF37] flex items-center justify-center">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            {{-- Transparent Math Section --}}
            <div class="bg-gray-900 rounded-[3rem] p-8 md:p-16 overflow-hidden relative mb-32">
                <div class="absolute top-0 right-0 w-64 h-64 bg-[#D4AF37] opacity-10 rounded-full blur-3xl"></div>

                <div class="grid lg:grid-cols-2 gap-16 items-center">
                    <div>
                        <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">Calculated to your <span
                                class="text-[#D4AF37]">advantage.</span></h2>
                        <p class="text-gray-400 mb-8 text-lg">No points conversion confusion. Every Ringgit spent
                            contributes directly to your next purchase.</p>

                        <div class="space-y-4">
                            <div class="flex items-center gap-4 text-white/80">
                                <div class="w-2 h-2 rounded-full bg-[#D4AF37]"></div>
                                <span>Real-time balance tracking</span>
                            </div>
                            <div class="flex items-center gap-4 text-white/80">
                                <div class="w-2 h-2 rounded-full bg-[#D4AF37]"></div>
                                <span>Redeemable on any future order</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-3xl p-8 space-y-6">
                        @foreach ([100 => 1, 1000 => 10, 5000 => 50] as $spend => $earn)
                            <div class="flex justify-between items-center group">
                                <div>
                                    <div class="text-xs text-gray-500 uppercase font-bold tracking-tighter">If you
                                        spend
                                    </div>
                                    <div class="text-xl font-bold text-white">RM{{ number_format($spend) }}</div>
                                </div>
                                <div class="h-px flex-grow mx-4 border-t border-dashed border-white/20"></div>
                                <div class="text-right">
                                    <div class="text-xs text-[#D4AF37] uppercase font-bold tracking-tighter">You earn
                                    </div>
                                    <div class="text-xl font-bold text-[#D4AF37]">RM{{ number_format($earn) }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- FAQ Section --}}
            <div class="max-w-5xl mx-auto px-6 mb-32">
                <div class="text-center mb-14">
                    <span
                        class="inline-flex items-center gap-2 px-4 py-1 rounded-full bg-white border border-[#D4AF37]/20 text-[#8f6a10] text-[11px] font-bold uppercase tracking-[0.25em] mb-5 shadow-sm">
                        Common Questions
                    </span>

                    <h2 class="text-4xl md:text-5xl font-black tracking-tight text-gray-900 mb-4">
                        Frequently Asked <span class="text-[#D4AF37]">Questions</span>
                    </h2>

                    <p class="text-gray-500 text-lg max-w-2xl mx-auto leading-relaxed">
                        Everything you need to know about how cashback works, when rewards are credited,
                        and how you can use them on future purchases.
                    </p>
                </div>

                <div class="space-y-4" x-data="{ open: 1 }">
                    {{-- Item 1 --}}
                    <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm overflow-hidden">
                        <button type="button" @click="open = open === 1 ? null : 1"
                            class="w-full flex items-center justify-between gap-6 px-6 md:px-8 py-6 text-left">
                            <div>
                                <h3 class="text-base md:text-lg font-black text-gray-900">
                                    How does the 1% cashback work?
                                </h3>
                                <p class="text-sm text-gray-400 mt-1">
                                    A simple and transparent rewards system.
                                </p>
                            </div>

                            <div class="w-10 h-10 rounded-2xl bg-[#D4AF37]/10 text-[#8f6a10] flex items-center justify-center shrink-0 transition-transform duration-300"
                                :class="open === 1 ? 'rotate-45' : ''">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M12 5v14M5 12h14" />
                                </svg>
                            </div>
                        </button>

                        <div x-show="open === 1" x-collapse class="px-6 md:px-8 pb-6">
                            <p class="text-gray-500 leading-relaxed">
                                Every eligible completed purchase earns you <span class="font-bold text-gray-900">1%
                                    cashback</span>.
                                For example, if you spend RM100, you earn RM1 in rewards value. The more you shop, the
                                more you accumulate.
                            </p>
                        </div>
                    </div>

                    {{-- Item 2 --}}
                    <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm overflow-hidden">
                        <button type="button" @click="open = open === 2 ? null : 2"
                            class="w-full flex items-center justify-between gap-6 px-6 md:px-8 py-6 text-left">
                            <div>
                                <h3 class="text-base md:text-lg font-black text-gray-900">
                                    When will my cashback be credited?
                                </h3>
                                <p class="text-sm text-gray-400 mt-1">
                                    Rewards are added after your order is completed.
                                </p>
                            </div>

                            <div class="w-10 h-10 rounded-2xl bg-[#D4AF37]/10 text-[#8f6a10] flex items-center justify-center shrink-0 transition-transform duration-300"
                                :class="open === 2 ? 'rotate-45' : ''">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M12 5v14M5 12h14" />
                                </svg>
                            </div>
                        </button>

                        <div x-show="open === 2" x-collapse class="px-6 md:px-8 pb-6">
                            <p class="text-gray-500 leading-relaxed">
                                Cashback is credited once your order has been successfully completed.
                                This ensures only valid and fulfilled purchases are included in the rewards calculation.
                            </p>
                        </div>
                    </div>

                    {{-- Item 3 --}}
                    <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm overflow-hidden">
                        <button type="button" @click="open = open === 3 ? null : 3"
                            class="w-full flex items-center justify-between gap-6 px-6 md:px-8 py-6 text-left">
                            <div>
                                <h3 class="text-base md:text-lg font-black text-gray-900">
                                    Do my rewards expire?
                                </h3>
                                <p class="text-sm text-gray-400 mt-1">
                                    Your rewards are designed for long-term value.
                                </p>
                            </div>

                            <div class="w-10 h-10 rounded-2xl bg-[#D4AF37]/10 text-[#8f6a10] flex items-center justify-center shrink-0 transition-transform duration-300"
                                :class="open === 3 ? 'rotate-45' : ''">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M12 5v14M5 12h14" />
                                </svg>
                            </div>
                        </button>

                        <div x-show="open === 3" x-collapse class="px-6 md:px-8 pb-6">
                            <p class="text-gray-500 leading-relaxed">
                                No. Your cashback does not expire, so you can keep it for your next order or save it for
                                a bigger purchase later.
                            </p>
                        </div>
                    </div>

                    {{-- Item 4 --}}
                    <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm overflow-hidden">
                        <button type="button" @click="open = open === 4 ? null : 4"
                            class="w-full flex items-center justify-between gap-6 px-6 md:px-8 py-6 text-left">
                            <div>
                                <h3 class="text-base md:text-lg font-black text-gray-900">
                                    Is there any minimum spending requirement?
                                </h3>
                                <p class="text-sm text-gray-400 mt-1">
                                    Start earning from your very first eligible order.
                                </p>
                            </div>

                            <div class="w-10 h-10 rounded-2xl bg-[#D4AF37]/10 text-[#8f6a10] flex items-center justify-center shrink-0 transition-transform duration-300"
                                :class="open === 4 ? 'rotate-45' : ''">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M12 5v14M5 12h14" />
                                </svg>
                            </div>
                        </button>

                        <div x-show="open === 4" x-collapse class="px-6 md:px-8 pb-6">
                            <p class="text-gray-500 leading-relaxed">
                                There is no minimum spending requirement to join the program.
                                Any eligible completed order can start earning cashback for your account.
                            </p>
                        </div>
                    </div>

                    {{-- Item 5 --}}
                    <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm overflow-hidden">
                        <button type="button" @click="open = open === 5 ? null : 5"
                            class="w-full flex items-center justify-between gap-6 px-6 md:px-8 py-6 text-left">
                            <div>
                                <h3 class="text-base md:text-lg font-black text-gray-900">
                                    Can I transfer my cashback to a friend or bank account?
                                </h3>
                                <p class="text-sm text-gray-400 mt-1">
                                    Cashback is designed for use within your account.
                                </p>
                            </div>

                            <div class="w-10 h-10 rounded-2xl bg-[#D4AF37]/10 text-[#8f6a10] flex items-center justify-center shrink-0 transition-transform duration-300"
                                :class="open === 5 ? 'rotate-45' : ''">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M12 5v14M5 12h14" />
                                </svg>
                            </div>
                        </button>

                        <div x-show="open === 5" x-collapse class="px-6 md:px-8 pb-6">
                            <p class="text-gray-500 leading-relaxed">
                                Cashback is tied to your account and cannot be transferred or withdrawn to a bank
                                account.
                                It is designed to be used within the platform for future purchases, helping you maximize
                                long-term value.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Final CTA Container --}}
        <div class="relative max-w-6xl mx-auto px-6">
            <div
                class="relative bg-white border border-gray-100 rounded-[3rem] p-12 md:p-20 shadow-[0_20px_50px_rgba(0,0,0,0.02)] overflow-hidden text-center">

                {{-- Subtle Background Pattern (Optional) --}}
                <div class="absolute top-0 left-0 w-full h-full opacity-[0.03] pointer-events-none"
                    style="background-image: radial-gradient(#D4AF37 1px, transparent 1px); background-size: 24px 24px;">
                </div>
                <div class="absolute -bottom-24 -right-24 w-64 h-64 bg-[#D4AF37]/10 rounded-full blur-3xl"></div>

                <div class="relative z-10">
                    {{-- Social Proof Mini-Element --}}
                    <div class="flex items-center justify-center -space-x-2 mb-8">
                        @foreach ([1, 2, 3, 4] as $i)
                            <img class="w-10 h-10 rounded-full border-2 border-white object-cover"
                                src="https://i.pravatar.cc/100?img={{ $i + 10 }}" alt="User">
                        @endforeach
                        <div
                            class="flex items-center justify-center w-10 h-10 rounded-full border-2 border-white bg-gray-50 text-[10px] font-bold text-gray-400">
                            +1k
                        </div>
                    </div>

                    <h2 class="text-4xl md:text-5xl font-black mb-6 tracking-tight text-gray-900">
                        Ready to upgrade your <span class="text-[#D4AF37]">shopping?</span>
                    </h2>

                    <p class="text-gray-500 mb-12 text-lg md:text-xl max-w-2xl mx-auto leading-relaxed">
                        Join thousands of customers who are already earning while they spend. Your rewards wallet is
                        ready and waiting.
                    </p>

                    <div class="flex flex-col sm:flex-row items-center justify-center gap-5">
                        <a href="{{ route('shop.index') }}"
                            class="group w-full sm:w-auto px-10 py-5 bg-gray-900 text-white rounded-2xl font-bold transition-all duration-300 hover:bg-black hover:scale-[1.02] hover:shadow-2xl active:scale-95 flex items-center justify-center gap-2">
                            Start Shopping
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 group-hover:translate-x-1 transition-transform" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>

                        <a href="{{ route('account.index') }}"
                            class="w-full sm:w-auto px-10 py-5 bg-white border border-gray-200 text-gray-700 rounded-2xl font-bold transition-all hover:bg-gray-50 hover:border-gray-300 flex items-center justify-center">
                            Check My Balance
                        </a>
                    </div>

                    {{-- Trust Badge --}}
                    <p class="mt-8 text-xs font-bold text-gray-400 uppercase tracking-[0.2em]">
                        No credit card required to join
                    </p>
                </div>
            </div>
        </div>
        </div>
    </section>

    <script>
        lucide.createIcons();
    </script>
</x-app-layout>
