<x-app-layout>
    @php
        $goldDark = '#8f6a10';
        $goldLight = '#fcf8ed';
        $waLink = 'https://wa.me/' . $whatsapp['phone'] . '?text=' . urlencode($whatsapp['text']);
    @endphp

    <div class="bg-[#fafafa] text-gray-900 antialiased">
        {{-- Hero Section --}}
        <div class="relative overflow-hidden">
            {{-- Subtle Background Glow --}}
            <div
                class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-96 bg-gradient-to-b from-amber-50/50 to-transparent pointer-events-none">
            </div>

            <div class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pt-20 sm:pt-24 pb-16 sm:pb-20 text-center">
                {{-- Badge --}}
                <div class="flex justify-center mb-6">
                    <span
                        class="inline-flex items-center gap-2 rounded-full px-4 py-1.5 text-xs font-bold tracking-wider uppercase bg-white text-amber-800 border border-amber-200 shadow-sm">
                        <span class="relative flex h-2 w-2">
                            <span
                                class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-amber-500"></span>
                        </span>
                        Professional Courses
                    </span>
                </div>

                {{-- Title --}}
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black tracking-tight mb-6"
                    style="color: {{ $goldDark }}">
                    ACCA Professional <span class="text-gray-900">Courses</span>
                </h1>
                <p class="text-base sm:text-lg text-gray-600 max-w-2xl mx-auto leading-relaxed mb-10">
                    Start or advance your accounting career with Malaysia's leading Mandarin-led ACCA program. Designed
                    for clarity, flexibility, and exam success.
                </p>

                {{-- Brand Line --}}
                <div class="flex items-center justify-center gap-3 mb-10">
                    <div class="h-px w-8 bg-gray-200"></div>
                    <div class="text-sm font-medium text-gray-400 italic">
                        Edufluence <span class="mx-1 text-gray-300">×</span> BR Innovate Future
                    </div>
                    <div class="h-px w-8 bg-gray-200"></div>
                </div>

                {{-- Primary CTAs --}}
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="{{ $waLink }}" target="_blank" rel="noopener"
                        class="group inline-flex items-center justify-center rounded-full px-8 py-4 text-sm font-bold text-white bg-gray-900 hover:bg-black transition-all duration-300 shadow-xl hover:shadow-gray-200 active:scale-95">
                        Get Course Details (Free)
                        <svg class="ml-2 w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </a>

                    <a href="#pathways"
                        class="inline-flex items-center justify-center rounded-full px-8 py-4 text-sm font-bold border-2 border-gray-200 text-gray-700 hover:bg-white hover:border-gray-300 transition-all active:scale-95">
                        View Course Pathways
                    </a>
                </div>
            </div>
        </div>

        {{-- Why ACCA --}}
        <div class="relative py-12 lg:py-20 overflow-hidden">
            {{-- Background image with high-quality sizing --}}
            <div class="absolute inset-0">
                <img src="{{ asset('images/acca/acca-bg.png') }}" alt="ACCA career background"
                    class="w-full h-full object-cover scale-105"> {{-- Slight scale for a zoom-in feel --}}
            </div>

            {{-- Advanced Overlay: Darker at the bottom for better text contrast --}}
            <div class="absolute inset-0 bg-gradient-to-b from-black/50 via-black/70 to-black/90"></div>

            {{-- Content --}}
            <div class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

                <div class="text-center mb-16">
                    <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black mb-6 text-white tracking-tight">
                        Why are more professionals <br class="hidden sm:block"> choosing <span
                            class="text-amber-400">ACCA?</span>
                    </h2>

                    <p class="text-lg text-gray-300 max-w-3xl mx-auto leading-relaxed">
                        ACCA is one of the world’s leading professional accounting qualifications,
                        recognised in over <span
                            class="text-white font-bold underline decoration-amber-500/50 underline-offset-4">170
                            countries</span>
                        and highly valued by the world's most prestigious firms.
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 lg:gap-8">
                    @foreach ([['Seen in most job listings', 'Accounting, audit, and finance roles frequently state “ACCA / Degree preferred”.'], ['Stronger salary potential', 'ACCA holders generally earn more than those with basic accounting diplomas.'], ['Clearer career progression', 'More opportunities, faster promotions, and long-term career stability.']] as $index => $item)
                        <div
                            class="group relative p-8 rounded-3xl bg-white/5 backdrop-blur-md border border-white/10 hover:border-amber-500/50 transition-all duration-500">
                            {{-- Decorative Number Accent --}}
                            <div
                                class="absolute top-4 right-6 text-5xl font-black text-white/5 group-hover:text-amber-500/10 transition-colors">
                                0{{ $index + 1 }}
                            </div>

                            <div class="relative">
                                <div class="font-bold text-xl text-white mb-4 flex items-center gap-2">
                                    <span class="h-6 w-1 bg-amber-500 rounded-full"></span>
                                    {{ $item[0] }}
                                </div>
                                <p class="text-gray-300 leading-relaxed text-sm lg:text-base">
                                    {{ $item[1] }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Bottom Quote/Insight --}}
                <div class="mt-16 text-center">
                    <div
                        class="inline-flex items-center gap-3 px-6 py-3 rounded-2xl bg-amber-500/10 border border-amber-500/20">
                        <svg class="w-5 h-5 text-amber-500" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z">
                            </path>
                        </svg>
                        <p class="text-sm lg:text-base text-amber-100 font-medium">
                            Without a recognised qualification, many professionals struggle to even get shortlisted.
                        </p>
                    </div>

                    <p class="mt-6 text-sm text-gray-400">
                        * Based on global industry standards and employer preferences in Malaysia.
                    </p>
                </div>
            </div>
        </div>


        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="h-px bg-gradient-to-r from-transparent via-gray-200 to-transparent"></div>
        </div>
        <div class="h-10 sm:h-14"></div>



        {{-- Grid Section --}}
        <div id="pathways" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 scroll-mt-36">
            <div class="text-center mb-10">
                <h2 class="text-3xl sm:text-4xl font-black text-gray-900 mb-4">
                    Choose the ACCA Package That Fits You
                </h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ($courses as $c)
                    <div
                        class="group relative bg-white rounded-[2rem] border border-gray-100 p-1
           shadow-sm hover:shadow-2xl hover:-translate-y-1
           transition-all duration-300
           flex flex-col h-full">
                        <div class="p-7 flex flex-col flex-1">
                            {{-- Icon & Header --}}
                            <div class="flex flex-col items-center text-center mb-6">
                                <div
                                    class="w-14 h-14 rounded-2xl bg-amber-50 flex items-center justify-center mb-4 group-hover:rotate-6 transition-transform">
                                    {{-- SVGs remain same, but styled with goldDark --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
                                    </svg>

                                </div>
                                <h3 class="text-xl font-black text-gray-900 leading-tight mb-1">{{ $c['title'] }}</h3>
                                <span
                                    class="px-3 py-1 bg-gray-100 rounded-full text-[10px] font-bold text-gray-500 uppercase tracking-widest">{{ $c['tag'] }}</span>
                            </div>

                            {{-- Papers list --}}
                            <div class="space-y-3 mb-6">
                                @foreach ($c['items'] as $it)
                                    <div class="flex items-start gap-3 text-sm font-medium text-gray-700">
                                        <svg class="mt-0.5 h-5 w-5 shrink-0 text-emerald-500" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span>{{ $it }}</span>
                                    </div>
                                @endforeach
                            </div>

                            {{-- Badges (0% instalment / HRDF etc.) --}}
                            @if (!empty($c['badges']))
                                <div class="space-y-2 mb-6">
                                    @foreach ($c['badges'] as $b)
                                        <div class="flex items-start gap-3 text-xs font-semibold">
                                            <span
                                                class="mt-0.5 inline-flex h-5 w-5 items-center justify-center rounded-full
                        {{ $b['ok'] ?? true ? 'bg-yellow-50 text-yellow-600' : 'bg-gray-100 text-gray-500' }}">
                                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                                                </svg>

                                            </span>

                                            <div class="leading-snug">
                                                <div
                                                    class="{{ !empty($b['danger']) ? 'text-red-600' : 'text-gray-700' }}">
                                                    {{ $b['text'] }}
                                                </div>
                                                @if (!empty($b['sub']))
                                                    <div class="text-[11px] text-gray-400 font-medium">
                                                        {{ $b['sub'] }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            <hr class="border-gray-100 my-6">

                            {{-- Notes (timeline / format etc.) --}}
                            @if (!empty($c['notes']))
                                <div class="space-y-2 mb-6">
                                    @foreach ($c['notes'] as $n)
                                        <div class="flex items-start gap-3 text-xs font-semibold text-gray-600">
                                            <span
                                                class="mt-0.5 inline-flex h-5 w-5 items-center justify-center rounded-full bg-gray-100 text-gray-500">
                                                <svg class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path
                                                        d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm1-12a1 1 0 1 0-2 0v4c0 .265.105.52.293.707l2 2a1 1 0 0 0 1.414-1.414L11 9.586V6Z" />
                                                </svg>
                                            </span>
                                            <span class="leading-snug">{{ $n }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            {{-- Description --}}
                            @if (!empty($c['desc']))
                                <p class="text-xs text-gray-500 leading-relaxed italic">
                                    {{ $c['desc'] }}
                                </p>
                            @endif


                            <hr class="border-gray-50 my-6">

                            {{-- Price & Action --}}
                            <div class="text-center mt-auto pt-6">
                                <div class="text-3xl font-black tracking-tight" style="color: {{ $goldDark }}">
                                    {{ $c['price'] }}
                                </div>
                                <div class="text-[11px] font-bold text-gray-400 mt-1 uppercase tracking-tighter">
                                    {{ $c['papers'] }}</div>

                                <a href="{{ $waLink }}" target="_blank" rel="noopener"
                                    class="mt-6 w-full inline-flex items-center justify-center rounded-xl px-4 py-3 text-sm font-bold bg-amber-50 text-amber-900 border border-amber-100 hover:bg-amber-500 hover:text-white transition-colors duration-300">
                                    Enquire Now
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Who Is This For --}}
        <div class="bg-white py-16">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

                <div class="text-center mb-16">
                    <h2 class="text-3xl sm:text-4xl font-black text-gray-900 mb-4 tracking-tight">
                        Is this ACCA program <span class="text-amber-600">right for you?</span>
                    </h2>
                    <p class="text-gray-500 max-w-2xl mx-auto text-lg">
                        We focus on clarity and career transformation — helping you bridge the gap between where you are
                        and where you want to be.
                    </p>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">

                    {{-- Left: The "Target Audience" Checklist --}}
                    <div class="lg:col-span-5 bg-[#fafafa] rounded-[2.5rem] p-8 sm:p-10 border border-gray-100">
                        <h3 class="text-2xl font-black text-gray-900 mb-8 flex items-center gap-3">
                            <span
                                class="flex h-8 w-8 items-center justify-center rounded-full bg-amber-500 text-white text-sm">?</span>
                            This is for you if:
                        </h3>

                        <ul class="space-y-5">
                            @foreach (['Want to upgrade your skills & career prospects', 'Feel stuck in low-paying or long-hour jobs', 'Plan to switch into accounting or audit', 'Need a globally recognised qualification', 'Must study while working full-time', 'Lack confidence in English-only environments'] as $li)
                                <li class="flex items-start gap-4 group">
                                    <div
                                        class="mt-1 flex-shrink-0 w-5 h-5 rounded-full border-2 border-amber-200 flex items-center justify-center group-hover:border-amber-500 transition-colors">
                                        <svg class="w-3 h-3 text-amber-600 opacity-0 group-hover:opacity-100 transition-opacity"
                                            fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z">
                                            </path>
                                        </svg>
                                    </div>
                                    <span class="text-gray-700 font-medium tracking-tight">{{ $li }}</span>
                                </li>
                            @endforeach
                        </ul>

                        <div
                            class="mt-10 p-5 rounded-2xl bg-white border border-gray-100 shadow-sm italic text-sm text-gray-500">
                            "If you checked more than 3 boxes, this program was built specifically for your success."
                        </div>
                    </div>

                    {{-- Right: The "Value Proposition" Cards --}}
                    <div class="lg:col-span-7">
                        <h3 class="text-2xl font-black text-gray-900 mb-8">
                            Why our program works better
                        </h3>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            {{-- Card 1 --}}
                            <div
                                class="p-6 rounded-3xl border border-gray-100 bg-white hover:shadow-xl hover:shadow-gray-100 transition-all duration-300">
                                <div
                                    class="w-10 h-10 bg-amber-50 rounded-xl flex items-center justify-center mb-4 text-amber-600">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129">
                                        </path>
                                    </svg>
                                </div>
                                <h4 class="font-bold text-gray-900 mb-2">Mandarin-led</h4>
                                <p class="text-xs lg:text-sm text-gray-600 leading-relaxed">Complex concepts explained
                                    in Mandarin to ensure 100% understanding.</p>
                            </div>

                            {{-- Card 2 --}}
                            <div
                                class="p-6 rounded-3xl border border-gray-100 bg-white hover:shadow-xl hover:shadow-gray-100 transition-all duration-300">
                                <div
                                    class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center mb-4 text-blue-600">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z">
                                        </path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <h4 class="font-bold text-gray-900 mb-2">Unlimited Replays</h4>
                                <p class="text-xs lg:text-sm text-gray-600 leading-relaxed">Perfect for busy
                                    professionals. Rewatch any lesson until you master it.</p>
                            </div>

                            {{-- Card 3 --}}
                            <div
                                class="p-6 rounded-3xl border border-gray-100 bg-white hover:shadow-xl hover:shadow-gray-100 transition-all duration-300">
                                <div
                                    class="w-10 h-10 bg-emerald-50 rounded-xl flex items-center justify-center mb-4 text-emerald-600">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                </div>
                                <h4 class="font-bold text-gray-900 mb-2">Exam Focused</h4>
                                <p class="text-xs lg:text-sm text-gray-600 leading-relaxed">Structured notes and mocks
                                    designed specifically to hit pass marks.</p>
                            </div>

                            {{-- Card 4 --}}
                            <div
                                class="p-6 rounded-3xl border border-gray-100 bg-white hover:shadow-xl hover:shadow-gray-100 transition-all duration-300">
                                <div
                                    class="w-10 h-10 bg-purple-50 rounded-xl flex items-center justify-center mb-4 text-purple-600">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                        </path>
                                    </svg>
                                </div>
                                <h4 class="font-bold text-gray-900 mb-2">High Pass Rate</h4>
                                <p class="text-xs lg:text-sm text-gray-600 leading-relaxed">A proven system that helps
                                    students pass on their very first attempt.</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>



        {{-- Image Grid (4 Square Images) --}}
        @php
            $images = [
                asset('images/acca/acca-1.png'),
                asset('images/acca/acca-2.png'),
                asset('images/acca/acca-3.png'),
                asset('images/acca/acca-4.png'),
            ];
        @endphp

        <div class="bg-white py-16">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 sm:gap-6">
                    @foreach ($images as $img)
                        <div class="aspect-square rounded-3xl overflow-hidden bg-gray-100 border border-gray-100">
                            <img src="{{ $img }}" alt="Gallery image" class="w-full h-full object-cover">
                        </div>
                    @endforeach
                </div>

            </div>
        </div>


        {{-- Final CTA --}}
        <div class="relative overflow-hidden py-20">
            {{-- Soft gradient background --}}
            <div class="absolute inset-0 bg-gradient-to-br from-amber-50 via-white to-[#fafafa]"></div>

            {{-- Subtle glow blobs --}}
            <div class="absolute -top-24 -left-24 h-72 w-72 rounded-full bg-amber-200/40 blur-3xl"></div>
            <div class="absolute -bottom-24 -right-24 h-72 w-72 rounded-full bg-gray-900/10 blur-3xl"></div>

            <div class="relative max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
                <div
                    class="rounded-[2.5rem] border border-amber-200/50 bg-white/70 backdrop-blur-xl
                   shadow-[0_25px_60px_-30px_rgba(0,0,0,0.25)] p-10 sm:p-12 text-center">

                    {{-- Mini badge --}}
                    <div class="flex justify-center mb-6">
                        <span
                            class="inline-flex items-center gap-2 rounded-full px-4 py-1.5 text-xs font-extrabold tracking-widest uppercase
                           bg-amber-50 text-amber-800 border border-amber-200">
                            <span class="h-2 w-2 rounded-full bg-amber-500"></span>
                            Free Course Info
                        </span>
                    </div>

                    <h2 class="text-3xl sm:text-4xl font-black text-gray-900 mb-5 tracking-tight">
                        Ready to change your future?
                    </h2>

                    <p class="text-gray-600 leading-relaxed max-w-2xl mx-auto mb-9">
                        Staying where you are keeps life the same. Choosing ACCA opens the door to a more stable,
                        professional, and higher-value career.
                    </p>

                    <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                        <a href="{{ $waLink }}" target="_blank" rel="noopener"
                            class="group inline-flex items-center justify-center rounded-full px-10 py-4
                           bg-gray-900 text-white font-bold hover:bg-black transition
                           shadow-lg hover:shadow-xl active:scale-95">
                            WhatsApp
                            <svg class="ml-2 h-4 w-4 group-hover:translate-x-1 transition-transform" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>

                        <a href="#pathways"
                            class="inline-flex items-center justify-center rounded-full px-10 py-4
                           border-2 border-gray-200 text-gray-700 font-bold hover:bg-white hover:border-gray-300 transition active:scale-95">
                            View Packages
                        </a>
                    </div>

                    <div class="mt-6 text-xs text-gray-400">
                        Response within business hours • Malaysia (Mandarin-led)
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
