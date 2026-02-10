@extends('admin.layouts.app')

@section('content')
    <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Spin Rewards</h1>
            <p class="text-sm text-gray-500 mt-1">Configure wheel rewards: points, weight, daily stock, order & active</p>
        </div>

        {{-- Optional: quick hint badge --}}
        <div
            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-[#D4AF37]/10 text-[#8f6a10]
                    border border-[#D4AF37]/20 text-sm font-bold">
            Daily Stock: empty = unlimited
        </div>
    </div>

    {{-- Filter --}}
    <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm mb-6 transition-all">
        <form method="GET" class="flex flex-col md:flex-row gap-3">
            <div class="flex-1 relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>

                <input name="keyword" value="{{ request('keyword') }}" placeholder="Search name or points…"
                    class="block w-full pl-10 pr-3 py-2.5 bg-gray-50 border-transparent rounded-xl text-sm
                           focus:bg-white focus:ring-2 focus:ring-[#D4AF37]/20 focus:border-[#D4AF37] transition-all">
            </div>

            <select name="active"
                class="min-w-[160px] py-2.5 bg-gray-50 border-transparent rounded-xl text-sm
                       focus:bg-white focus:ring-2 focus:ring-[#D4AF37]/20 focus:border-[#D4AF37] transition-all">
                <option value="">All Status</option>
                <option value="1" @selected(request('active') === '1')>Active Only</option>
                <option value="0" @selected(request('active') === '0')>Inactive Only</option>
            </select>

            <button
                class="px-6 py-2.5 rounded-xl bg-[#D4AF37]/10 text-[#8f6a10]
                       border border-[#D4AF37]/20 hover:bg-[#D4AF37] hover:text-white
                       transition-all font-bold text-sm">
                Filter
            </button>

            <a href="{{ route('admin.spin-rewards.index') }}"
                class="px-4 py-2.5 rounded-xl border border-gray-100 text-gray-500 hover:bg-gray-50
                       transition-all text-sm flex items-center justify-center">
                Reset
            </a>
        </form>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50/50 border-b border-gray-50">
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider w-[90px]">
                            No
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider w-[260px]">
                            Name
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider w-[140px]">
                            Points
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider w-[140px]">
                            Percentage %
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider w-[170px]">
                            Daily Stock
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-wider w-[140px]">
                            Status
                        </th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-gray-400 uppercase tracking-wider w-[120px]">
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-50">
                    @forelse ($rewards as $r)
                        @php
                            $statusBadge = $r->is_active
                                ? 'bg-emerald-50 text-emerald-600 border-emerald-100'
                                : 'bg-rose-50 text-rose-600 border-rose-100';

                            $stockText = is_null($r->daily_stock) ? 'Unlimited' : (int) $r->daily_stock;
                            $stockBadge = is_null($r->daily_stock)
                                ? 'bg-gray-50 text-gray-600 border-gray-100'
                                : 'bg-indigo-50 text-indigo-600 border-indigo-100';
                        @endphp

                        <tr class="group hover:bg-[#D4AF37]/5 transition-colors">
                            <td class="px-6 py-4 text-gray-900 font-bold whitespace-nowrap">
                                {{ (int) $r->sort_order }}
                            </td>

                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-900 group-hover:text-[#8f6a10] transition-colors">
                                    {{ $r->name }}
                                </div>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full
                                           text-[11px] font-bold border uppercase tracking-wider
                                           bg-[#D4AF37]/10 text-[#8f6a10] border-[#D4AF37]/20">
                                    {{ (int) $r->points }} PTS
                                </span>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap text-gray-800 font-semibold">
                                {{ (int) $r->weight }}
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full
                                           text-[11px] font-bold border uppercase tracking-wider {{ $stockBadge }}">
                                    {{ $stockText }}
                                </span>
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full
                                           text-[11px] font-bold border uppercase tracking-wider {{ $statusBadge }}">
                                    {{ $r->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>

                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.spin-rewards.edit', $r) }}"
                                        class="p-2 rounded-lg text-gray-400 hover:text-[#8f6a10] hover:bg-[#D4AF37]/10 transition-all"
                                        title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414
                                                                 a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-20 text-center text-gray-400">
                                <div class="flex flex-col items-center">
                                    <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                        <svg class="w-8 h-8 text-gray-200" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8V6m0 12v-2m9-4a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <p class="font-medium">No spin rewards yet</p>
                                    <p class="text-xs mt-1 text-gray-300">Create rewards via seeder or DB first</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- 如果你之后想分页，这里留着。现在 rewards 是 get() 就先不显示 --}}
        {{-- <div class="px-6 py-4 bg-gray-50/50 border-t border-gray-100">
            {{ $rewards->links() }}
        </div> --}}
    </div>
@endsection
