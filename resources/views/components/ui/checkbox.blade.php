@props([
    'label',
    'name',
    'checked' => false
])

<label class="inline-flex items-center gap-2.5 cursor-pointer text-sm text-gray-700 select-none">
    <input type="checkbox" 
           name="{{ $name }}" 
           {{ $checked ? 'checked' : '' }}
           {{ $attributes->merge(['class' => 'w-4 h-4 text-brand-accent bg-gray-100 border-gray-300 rounded focus:ring-brand-accent/50 focus:ring-2 cursor-pointer']) }}>
    <span class="font-medium">{{ $label }}</span>
</label>
