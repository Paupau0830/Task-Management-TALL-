<div class="w-full max-w-7xl mx-auto mt-10 bg-white shadow-lg rounded-lg p-6">
    <h2 class="text-2xl font-bold mb-4">New Task</h2>

    @if (session()->has('message'))
    <div class="p-2 text-green-600 bg-green-100 rounded-lg">
        {{ session('message') }}
    </div>
    @endif
    <br>
    <div class="grid grid-cols-2 gap-2 mb-4">
        <x-form-input label="" name="newTask" type="text" placeholder="Task Title" />
        <x-form-input label="" name="newDescription" type="text" placeholder="Task Description" />
    </div>

    <div class="grid grid-cols-2 gap-2 mb-4">
        <x-category-select model="newCategory" />
        <x-user-select model="assignedTo" />
    </div>

    <button wire:click="addTask" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 w-full">
        Add
    </button>

</div>