@props([
    'title',
    'description'
])

<div class="bg-white border border-[#f2eaea] rounded-2xl p-6 shadow-xs hover:shadow-md transition-shadow duration-200 flex flex-col gap-3">
    @if(isset($icon))
        <div class="text-gray-800">
            {{ $icon }}
        </div>
    @endif
    
    <h3 class="text-base font-bold text-gray-900 leading-tight">
        {{ $title }}
    </h3>
    
    <p class="text-xs text-gray-500 font-normal leading-relaxed">
        {{ $description }}
    </p>
</div>
