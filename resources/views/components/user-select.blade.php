<div class="w-full">
    <select wire:model="{{ $model }}" class="w-full h-10 px-3 border rounded-lg focus:ring focus:ring-blue-300 bg-white">
        <option value="">Select User</option>
        @foreach ($users as $user)
        <option value="{{ $user->id }}">{{ ucfirst($user->name) }}</option>
        @endforeach
    </select>

    @error($model)
    <span class="text-red-500 text-sm">{{ $message }}</span>
    @enderror
</div>