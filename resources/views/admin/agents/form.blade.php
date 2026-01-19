@extends('admin.layouts.app')

@php
    /** @var \App\Models\Agent|null $agent */
    $isEdit = isset($agent) && $agent->exists;
@endphp

@section('content')
    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-semibold text-gray-900 tracking-tight">
                {{ $isEdit ? 'Edit Agent' : 'Add Agent' }}
            </h1>
            <p class="text-sm text-gray-500 mt-1">
                {{ $isEdit ? 'Update agent profile and status.' : 'Create a new agent record.' }}
            </p>
        </div>

        <a href="{{ route('admin.agents.index') }}"
            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white border border-gray-200
                   text-sm font-semibold text-gray-600 hover:bg-gray-50 transition shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>
            <span>Back</span>
        </a>
    </div>

    {{-- Error --}}
    @if ($errors->any())
        <div
            class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200
                    text-red-800 text-sm flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-red-500">
                <path fill-rule="evenodd"
                    d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0Zm-8-5a.75.75 0 0 1 .75.75v4.5a.75.75 0 0 1-1.5 0v-4.5A.75.75 0 0 1 10 5Zm0 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z"
                    clip-rule="evenodd" />
            </svg>
            {{ $errors->first() }}
        </div>
    @endif

    <div class="bg-white border border-[#D4AF37]/18 rounded-2xl p-6
                shadow-[0_18px_40px_rgba(0,0,0,0.06)]">

        {{-- FORM --}}
        <form id="agent-form" method="POST"
            action="{{ $isEdit ? route('admin.agents.update', $agent) : route('admin.agents.store') }}">
            @csrf
            @if ($isEdit)
                @method('PUT')
            @endif

            {{-- Section: Basic Info --}}
            <div class="flex items-center gap-2 mb-4">
                <span class="w-1.5 h-6 bg-[#D4AF37] rounded-full"></span>
                <h2 class="font-bold text-gray-900">Agent Information</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                {{-- Agent ID (auto, readonly) --}}
                <div>
                    <label class="text-xs uppercase font-black tracking-widest text-gray-400">
                        Agent ID
                    </label>
                    <input type="text" value="{{ $agent->agent_code }}" readonly
                        class="mt-1.5 w-full rounded-xl bg-gray-100 border-gray-200
                      text-gray-500 font-bold cursor-not-allowed">
                    <input type="hidden" name="agent_code" value="{{ $agent->agent_code }}">
                </div>

                {{-- Full Name --}}
                <div>
                    <label class="text-xs uppercase font-black tracking-widest text-gray-400">
                        Full Name
                    </label>
                    <input type="text" name="name" value="{{ old('name', $agent->name) }}"
                        class="mt-1.5 w-full rounded-xl border-gray-200
                      focus:border-[#D4AF37] focus:ring-[#D4AF37]/30 font-medium">
                </div>

                {{-- Phone --}}
                <div>
                    <label class="text-xs uppercase font-black tracking-widest text-gray-400">
                        Phone Number
                    </label>
                    <input type="text" name="phone" value="{{ old('phone', $agent->phone) }}"
                        class="mt-1.5 w-full rounded-xl border-gray-200
                      focus:border-[#D4AF37] focus:ring-[#D4AF37]/30 font-medium">
                </div>

            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">

                {{-- Role --}}
                <div>
                    <label class="text-xs uppercase font-black tracking-widest text-gray-400">
                        Role
                    </label>
                    <select name="role"
                        class="mt-1.5 w-full rounded-xl border-gray-200 bg-white
                   focus:border-[#D4AF37] focus:ring-[#D4AF37]/30 font-medium">
                        @php
                            $roles = ['Agent'];
                        @endphp
                        @foreach ($roles as $role)
                            <option value="{{ $role }}" @selected(old('role', $agent->role) === $role)>
                                {{ $role }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Region --}}
                <div>
                    <label class="text-xs uppercase font-black tracking-widest text-gray-400">
                        Region
                    </label>
                    <select name="region"
                        class="mt-1.5 w-full rounded-xl border-gray-200 bg-white
                   focus:border-[#D4AF37] focus:ring-[#D4AF37]/30 font-medium">
                        @php
                            $regions = [
                                'Johor',
                                'Kedah',
                                'Kelantan',
                                'Kuala Lumpur',
                                'Labuan',
                                'Melaka',
                                'Negeri Sembilan',
                                'Pahang',
                                'Penang',
                                'Perak',
                                'Perlis',
                                'Putrajaya',
                                'Sabah',
                                'Sarawak',
                                'Selangor',
                                'Terengganu',
                            ];
                        @endphp

                        <option value="">Select Region</option>
                        @foreach ($regions as $region)
                            <option value="{{ $region }}" @selected(old('region', $agent->region) === $region)>
                                {{ $region }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Status --}}
                <div>
                    <label class="text-xs uppercase font-black tracking-widest text-gray-400">
                        Status
                    </label>
                    <select name="status"
                        class="mt-1.5 w-full rounded-xl border-gray-200 bg-white
                   focus:border-[#D4AF37] focus:ring-[#D4AF37]/30 font-medium">
                        <option value="active" @selected(old('status', $agent->status) === 'active')>
                            Active
                        </option>
                        <option value="suspended" @selected(old('status', $agent->status) === 'suspended')>
                            Suspended
                        </option>
                        <option value="inactive" @selected(old('status', $agent->status) === 'inactive')>
                            Inactive
                        </option>
                    </select>
                </div>

            </div>


        </form>

        {{-- Footer --}}
        <div class="mt-10 pt-6 border-t border-gray-100 flex items-center justify-between">

            {{-- Left --}}
            <p class="text-xs text-gray-400 font-bold uppercase tracking-widest">
                {{ $isEdit ? 'Last updated: ' . optional($agent->updated_at)->diffForHumans() : 'New agent record' }}
            </p>

            {{-- Right --}}
            <div class="flex items-center gap-6">

                {{-- Actions --}}
                <div class="flex gap-3">
                    <a href="{{ route('admin.agents.index') }}"
                        class="px-6 py-2.5 rounded-xl border border-gray-200
                               text-sm font-bold text-gray-500 hover:bg-gray-50 transition">
                        Cancel
                    </a>

                    <button type="submit" form="agent-form"
                        class="px-8 py-2.5 rounded-xl bg-[#D4AF37] text-white
                               text-sm font-bold hover:bg-[#c29c2f] transition
                               shadow-lg shadow-[#D4AF37]/20">
                        {{ $isEdit ? 'Save Changes' : 'Create Agent' }}
                    </button>
                </div>

            </div>
        </div>

    </div>
@endsection
