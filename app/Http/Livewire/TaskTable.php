<?php

namespace App\Http\Livewire;

use App\Models\TaskCategory;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Tasks;
use App\Models\TaskStatuses;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\WireLinkColumn;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\TextFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateFilter;

class TaskTable extends DataTableComponent
{
    protected $model = Tasks::class;

    protected $listeners = ['deleteSelectedRows' => 'deleteSelected', 'completedSelectedRows' => 'completeSelected'];

    public array $selectedRows = [];

    public array $userOptions = [];
    public array $categoriesOptions = [];
    public array $taskStatusOptions = [];

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setDefaultSort('created_at', 'desc');
        $this->setColumnSelectStatus(true);

        $this->listeners = array_merge($this->listeners, [
            'refreshDatatable' => 'refreshDatatable',
            'updateColumn' => 'updateColumn',
        ]);
    }

    public function filters(): array
    {
        return [
            // Dropdown filter
            SelectFilter::make('Status')
                ->options([
                    '' => 'All',  // Show all by default
                    'Open' => 'Open',
                    'Ongoing' => 'Ongoing',
                    'Completed' => 'Completed',
                    'Deleted' => 'Deleted',
                ])
                ->filter(function ($query, $value) {
                    if ($value) {
                        $query->where('tasks.status', $value);
                    }
                }),

            // Searchable text filter
            TextFilter::make('Title')
                ->filter(function ($query, $value) {
                    $query->where('tasks.title', 'like', '%' . $value . '%');
                }),

            // Date filter
            DateFilter::make('Created At')
                ->filter(function ($query, $value) {
                    $query->whereDate('tasks.created_at', '=', $value);
                }),
        ];
    }

    public function refreshDatatable()
    {
        $this->setPage(1);
    }

    public function mount()
    {
        $this->listeners[] = 'updateColumn';

        // Fetch status options from the database
        $this->userOptions = User::pluck('name', 'id')
            ->toArray();

        // Fetch categories options from the database
        $this->categoriesOptions = TaskCategory::where([['status', 1], ['deleted', 0],]) // Exclude inactive categories and/or deleted
            ->pluck('title', 'id')
            ->toArray();

        $this->taskStatusOptions = TaskStatuses::where('deleted', 0) // Exclude deleted statuses
            ->pluck('title', 'id') // Returns an associative array [id => title]
            ->toArray();
    }

    public function updateColumn($id, $column, $value)
    {
        Tasks::where('id', $id)->update([$column => $value]);

        if ($column != 'status') {
            Tasks::where('id', $id)->update(['status' => 1]);
        }

        $this->dispatch('refreshDatatable'); // Refresh table after update
    }

    public function columns(): array
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        if ($user->hasPermissionTo('edit tasks')) {
            // User has edit permissions, show inline edit/select fields
            return [
                Column::make('', 'id')
                    ->format(fn ($value, $row) => view('livewire.checkbox', ['id' => $row->id])),

                Column::make('No.', 'id')->sortable()->searchable(),

                Column::make('Title', 'title')
                    ->sortable()
                    ->searchable()
                    ->format(fn ($value, $row) => view('livewire.inline-edit', [
                        'id' => $row->id,
                        'column' => 'title',
                        'value' => $value,
                    ])),

                Column::make('Description', 'description')
                    ->sortable()
                    ->searchable()
                    ->format(fn ($value, $row) => view('livewire.inline-edit', [
                        'id' => $row->id,
                        'column' => 'description',
                        'value' => $value,
                    ])),

                Column::make('Task Category', 'category')
                    ->sortable()
                    ->searchable()
                    ->format(fn ($value, $row) => view('livewire.inline-select', [
                        'id' => $row->id,
                        'column' => 'category',
                        'value' => $row->categories->id ?? null, // Ensure it gets the ID
                        'options' => $this->categoriesOptions,
                    ])),

                Column::make('Task Status', 'status')
                    ->sortable()
                    ->searchable()
                    ->format(fn ($value, $row) => view('livewire.inline-select', [
                        'id' => $row->id,
                        'column' => 'status',
                        'value' => $value,
                        'options' => collect($this->taskStatusOptions)
                            ->reject(fn ($status) => $status === 'Deleted' || ($row->status !== 'Completed' && $status === 'Completed'))
                            ->toArray(),
                    ])),

                Column::make('Task Assigned To', 'assigned_to')
                    ->sortable()
                    ->searchable()
                    ->format(fn ($value, $row) => view('livewire.inline-select', [
                        'id' => $row->id,
                        'column' => 'assigned_to',
                        'value' => $row->assigned_to, // Use ID instead of name
                        'options' => $this->userOptions,
                    ])),

                Column::make('Created By', 'creator.name')->sortable(),
                Column::make('Created At', 'created_at')->sortable()
                    ->format(fn ($value) => \Carbon\Carbon::parse($value)->format('Y-m-d H:i:s')),
                Column::make('Updated At', 'updated_at')->sortable()
                    ->format(fn ($value) => \Carbon\Carbon::parse($value)->format('Y-m-d H:i:s')),
                Column::make('', 'id') // Use 'id' but keep the header empty
                    ->format(fn ($value, $row) => view('components.task-actions', ['task' => $row])) // Render Blade component
                    ->html(),
            ];
        } else {
            // User does NOT have edit permissions, show plain text columns
            return [
                Column::make('Id')
                    ->format(fn ($value, $row) => view('livewire.checkbox', ['id' => $row->id])),

                Column::make('No.', 'id')->sortable()->searchable(),

                Column::make('Title', 'title')->sortable()->searchable(),
                Column::make('Description', 'description')->sortable()->searchable(),
                Column::make('Task Category', 'categories.title')->sortable()->searchable(),

                Column::make('Task Status', 'status')
                    ->sortable()
                    ->searchable()
                    ->format(fn ($value, $row) => view('livewire.inline-select', [
                        'id' => $row->id,
                        'column' => 'status',
                        'value' => $value,
                        'options' => collect($this->taskStatusOptions)
                            ->reject(fn ($status) => $status === 'Deleted') // Always remove "Deleted"
                            ->when($value !== 'Completed', fn ($statuses) => $statuses->reject(fn ($status) => $status === 'Completed')) // Hide "Completed" unless it's selected
                            ->toArray(),
                    ])),


                Column::make('Task Assigned To', 'assignee.name')
                    ->sortable()
                    ->searchable()
                    ->format(fn ($value) => $value),

                Column::make('Created By', 'creator.name')->sortable(),
                Column::make('Created At', 'created_at')->sortable()
                    ->format(fn ($value) => \Carbon\Carbon::parse($value)->format('Y-m-d H:i:s')),
                Column::make('Updated At', 'updated_at')->sortable()
                    ->format(fn ($value) => \Carbon\Carbon::parse($value)->format('Y-m-d H:i:s')),
                Column::make('', 'id') // Use 'id' but keep the header empty
                    ->format(fn ($value, $row) => view('components.task-actions', ['task' => $row])) // Render Blade component
                    ->html(),
            ];
        }
    }

    public function builder(): Builder
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        if ($user->hasRole('admin')) {
            return Tasks::query()
                ->where('tasks.deleted', 0)
                ->with(['creator', 'deleter', 'assignee', 'categories']);
        } else {
            return Tasks::query()
                ->where('tasks.deleted', 0)
                ->where('tasks.assigned_to', $user->id)
                ->with(['creator', 'deleter', 'assignee', 'categories']);
        }
    }

    public function deleteTask($id)
    {
        $task = Tasks::find($id);

        if ($task) {
            $task->update([
                'deleted' => 1,
                'deleted_by' => Auth::id(),
            ]);

            $this->dispatch('refreshDatatable'); // Refresh table after update
        }
    }

    public function deleteSelected()
    {
        Tasks::whereIn('id', $this->selectedRows)
            ->update([
                'deleted' => 1,
                'deleted_by' => auth()->id(),
            ]);

        $this->selectedRows = []; // Clear selection after deletion
        $this->dispatch('refreshDatatable'); // Refresh table
    }

    public function completeSelected()
    {
        Tasks::whereIn('id', $this->selectedRows)
            ->update([
                'status' => 'Completed',
                'completed_by' => auth()->id(),
            ]);

        $this->selectedRows = []; // Clear selection after deletion
        $this->dispatch('refreshDatatable'); // Refresh table
        session()->flash('message', 'Task completed successfully!');
    }
}
