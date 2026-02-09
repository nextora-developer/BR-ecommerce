@if ($paginator->hasPages())
    <nav class="flex items-center justify-center gap-3 select-none py-6" role="navigation">
        
        {{-- Previous Page --}}
        @if ($paginator->onFirstPage())
            <span class="inline-flex items-center justify-center h-11 px-5 rounded-2xl border border-gray-100 bg-gray-50/50 text-sm font-medium text-gray-300 cursor-not-allowed">
                Previous
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}"
               class="inline-flex items-center justify-center h-11 px-5 rounded-2xl border border-gray-200 bg-white text-sm font-semibold text-gray-700 shadow-sm hover:shadow-md hover:border-[#D4AF37]/30 hover:text-[#8f6a10] hover:-translate-y-0.5 transition-all duration-200 active:scale-95">
                Previous
            </a>
        @endif

        {{-- Page Numbers --}}
        <div class="hidden md:flex items-center gap-2">
            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="w-10 text-center text-gray-400 font-medium">···</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="inline-flex items-center justify-center h-11 w-11 rounded-2xl bg-[#D4AF37] text-white text-sm font-bold shadow-lg shadow-[#D4AF37]/30 ring-2 ring-[#D4AF37]/10">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}"
                               class="inline-flex items-center justify-center h-11 w-11 rounded-2xl border border-gray-200 bg-white text-sm font-semibold text-gray-600 hover:border-[#D4AF37]/40 hover:text-[#8f6a10] hover:bg-[#D4AF37]/5 hover:shadow-sm transition-all duration-200">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </div>

        {{-- Next Page --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}"
               class="inline-flex items-center justify-center h-11 px-5 rounded-2xl border border-gray-200 bg-white text-sm font-semibold text-gray-700 shadow-sm hover:shadow-md hover:border-[#D4AF37]/30 hover:text-[#8f6a10] hover:-translate-y-0.5 transition-all duration-200 active:scale-95">
                Next
            </a>
        @else
            <span class="inline-flex items-center justify-center h-11 px-5 rounded-2xl border border-gray-100 bg-gray-50/50 text-sm font-medium text-gray-300 cursor-not-allowed">
                Next
            </span>
        @endif
    </nav>
@endif