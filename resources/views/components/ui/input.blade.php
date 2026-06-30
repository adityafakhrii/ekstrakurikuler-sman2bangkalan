@props([
    'label' => null,
    'name',
    'type' => 'text',
    'placeholder' => '',
    'value' => ''
])

<div class="w-full">
    @if($label)
        <label for="{{ $name }}" class="block text-sm font-semibold text-gray-800 mb-2">
            {{ $label }}
        </label>
    @endif
    
    <input type="{{ $type }}" 
           id="{{ $name }}" 
           name="{{ $name }}" 
           value="{{ old($name, $value) }}"
           placeholder="{{ $placeholder }}"
           {{ $attributes->merge(['class' => 'input-field']) }}>
           
    @error($name)
        <p class="text-xs text-red-600 mt-1.5 font-medium">{{ $message }}</p>
    @enderror
</div>
