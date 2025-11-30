@if ($paginator->hasPages())
    <nav class="flex items-center justify-center space-x-2" aria-label="Pagination Navigation">
        
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="flex items-center justify-center w-10 h-10 bg-white/10 text-gray-500 rounded-lg cursor-not-allowed">
                <i class="fas fa-chevron-left text-sm"></i>
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" 
               class="flex items-center justify-center w-10 h-10 bg-white/10 hover:bg-primary/20 text-gray-300 hover:text-white rounded-lg transition-all duration-300 group">
                <i class="fas fa-chevron-left text-sm group-hover:scale-110 transition-transform duration-300"></i>
            </a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span class="flex items-center justify-center w-10 h-10 text-gray-500">
                    {{ $element }}
                </span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="flex items-center justify-center w-10 h-10 bg-gradient-to-r from-primary to-secondary text-white font-semibold rounded-lg shadow-lg transform scale-110">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}" 
                           class="flex items-center justify-center w-10 h-10 bg-white/10 hover:bg-primary/20 text-gray-300 hover:text-white rounded-lg transition-all duration-300 font-medium hover:scale-105 transform">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" 
               class="flex items-center justify-center w-10 h-10 bg-white/10 hover:bg-primary/20 text-gray-300 hover:text-white rounded-lg transition-all duration-300 group">
                <i class="fas fa-chevron-right text-sm group-hover:scale-110 transition-transform duration-300"></i>
            </a>
        @else
            <span class="flex items-center justify-center w-10 h-10 bg-white/10 text-gray-500 rounded-lg cursor-not-allowed">
                <i class="fas fa-chevron-right text-sm"></i>
            </span>
        @endif

        {{-- Results Info --}}
        <div class="hidden sm:flex items-center ml-6 text-sm text-gray-400">
            <span>
                Showing {{ $paginator->firstItem() ?? 0 }} to {{ $paginator->lastItem() ?? 0 }} of {{ $paginator->total() }} results
            </span>
        </div>
    </nav>

    {{-- Mobile Results Info --}}
    <div class="sm:hidden flex justify-center mt-4">
        <span class="text-sm text-gray-400">
            Page {{ $paginator->currentPage() }} of {{ $paginator->lastPage() }}
        </span>
    </div>
@endif