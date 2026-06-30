@props([
    'name',
    'value' => 0,
    'readonly' => false
])

<div x-data="{ 
    rating: {{ $value }}, 
    hoverRating: 0,
    readonly: {{ $readonly ? 'true' : 'false' }}
}" class="flex items-center gap-2">
    <!-- Hidden Input for Form Submission -->
    <input type="hidden" name="{{ $name }}" :value="rating">
    
    <template x-for="star in 5">
        <button type="button" 
                @click="if(!readonly) rating = star" 
                @mouseover="if(!readonly) hoverRating = star"
                @mouseleave="if(!readonly) hoverRating = 0"
                :class="readonly ? 'cursor-default' : 'cursor-pointer'"
                class="focus:outline-none transition-transform duration-100 active:scale-95"
                aria-label="Rate star">
            <!-- Stars styled matching screenshot: solid black filled when rated, empty thin black outline when unrated -->
            <svg class="w-8 h-8 transition-all duration-150" 
                 :class="(hoverRating ? star <= hoverRating : star <= rating) ? 'text-gray-900 fill-gray-900' : 'text-gray-900 fill-none'"
                 fill="none" 
                 stroke="currentColor" 
                 stroke-width="1.8" 
                 viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499c-.196-.399-.678-.399-.874 0L7.53 9.24l-6.27.63c-.44.045-.616.59-.283.896l4.847 4.45-.1.38-1.16 6.13c-.08.436.37.765.74.542l5.42-3.23 5.42 3.23c.37.223.82-.106.74-.542l-1.16-6.13 4.847-4.45c.33-.306.154-.851-.283-.896l-6.27-.63-3.076-5.741z" />
            </svg>
        </button>
    </template>
</div>
