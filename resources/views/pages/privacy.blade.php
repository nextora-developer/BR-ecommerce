<x-app-layout>
    <section class="bg-[#FAF9F6] min-h-screen pb-20">
        {{-- Hero Header --}}
        <div class="bg-white border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16 text-center">
                <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 tracking-tight mb-4">
                    Privacy Policy
                </h1>
                <p class="text-sm text-gray-500 font-medium italic">
                    Last Updated: {{ date('F d, Y') }}
                </p>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-12">
            <div class="flex flex-col lg:flex-row gap-12">

                {{-- Sidebar Navigation (Desktop Only) --}}
                <aside class="hidden lg:block w-64 flex-shrink-0">
                    <div class="sticky top-24 space-y-1">
                        <p class="text-[10px] font-bold uppercase tracking-widest text-[#8f6a10] mb-4">On this page</p>
                        @php
                            $nav = [
                                'introduction' => 'Introduction',
                                'data-collection' => 'Data We Collect',
                                'how-we-use' => 'How We Use Data',
                                'data-protection' => 'Data Protection',
                                'your-rights' => 'Your Rights',
                                'cookies' => 'Cookies Policy',
                            ];
                        @endphp
                        @foreach ($nav as $id => $label)
                            <a href="#{{ $id }}"
                                class="block px-3 py-2 text-sm text-gray-600 hover:text-[#D4AF37] hover:bg-white rounded-lg transition-all font-medium">
                                {{ $label }}
                            </a>
                        @endforeach
                    </div>
                </aside>

                {{-- Policy Content --}}
                <main class="flex-1 max-w-3xl bg-white border border-gray-100 rounded-3xl p-8 md:p-12 shadow-sm">

                    <div class="prose prose-sm prose-gray max-w-none space-y-10 text-gray-600 leading-relaxed">

                        <section id="introduction">
                            <h2 class="text-xl font-bold text-gray-900 mb-4">1. Introduction</h2>
                            <p>
                                At <strong>{{ config('app.name') }}</strong>, accessible from {{ url('/') }}, one
                                of our main priorities is the privacy of our visitors. This Privacy Policy document
                                contains types of information that is collected and recorded by us and how we use it.
                            </p>
                        </section>

                        <section id="data-collection">
                            <h2 class="text-xl font-bold text-gray-900 mb-4">2. Data We Collect</h2>
                            <p>We may collect several types of information for various purposes to provide and improve
                                our service to you:</p>
                            <ul class="list-disc pl-5 space-y-2 mt-4">
                                <li><strong>Personal Identification Information:</strong> Name, email address, phone
                                    number, and shipping/billing address.</li>
                                <li><strong>Payment Data:</strong> We process payments through secure third-party
                                    gateways. We do not store your full credit card details on our servers.</li>
                                <li><strong>Log Data:</strong> IP address, browser type, and pages visited on our site.
                                </li>
                            </ul>
                        </section>

                        <section id="how-we-use">
                            <h2 class="text-xl font-bold text-gray-900 mb-4">3. How We Use Data</h2>
                            <p>We use the collected data for various purposes, including:</p>
                            <ul class="grid md:grid-cols-2 gap-4 mt-4">
                                <li class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                                    <span class="block font-bold text-gray-900 text-xs uppercase mb-1">Orders</span>
                                    To process and manage your purchases and delivery.
                                </li>
                                <li class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                                    <span class="block font-bold text-gray-900 text-xs uppercase mb-1">Support</span>
                                    To provide customer care and respond to inquiries.
                                </li>
                                <li class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                                    <span class="block font-bold text-gray-900 text-xs uppercase mb-1">Updates</span>
                                    To notify you about changes to our service or special offers.
                                </li>
                                <li class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                                    <span class="block font-bold text-gray-900 text-xs uppercase mb-1">Security</span>
                                    To detect, prevent, and address technical or security issues.
                                </li>
                            </ul>
                        </section>

                        <section id="data-protection" class="bg-[#8f6a10]/5 p-6 rounded-2xl border border-[#D4AF37]/20">
                            <h2 class="text-xl font-bold text-gray-900 mb-4">4. Data Protection</h2>
                            <p>
                                The security of your data is important to us. We implement industry-standard <strong>SSL
                                    encryption</strong> for all data transmissions. While we strive to use commercially
                                acceptable means to protect your Personal Data, we cannot guarantee its absolute
                                security.
                            </p>
                        </section>

                        <section id="your-rights">
                            <h2 class="text-xl font-bold text-gray-900 mb-4">5. Your Rights</h2>
                            <p>You have the right to:</p>
                            <ul class="list-disc pl-5 space-y-2">
                                <li>Request access to the personal data we hold about you.</li>
                                <li>Request that we correct any information you believe is inaccurate.</li>
                                <li>Request the deletion of your personal data under certain conditions.</li>
                                <li>Opt-out of marketing communications at any time.</li>
                            </ul>
                        </section>

                        <section id="cookies">
                            <h2 class="text-xl font-bold text-gray-900 mb-4">6. Cookies Policy</h2>
                            <p>
                                We use cookies and similar tracking technologies to track the activity on our service
                                and hold certain information. You can instruct your browser to refuse all cookies or to
                                indicate when a cookie is being sent.
                            </p>
                        </section>

                    </div>

                    {{-- Contact Info Box --}}
                    <div class="mt-16 pt-8 border-t border-gray-100">
                        <p class="text-sm text-gray-500">
                            If you have any questions about this Privacy Policy, please contact us at
                            <a href="mailto:privacy@yourshop.com"
                                class="text-[#8f6a10] font-bold hover:underline">privacy@yourshop.com</a>.
                        </p>
                    </div>

                </main>
            </div>
        </div>
    </section>
</x-app-layout>
