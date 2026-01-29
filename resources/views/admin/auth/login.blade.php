<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin Login | Secure Access</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="min-h-screen bg-[#F9F7F2]
             text-gray-900 flex items-center justify-center relative overflow-hidden
             selection:bg-[#D4AF37]/30">

    <div class="w-full max-w-6xl mx-auto px-4">
        {{-- OUTER BIG CARD --}}
        <div
            class="relative rounded-[40px] bg-white/80 backdrop-blur-2xl
                    shadow-[0_40px_100px_-15px_rgba(0,0,0,0.15)]
                    overflow-hidden xl:max-h-[min(720px,calc(100svh-100px))]">

            <div class="h-full grid grid-cols-1 lg:grid-cols-12 gap-0 items-stretch overflow-hidden rounded-[32px]">

                {{-- LEFT IMAGE PANEL (same as user) --}}
                <div class="lg:col-span-5 xl:col-span-5 h-full hidden lg:block">
                    <div class="relative h-full overflow-hidden">
                        <img src="{{ asset('images/admin-login.png') }}"
                            onerror="this.style.display='none'; document.getElementById('admin-placeholder').style.display='flex';"
                            alt="Admin visual" class="absolute inset-0 w-full h-full object-cover" />

                        <div id="admin-placeholder"
                            class="hidden absolute inset-0 items-center justify-center
                                   border-2 border-dashed border-white/30 bg-[#D4AF37]/30">
                            <span class="text-white/70 text-[11px] font-black uppercase tracking-widest">
                                Asset: images/admin-login.png
                            </span>
                        </div>

                        {{-- Optional soft overlay to match premium feel --}}
                        <div class="absolute inset-0 bg-black/5"></div>
                    </div>
                </div>

                {{-- RIGHT ADMIN FORM --}}
                <div class="lg:col-span-7 xl:col-span-7 h-full bg-white flex items-center px-8 py-12 sm:px-16">
                    <div class="w-full max-w-sm mx-auto">

                        {{-- Header (similar weight to user) --}}
                        <div class="mb-10 text-center lg:text-left">
                            <div class="inline-flex items-center gap-3 mb-4">
                                <div
                                    class="flex items-center justify-center h-10 w-10 rounded-2xl
                                            bg-gradient-to-br from-[#D4AF37] to-[#B8962E]
                                            shadow-[0_14px_30px_rgba(212,175,55,0.28)]">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </div>
                                <span class="text-base font-black tracking-widest text-gray-400 uppercase">Admin
                                    Portal</span>
                            </div>

                            <h1 class="text-3xl font-black tracking-tight text-gray-900">
                                Secure <span class="text-[#D4AF37]">Access</span>
                            </h1>
                            <p class="mt-1 text-sm text-gray-400">
                                Authentication required to continue.
                            </p>
                        </div>

                        {{-- Error Box --}}
                        @if ($errors->any())
                            <div
                                class="mb-5 rounded-2xl border border-red-200 bg-red-50 px-4 py-3
                                        text-sm text-red-700 font-semibold flex items-start gap-3">
                                <svg class="w-5 h-5 shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <div>{{ $errors->first() }}</div>
                            </div>
                        @endif

                        {{-- Form --}}
                        <form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-5">
                            @csrf

                            <div class="group">
                                <label
                                    class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1 ml-1
                                           group-focus-within:text-[#D4AF37] transition-colors">
                                    Username
                                </label>
                                <input type="email" name="email" required placeholder="admin@internal.com"
                                    class="w-full px-6 py-4 rounded-2xl bg-gray-50 border border-gray-100
                                           focus:bg-white focus:border-[#D4AF37] focus:ring-4 focus:ring-[#D4AF37]/5
                                           outline-none transition-all duration-300 text-gray-900 placeholder:text-gray-300" />
                            </div>

                            <div class="group">
                                <div class="flex justify-between items-center mb-1 px-1">
                                    <label
                                        class="block text-[10px] font-black text-gray-400 uppercase tracking-widest
                                               group-focus-within:text-[#D4AF37] transition-colors">
                                        Password
                                    </label>
                                </div>

                                <input type="password" name="password" required placeholder="••••••••"
                                    class="w-full px-6 py-4 rounded-2xl bg-gray-50 border border-gray-100
                                           focus:bg-white focus:border-[#D4AF37] focus:ring-4 focus:ring-[#D4AF37]/5
                                           outline-none transition-all duration-300 text-gray-900 placeholder:text-gray-300" />
                            </div>

                            <div class="flex items-center justify-between">
                                <label class="inline-flex items-center gap-2 text-sm text-gray-500 font-semibold">
                                    <input type="checkbox" name="remember"
                                        class="rounded border-gray-300 text-[#D4AF37] focus:ring-[#D4AF37]">
                                    Remember
                                </label>

                                <a href="{{ route('home') }}"
                                    class="text-sm font-semibold text-gray-500 hover:text-[#8f6a10] transition-colors">
                                    ← Exit to Shop
                                </a>
                            </div>

                            <button type="submit"
                                class="w-full py-4 rounded-2xl font-black text-white tracking-[0.2em] uppercase text-[11px]
                                       bg-[#D4AF37]
                                       shadow-[0_20px_40px_-10px_rgba(212,175,55,0.4)]
                                       hover:shadow-[0_25px_50px_-12px_rgba(212,175,55,0.5)]
                                       hover:-translate-y-1 active:translate-y-0 transition-all duration-300">
                                Authorize Access
                            </button>
                        </form>

                        {{-- Footer --}}
                        <div class="mt-6 pt-6 border-t border-amber-200/40 text-center">
                            <p class="text-[10px] uppercase tracking-[0.2em] text-gray-500">
                                System Core v2.4.0 <span class="mx-2">•</span> Secure Layer Active
                            </p>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

</body>

</html>
