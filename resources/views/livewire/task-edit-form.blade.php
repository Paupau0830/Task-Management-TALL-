<div x-data="tasksForm()" class="max-w-md mx-auto mt-10 p-6 bg-white rounded-lg">

    @if (session()->has('message'))
    <div class="bg-green-200 text-green-700 p-2 rounded mb-4">
        {{ session('message') }}
    </div>
    @endif

    <form wire:submit.prevent="updateTask">
        <div x-data="{ newTask: '{{ $newTask }}', newDescription: '{{ $newDescription }}' }">
            <x-form-input label="Task" name="newTask" type="text" placeholder="Task Title" x-model="newTask" />
            <x-form-input label="Task Description" name="newDescription" type="text" placeholder="Task Description" x-model="newDescription" />
        </div>

        <div class="grid grid-cols-2 gap-2 mb-4">
            <label class="block text-sm font-medium">Category:</label>
            <x-category-select model="newCategory" />
            <label class="block text-sm font-medium">Assigned To:</label>
            <x-user-select model="assignedTo" />
            <label class="block text-sm font-medium">Status:</label>
            <x-task-status-select model="status" />
        </div>

        <br>
        @can('edit tasks')
        <button type="submit" class="w-full bg-blue-500 text-white px-4 py-2 rounded">
            Update
        </button>
        @endcan
    </form>
</div>