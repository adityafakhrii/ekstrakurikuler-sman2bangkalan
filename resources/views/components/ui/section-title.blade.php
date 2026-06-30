@props([
    'title'
])

<div {{ $attributes->merge(['class' => 'border-b border-[#f2eaea] pb-2 mb-6 mt-8 first:mt-0']) }}>
    <h3 class="text-sm md:text-base font-bold text-[#2A1B60] tracking-wide uppercase">
        {{ $title }}
    </h3>
</div>
