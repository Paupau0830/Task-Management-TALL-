<div class="w-full max-w-7xl mx-auto mt-10 bg-white shadow-lg rounded-lg p-6">
    <h2 class="text-2xl font-bold mb-4">Task List</h2>

    <div class="grid grid-cols-4 gap-2 mb-4">
        <x-form-input label="" name="newTask" type="text" placeholder="Task Title" />
        <x-form-input label="" name="newDescription" type="text" placeholder="Task Description" />
        <x-category-select model="newCategory" />
        <x-user-select model="assignedTo" />
    </div>

    <button wire:click="addTask" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
        Add
    </button>

    <table class="w-full border-collapse border border-gray-300 mt-4">
        <thead>
            <tr class="bg-gray-100">
                <th class="border border-gray-300 px-4 py-2 text-left">Title</th>
                <th class="border border-gray-300 px-4 py-2 text-left">Description</th>
                <th class="border border-gray-300 px-4 py-2 text-left">Category</th>
                <th class="border border-gray-300 px-4 py-2 text-left">Assigned To</th>
                <th class="border border-gray-300 px-4 py-2 text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tasks as $index => $task)
            <tr>
                <td class="border border-gray-300 px-4 py-2">{{ $task['title'] }}</td>
                <td class="border border-gray-300 px-4 py-2">{{ $task['description'] }}</td>
                <td class="border border-gray-300 px-4 py-2">
                    {{ optional($categories->firstWhere('id', $task['category']))->title ?? 'Unassigned' }}
                </td>
                <td class="border border-gray-300 px-4 py-2">
                    {{ optional($users->firstWhere('id', $task['assigned_to']))->name ?? 'Unassigned' }}
                </td>
                <td class="border border-gray-300 px-4 py-2 text-center">
                    <button wire:click="removeTask({{ $index }})" class="text-red-500 hover:text-red-700">
                        ✖
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>