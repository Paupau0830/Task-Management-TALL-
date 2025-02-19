<div class="mb-4">
    <label class="block text-sm font-medium">{{ $label }}</label>
    <input type="{{ $type }}" name="{{ $name }}" wire:model="{{ $name }}" x-model="{{ $name }}" @input="$wire.set('{{ $name }}', {{ $name }})" class="w-full border rounded px-3 py-2" placeholder="{{ $placeholder }}">
    <span x-text="errors.{{ $name }}" class="text-red-500 text-sm"></span>
    @error($name) <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
</div>