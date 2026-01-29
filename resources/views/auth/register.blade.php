<x-guest-layout>
    <div class="w-full max-w-6xl mx-auto px-4">
        {{-- OUTER BIG CARD --}}
        <div
            class="relative rounded-[40px] bg-white/80 backdrop-blur-2xl
                    shadow-[0_40px_100px_-15px_rgba(0,0,0,0.15)]
                    overflow-hidden lg:max-h-[min(720px,calc(100svh-100px))]">

            <div class="h-full grid grid-cols-1 lg:grid-cols-12 gap-0 items-stretch overflow-hidden rounded-[32px]">

                {{-- LEFT IMAGE PANEL --}}
                <div class="lg:col-span-5 xl:col-span-5 h-full hidden lg:block">
                    <div class="relative h-full overflow-hidden">

                        <img src="{{ asset('images/user-register.png') }}"
                            onerror="this.style.display='none'; document.getElementById('luxury-placeholder').style.display='flex';"
                            alt="BRIF visual" class="absolute inset-0 w-full h-full object-cover" />

                        <div id="luxury-placeholder"
                            class="hidden absolute inset-0 items-center justify-center
                                   border-2 border-dashed border-white/30 bg-[#D4AF37]/30">
                            <span class="text-white/60 text-[11px] font-bold uppercase tracking-widest">
                                Asset: images/1.png
                            </span>
                        </div>
                    </div>
                </div>

                {{-- RIGHT REGISTER FORM --}}
                <div class="lg:col-span-7 xl:col-span-7 h-full bg-white flex items-center px-8 py-10 sm:px-16">
                    <div class="w-full max-w-sm mx-auto">

                        <div class="mb-8 text-center lg:text-left">
                            <div class="inline-flex items-center gap-3 mb-4">
                                <img src="{{ asset('images/logo.png') }}" class="h-8 w-8 rounded-xl" alt=""
                                    onerror="this.src='https://ui-avatars.com/api/?name=B&background=D4AF37&color=fff'">
                                <span
                                    class="text-base font-black tracking-widest text-gray-400 uppercase">brif.my</span>

                            </div>

                            <h2 class="text-3xl font-black text-gray-900 tracking-tight">Create Account</h2>
                            <p class="text-gray-400 text-sm mt-1">Join us and start your journey today, where premium
                                essentials and a seamless experience come together.</p>
                        </div>

                        <form method="POST" action="{{ route('register') }}" class="space-y-4">
                            @csrf

                            {{-- Full Name (full row) --}}
                            <div class="group">
                                <label
                                    class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1 ml-1
                   group-focus-within:text-[#D4AF37] transition-colors">
                                    Full Name
                                </label>
                                <input id="name" type="text" name="name" value="{{ old('name') }}" required
                                    autofocus placeholder="John Doe"
                                    class="w-full px-5 py-4 rounded-2xl bg-gray-50 border border-gray-100
                   focus:bg-white focus:border-[#D4AF37] focus:ring-4 focus:ring-[#D4AF37]/5
                   outline-none transition-all duration-300 text-gray-900 placeholder:text-gray-300" />
                                @error('name')
                                    <p class="text-xs text-red-500 mt-2 ml-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Two-column row --}}
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                {{-- Email --}}
                                <div class="group">
                                    <label
                                        class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1 ml-1
                       group-focus-within:text-[#D4AF37] transition-colors">
                                        Email Address
                                    </label>
                                    <input id="email" type="email" name="email" value="{{ old('email') }}"
                                        required placeholder="name@company.com"
                                        class="w-full px-6 py-4 rounded-2xl bg-gray-50 border border-gray-100
                       focus:bg-white focus:border-[#D4AF37] focus:ring-4 focus:ring-[#D4AF37]/5
                       outline-none transition-all duration-300 text-gray-900 placeholder:text-gray-300" />
                                    @error('email')
                                        <p class="text-xs text-red-500 mt-2 ml-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Referral Code --}}
                                <div class="group">
                                    <label
                                        class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1 ml-1
                       group-focus-within:text-[#D4AF37] transition-colors">
                                        Referral Code <span
                                            class="text-gray-300 normal-case font-bold">(optional)</span>
                                    </label>
                                    <input id="ref" type="text" name="ref"
                                        value="{{ old('ref', request('ref')) }}" placeholder="Referral code"
                                        autocomplete="off"
                                        class="w-full px-5 py-4 rounded-2xl bg-gray-50 border border-gray-100
                       focus:bg-white focus:border-[#D4AF37] focus:ring-4 focus:ring-[#D4AF37]/5
                       outline-none transition-all duration-300 text-gray-900 placeholder:text-gray-300" />
                                    @error('ref')
                                        <p class="text-xs text-red-500 mt-2 ml-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            {{-- Password row --}}
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                {{-- Password --}}
                                <div class="group">
                                    <label
                                        class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1 ml-1
                       group-focus-within:text-[#D4AF37] transition-colors">
                                        Password
                                    </label>
                                    <input id="password" type="password" name="password" required
                                        autocomplete="new-password" placeholder="••••••••"
                                        class="w-full px-5 py-4 rounded-2xl bg-gray-50 border border-gray-100
                       focus:bg-white focus:border-[#D4AF37] focus:ring-4 focus:ring-[#D4AF37]/5
                       outline-none transition-all duration-300 text-gray-900 placeholder:text-gray-300" />
                                    @error('password')
                                        <p class="text-xs text-red-500 mt-2 ml-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Confirm Password --}}
                                <div class="group">
                                    <label
                                        class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1 ml-1
                       group-focus-within:text-[#D4AF37] transition-colors">
                                        Confirm Password
                                    </label>
                                    <input id="password_confirmation" type="password" name="password_confirmation"
                                        required placeholder="••••••••"
                                        class="w-full px-5 py-4 rounded-2xl bg-gray-50 border border-gray-100
                       focus:bg-white focus:border-[#D4AF37] focus:ring-4 focus:ring-[#D4AF37]/5
                       outline-none transition-all duration-300 text-gray-900 placeholder:text-gray-300" />
                                </div>
                            </div>

                            {{-- Submit --}}
                            <button type="submit"
                                class="w-full mt-2 py-4 rounded-2xl font-black text-white tracking-[0.2em] uppercase text-[11px]
               bg-[#D4AF37]
               shadow-[0_20px_40px_-10px_rgba(212,175,55,0.4)]
               hover:shadow-[0_25px_50px_-12px_rgba(212,175,55,0.5)]
               hover:-translate-y-1 active:translate-y-0 transition-all duration-300">
                                Create Account
                            </button>

                            <p class="pt-4 text-center text-sm text-gray-400 font-medium">
                                Already have an account?
                                <a href="{{ route('login') }}"
                                    class="text-[#D4AF37] font-black hover:underline decoration-2 underline-offset-4 transition-all">
                                    Sign in
                                </a>
                            </p>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
</x-guest-layout>
