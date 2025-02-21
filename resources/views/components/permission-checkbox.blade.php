<div class="flex items-center space-x-2">
    <input type="checkbox" id="{{ Str::slug($name) }}" name="{{ $name }}" wire:model="{{ $name }}" class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring focus:ring-blue-300">

    <label for="{{ Str::slug($name) }}" class="text-gray-700 text-sm font-medium">
        {{ $label }}
    </label>
</div>