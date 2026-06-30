@props([
    'title',
    'subtitle' => null
])

<div class="mb-8">
    <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight leading-none mb-2">
        {{ $title }}
    </h1>
    @if ($subtitle)
        <p class="text-sm text-gray-500 font-light">
            {{ $subtitle }}
        </p>
    @endif
</div>
