<x-app-layout>
    <section class="bg-[#FAF9F6] min-h-screen py-12 md:py-20">
        <div class="max-w-5xl mx-auto px-4">

            {{-- Header --}}
            <div class="text-center mb-12">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-[#D4AF37]/10 rounded-full mb-4">
                    <svg class="w-8 h-8 text-[#D4AF37]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                    </svg>
                </div>
                <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight">Agent Verification</h1>
                <p class="text-base text-gray-500 mt-3 max-w-md mx-auto">
                    Protect yourself from fraud. Verify the identity and authorization status of our representatives
                    instantly.
                </p>
            </div>

            {{-- Search Bar --}}
            <div class="relative group mb-10">
                <form method="GET"
                    class="relative z-10 flex items-center bg-white rounded-2xl shadow-xl shadow-gray-200/50 border border-gray-100 p-2 focus-within:ring-4 focus-within:ring-[#D4AF37]/10 transition-all">
                    <div class="pl-4 text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input name="q" value="{{ $q }}"
                        placeholder="Enter Agent ID / Name / Phone Number..."
                        class="flex-1 border-none focus:ring-0 text-gray-900 font-medium placeholder:text-gray-400 px-4 py-3 bg-transparent">
                    <button
                        class="bg-black text-[#D4AF37] px-8 py-3 rounded-xl font-bold text-sm hover:bg-gray-900 transition-all active:scale-95">
                        Verify Now
                    </button>
                </form>
            </div>

            {{-- Results Section --}}
            @if ($q !== '')
                <div class="animate-in fade-in slide-in-from-bottom-4 duration-500">
                    @if ($agent)
                        @php
                            $isActive = $agent->status === 'active';
                            $isSuspended = $agent->status === 'suspended';
                            $isInactive = $agent->status === 'inactive';
                        @endphp

                        <div
                            class="bg-white rounded-3xl border
                    {{ $isActive ? 'border-emerald-100' : ($isSuspended ? 'border-red-100' : 'border-gray-200') }}
                    shadow-sm overflow-hidden mb-8">

                            {{-- Status Banner --}}
                            <div
                                class="{{ $isActive ? 'bg-emerald-500' : ($isSuspended ? 'bg-red-600' : 'bg-gray-600') }}
                        px-6 py-3 flex items-center justify-between text-white">

                                <span class="text-xs font-black uppercase tracking-[0.2em]">
                                    Official Verification Result
                                </span>

                                <div class="flex items-center gap-3">
                                    <span class="flex items-center gap-1.5 text-xs font-bold uppercase tracking-wider">
                                        <span class="w-2 h-2 bg-white rounded-full animate-pulse"></span>
                                        System Verified
                                    </span>

                                    <a href="{{ route('agents.verify.pdf', ['q' => $q]) }}"  target="_blank"
                                        class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg bg-white/10
                                  border border-white/20 text-white text-xs font-black uppercase tracking-wider
                                  hover:bg-white/15 transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 16v-8m0 8l-3-3m3 3l3-3M4 20h16" />
                                        </svg>
                                        PDF
                                    </a>
                                </div>
                            </div>

                            <div class="p-8 md:p-10">
                                <div class="flex flex-col md:flex-row justify-between md:items-center gap-6">
                                    <div class="space-y-1">
                                        <h2 class="text-3xl font-bold text-gray-900 leading-tight">
                                            {{ $agent->name }}
                                        </h2>
                                        <p class="text-[#D4AF37] font-bold tracking-widest text-base uppercase">
                                            {{ $agent->agent_code }}
                                        </p>
                                    </div>

                                    {{-- Status Badge --}}
                                    <div
                                        class="px-6 py-2 rounded-full border-2
                                {{ $isActive
                                    ? 'border-emerald-500 text-emerald-600 bg-emerald-50'
                                    : ($isSuspended
                                        ? 'border-red-500 text-red-600 bg-red-50'
                                        : 'border-gray-400 text-gray-600 bg-gray-50') }}
                                font-black uppercase tracking-tighter text-xl">
                                        {{ $agent->status }}
                                    </div>
                                </div>

                                {{-- Details --}}
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-10">
                                    <div>
                                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">
                                            Official Role
                                        </p>
                                        <p class="text-base font-bold text-gray-800">{{ $agent->role }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">
                                            Verified Region
                                        </p>
                                        <p class="text-base font-bold text-gray-800">
                                            {{ $agent->region ?? 'Not Specified' }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">
                                            Contact No.
                                        </p>
                                        <p class="text-base font-bold text-gray-800">{{ $agent->phone }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">
                                            Last Update
                                        </p>
                                        <p class="text-base font-bold text-gray-800">
                                            {{ $agent->updated_at?->format('d M Y') }}
                                        </p>
                                    </div>
                                </div>

                                {{-- Alerts --}}
                                @if ($isSuspended)
                                    <div
                                        class="mt-8 p-4 bg-red-50 rounded-xl border border-red-100 flex items-start gap-3">
                                        <svg class="w-5 h-5 text-red-600 mt-0.5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4
                                         c-.77-1.333-2.694-1.333-3.464 0L3.34 16
                                         c-.77 1.333.192 3 1.732 3z" />
                                        </svg>
                                        <p class="text-base text-red-800 font-medium leading-relaxed">
                                            <strong>Safety Alert:</strong>
                                            This representative's authorization has been revoked.
                                            Do not conduct business or share sensitive information.
                                        </p>
                                    </div>
                                @endif

                                @if ($isInactive)
                                    <div
                                        class="mt-8 p-4 bg-gray-50 rounded-xl border border-gray-200 flex items-start gap-3">
                                        <svg class="w-5 h-5 text-gray-500 mt-0.5" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 3
                                         C7.03 3 3 7.03 3 12s4.03 9 9 9
                                         9-4.03 9-9-4.03-9-9-9z" />
                                        </svg>
                                        <p class="text-base text-gray-700 font-medium leading-relaxed">
                                            <strong>Notice:</strong>
                                            This individual is no longer an active representative of the company.
                                        </p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @else
                        {{-- No Result --}}
                        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-12 text-center">
                            <h3 class="text-xl font-bold text-gray-900">Agent Not Found</h3>
                            <p class="text-gray-500 mt-2 text-sm max-w-xs mx-auto">
                                No agent matched
                                <span class="text-black font-semibold">{{ $q }}</span>.
                                Please verify the information provided.
                            </p>
                        </div>
                    @endif
                </div>
            @endif


            {{-- Guidelines Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-12">
                {{-- Status Meanings --}}
                <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm">
                    <h3
                        class="font-extrabold text-gray-900 uppercase tracking-widest text-sm mb-6 flex items-center gap-2">
                        <span class="w-1 h-4 bg-[#D4AF37] rounded-full"></span>
                        Status Definitions
                    </h3>

                    <div class="space-y-4">

                        {{-- Active --}}
                        <div class="flex gap-4">
                            <div class="w-2 h-2 rounded-full bg-emerald-500 mt-1.5 shrink-0"></div>
                            <div>
                                <p class="text-base font-bold text-gray-800">Active</p>
                                <p class="text-sm text-gray-500">
                                    <span class="font-bold">Officially authorised.</span> Proceed only via official
                                    channels.
                                </p>
                            </div>
                        </div>

                        {{-- Suspended --}}
                        <div class="flex gap-4">
                            <div class="w-2 h-2 rounded-full bg-red-500 mt-1.5 shrink-0"></div>
                            <div>
                                <p class="text-base font-bold text-gray-800">Suspended</p>
                                <p class="text-sm text-gray-500">
                                    <span class="font-bold">Not allowed to transaction.</span> Do not pay. Report to
                                    support.
                                </p>
                            </div>
                        </div>

                        {{-- Inactive --}}
                        <div class="flex gap-4">
                            <div class="w-2 h-2 rounded-full bg-gray-400 mt-1.5 shrink-0"></div>
                            <div>
                                <p class="text-base font-bold text-gray-800">Inactive</p>
                                <p class="text-sm text-gray-500">
                                    <span class="font-bold">Unverified.</span> Treat as suspicious. Do not pay. Contact
                                    support.
                                </p>
                            </div>
                        </div>

                    </div>
                </div>


                {{-- Security Checklist --}}
                <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-sm">
                    <h3
                        class="font-extrabold text-gray-900 uppercase tracking-widest text-sm mb-6 flex items-center gap-2">
                        <span class="w-1 h-4 bg-red-500 rounded-full"></span>
                        Security Checklist
                    </h3>
                    <ul class="space-y-3">
                        <li class="flex items-center gap-3 text-base text-gray-600">
                            <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Never share OTP, bank login, TAC, or remote access.
                        </li>
                        <li class="flex items-center gap-3 text-base text-gray-600">
                            <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Always verify agent status is Active.
                        </li>
                        <li class="flex items-center gap-3 text-base text-gray-600">
                            <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            Only pay to the official business account / official checkout methods.
                        </li>
                        <li class="flex items-center gap-3 text-base text-gray-600">
                            <svg class="w-4 h-4 text-emerald-500 shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                            When unsure, submit a report below.
                        </li>
                    </ul>
                </div>
            </div>

            {{-- Official Contact & Payment Safety --}}
            <div class="mt-12 bg-white rounded-[2rem] border border-gray-100 shadow-sm overflow-hidden">
                {{-- Header --}}
                <div class="px-8 pt-10 pb-8 text-center md:text-left">
                    <h3 class="text-xl md:text-2xl font-black text-gray-900 tracking-tight">
                        Official Contact <span class="text-[#D4AF37]">&</span> Payment Safety
                    </h3>
                    <p class="text-sm text-gray-500 mt-3 max-w-2xl leading-relaxed">
                        Protect your transactions. Only communicate through these verified touchpoints and ensure all
                        payments match our registered business name.
                    </p>
                </div>

                {{-- Cards Grid --}}
                <div class="px-8 pb-10">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                        {{-- Official WhatsApp --}}
                        <div
                            class="group rounded-2xl border border-gray-100 bg-gray-50/50 p-6 transition-all hover:bg-white hover:shadow-md">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="p-2 bg-emerald-100 rounded-lg text-emerald-600">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.246 2.248 3.484 5.232 3.484 8.412-.003 6.557-5.338 11.892-11.893 11.892-1.997-.001-3.951-.5-5.688-1.448l-6.309 1.656zm6.224-3.669c1.55.921 3.404 1.408 5.293 1.409 5.73 0 10.391-4.661 10.393-10.392 0-2.778-1.082-5.39-3.048-7.354-1.966-1.967-4.577-3.049-7.355-3.05-5.732 0-10.393 4.661-10.393 10.392 0 2.056.541 4.062 1.566 5.825l-1.023 3.732 3.828-1.003z" />
                                    </svg>
                                </div>
                                <span class="text-xs font-black uppercase tracking-widest text-gray-400">Support
                                    Line</span>
                            </div>
                            <div class="text-xl font-bold text-gray-900">012 345 6789</div>
                            <p class="mt-2 text-sm text-gray-500 font-medium">Verified WhatsApp for support & agent
                                verification identity.</p>
                        </div>

                        {{-- Official Email --}}
                        <div
                            class="group rounded-2xl border border-gray-100 bg-gray-50/50 p-6 transition-all hover:bg-white hover:shadow-md">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="p-2 bg-blue-100 rounded-lg text-blue-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <span class="text-xs font-black uppercase tracking-widest text-gray-400">Email
                                    Inquiry</span>
                            </div>
                            <div class="text-xl font-bold text-gray-900 break-all">cs@brinnovatefuture.com</div>
                            <p class="mt-2 text-sm text-gray-500 font-medium">Official correspondence channel for
                                formal queries.</p>
                        </div>

                        {{-- Official Business Account - Highlighted --}}
                        <div
                            class="md:col-span-1 rounded-2xl border-2 border-[#D4AF37]/30 bg-white p-6 shadow-lg shadow-[#D4AF37]/5 relative">
                            <div
                                class="absolute top-4 right-4 uppercase text-[10px] font-black bg-[#D4AF37] text-black px-2 py-1 rounded">
                                Official</div>
                            <div class="flex items-center gap-3 mb-4 text-[#D4AF37]">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                <span class="text-xs font-black uppercase tracking-widest">Payment Destination</span>
                            </div>
                            <div class="space-y-1">
                                <div class="text-lg font-medium text-gray-500 mb-5">Maybank</div>

                                <div class="text-lg font-black text-gray-900 uppercase">BR INNOVATE FUTURE SDN. BHD.
                                </div>

                                <div class="text-2xl font-mono font-bold text-gray-900 tracking-tighter mt-5">
                                    514280900032</div>
                            </div>
                        </div>

                        {{-- Safe Payment Rule - Warning Style --}}
                        <div class="md:col-span-1 rounded-2xl bg-gray-900 p-6 text-white shadow-xl">
                            <div class="flex items-center gap-3 mb-4 text-red-400">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m0-8V3m0 0l-3 3m3-3l3 3M6.75 6.75l-4.5 4.5m0 0l4.5 4.5m-4.5-4.5h18M18 12h.008v.008H18V12z" />
                                </svg>
                                <span class="text-xs font-black uppercase tracking-widest">Security Protocol</span>
                            </div>
                            <div class="text-lg font-bold mb-2">Zero-Trust Rules</div>
                            <ul class="space-y-2">
                                <li class="flex items-center gap-2 text-sm font-bold text-red-400">
                                    <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span> NO OTP Requests
                                </li>
                                <li class="flex items-center gap-2 text-sm font-bold text-red-400">
                                    <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span> NO Remote Access
                                </li>
                                <li class="flex items-center gap-2 text-sm font-bold text-red-400">
                                    <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span> NO "Urgent" Cash Requests
                                </li>
                            </ul>
                            <p class="mt-4 text-sm text-gray-400 leading-tight">
                                If an agent creates pressure to pay quickly, stop and verify via our WhatsApp
                                immediately.
                            </p>
                        </div>

                    </div>

                    <div class="mt-8 flex items-center justify-between border-t border-gray-100 pt-6">
                        <p class="text-[10px] text-gray-400 font-bold uppercase tracking-[0.2em]">
                            Verified Security Data &bull; Last updated: Jan 2026
                        </p>
                        <div class="flex gap-2">
                            <div class="w-2 h-2 rounded-full bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.5)]">
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            {{-- Report Bar --}}
            <div
                class="mt-8 bg-black rounded-3xl p-8 flex flex-col md:flex-row items-center justify-between gap-6 shadow-xl shadow-black/10">
                <div>
                    <h4 class="text-white font-bold text-xl">Found a suspicious agent?</h4>
                    <p class="text-gray-400 text-base">Help us keep the community safe by reporting fraud.</p>
                </div>
                <div class="flex gap-3 shrink-0">
                    <a href="mailto:cs@brinnovatefuture.com"
                        class="px-5 py-2.5 bg-red-600 text-white rounded-xl text-sm font-bold hover:bg-red-700 transition-all">Email
                        Report</a>
                    <a href="https://wa.me/60123456789"
                        class="px-5 py-2.5 bg-white/10 text-white rounded-xl text-sm font-bold hover:bg-white/20 transition-all border border-white/10">WhatsApp</a>
                </div>
            </div>

            <p class="text-xs text-gray-400 mt-10 text-center uppercase tracking-[0.2em] font-medium">
                Verified System Data &bull; Live Status Feedback &bull; Protected by Company Security
            </p>

        </div>
    </section>
</x-app-layout>
