<div class="rounded-[2.5rem] bg-white border border-gray-100 p-8 shadow-sm space-y-10">

    {{-- Header --}}
    <div class="flex items-center justify-between gap-4">
        <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900">
            KYC Guide
        </h2>
        <span
            class="px-3 py-1 rounded-full bg-blue-50 text-blue-700 text-[10px] font-black uppercase tracking-widest border border-blue-100">
            Security
        </span>
    </div>

    {{-- Intro --}}
    <div class="space-y-3">
        <p class="text-lg text-gray-700 leading-relaxed">
            To protect your identity and prevent misuse, we require a clear
            <strong>IC (MyKad)</strong> photo before approving account verification.
        </p>

        <div class="flex items-start gap-3 p-4 bg-blue-50/50 rounded-2xl border border-blue-100">
            <svg class="w-5 h-5 text-blue-500 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                    clip-rule="evenodd"></path>
            </svg>
            <p class="text-sm text-blue-700">
                <strong>Tip:</strong> Use natural lighting and avoid flash glare so all text remains sharp and readable.
            </p>
        </div>
    </div>

    {{-- Methods --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Method 1 --}}
        <div class="p-8 rounded-3xl bg-gray-50 border border-gray-100 space-y-5">
            <div class="flex items-center justify-between gap-3">
                <h4 class="text-lg font-extrabold text-gray-900">
                    Method 1: Physical Note
                </h4>
                <span
                    class="px-3 py-1 rounded-full bg-[#D4AF37]/10 text-[#8f6a10] text-[10px] font-black uppercase tracking-widest">
                    Recommended
                </span>
            </div>

            <p class="text-sm text-gray-600 leading-relaxed">
                Write a note on a small piece of paper and place it
                <strong class="text-gray-900">next to your IC</strong>
                when taking the photo.
            </p>

            {{-- <div class="rounded-2xl bg-white border border-gray-200 p-4">
                <div class="text-xs font-black uppercase tracking-widest text-gray-900 mb-3">
                    Recommended Note
                </div>

                <div class="text-sm font-mono text-gray-700 leading-relaxed">
                    For Verification Only<br>
                    <strong class="text-gray-900">BR Innovate Future</strong><br>
                    Date: <strong class="text-gray-900">DD/MM/YYYY</strong>
                </div>

                <p class="mt-3 text-xs text-gray-500 italic">
                    This helps prevent your ID image from being reused for other purposes.
                </p>
            </div> --}}

            <div class="text-xs font-black uppercase tracking-widest text-gray-900">
                Sample (Physical Note)
            </div>

            <div class="group relative overflow-hidden rounded-2xl border border-gray-200 bg-gray-100 cursor-zoom-in">
                <img src="/images/ic-text.png" alt="Sample IC with Digital Watermark"
                    class="w-full object-cover transition-transform duration-500 group-hover:scale-105">

                <div
                    class="absolute inset-0 bg-black/0 group-hover:bg-black/40 transition flex items-center justify-center">
                    <span
                        class="opacity-0 group-hover:opacity-100 text-white text-xs font-bold uppercase tracking-widest">
                        View Sample
                    </span>
                </div>
            </div>
        </div>

        {{-- Method 2 --}}
        <div class="p-8 rounded-3xl bg-white border border-gray-100 space-y-5">
            <h4 class="text-lg font-extrabold text-gray-900">
                Method 2: Digital Watermark
            </h4>

            <p class="text-sm text-gray-600 leading-relaxed">
                Take a photo of your IC first, then add a watermark text across the image.
            </p>

            <ul class="text-sm text-gray-600 space-y-2 list-disc pl-5">
                <li>Place the text diagonally across the photo.</li>
                <li><strong class="text-gray-900">Do not cover</strong> your name, IC number, or face.</li>
                <li>
                    Recommended text:
                    <strong class="text-gray-900">For Verification Use Only</strong>
                </li>
            </ul>

            {{-- Sample --}}
            <div class="mt-4">
                <div class="text-xs font-black uppercase tracking-widest text-gray-900 mb-2">
                    Sample (Digital Watermark)
                </div>

                <div
                    class="group relative overflow-hidden rounded-2xl border border-gray-200 bg-gray-100 cursor-zoom-in">
                    <img src="/images/ic-sample.jpeg" alt="Sample IC with Digital Watermark"
                        class="w-full object-cover transition-transform duration-500 group-hover:scale-105">

                    <div
                        class="absolute inset-0 bg-black/0 group-hover:bg-black/40 transition flex items-center justify-center">
                        <span
                            class="opacity-0 group-hover:opacity-100 text-white text-xs font-bold uppercase tracking-widest">
                            View Sample
                        </span>
                    </div>
                </div>

                <p class="mt-2 text-xs text-gray-500 italic">
                    Example only. Personal details are hidden for demonstration.
                </p>
            </div>
        </div>
    </div>

    {{-- Do & Avoid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <div class="p-6 rounded-2xl bg-green-50/60 border border-green-100">
            <div class="flex items-center gap-2 mb-3">
                <div class="w-2 h-2 rounded-full bg-green-500"></div>
                <h5 class="font-black text-green-800 uppercase tracking-widest text-xs">
                    Please Do
                </h5>
            </div>
            <ul class="space-y-2 text-sm text-green-900/80">
                <li>• Use a <strong>color photo</strong></li>
                <li>• Ensure <strong>all four corners</strong> are visible</li>
                <li>• Keep all text <strong>clear and readable</strong></li>
            </ul>
        </div>

        <div class="p-6 rounded-2xl bg-red-50/60 border border-red-100">
            <div class="flex items-center gap-2 mb-3">
                <div class="w-2 h-2 rounded-full bg-red-500"></div>
                <h5 class="font-black text-red-800 uppercase tracking-widest text-xs">
                    Please Avoid
                </h5>
            </div>
            <ul class="space-y-2 text-sm text-red-900/80">
                <li>• Blurry or glare-heavy photos</li>
                <li>• Covering name, IC number, or face</li>
                <li>• Screenshots or photocopies</li>
            </ul>
        </div>
    </div>

    {{-- Why verify --}}
    <div class="space-y-6">
        <h3 class="text-xl font-extrabold text-gray-900 flex items-center gap-2">
            <span class="text-lg">🛡️</span>
            Why do I need to verify my identity?
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <div class="p-6 rounded-2xl bg-white border border-gray-200 shadow-sm">
                <div class="text-2xl mb-3">🚫</div>
                <strong class="block text-gray-900 font-bold mb-1">
                    Prevent Scammers
                </strong>
                <p class="text-sm text-gray-600 leading-relaxed">
                    Verification prevents scammers from using fake or stolen IDs.
                </p>
            </div>

            <div class="p-6 rounded-2xl bg-white border border-gray-200 shadow-sm">
                <div class="text-2xl mb-3">🔒</div>
                <strong class="block text-gray-900 font-bold mb-1">
                    Protect Your Identity
                </strong>
                <p class="text-sm text-gray-600 leading-relaxed">
                    Ensures no one else uses your personal details illegally.
                </p>
            </div>

            <div class="p-6 rounded-2xl bg-white border border-gray-200 shadow-sm">
                <div class="text-2xl mb-3">✅</div>
                <strong class="block text-gray-900 font-bold mb-1">
                    Trust & Safety
                </strong>
                <p class="text-sm text-gray-600 leading-relaxed">
                    Helps maintain a safe and trusted platform for all users.
                </p>
            </div>

        </div>
    </div>

</div>
