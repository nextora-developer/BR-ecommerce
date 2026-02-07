@php
    $rating = (int) ($r['rating'] ?? 5);
    $name = $r['name'] ?? 'Customer';
    $title = $r['title'] ?? '';
    $body = $r['body'] ?? '';
    $meta = $r['meta'] ?? 'Verified Buyer';
    $initial = mb_strtoupper(mb_substr($name, 0, 1));
@endphp

<div
    class="group relative h-full rounded-[2rem] border border-black/[0.04] bg-white
            shadow-[0_15px_40px_-15px_rgba(0,0,0,0.05)]
            hover:shadow-[0_30px_60px_-20px_rgba(0,0,0,0.12)]
            hover:-translate-y-1 transition-all duration-500 overflow-hidden">

    {{-- Subtle Quote Watermark --}}
    <div class="absolute top-6 right-8 text-[#8f6a10]/5 select-none pointer-events-none">
        <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 24 24">
            <path
                d="M14.017 21L14.017 18C14.017 16.8954 14.9124 16 16.017 16H19.017C19.5693 16 20.017 15.5523 20.017 15V9C20.017 8.44772 19.5693 8 19.017 8H15.017C14.4647 8 14.017 8.44772 14.017 9V12C14.017 12.5523 13.5693 13 13.017 13H11.017C10.4647 13 10.017 12.5523 10.017 12V9C10.017 6.79086 11.8079 5 14.017 5H19.017C21.2261 5 23.017 6.79086 23.017 9V15C23.017 18.3137 20.3307 21 17.017 21H14.017ZM1.017 21L1.017 18C1.017 16.8954 1.91243 16 3.017 16H6.017C6.56928 16 7.017 15.5523 7.017 15V9C7.017 8.44772 6.56928 8 6.017 8H2.017C1.46472 8 1.017 8.44772 1.017 9V12C1.017 12.5523 0.569282 13 0.017 13H-1.983C-2.53528 13 -2.983 12.5523 -2.983 12V9C-2.983 6.79086 -1.19214 5 1.017 5H6.017C8.22614 5 10.017 6.79086 10.017 9V15C10.017 18.3137 7.33071 21 4.017 21H1.017Z" />
        </svg>
    </div>

    <div class="p-8 flex flex-col h-full relative z-10">

        {{-- Header Section --}}
        <div class="flex items-center gap-4">
            <div
                class="h-12 w-12 rounded-2xl bg-gradient-to-br from-[#FDFBF7] to-[#F2EFE9] border border-[#8f6a10]/10 flex items-center justify-center shadow-sm">
                <span class="text-xs font-bold text-[#8f6a10] tracking-widest">{{ $initial }}</span>
            </div>

            <div class="flex-1">
                <div class="flex items-center gap-2">
                    <h3 class="text-base font-bold text-[#0B0B0B] tracking-tight">{{ $name }}</h3>
                    {{-- Verified Check --}}
                    <svg class="w-3.5 h-3.5 text-[#D4AF37]" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                {{-- <div class="text-[10px] font-medium uppercase tracking-[0.15em] text-black/40">
                    {{ $meta }}
                </div> --}}
            </div>
        </div>

        {{-- Star Rating --}}
        <div class="mt-6 flex items-center gap-1">
            @for ($i = 1; $i <= 5; $i++)
                <svg class="h-3 w-3 {{ $i <= $rating ? 'text-[#D4AF37]' : 'text-black/10' }}" fill="currentColor"
                    viewBox="0 0 20 20">
                    <path
                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                </svg>
            @endfor
            <span class="ml-2 text-[9px] font-bold text-black/30 tracking-widest uppercase">
                Product Quality
            </span>
        </div>

        {{-- Review Content --}}
        <div class="mt-4 flex-1">
            @if ($title)
                <h4 class="text-sm font-bold text-[#0B0B0B] leading-snug mb-2">
                    "{{ $title }}"
                </h4>
            @endif
            <p class="text-[13px] text-black/60 leading-[1.8] font-medium italic">
                {{ $body }}
            </p>
        </div>

        {{-- Footer Detail --}}
        <div class="mt-8 pt-4 border-t border-black/[0.03] flex items-center justify-between">
            <span class="text-[10px] font-bold uppercase tracking-[0.2em] text-[#8f6a10]/60">
                Verified Purchase
            </span>
            <div class="flex gap-1">
                <span class="h-1 w-1 rounded-full bg-black/10"></span>
                <span class="h-1 w-1 rounded-full bg-black/10"></span>
                <span class="h-1 w-1 rounded-full bg-[#D4AF37]"></span>
            </div>
        </div>
    </div>
</div>
