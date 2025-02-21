<div x-data="{ editing: false, value: @entangle('value').defer }" class="relative w-full">
    <span x-show="!editing" @click="editing = true" class="cursor-pointer hover:text-blue-500 block w-full" x-cloak>
        {{ $value }}
    </span>

    <input x-show="editing" x-model="value" x-on:keydown.enter="Livewire.dispatch('updateColumn', { id: {{ $id }}, column: '{{ $column }}', value: value }); editing = false;" x-on:blur="editing = false" class="border px-2 py-1 w-full absolute left-0 top-0 bg-white z-50 shadow-md" x-cloak>
</div>