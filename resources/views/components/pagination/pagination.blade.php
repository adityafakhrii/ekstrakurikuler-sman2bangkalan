@props([
    'paginator' => null,
    'entries' => [10, 25, 50, 100],
    'currentEntries' => 10,
])

<div class="flex flex-col gap-1.5 text-left">
    <p class="text-xs font-medium text-gray-800 leading-none">
        @if ($paginator)
            Showing {{ $paginator->firstItem() ?? 0 }} to {{ $paginator->lastItem() ?? 0 }} of {{ $paginator->total() }} Entries
        @else
            Showing 0 to 0 of 0 Entries
        @endif
    </p>

    <div class="flex items-center gap-1">
        <form method="GET" action="{{ url()->current() }}" class="flex items-center">
            @foreach(request()->except(['per_page', 'page']) as $key => $value)
                @if(is_array($value))
                    @foreach($value as $nestedValue)
                        <input type="hidden" name="{{ $key }}[]" value="{{ $nestedValue }}">
                    @endforeach
                @else
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endif
            @endforeach

            <select name="per_page" onchange="this.form.submit()"
                class="h-7 text-xs font-medium text-gray-800 bg-white border border-gray-400 rounded-md px-2 py-0 focus:outline-none focus:ring-1 focus:ring-[#6366F1] cursor-pointer">
                @foreach($entries as $entry)
                    <option value="{{ $entry }}" {{ (int) request('per_page', $paginator ? $paginator->perPage() : $currentEntries) === (int) $entry ? 'selected' : '' }}>
                        {{ $entry }}
                    </option>
                @endforeach
            </select>
        </form>

        <div class="inline-flex items-center overflow-hidden rounded-md shadow-xs">
            @if ($paginator && !$paginator->onFirstPage())
                <a href="{{ $paginator->previousPageUrl() }}"
                    class="h-7 inline-flex items-center bg-black hover:bg-gray-900 text-white px-3 text-xs font-semibold transition-colors no-underline">
                    Prev
                </a>
            @else
                <span class="h-7 inline-flex items-center bg-gray-200 text-gray-400 px-3 text-xs font-semibold cursor-not-allowed">
                    Prev
                </span>
            @endif

            @if ($paginator && $paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}"
                    class="h-7 inline-flex items-center bg-black hover:bg-gray-900 text-white px-3 text-xs font-semibold transition-colors border-l border-white/20 no-underline">
                    Next
                </a>
            @else
                <span class="h-7 inline-flex items-center bg-gray-200 text-gray-400 px-3 text-xs font-semibold border-l border-gray-300 cursor-not-allowed">
                    Next
                </span>
            @endif
        </div>
    </div>
</div>
