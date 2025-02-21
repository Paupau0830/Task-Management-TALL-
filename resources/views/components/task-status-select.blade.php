<div class="w-full">
    <select wire:model="{{ $model }}" class="w-full h-10 px-3 border rounded-lg focus:ring focus:ring-blue-300 bg-white">
        <option value="">Status Select</option>
        @foreach ($statuses->whereNotIn('title', ['Deleted', 'Completed']) as $status)
        <option value="{{ $status->id }}">{{ ucfirst($status->title) }}</option>
        @endforeach

    </select>

    @error($model)
    <span class="text-red-500 text-sm">{{ $message }}</span>
    @enderror
</div>