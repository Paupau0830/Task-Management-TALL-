<div class="relative w-full">
    <select x-data @change="$wire.dispatch('updateColumn', { id: {{ $id }}, column: '{{ $column }}', value: $event.target.value })" class="border p-2 rounded w-full absolute left-0 top-0 bg-white z-50 shadow-md" x-cloak>

        @foreach ($options as $optionId => $optionName)
        <option value="{{ $optionId }}" {{ $value == $optionId ? 'selected' : '' }}>
            {{ $optionName }}
        </option>
        @endforeach
    </select>
</div>