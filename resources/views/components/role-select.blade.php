<div class="mb-4">
    <label class="block text-sm font-medium">Role</label>
    <select wire:model="{{ $model }}" class="w-full border rounded px-3 py-2">
        <option value="">Select Role</option>
        @foreach ($roles as $role)
        <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
        @endforeach
    </select>
    @error($model) <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
</div>