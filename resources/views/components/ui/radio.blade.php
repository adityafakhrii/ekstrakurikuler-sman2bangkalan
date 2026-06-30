@props([
    'label',
    'name',
    'value',
    'checked' => false
])

<label class="inline-flex items-center gap-2 cursor-pointer text-sm text-gray-700 select-none">
    <input type="radio" 
           name="{{ $name }}" 
           value="{{ $value }}" 
           {{ $checked ? 'checked' : '' }}
           {{ $attributes->merge(['class' => 'w-4 h-4 text-gray-900 bg-gray-100 border-gray-300 focus:ring-black focus:ring-2 focus:ring-offset-2 cursor-pointer']) }}>
    <span>{{ $label }}</span>
</label>
