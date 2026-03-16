@extends('admin.layouts.app')

@section('content')
    <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Orders</h1>
            <p class="text-sm text-gray-500 mt-1">Search, filter and manage customer orders</p>
        </div>

        <button type="button" id="enableSoundBtn"
            class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl 
           bg-[#D4AF37]/10 text-[#72530d] border border-[#D4AF37]/30 
           hover:bg-[#D4AF37] hover:text-white hover:shadow-lg hover:shadow-[#D4AF37]/20
           focus:outline-none focus:ring-2 focus:ring-[#D4AF37] focus:ring-offset-2
           transition-all duration-200 text-sm font-bold active:scale-95">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M11 5L6 9H2v6h4l5 4V5z"></path>
                <path d="M19.07 4.93a10 10 0 0 1 0 14.14"></path>
                <path d="M15.54 8.46a5 5 0 0 1 0 7.07"></path>
            </svg>
            Enable Notification Sound
        </button>
    </div>

    {{-- Filters --}}
    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm mb-6 transition-all">
        <form method="GET" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1 relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input name="keyword" value="{{ request('keyword') }}" placeholder="Search order no, name or phone…"
                    class="block w-full pl-10 pr-3 py-2.5 bg-gray-50 border-transparent rounded-xl text-sm
                              focus:bg-white focus:ring-2 focus:ring-[#D4AF37]/20 focus:border-[#D4AF37] transition-all">
            </div>

            <select name="status"
                class="min-w-[140px] py-2.5 bg-gray-50 border-transparent rounded-xl text-sm
                       focus:bg-white focus:ring-2 focus:ring-[#D4AF37]/20 focus:border-[#D4AF37] transition-all">
                <option value="">All Status</option>
                @foreach ($statuses as $s)
                    <option value="{{ $s }}" @selected(request('status') === $s)>{{ strtoupper($s) }}</option>
                @endforeach
            </select>

            <input type="date" name="from" value="{{ request('from') }}"
                class="py-2.5 bg-gray-50 border-transparent rounded-xl text-sm
                       focus:bg-white focus:ring-2 focus:ring-[#D4AF37]/20 focus:border-[#D4AF37] transition-all">

            <input type="date" name="to" value="{{ request('to') }}"
                class="py-2.5 bg-gray-50 border-transparent rounded-xl text-sm
                       focus:bg-white focus:ring-2 focus:ring-[#D4AF37]/20 focus:border-[#D4AF37] transition-all">

            <button
                class="px-6 py-2.5 rounded-xl bg-[#D4AF37]/10 text-[#8f6a10]
                       border border-[#D4AF37]/20 hover:bg-[#D4AF37] hover:text-white
                       transition-all font-bold text-sm">
                Filter
            </button>

            <a href="{{ route('admin.orders.index') }}"
                class="px-4 py-2.5 rounded-xl border border-gray-100 text-gray-500 hover:bg-gray-50
                       transition-all text-sm flex items-center justify-center">
                Reset
            </a>
        </form>
    </div>

    {{-- Table --}}
    <div id="ordersTable"
        class="bg-white rounded-2xl border border-gray-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] overflow-hidden">

        <form method="POST" action="{{ route('admin.orders.bulk-update') }}">
            @csrf

            {{-- Bulk Action Bar --}}
            <div
                class="px-6 py-4 bg-gray-50/80 border-b border-gray-100 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                <div class="flex items-center gap-3">
                    <span id="selectedCount"
                        class="inline-flex items-center px-3 py-1 rounded-full bg-white border border-gray-200 text-xs font-bold text-gray-500">
                        0 selected
                    </span>

                    <select name="bulk_status"
                        class="px-4 py-2.5 rounded-xl border border-gray-200 bg-white text-sm text-gray-700 focus:ring-2 focus:ring-[#D4AF37]/20 focus:border-[#D4AF37]">
                        <option value="">Bulk Status</option>
                        <option value="pending">PENDING</option>
                        <option value="processing">PROCESSING</option>
                        <option value="cancelled">CANCELLED</option>
                        <option value="failed">FAILED</option>
                    </select>

                    <button type="submit"
                        class="px-5 py-2.5 rounded-xl bg-[#D4AF37] text-white font-bold text-sm hover:bg-[#c39f2f] transition-all">
                        Update Selected
                    </button>
                </div>

                <p class="text-xs text-gray-400">
                    Select multiple orders and update status in one action
                </p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50/50 border-b border-gray-50">
                            <th class="px-6 py-4 w-[50px]">
                                <input type="checkbox" id="selectAll"
                                    class="rounded border-gray-300 text-[#D4AF37] focus:ring-[#D4AF37]">
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">
                                Order No
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">
                                Customer
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">
                                Total
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider">
                                Created
                            </th>
                            <th class="px-6 py-4"></th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-50">
                        @forelse ($orders as $o)
                            @php
                                $status = strtoupper($o->status);
                                $colors = [
                                    'PENDING' => 'bg-amber-50 text-amber-700 border border-amber-200',
                                    'PAID' => 'bg-green-50 text-green-700 border border-green-200',
                                    'PROCESSING' => 'bg-purple-50 text-purple-700 border border-purple-200',
                                    'SHIPPED' => 'bg-blue-50 text-blue-700 border border-blue-200',
                                    'COMPLETED' => 'bg-emerald-50 text-emerald-700 border border-emerald-200',
                                    'CANCELLED' => 'bg-gray-50 text-gray-700 border border-gray-200',
                                    'FAILED' => 'bg-red-50 text-red-700 border border-red-200',
                                ];
                                $style = $colors[$status] ?? 'bg-gray-50 text-gray-500 border border-gray-200';
                            @endphp

                            <tr class="group hover:bg-[#D4AF37]/5 transition-colors">
                                <td class="px-6 py-4">
                                    <input type="checkbox" name="orders[]" value="{{ $o->id }}"
                                        class="orderCheckbox rounded border-gray-300 text-[#D4AF37] focus:ring-[#D4AF37]">
                                </td>

                                <td class="px-6 py-4 font-bold text-gray-900 group-hover:text-[#8f6a10]">
                                    {{ $o->order_no }}
                                </td>

                                <td class="px-6 py-4">
                                    @if ($o->user)
                                        <div class="font-medium text-gray-900">
                                            {{ $o->user->name }}
                                        </div>
                                        <div class="text-xs text-gray-400">
                                            {{ $o->user->phone ?? $o->user->email }}
                                        </div>
                                    @else
                                        <div class="text-gray-400 italic">
                                            Guest (no user)
                                        </div>
                                    @endif
                                </td>

                                <td class="px-6 py-4">
                                    <span
                                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-bold uppercase tracking-wider {{ $style }}">
                                        {{ $status }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 font-bold text-gray-900">
                                    RM {{ number_format($o->total ?? 0, 2) }}
                                </td>

                                <td class="px-6 py-4 text-gray-500">
                                    {{ optional($o->created_at)->format('d M Y h:i A') }}
                                </td>

                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.orders.show', $o) }}"
                                            class="p-2 rounded-lg text-gray-400 hover:text-[#8f6a10] hover:bg-[#D4AF37]/10 transition-all"
                                            title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-20 text-center text-gray-400">
                                    <div class="flex flex-col items-center">
                                        <div
                                            class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                            <svg class="w-8 h-8 text-gray-200" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                            </svg>
                                        </div>
                                        <p class="font-medium">No orders found</p>
                                        <p class="text-xs mt-1 text-gray-300">Try adjusting your filters or search keywords
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </form>

        <div class="px-6 py-4 bg-gray-50/50 border-t border-gray-100">
            {{ $orders->links() }}
        </div>
    </div>

    <audio id="orderSound" preload="auto">
        <source src="{{ asset('sounds/kaching.mp3') }}" type="audio/mpeg">
    </audio>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            let isRequesting = false;
            let lastFirstOrderNo = @json(optional($orders->first())->order_no);
            let audioUnlocked = false;

            const sound = document.getElementById('orderSound');
            const enableBtn = document.getElementById('enableSoundBtn');

            function updateSelectedCount() {
                const checked = document.querySelectorAll('.orderCheckbox:checked').length;
                const counter = document.getElementById('selectedCount');
                const selectAll = document.getElementById('selectAll');
                const allCheckboxes = document.querySelectorAll('.orderCheckbox');

                if (counter) {
                    counter.textContent = checked + ' selected';
                }

                if (selectAll) {
                    selectAll.checked = allCheckboxes.length > 0 && checked === allCheckboxes.length;
                }
            }

            function bindSelectAll() {
                const selectAll = document.getElementById('selectAll');
                const checkboxes = document.querySelectorAll('.orderCheckbox');

                if (selectAll) {
                    selectAll.addEventListener('change', function() {
                        checkboxes.forEach(cb => {
                            cb.checked = this.checked;
                        });
                        updateSelectedCount();
                    });
                }

                checkboxes.forEach(cb => {
                    cb.addEventListener('change', function() {
                        updateSelectedCount();
                    });
                });

                updateSelectedCount();
            }

            function bindBulkForm() {
                const bulkForm = document.querySelector('form[action*="bulk-update"]');

                if (!bulkForm) return;

                bulkForm.addEventListener('submit', function(e) {
                    const checked = document.querySelectorAll('.orderCheckbox:checked');
                    const bulkStatus = bulkForm.querySelector('[name="bulk_status"]');

                    if (checked.length === 0) {
                        e.preventDefault();
                        alert('Please select at least one order.');
                        return;
                    }

                    if (!bulkStatus || !bulkStatus.value) {
                        e.preventDefault();
                        alert('Please select a bulk status.');
                        return;
                    }
                });
            }

            async function unlockAudio() {
                if (!sound || audioUnlocked) return;

                try {
                    sound.volume = 0;
                    await sound.play();
                    sound.pause();
                    sound.currentTime = 0;
                    sound.volume = 1;

                    audioUnlocked = true;

                    if (enableBtn) {
                        enableBtn.textContent = 'Notification Sound Enabled';

                        enableBtn.classList.remove(
                            'bg-[#D4AF37]/10',
                            'text-[#8f6a10]',
                            'border-[#D4AF37]/30'
                        );

                        enableBtn.classList.add(
                            'bg-green-50',
                            'text-green-700',
                            'border-green-200'
                        );
                    }

                } catch (error) {
                    console.log('Audio unlock failed:', error);
                }
            }

            enableBtn?.addEventListener('click', unlockAudio);

            async function refreshOrders() {
                if (document.hidden) return;
                if (isRequesting) return;

                isRequesting = true;

                try {
                    const res = await fetch(window.location.href, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'text/html'
                        },
                        cache: 'no-store'
                    });

                    const html = await res.text();

                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');

                    const newTable = doc.querySelector('#ordersTable');

                    if (!newTable) {
                        isRequesting = false;
                        return;
                    }

                    const firstRowCell = newTable.querySelector('tbody tr td:nth-child(2)');
                    const newFirstOrderNo = firstRowCell ? firstRowCell.textContent.trim() : null;

                    console.log('Old order:', lastFirstOrderNo, 'New order:', newFirstOrderNo);

                    if (lastFirstOrderNo && newFirstOrderNo && newFirstOrderNo !== lastFirstOrderNo) {
                        if (sound && audioUnlocked) {
                            sound.currentTime = 0;
                            sound.play().catch(function(error) {
                                console.log('Play failed:', error);
                            });
                        }
                    }

                    document.getElementById('ordersTable').innerHTML = newTable.innerHTML;
                    lastFirstOrderNo = newFirstOrderNo;

                    bindSelectAll();
                    bindBulkForm();

                } catch (error) {
                    console.error('Order refresh failed:', error);
                }

                isRequesting = false;
            }

            bindSelectAll();
            bindBulkForm();

            setInterval(refreshOrders, 10000);
        });
    </script>
@endsection
