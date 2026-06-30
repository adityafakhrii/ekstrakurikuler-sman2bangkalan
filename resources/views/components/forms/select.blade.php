@props([
    'label' => null,
    'name',
    'options' => [], // Format: ['value' => 'label'] atau array biasa
    'value' => ''
])

<div class="w-full">
    @if($label)
        <label for="{{ $name }}" class="block text-sm font-semibold text-gray-800 mb-2">
            {{ $label }}
        </label>
    @endif
    
    <div class="relative">
        <select id="{{ $name }}" 
                name="{{ $name }}" 
                {{ $attributes->merge(['class' => 'input-field appearance-none cursor-pointer pr-10']) }}>
            @foreach($options as $val => $lbl)
                <option value="{{ $val }}" {{ old($name, $value) == $val ? 'selected' : '' }}>
                    {{ $lbl }}
                </option>
            @endforeach
        </select>
        <!-- Custom Dropdown Arrow -->
        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-500">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
            </svg>
        </div>
    </div>
              
    @error($name)
        <p class="text-xs text-red-600 mt-1.5 font-medium">{{ $message }}</p>
    @enderror
</div>
