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
                                'definitions' => 'Definitions',
                                'data-collection' => 'What Data We Collect',
                                'how-we-use' => 'Purposes of Processing',
                                'legal-basis' => 'Legal Basis & Consent',
                                'payments' => 'Payments',
                                'cookies' => 'Cookies & Tracking',
                                'disclosure' => 'Data Disclosure',
                                'cross-border' => 'Cross-Border Transfers',
                                'data-protection' => 'Data Security',
                                'retention' => 'Data Retention',
                                'your-rights' => 'Your Rights',
                                'third-party' => 'Third-Party & Minors',
                                'changes' => 'Policy Updates',
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

                        {{-- 1. Introduction --}}
                        <section id="introduction">
                            <h2 class="text-xl font-bold text-gray-900 mb-4">1. Introduction</h2>
                            <p>
                                This Privacy Policy (“Policy”) describes how <strong>BR Innovate Future Sdn.
                                    Bhd.</strong>
                                (“BRIF”, “we”, “us”, “our”) collects, uses, discloses, stores, and protects Personal
                                Data
                                when you access or use <strong>brif.my</strong> (“Website”) or purchase our
                                products and/or services.
                            </p>
                            <p>
                                We are committed to complying with the <strong>Personal Data Protection Act 2010
                                    (Malaysia) (“PDPA”)</strong> and all applicable regulations, guidelines, and
                                directions
                                issued by relevant authorities.
                            </p>
                            <p>
                                By using the Website and/or providing your Personal Data, you acknowledge that you
                                have read, understood, and agreed to this Policy.
                            </p>
                        </section>

                        {{-- 2. Definitions --}}
                        <section id="definitions">
                            <h2 class="text-xl font-bold text-gray-900 mb-4">2. Definitions</h2>
                            <ul class="list-disc pl-5 space-y-2">
                                <li>
                                    <strong>Personal Data</strong> means any information that relates directly or
                                    indirectly
                                    to an identifiable individual.
                                </li>
                                <li>
                                    <strong>Processing</strong> includes collecting, recording, holding, storing, using,
                                    disclosing, transferring, correcting, erasing, or otherwise handling Personal Data.
                                </li>
                                <li>
                                    <strong>Services</strong> refer to any products, digital goods, memberships,
                                    subscriptions, top-ups, reloads, bill payments, or other services offered through
                                    the Website.
                                </li>
                            </ul>
                        </section>

                        {{-- 3. What Personal Data We Collect --}}
                        <section id="data-collection">
                            <h2 class="text-xl font-bold text-gray-900 mb-4">3. What Personal Data We Collect</h2>

                            <h3 class="font-semibold text-gray-900 mt-4 mb-2">A. Personal Data You Provide Directly</h3>
                            <ul class="list-disc pl-5 space-y-2">
                                <li><strong>Identity & Contact Details:</strong> Full name, email address, phone number,
                                    nationality (where required).</li>
                                <li><strong>Account Information:</strong> Username, encrypted/hashed password, account
                                    preferences.</li>
                                <li><strong>Transaction Details:</strong> Orders, invoices, receipts, payment status,
                                    transaction references.</li>
                                <li><strong>Delivery Information:</strong> Billing address, delivery address, recipient
                                    details (where applicable).</li>
                                <li><strong>Communications:</strong> Messages, enquiries, complaints, support records.
                                </li>
                                <li><strong>Verification Information:</strong> Identity documents, selfies, or business
                                    documents submitted for compliance or fraud prevention.</li>
                            </ul>

                            <p class="mt-4 text-sm italic text-gray-500">
                                We apply data minimisation principles and collect only data necessary for the stated
                                purposes.
                            </p>

                            <h3 class="font-semibold text-gray-900 mt-6 mb-2">B. Personal Data Collected Automatically
                            </h3>
                            <ul class="list-disc pl-5 space-y-2">
                                <li><strong>Device & Technical Data:</strong> IP address, browser type, device type,
                                    operating system.</li>
                                <li><strong>Usage Data:</strong> Pages visited, time spent, clickstream data, referring
                                    URLs.</li>
                                <li><strong>Cookies & Similar Technologies:</strong> Session identifiers, preferences,
                                    and performance analytics.</li>
                            </ul>
                        </section>

                        {{-- 4. Purposes of Processing --}}
                        <section id="how-we-use">
                            <h2 class="text-xl font-bold text-gray-900 mb-4">4. Purposes of Processing</h2>
                            <ul class="list-disc pl-5 space-y-2">
                                <li>Account creation, authentication, and management</li>
                                <li>Order processing and delivery of products or digital services</li>
                                <li>Payment processing, reconciliation, refunds, and financial administration</li>
                                <li>Customer support, communications, and dispute handling</li>
                                <li>Security monitoring, fraud prevention, and abuse detection</li>
                                <li>Operational analytics and service improvement</li>
                                <li>Legal, regulatory, accounting, and tax compliance</li>
                                <li>Marketing and service updates (where permitted by law or consented)</li>
                                <li>Enforcement of our rights, agreements, and platform integrity</li>
                            </ul>
                        </section>

                        {{-- 5. Legal Basis & Consent --}}
                        <section id="legal-basis">
                            <h2 class="text-xl font-bold text-gray-900 mb-4">5. Legal Basis & Consent</h2>
                            <p>
                                Where required under the PDPA, we will obtain your consent before collecting or
                                Processing your Personal Data.
                            </p>
                            <p>
                                By using the Website, submitting information, or purchasing Services, you consent
                                to the Processing described in this Policy.
                            </p>
                            <p class="text-sm text-gray-500 italic">
                                You may withdraw consent at any time. Withdrawal may affect our ability to provide
                                Services or maintain your account where Processing is necessary for contractual or
                                legal purposes.
                            </p>
                        </section>

                        {{-- 6. Payments --}}
                        <section id="payments">
                            <h2 class="text-xl font-bold text-gray-900 mb-4">6. Payments</h2>
                            <p>
                                We do not store full credit/debit card numbers or CVV details on our servers.
                                Payments are processed securely by authorized third-party payment gateway providers.
                            </p>
                            <p>
                                We may retain limited transaction data such as payment status, transaction reference,
                                amount, and order number for reconciliation and record-keeping purposes.
                            </p>
                        </section>

                        {{-- 7. Cookies & Tracking --}}
                        <section id="cookies">
                            <h2 class="text-xl font-bold text-gray-900 mb-4">7. Cookies & Tracking Technologies</h2>
                            <p>
                                Cookies are used to operate essential Website functions, maintain login sessions,
                                remember preferences, analyze performance, and detect fraud.
                            </p>
                            <p>
                                You may manage or disable cookies via your browser settings. Disabling cookies may
                                affect certain features of the Website.
                            </p>
                        </section>

                        {{-- 8. Disclosure / Sharing --}}
                        <section id="disclosure">
                            <h2 class="text-xl font-bold text-gray-900 mb-4">8. Disclosure / Sharing of Personal Data
                            </h2>
                            <p>
                                We do not sell or rent Personal Data. We may disclose Personal Data where necessary to:
                            </p>
                            <ul class="list-disc pl-5 space-y-2">
                                <li>Payment processors, banks, and financial institutions</li>
                                <li>Logistics or delivery partners (where applicable)</li>
                                <li>IT, hosting, security, analytics, and customer support providers</li>
                                <li>Professional advisers such as auditors, accountants, and legal advisers</li>
                                <li>Regulators or authorities where required by law or lawful request</li>
                            </ul>
                        </section>

                        {{-- 9. Cross-Border Transfers --}}
                        <section id="cross-border">
                            <h2 class="text-xl font-bold text-gray-900 mb-4">9. Cross-Border Transfers</h2>
                            <p>
                                Personal Data may be stored or processed on servers located within or outside Malaysia,
                                including cloud infrastructure providers.
                            </p>
                            <p>
                                Where cross-border Processing occurs, reasonable safeguards are applied in accordance
                                with the PDPA.
                            </p>
                        </section>

                        {{-- 10. Data Security --}}
                        <section id="data-protection" class="bg-[#8f6a10]/5 p-6 rounded-2xl border border-[#D4AF37]/20">
                            <h2 class="text-xl font-bold text-gray-900 mb-4">10. Data Security</h2>
                            <p>
                                We implement reasonable technical and organizational measures including access controls,
                                encryption in transit, monitoring, and staff confidentiality obligations.
                            </p>
                            <p>
                                No system is completely secure. You are responsible for safeguarding your login
                                credentials.
                            </p>
                        </section>

                        {{-- 11. Data Retention --}}
                        <section id="retention">
                            <h2 class="text-xl font-bold text-gray-900 mb-4">11. Data Retention</h2>
                            <p>
                                Personal Data is retained only for as long as necessary to fulfill the purposes
                                described
                                in this Policy or to comply with legal obligations.
                            </p>
                        </section>

                        {{-- 12. Your Rights --}}
                        <section id="your-rights">
                            <h2 class="text-xl font-bold text-gray-900 mb-4">12. Your Rights</h2>
                            <ul class="list-disc pl-5 space-y-2">
                                <li>Request access to your Personal Data</li>
                                <li>Request correction of inaccurate or outdated data</li>
                                <li>Withdraw consent where applicable</li>
                            </ul>
                        </section>

                        {{-- 13. Third-Party Links & Minors --}}
                        <section id="third-party">
                            <h2 class="text-xl font-bold text-gray-900 mb-4">13. Third-Party Links & Minors</h2>
                            <p>
                                The Website may contain links to third-party websites. We are not responsible for their
                                privacy practices or content.
                            </p>
                            <p>
                                Our Services are not intended for individuals unable to form legally binding contracts.
                                If a minor has provided Personal Data without consent, please contact us.
                            </p>
                        </section>

                        {{-- 14. Changes --}}
                        <section id="changes">
                            <h2 class="text-xl font-bold text-gray-900 mb-4">14. Changes to This Policy</h2>
                            <p>
                                We may update this Policy from time to time. Changes will be posted with an updated
                                “Last Updated” date. Continued use of the Website constitutes acceptance.
                            </p>
                        </section>

                    </div>

                    {{-- Contact --}}
                    <div class="mt-16 pt-8 border-t border-gray-100">
                        <p class="text-sm text-gray-500">
                            If you have any questions about this Privacy Policy, please contact us at
                            <a href="mailto:cs@brinnovatefuture.com" class="text-[#8f6a10] font-bold hover:underline">
                                cs@brinnovatefuture.com
                            </a>.
                        </p>
                    </div>

                </main>


            </div>
        </div>
    </section>
</x-app-layout>
