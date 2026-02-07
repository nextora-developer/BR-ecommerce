<div class="rounded-[2.5rem] bg-white border border-gray-100 p-8 shadow-sm space-y-10">

    {{-- Header --}}
    <div class="flex items-center justify-between gap-4">
        <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900">
            Switch Language
        </h2>
        <span
            class="px-3 py-1 rounded-full bg-gray-100 text-gray-700 text-[10px] font-black uppercase tracking-widest border border-gray-200">
            Language
        </span>
    </div>

    {{-- Intro --}}
    <div class="space-y-3">
        <p class="text-lg text-gray-700 leading-relaxed">
            Our website does not have a built-in language switcher.
            You can easily translate the page using your browser’s
            <strong>built-in translation feature</strong>.
        </p>

        <div class="rounded-2xl bg-blue-50/60 border border-blue-100 p-4 text-sm text-blue-700">
            <strong>Good to know:</strong><br>
            Translation is handled by your browser (Google or Apple),
            and no additional installation is required.
        </div>
    </div>

    {{-- Methods --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- Google Chrome --}}
        <div class="p-6 rounded-3xl bg-[#FAF9F6] border border-gray-100 space-y-4">
            <div class="flex items-center justify-between">
                <h4 class="text-lg font-extrabold text-gray-900">
                    Google Chrome
                </h4>
                <span
                    class="text-[10px] font-black uppercase tracking-widest text-green-700 bg-green-50 border border-green-100 px-2 py-1 rounded-full">
                    Recommended
                </span>
            </div>

            <ol class="text-sm text-gray-700 space-y-2 list-decimal pl-5">
                <li>Open the website using <strong>Google Chrome</strong>.</li>
                <li>Right-click anywhere on the page.</li>
                <li>Select <strong>Translate to your language</strong>.</li>
                <li>The page will reload automatically in the selected language.</li>
            </ol>

            <div class="rounded-2xl bg-white border border-gray-100 p-4 text-sm text-gray-700">
                <strong>Tip:</strong> If the translate option does not appear,
                click the <strong>Translate icon</strong> in the address bar.
            </div>
        </div>

        {{-- Safari --}}
        <div class="p-6 rounded-3xl bg-[#FAF9F6] border border-gray-100 space-y-4">
            <h4 class="text-lg font-extrabold text-gray-900">
                Safari (iPhone / iPad / Mac)
            </h4>

            <ol class="text-sm text-gray-700 space-y-2 list-decimal pl-5">
                <li>Open the website using <strong>Safari</strong>.</li>
                <li>Tap the <strong>aA</strong> icon in the address bar.</li>
                <li>Select <strong>Translate Website</strong>.</li>
                <li>Choose your preferred language.</li>
            </ol>

            <div class="rounded-2xl bg-white border border-gray-100 p-4 text-sm text-gray-700">
                <strong>Note:</strong> Safari translation is available on supported
                languages and newer iOS/macOS versions.
            </div>
        </div>

    </div>

    {{-- Mobile Chrome --}}
    <div class="rounded-3xl bg-[#FAF9F6] border border-gray-100 p-6 space-y-4">
        <h4 class="text-lg font-extrabold text-gray-900">
            Mobile (Chrome Browser)
        </h4>

        <ol class="text-sm text-gray-700 space-y-2 list-decimal pl-5">
            <li>Open the website in the <strong>Chrome</strong> app.</li>
            <li>Tap the <strong>three-dot menu</strong> at the top right.</li>
            <li>Select <strong>Translate</strong>.</li>
            <li>Choose your language.</li>
        </ol>

        <div class="rounded-2xl bg-amber-50/60 border border-amber-100 p-4 text-sm text-amber-800">
            <strong>Tip:</strong> If translation does not start automatically,
            scroll the page or refresh once.
        </div>
    </div>

    {{-- Limitations --}}
    <div class="rounded-2xl bg-gray-50 border border-gray-200 p-4 text-sm text-gray-600">
        <strong>Please note:</strong><br>
        Translation accuracy depends on the browser’s translation engine.
        Some brand names, buttons, or technical terms may remain untranslated.
    </div>

</div>
