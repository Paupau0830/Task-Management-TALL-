<select x-data @change="$wire.dispatch('updateColumn', { id: {{ $id }}, column: '{{ $column }}', value: $event.target.value })" class="border p-2 rounded">
    @foreach ($options as $option)
    <option value="{{ $option }}" {{ $value === $option ? 'selected' : '' }}>{{ $option }}</option>
    @endforeach
</select>