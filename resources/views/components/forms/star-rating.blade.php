@props([
    'name',
    'value' => 0,
    'readonly' => false
])

<div x-data="{
    rating: {{ $value }},
    hoverRating: 0,
    readonly: {{ $readonly ? 'true' : 'false' }},
    focusRating: 0
}"
     class="flex items-center gap-1"
     role="radiogroup"
     aria-label="Penilaian Bintang"
     @mouseleave="if(!readonly) hoverRating = 0">

    <!-- Hidden Input for Form Submission -->
    <input type="hidden" name="{{ $name }}" :value="rating">

    <template x-for="star in 5">
        <button type="button"
                role="radio"
                :aria-checked="rating === star"
                :tabindex="readonly ? '-1' : '0'"
                @click="if(!readonly) rating = star"
                @mouseover="if(!readonly) hoverRating = star"
                @focus="if(!readonly) focusRating = star"
                @blur="if(!readonly) focusRating = 0"
                @keydown.space.prevent="if(!readonly) rating = star"
                @keydown.enter.prevent="if(!readonly) rating = star"
                :class="readonly ? 'cursor-default' : 'cursor-pointer focus:outline-none focus:scale-110'"
                class="transition-all duration-100 p-0.5"
                :aria-label="'Bintang ' + star + ' dari 5'">
            <!-- Stars styled matching screenshot: solid yellow filled when rated, empty thin gray outline when unrated -->
            <svg class="w-8 h-8 transition-colors duration-150"
                 :class="((hoverRating || focusRating) ? star <= (hoverRating || focusRating) : star <= rating) ? 'text-yellow-400 fill-yellow-400' : 'text-gray-300 fill-none'"
                 fill="none"
                 stroke="currentColor"
                 stroke-width="1.8"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499c-.196-.399-.678-.399-.874 0L7.53 9.24l-6.27.63c-.44.045-.616.59-.283.896l4.847 4.45-.1.38-1.16 6.13c-.08.436.37.765.74.542l5.42-3.23 5.42 3.23c.37.223.82-.106.74-.542l-1.16-6.13 4.847-4.45c.33-.306.154-.851-.283-.896l-6.27-.63-3.076-5.741z" />
            </svg>
        </button>
    </template>
</div>
