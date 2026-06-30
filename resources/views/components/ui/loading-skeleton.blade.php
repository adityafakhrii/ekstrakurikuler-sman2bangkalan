@props([
    'type' => 'card', // card, table, text, list
    'count' => 1
])

<div {{ $attributes->merge(['class' => 'space-y-4 w-full']) }}>
    @for($i = 0; $i < $count; $i++)
        @if($type === 'card')
            <div class="card-main border border-[#f2eaea] shadow-xs">
                <div class="skeleton-pulse h-6 w-1/3 mb-4"></div>
                <div class="skeleton-pulse h-4 w-full mb-2"></div>
                <div class="skeleton-pulse h-4 w-5/6 mb-4"></div>
                <div class="skeleton-pulse h-10 w-24"></div>
            </div>
        @elseif($type === 'table')
            <div class="space-y-3">
                <div class="grid grid-cols-4 gap-4 pb-2 border-b border-[#f2eaea]">
                    <div class="skeleton-pulse h-5 w-1/2"></div>
                    <div class="skeleton-pulse h-5 w-3/4"></div>
                    <div class="skeleton-pulse h-5 w-2/3"></div>
                    <div class="skeleton-pulse h-5 w-1/2"></div>
                </div>
                @for($j = 0; $j < 3; $j++)
                    <div class="grid grid-cols-4 gap-4 py-2 border-b border-[#f2eaea]/50">
                        <div class="skeleton-pulse h-4 w-2/3"></div>
                        <div class="skeleton-pulse h-4 w-5/6"></div>
                        <div class="skeleton-pulse h-4 w-1/2"></div>
                        <div class="skeleton-pulse h-4 w-3/4"></div>
                    </div>
                @endfor
            </div>
        @elseif($type === 'text')
            <div class="space-y-2">
                <div class="skeleton-pulse h-4 w-full"></div>
                <div class="skeleton-pulse h-4 w-11/12"></div>
                <div class="skeleton-pulse h-4 w-5/6"></div>
            </div>
        @elseif($type === 'list')
            <div class="flex items-center gap-3">
                <div class="skeleton-pulse w-10 h-10 rounded-full"></div>
                <div class="flex-grow space-y-1.5">
                    <div class="skeleton-pulse h-4 w-1/4"></div>
                    <div class="skeleton-pulse h-3 w-1/2"></div>
                </div>
            </div>
        @endif
    @endfor
</div>
