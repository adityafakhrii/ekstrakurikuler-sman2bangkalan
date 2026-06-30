@props([
    'items' => []
])

<nav class="flex text-xs text-gray-500 font-medium tracking-wide uppercase" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-2">
        <li class="inline-flex items-center">
            <a href="{{ url('/') }}" class="hover:text-gray-900 transition-colors duration-150">Home</a>
        </li>
        @foreach ($items as $item)
            <li>
                <div class="flex items-center gap-1.5 md:gap-2">
                    <svg class="w-3.5 h-3.5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                    @if (isset($item['url']))
                        <a href="{{ $item['url'] }}" class="hover:text-gray-900 transition-colors duration-150">{{ $item['title'] }}</a>
                    @else
                        <span class="text-gray-800">{{ $item['title'] }}</span>
                    @endif
                </div>
            </li>
        @endforeach
    </ol>
</nav>
