<div x-data="{ editing: false, value: @entangle('value').defer }">
    <span x-show="!editing" @click="editing = true" class="cursor-pointer hover:text-blue-500">
        {{ $value }}
    </span>

    <input x-show="editing" x-model="value" x-on:keydown.enter="Livewire.dispatch('updateColumn', { id: {{ $id }}, column: '{{ $column }}', value: value }); editing = false;" x-on:blur="editing = false" class="border px-2 py-1 w-full">
</div>