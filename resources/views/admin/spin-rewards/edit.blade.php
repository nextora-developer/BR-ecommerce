@extends('admin.layouts.app')

@section('content')
    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-semibold text-gray-900 tracking-tight">Edit Spin Reward</h1>
            <p class="text-sm text-gray-500 mt-1">Adjust points, probability weight, daily stock, order and status.</p>
        </div>

        <a href="{{ route('admin.spin-rewards.index') }}"
            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white border border-gray-200
                   text-sm font-semibold text-gray-600 hover:bg-gray-50 transition shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>
            <span>Back</span>
        </a>
    </div>

    <div class="bg-white border border-[#D4AF37]/18 rounded-2xl p-6 shadow-[0_18px_40px_rgba(0,0,0,0.06)]">

        <form id="reward-form" method="POST" action="{{ route('admin.spin-rewards.update', $reward) }}">
            @csrf
            @method('PUT')

            <div class="flex items-center gap-2 mb-4">
                <span class="w-1.5 h-6 bg-[#D4AF37] rounded-full"></span>
                <h2 class="font-bold text-gray-900">Reward Settings</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <div class="md:col-span-2">
                    <label class="text-xs uppercase font-black tracking-widest text-gray-400">Name</label>
                    <input type="text" name="name" value="{{ old('name', $reward->name) }}"
                        class="mt-1.5 w-full rounded-xl border-gray-200 focus:border-[#D4AF37] focus:ring-[#D4AF37]/30 font-medium"
                        placeholder="e.g. 15 Points">
                </div>

                <div>
                    <label class="text-xs uppercase font-black tracking-widest text-gray-400">Sort Order</label>
                    <input type="number" min="1" name="sort_order"
                        value="{{ old('sort_order', $reward->sort_order) }}"
                        class="mt-1.5 w-full rounded-xl border-gray-200 focus:border-[#D4AF37] focus:ring-[#D4AF37]/30 font-medium"
                        placeholder="1,2,3...">
                </div>

                <div>
                    <label class="text-xs uppercase font-black tracking-widest text-gray-400">Points</label>
                    <input type="number" min="0" name="points" value="{{ old('points', $reward->points) }}"
                        class="mt-1.5 w-full rounded-xl border-gray-200 focus:border-[#D4AF37] focus:ring-[#D4AF37]/30 font-medium"
                        placeholder="0">
                    <p class="mt-2 text-xs text-gray-400">Points credited when user lands on this reward.</p>
                </div>

                <div>
                    <label class="text-xs uppercase font-black tracking-widest text-gray-400">Percentage %</label>
                    <input type="number" min="0" name="weight" value="{{ old('weight', $reward->weight) }}"
                        class="mt-1.5 w-full rounded-xl border-gray-200 focus:border-[#D4AF37] focus:ring-[#D4AF37]/30 font-medium"
                        placeholder="e.g. 45">
                    <p class="mt-2 text-xs text-gray-400">Higher percentage = higher chance to be picked.</p>
                </div>

                <div>
                    <label class="text-xs uppercase font-black tracking-widest text-gray-400">Daily Stock</label>
                    <input type="number" min="1" name="daily_stock"
                        value="{{ old('daily_stock', $reward->daily_stock) }}"
                        class="mt-1.5 w-full rounded-xl border-gray-200 focus:border-[#D4AF37] focus:ring-[#D4AF37]/30 font-medium"
                        placeholder="Leave empty = unlimited">
                    <p class="mt-2 text-xs text-gray-400">Leave empty for unlimited. If set, max wins per day.</p>
                </div>

                <div class="md:col-span-3 mt-6">
                    <div class="relative overflow-hidden rounded-2xl border border-indigo-100 bg-white p-5 shadow-sm">
                        <div class="absolute top-0 right-0 -mt-4 -mr-4 h-24 w-24 rounded-full bg-indigo-50 opacity-50">
                        </div>

                        <div class="relative flex items-start gap-4">
                            <div
                                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-indigo-600 text-white shadow-md shadow-indigo-200">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                    stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 100 20 10 10 0 000-20z" />
                                </svg>
                            </div>

                            <div class="flex-1">
                                <div class="text-base font-bold text-gray-900 flex items-center gap-2">
                                    How the Wheel Works
                                    <span
                                        class="px-2 py-0.5 text-[10px] uppercase tracking-wider bg-indigo-100 text-indigo-700 rounded-md">
                                        Simple Guide
                                    </span>
                                </div>

                                <div class="mt-3 grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-3">
                                    <div class="flex items-start gap-2">
                                        <div class="mt-1.5 h-1.5 w-1.5 shrink-0 rounded-full bg-indigo-500"></div>
                                        <p class="text-sm text-gray-600">
                                            <span class="font-bold text-gray-800">Sort Order:</span>
                                            Sets the segment position on the wheel (visual only).
                                        </p>
                                    </div>

                                    <div class="flex items-start gap-2">
                                        <div class="mt-1.5 h-1.5 w-1.5 shrink-0 rounded-full bg-indigo-500"></div>
                                        <p class="text-sm text-gray-600">
                                            <span class="font-bold text-gray-800">Percentage (%):</span>
                                            Higher number = more likely to be picked.
                                        </p>
                                    </div>

                                    <div class="flex items-start gap-2 border-t border-gray-50 pt-2 sm:border-0 sm:pt-0">
                                        <div class="mt-1.5 h-1.5 w-1.5 shrink-0 rounded-full bg-amber-500"></div>
                                        <p class="text-sm text-gray-600">
                                            <span class="font-bold text-gray-800">Daily Stock:</span>
                                            Max wins per day (leave empty = unlimited).
                                        </p>
                                    </div>

                                    <div class="flex items-start gap-2 border-t border-gray-50 pt-2 sm:border-0 sm:pt-0">
                                        <div class="mt-1.5 h-1.5 w-1.5 shrink-0 rounded-full bg-amber-500"></div>
                                        <p class="text-sm text-gray-600">
                                            <span class="font-bold text-gray-800">Out of Stock:</span>
                                            Once daily stock hits 0, it won't be given until the next day.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </form>

        {{-- Footer Actions --}}
        <div class="mt-10 pt-6 border-t border-gray-100 flex items-center justify-between">
            <p class="text-xs text-gray-400 font-bold uppercase tracking-widest">
                Reward ID: {{ $reward->id }}
            </p>

            <div class="flex items-center gap-6">

                {{-- Active Toggle --}}
                <label class="flex items-center gap-3 cursor-pointer">
                    <input type="hidden" name="is_active" value="0" form="reward-form">
                    <input type="checkbox" name="is_active" value="1" class="sr-only peer" form="reward-form"
                        @checked(old('is_active', (bool) $reward->is_active))>

                    <div
                        class="relative w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-[#D4AF37]
                               after:content-[''] after:absolute after:top-[2px] after:left-[2px]
                               after:bg-white after:h-5 after:w-5 after:rounded-full
                               after:transition-all peer-checked:after:translate-x-full">
                    </div>

                    <span
                        class="text-xs font-bold uppercase tracking-widest {{ $reward->is_active ? 'text-[#8f6a10]' : 'text-gray-500' }}">
                        Reward Active
                    </span>
                </label>

                <div class="flex gap-3">
                    <a href="{{ route('admin.spin-rewards.index') }}"
                        class="px-6 py-2.5 rounded-xl border border-gray-200
                               text-sm font-bold text-gray-500 hover:bg-gray-50 transition">
                        Cancel
                    </a>

                    <button type="submit" form="reward-form"
                        class="px-8 py-2.5 rounded-xl bg-[#D4AF37] text-white
                               text-sm font-bold hover:bg-[#c29c2f] transition
                               shadow-lg shadow-[#D4AF37]/20">
                        Save Changes
                    </button>
                </div>
            </div>
        </div>

    </div>
@endsection
