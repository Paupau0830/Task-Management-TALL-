<div class="w-full">
    <select wire:model="{{ $model }}" class="w-full h-10 px-3 border rounded-lg focus:ring focus:ring-blue-300 bg-white">
        <option value="">Category Select</option>
        @foreach ($categories as $category)
        <option value="{{ $category->id }}">{{ ucfirst($category->title) }}</option>
        @endforeach
    </select>

    @error($model)
    <span class="text-red-500 text-sm">{{ $message }}</span>
    @enderror
</div>