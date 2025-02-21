<div>
    <div class="w-full mt-6 px-3">

        @can('create tasks')
        <!-- New Task Start -->
        <livewire:task-list />
        <!-- New Task End -->
        @endcan

        <div class="w-full max-w-7xl mx-auto mt-10 bg-white shadow-lg rounded-lg p-6">
            <h2 class="text-2xl font-bold mb-4">Task List</h2>

            <!-- Session message -->
            @if (session()->has('message'))
            <div class="p-2 text-green-600 bg-green-100 rounded-lg">
                {{ session('message') }}
            </div>
            @endif
            <br>
            <!-- Task List Start -->
            <livewire:task-table />
            <!-- Task List End -->
            <button x-data @click.stop.once="if (confirm('Are you sure you want to complete the selected rows?')) { $dispatch('completedSelectedRows') }" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600 w-full">
                Complete Selected
            </button>

            <!-- <button x-data @click.stop="if (!window.confirmed) { window.confirmed = confirm('Are you sure you want to complete the selected rows?'); if (window.confirmed) { $dispatch('completedSelectedRows') } }" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600 w-full">
                Complete Selected
            </button> -->

            <br>
            <br>
            @can('delete tasks')
            <button x-data @click.stop.once="if (confirm('Are you sure you want to delete the selected rows?')) { $dispatch('deleteSelectedRows') }" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 w-full">
                Delete Selected
            </button>
            <!-- <button x-data @click.stop="if (!window.confirmed) { window.confirmed = confirm('Are you sure you want to delete the selected rows?'); if (window.confirmed) { $dispatch('deleteSelectedRows') } }" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 w-full">
                Delete Selected
            </button> -->
            @endcan
        </div>

    </div>

</div>