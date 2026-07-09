@props([
    'paginator' => null, // Laravel length aware paginator
    'entries' => [10, 25, 50, 100],
    'currentEntries' => 10
])

<!-- Pagination Container conforming to the screenshot layout -->
<div class="flex flex-col gap-2 py-2 text-xs font-semibold text-gray-700 text-left">
    
    <!-- Top Row: Showing Entries Info -->
    <span class="text-xs font-semibold text-gray-800">Showing 1 to 3 of 3 Entries</span>
    
    <!-- Bottom Row: Dropdown and Prev/Next Navigation horizontally aligned -->
    <div class="flex items-center gap-1.5">
        <!-- Entries Dropdown -->
        <div class="relative" x-data="{ open: false, selected: {{ $currentEntries }} }">
            <button @click="open = !open" 
                    class="flex items-center gap-1.5 bg-white border border-gray-300 rounded-md px-2.5 py-1 text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-1 focus:ring-brand-accent cursor-pointer">
                <span x-text="selected"></span>
                <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                </svg>
            </button>
            <div x-show="open" 
                 @click.away="open = false"
                 class="absolute left-0 bottom-full mb-1 w-16 bg-white border border-gray-300 rounded shadow-lg z-50 text-center py-1"
                 style="display: none;">
                @foreach($entries as $entry)
                    <button @click="selected = {{ $entry }}; open = false" 
                            class="block w-full py-1 hover:bg-brand-primary/10 hover:text-brand-primary text-gray-700">
                        {{ $entry }}
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Buttons Prev & Next -->
        <div class="inline-flex rounded-md shadow-xs overflow-hidden">
            <button class="bg-[#111827] hover:bg-black text-white px-3.5 py-1.5 text-xs font-semibold transition-colors cursor-pointer border-0">
                Prev
            </button>
            <button class="bg-[#111827] hover:bg-black text-white px-3.5 py-1.5 text-xs font-semibold transition-colors border-l border-gray-700 cursor-pointer border-0">
                Next
            </button>
        </div>
    </div>

</div>
