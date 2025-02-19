<div>
    @if (session()->has('message'))
    <div class="p-2 text-green-600 bg-green-100 rounded-lg">
        {{ session('message') }}
    </div>
    @endif
    <br>
    <div class="flex gap-2">
        <input type="text" wire:model="category" class="w-full p-2 border rounded-lg focus:ring focus:ring-blue-300" placeholder="Enter a new category">
        <button wire:click="addCategory" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
            Add
        </button>
    </div>
</div>