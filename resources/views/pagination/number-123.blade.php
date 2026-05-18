@if ($paginator->hasPages())
    <nav class="flex justify-center mt-4">
        <div class="inline-flex rounded-md shadow-sm">
            @for ($page = 1; $page <= min(3, $paginator->lastPage()); $page++)
                @if ($page == $paginator->currentPage())
                    <span class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-blue-600">
                        {{ $page }}
                    </span>
                @else
                    <a href="{{ $paginator->url($page) }}"
                       class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 hover:bg-gray-100">
                        {{ $page }}
                    </a>
                @endif
            @endfor
        </div>
    </nav>
@endif
