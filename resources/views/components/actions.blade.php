<div class="flex space-x-2">
    <button wire:click="edit({{ $row->id }})" class="px-3 py-1 text-white bg-green-500 rounded">
        Edit
    </button>

    <button wire:click="confirmDelete({{ $row->id }})" class="px-3 py-1 text-white bg-red-500 rounded">
        Delete
    </button>
</div>