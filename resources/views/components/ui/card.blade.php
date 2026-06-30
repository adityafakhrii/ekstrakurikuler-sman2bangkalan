@props([
    'title' => null,
    'underline' => true
])

<div {{ $attributes->merge(['class' => 'card-main']) }}>
    @if($title)
        <div class="text-center mb-8 relative">
            <h2 class="text-2xl md:text-3xl font-semibold text-[#2A1B60] tracking-wide inline-block">
                {{ $title }}
            </h2>
            @if($underline)
                <!-- Underline styling like screenshots -->
                <div class="h-1.5 w-24 bg-brand-primary/20 mx-auto mt-3 rounded-full"></div>
            @endif
        </div>
    @endif

    {{ $slot }}
</div>
