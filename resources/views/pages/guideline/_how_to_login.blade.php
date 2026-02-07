<div class="rounded-[2.5rem] bg-white border border-gray-100 p-8 shadow-sm">

    {{-- Header --}}
    <div class="flex items-center justify-between gap-4 mb-8">
        <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900">
            How to Login
        </h2>
        <span
            class="px-3 py-1 rounded-full bg-[#D4AF37]/10 text-[#8f6a10] text-[10px] font-black uppercase tracking-widest">
            Account
        </span>
    </div>

    {{-- Quick Summary --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-10">
        <div class="rounded-2xl bg-[#FAF9F6] border border-gray-100 p-5">
            <div class="text-xs text-gray-500 font-black uppercase tracking-widest">✅ What you need</div>
            <div class="mt-2 text-sm font-bold text-gray-900">Email + Password</div>
            <p class="mt-1 text-xs text-gray-500">Use the email you registered with.</p>
        </div>

        <div class="rounded-2xl bg-[#FAF9F6] border border-gray-100 p-5">
            <div class="text-xs text-gray-500 font-black uppercase tracking-widest">
                📝 New User
            </div>
            <div class="mt-2 text-sm font-bold text-gray-900">
                Register First
            </div>
            <p class="mt-1 text-xs text-gray-500">
                Don’t have an account? Create one before logging in.
            </p>
        </div>


        <div class="rounded-2xl bg-[#FAF9F6] border border-gray-100 p-5">
            <div class="text-xs text-gray-500 font-black uppercase tracking-widest">📍 Where</div>
            <div class="mt-2 text-sm font-bold text-gray-900">Login Page</div>
            <p class="mt-1 text-xs text-gray-500">From website menu or profile.</p>
        </div>

        <div class="rounded-2xl bg-[#FAF9F6] border border-gray-100 p-5">
            <div class="text-xs text-gray-500 font-black uppercase tracking-widest">🔒 Security</div>
            <div class="mt-2 text-sm font-bold text-gray-900">Keep password private</div>
            <p class="mt-1 text-xs text-gray-500">Never share password.</p>
        </div>
    </div>

    {{-- Desktop / Mobile Steps --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- Desktop --}}
        <div class="rounded-3xl bg-[#FAF9F6] border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="text-xs font-black uppercase tracking-widest text-gray-500">🖥️Desktop</div>
                <span
                    class="text-[10px] font-black uppercase tracking-widest text-[#8f6a10] bg-[#D4AF37]/10 px-2 py-1 rounded-full">
                    Steps
                </span>
            </div>

            <ol class="space-y-3 text-sm text-gray-700 list-decimal pl-5">
                <li>
                    On the top navigation bar, click
                    <span class="font-semibold text-gray-900">Login</span>.
                </li>
                <li>
                    Enter your <span class="font-semibold text-gray-900">Email</span> and
                    <span class="font-semibold text-gray-900">Password</span>.
                </li>
                <li>
                    Click <span class="font-semibold text-gray-900">Sign In</span>.
                </li>
                <li>
                    After login, you can click your <span class="font-semibold text-gray-900">username</span>
                    (top-right)
                    to access <span class="font-semibold text-gray-900">My Orders</span> and other options.
                </li>
            </ol>

            <div class="mt-5 rounded-2xl bg-white border border-gray-100 p-4 text-sm text-gray-700">
                <span class="font-bold text-gray-900">Tip:</span> If you’re using a shared device, remember to logout
                after use.
            </div>
        </div>

        {{-- Mobile --}}
        <div class="rounded-3xl bg-[#FAF9F6] border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="text-xs font-black uppercase tracking-widest text-gray-500">📱Mobile</div>
                <span
                    class="text-[10px] font-black uppercase tracking-widest text-[#8f6a10] bg-[#D4AF37]/10 px-2 py-1 rounded-full">
                    Steps
                </span>
            </div>

            <ol class="space-y-3 text-sm text-gray-700 list-decimal pl-5">
                <li>
                    Tap <span class="font-semibold text-gray-900">Profile</span> on the bottom menu.
                </li>
                <li>
                    Tap <span class="font-semibold text-gray-900">Login</span> (or <span
                        class="font-semibold text-gray-900">Sign In</span>).
                </li>
                <li>
                    Enter your <span class="font-semibold text-gray-900">Email</span> and
                    <span class="font-semibold text-gray-900">Password</span>.
                </li>
                <li>
                    Tap <span class="font-semibold text-gray-900">Sign In</span>.
                </li>
            </ol>

            <div class="mt-5 rounded-2xl bg-white border border-gray-100 p-4 text-sm text-gray-700">
                <span class="font-bold text-gray-900">Tip:</span> Make sure your keyboard doesn’t add spaces at the end
                of your email.
            </div>
        </div>

    </div>

    {{-- Common Problems --}}
    <div class="mt-12 space-y-4">
        <h3 class="text-lg font-extrabold text-gray-900">
            Common Problems
        </h3>

        <div class="rounded-2xl bg-blue-50/60 border border-blue-100 p-4 text-sm text-blue-700">
            <strong>Forgot password?</strong><br>
            Please contact the our customer support to reset your access or resolve account issues
        </div>

        <div class="rounded-2xl bg-blue-50/60 border border-blue-100 p-4 text-sm text-blue-700">
            <strong>Login failed even though password is correct?</strong><br>
            Ensure you are using the same email you registered with. If you recently changed password, try clearing
            browser cache or reopen the app.
        </div>
    </div>

</div>
