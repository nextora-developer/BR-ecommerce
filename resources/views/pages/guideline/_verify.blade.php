<div class="rounded-[2.5rem] bg-white border border-gray-100 p-8 shadow-sm">

    {{-- Header --}}
    <div class="flex items-center justify-between gap-4 mb-8">
        <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-900">
            Verify Account
        </h2>
        <span
            class="px-3 py-1 rounded-full
           bg-emerald-500/10 text-emerald-600
           text-[10px] font-black uppercase tracking-widest">
            Verification
        </span>
    </div>

    {{-- Important Notice --}}
    <div class="mb-8 rounded-2xl bg-amber-50/60 border border-amber-100 p-4 text-sm text-amber-800">
        <strong>Important:</strong><br>
        Profile verification details can be submitted <strong>only once</strong>.
        Please ensure all information is correct before saving.
    </div>

    {{-- Desktop / Mobile --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">

        {{-- Desktop --}}
        <div class="rounded-3xl bg-[#FAF9F6] border border-gray-100 p-6">
            <div class="text-xs font-black uppercase tracking-widest text-gray-500 mb-3">
                🖥️Desktop
            </div>

            <ol class="space-y-3 text-sm text-gray-700 list-decimal pl-5">
                <li>Click your <span class="font-semibold text-gray-900">username</span> at the top-right.</li>
                <li>Select <span class="font-semibold text-gray-900">Dashboard</span>.</li>
                <li>Click <span class="font-semibold text-gray-900">Profile Settings</span>.</li>
                <li>Fill in all required information.</li>
                <li>Upload your identification image.</li>
                <li>Click <span class="font-semibold text-gray-900">Save</span>.</li>
            </ol>
        </div>

        {{-- Mobile --}}
        <div class="rounded-3xl bg-[#FAF9F6] border border-gray-100 p-6">
            <div class="text-xs font-black uppercase tracking-widest text-gray-500 mb-3">
                📱Mobile
            </div>

            <ol class="space-y-3 text-sm text-gray-700 list-decimal pl-5">
                <li>Tap <span class="font-semibold text-gray-900">Profile</span> on the bottom menu.</li>
                <li>Tap <span class="font-semibold text-gray-900">Profile Settings</span>.</li>
                <li>Fill in all required information.</li>
                <li>Upload your identification image.</li>
                <li>Tap <span class="font-semibold text-gray-900">Save</span>.</li>
            </ol>
        </div>

    </div>

    {{-- Required Fields --}}
    <div class="mb-10">
        <h3 class="text-lg font-extrabold text-gray-900 mb-4">
            Required Information
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <div class="rounded-2xl bg-[#FAF9F6] border border-gray-100 p-4 text-sm text-gray-700">
                <ul class="space-y-2 list-disc pl-5">
                    <li><strong>Full Name</strong></li>
                    <li><strong>Phone Number</strong></li>
                    <li><strong>Email Address</strong></li>
                </ul>
            </div>

            <div class="rounded-2xl bg-[#FAF9F6] border border-gray-100 p-4 text-sm text-gray-700">
                <ul class="space-y-2 list-disc pl-5">
                    <li><strong>IC Number</strong></li>
                    <li><strong>Date of Birth</strong></li>
                    <li><strong>IC Image Upload</strong></li>
                </ul>
            </div>

        </div>
    </div>

    {{-- Status Explanation --}}
    <div class="mb-10">
        <h3 class="text-lg font-extrabold text-gray-900 mb-4">
            Verification Status
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            {{-- Unverified --}}
            <div class="rounded-2xl bg-gray-50 border border-gray-200 p-5">
                <span
                    class="inline-flex px-3 py-1 rounded-full text-xs font-bold
                           bg-gray-100 text-gray-700 border border-gray-200">
                    Unverified
                </span>
                <p class="mt-2 text-sm text-gray-600">
                    Your profile has not been verified yet.
                    This is the default status after submission.
                </p>
            </div>

            {{-- Verified --}}
            <div class="rounded-2xl bg-emerald-50 border border-emerald-100 p-5">
                <span
                    class="inline-flex px-3 py-1 rounded-full text-xs font-bold
                           bg-emerald-50 text-emerald-700 border border-emerald-200">
                    Verified
                </span>
                <p class="mt-2 text-sm text-gray-600">
                    Your profile has been successfully reviewed and approved by admin.
                </p>
            </div>

        </div>
    </div>

    {{-- Final Notes --}}
    <div class="rounded-2xl bg-blue-50/60 border border-blue-100 p-4 text-sm text-blue-700">
        <strong>Note:</strong><br>
        Verification is reviewed manually by admin.
        Once approved, your status will automatically change from
        <strong>Unverified</strong> (grey)
        to
        <strong>Verified</strong> (green).
    </div>

</div>
