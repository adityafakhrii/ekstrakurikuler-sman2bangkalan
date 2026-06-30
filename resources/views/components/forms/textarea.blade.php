@props([
    'label' => null,
    'name',
    'rows' => 4,
    'placeholder' => '',
    'value' => ''
])

<div class="w-full">
    @if($label)
        <label for="{{ $name }}" class="block text-sm font-semibold text-gray-800 mb-2">
            {{ $label }}
        </label>
    @endif
    
    <textarea id="{{ $name }}" 
              name="{{ $name }}" 
              rows="{{ $rows }}"
              placeholder="{{ $placeholder }}"
              {{ $attributes->merge(['class' => 'input-field resize-none']) }}>{{ old($name, $value) }}</textarea>
              
    @error($name)
        <p class="text-xs text-red-600 mt-1.5 font-medium">{{ $message }}</p>
    @enderror
</div>
