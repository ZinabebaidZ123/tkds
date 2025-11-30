@if ($paginator->hasPages())
    <nav class="flex items-center justify-between" aria-label="Pagination Navigation">
        
        <!-- Mobile Pagination -->
        <div class="flex justify-between flex-1 sm:hidden">
            @if ($paginator->onFirstPage())
                <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-gray-800 border border-gray-600 cursor-default leading-5 rounded-md">
                    Previous
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" 
                   class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-white/10 border border-white/20 leading-5 rounded-md hover:bg-white/20 focus:outline-none focus:ring focus:ring-primary focus:ring-offset-0 active:bg-white/30 transition ease-in-out duration-150">
                    Previous
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" 
                   class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-white bg-white/10 border border-white/20 leading-5 rounded-md hover:bg-white/20 focus:outline-none focus:ring focus:ring-primary focus:ring-offset-0 active:bg-white/30 transition ease-in-out duration-150">
                    Next
                </a>
            @else
                <span class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-500 bg-gray-800 border border-gray-600 cursor-default leading-5 rounded-md">
                    Next
                </span>
            @endif
        </div>

        <!-- Desktop Pagination -->
        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-gray-400 leading-5">
                    Showing
                    @if ($paginator->firstItem())
                        <span class="font-medium text-white">{{ $paginator->firstItem() }}</span>
                        to
                        <span class="font-medium text-white">{{ $paginator->lastItem() }}</span>
                    @else
                        {{ $paginator->count() }}
                    @endif
                    of
                    <span class="font-medium text-white">{{ $paginator->total() }}</span>
                    results
                </p>
            </div>

            <div>
                <span class="relative z-0 inline-flex shadow-sm rounded-lg">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <span aria-disabled="true" aria-label="Previous">
                            <span class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500 bg-gray-800 border border-gray-600 cursor-default rounded-l-lg leading-5" aria-hidden="true">
                                <i class="fas fa-chevron-left text-xs"></i>
                            </span>
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" rel="prev" 
                           class="relative inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-white/10 border border-white/20 rounded-l-lg leading-5 hover:bg-white/20 focus:z-10 focus:outline-none focus:ring focus:ring-primary focus:ring-offset-0 active:bg-white/30 transition ease-in-out duration-150" 
                           aria-label="Previous">
                            <i class="fas fa-chevron-left text-xs"></i>
                        </a>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <span aria-disabled="true">
                                <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-500 bg-gray-800 border border-gray-600 cursor-default leading-5">{{ $element }}</span>
                            </span>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span aria-current="page">
                                        <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-bold text-white bg-gradient-to-r from-primary to-secondary border border-primary cursor-default leading-5">{{ $page }}</span>
                                    </span>
                                @else
                                    <a href="{{ $url }}" 
                                       class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-300 bg-white/5 border border-white/20 leading-5 hover:text-white hover:bg-white/10 focus:z-10 focus:outline-none focus:ring focus:ring-primary focus:ring-offset-0 active:bg-white/20 transition ease-in-out duration-150" 
                                       aria-label="Go to page {{ $page }}">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" rel="next" 
                           class="relative inline-flex items-center px-3 py-2 -ml-px text-sm font-medium text-white bg-white/10 border border-white/20 rounded-r-lg leading-5 hover:bg-white/20 focus:z-10 focus:outline-none focus:ring focus:ring-primary focus:ring-offset-0 active:bg-white/30 transition ease-in-out duration-150" 
                           aria-label="Next">
                            <i class="fas fa-chevron-right text-xs"></i>
                        </a>
                    @else
                        <span aria-disabled="true" aria-label="Next">
                            <span class="relative inline-flex items-center px-3 py-2 -ml-px text-sm font-medium text-gray-500 bg-gray-800 border border-gray-600 cursor-default rounded-r-lg leading-5" aria-hidden="true">
                                <i class="fas fa-chevron-right text-xs"></i>
                            </span>
                        </span>
                    @endif
                </span>
            </div>
        </div>
    </nav>

    <!-- Jump to Page (Optional) -->
    @if ($paginator->lastPage() > 10)
        <div class="mt-6 flex items-center justify-center">
            <div class="flex items-center space-x-3">
                <label for="jumpToPage" class="text-sm text-gray-400">Jump to page:</label>
                <select id="jumpToPage" onchange="window.location.href = this.value" 
                        class="px-3 py-1 bg-white/10 border border-white/20 rounded-lg text-white text-sm focus:outline-none focus:ring-2 focus:ring-primary">
                    @for ($i = 1; $i <= $paginator->lastPage(); $i++)
                        <option value="{{ $paginator->url($i) }}" {{ $i == $paginator->currentPage() ? 'selected' : '' }}>
                            {{ $i }}
                        </option>
                    @endfor
                </select>
            </div>
        </div>
    @endif

    <!-- Page Size Selector (Optional) -->
    @if (request()->has('per_page') || $paginator->perPage() != 15)
        <div class="mt-4 flex items-center justify-center">
            <div class="flex items-center space-x-3">
                <label class="text-sm text-gray-400">Items per page:</label>
                <select onchange="changePerPage(this.value)" 
                        class="px-3 py-1 bg-white/10 border border-white/20 rounded-lg text-white text-sm focus:outline-none focus:ring-2 focus:ring-primary">
                    <option value="12" {{ request('per_page', 12) == 12 ? 'selected' : '' }}>12</option>
                    <option value="24" {{ request('per_page') == 24 ? 'selected' : '' }}>24</option>
                    <option value="48" {{ request('per_page') == 48 ? 'selected' : '' }}>48</option>
                    <option value="96" {{ request('per_page') == 96 ? 'selected' : '' }}>96</option>
                </select>
            </div>
        </div>

        <script>
        function changePerPage(perPage) {
            const url = new URL(window.location);
            url.searchParams.set('per_page', perPage);
            url.searchParams.delete('page'); // Reset to page 1
            window.location.href = url.toString();
        }
        </script>
    @endif
@endif

<style>
/* Custom pagination styles */
.pagination-container {
    font-family: 'Inter', sans-serif;
}

/* Smooth hover transitions */
nav a {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Active page gradient animation */
@keyframes gradient-shift {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

span[aria-current="page"] span {
    background-size: 200% 200%;
    animation: gradient-shift 3s ease infinite;
}

/* Focus ring improvements */
nav a:focus {
    box-shadow: 0 0 0 3px rgba(197, 48, 48, 0.3);
}

/* Responsive improvements */
@media (max-width: 640px) {
    .pagination-container {
        padding: 0 1rem;
    }
    
    nav span,
    nav a {
        min-width: 44px; /* Better touch targets */
        min-height: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
}
</style>