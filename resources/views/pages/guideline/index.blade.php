<x-app-layout>
    <section class="bg-[#FAF9F6] min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 lg:py-16">

            {{-- Header --}}
            <div class="text-center mb-10">
                <div
                    class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-[#D4AF37]/10 text-[#8f6a10] text-xs font-bold uppercase tracking-wider mb-4">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Help Center
                </div>

                <h1 class="text-3xl sm:text-5xl font-extrabold text-gray-900 tracking-tight">
                    Guideline
                </h1>
                <p class="text-gray-500 max-w-2xl mx-auto mt-3 text-base sm:text-lg leading-relaxed">
                    Quick answers. Step-by-step guides. Less reading, more doing.
                </p>
            </div>


            <div class="grid grid-cols-1 lg:grid-cols-4 gap-10 items-start">

                {{-- Left Nav --}}
                <aside class="lg:col-span-1 lg:sticky lg:top-48">
                    <nav class="space-y-2" id="guide-nav">
                        @php
                            $menus = [
                                ['id' => 'login', 'label' => 'How to Login'],
                                ['id' => 'order', 'label' => 'How to Order'],
                                ['id' => 'track', 'label' => 'How to Check Order'],
                                ['id' => 'verify', 'label' => 'Verify Account'],
                                ['id' => 'kyc', 'label' => 'KYC Guide'],
                                ['id' => 'language', 'label' => 'Switch Language'],
                            ];
                        @endphp

                        @foreach ($menus as $m)
                            <a href="#{{ $m['id'] }}"
                                class="guide-link block px-5 py-4 rounded-2xl text-sm font-bold
                                      text-gray-600 bg-white border border-gray-100 shadow-sm
                                      hover:border-[#D4AF37] hover:text-[#8f6a10] hover:shadow-md
                                      transition-all duration-300">
                                {{ $m['label'] }}
                            </a>
                        @endforeach
                    </nav>
                </aside>

                {{-- Right Content --}}
                <div class="lg:col-span-3 space-y-10">

                    <div id="login" class="guide-section scroll-mt-48">
                        @include('pages.guideline._how_to_login')
                    </div>

                    <div id="order" class="guide-section scroll-mt-48">
                        @include('pages.guideline._how_to_order')
                    </div>

                    <div id="track" class="guide-section scroll-mt-48">
                        @include('pages.guideline._check_order')
                    </div>

                    <div id="verify" class="guide-section scroll-mt-48">
                        @include('pages.guideline._verify')
                    </div>

                    <div id="kyc" class="guide-section scroll-mt-48">
                        @include('pages.guideline._kyc')
                    </div>

                    <div id="language" class="guide-section scroll-mt-48">
                        @include('pages.guideline._language')
                    </div>


                    {{-- Support --}}
                    {{-- <div class="rounded-[2.5rem] bg-white border border-gray-100 p-8 shadow-sm">
                        <div class="text-xl font-extrabold text-gray-900">Still need help?</div>
                        <p class="text-sm text-gray-600 mt-2">
                            Contact our support and we’ll assist you as soon as possible.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-3 mt-5">
                            
                            <a href="https://wa.me/60123456789" target="_blank"
                                class="px-5 py-3 rounded-2xl bg-[#D4AF37] text-white text-sm font-bold text-center hover:brightness-95 transition">
                                WhatsApp Support
                            </a>
                        </div>
                    </div> --}}

                </div>
            </div>

        </div>
    </section>

    <style>
        html {
            scroll-behavior: smooth;
        }

        .active-guide {
            border-color: #D4AF37 !important;
            color: #8f6a10 !important;
            background-color: #fffdf7 !important;
            box-shadow: 0 10px 15px -3px rgba(212, 175, 55, 0.12) !important;
        }
    </style>

    <script>
        // Active nav highlight (same idea, but only for .guide-section)
        const observerOptions = {
            root: null,
            rootMargin: '-15% 0px -70% 0px',
            threshold: 0
        };
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (!entry.isIntersecting) return;
                const id = entry.target.getAttribute('id');
                document.querySelectorAll('.guide-link').forEach(link => {
                    link.classList.toggle('active-guide', link.getAttribute('href') === `#${id}`);
                });
            });
        }, observerOptions);

        document.querySelectorAll('.guide-section[id]').forEach(sec => observer.observe(sec));
    </script>

</x-app-layout>
