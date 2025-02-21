<?php

namespace App\Http\Livewire;

use App\Models\StaticStatuses;
use App\Models\TaskCategory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\WireLinkColumn;

class TaskCategoryTable extends DataTableComponent
{
    // Define the model
    protected $model = TaskCategory::class;
    protected $listeners = ['deleteSelectedRows' => 'deleteSelected'];

    public array $selectedRows = [];
    public array $statusOptions = [];

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

    public function refreshDatatable()
    {
        $this->setPage(1);
    }

    public function mount()
    {
        $this->listeners[] = 'updateColumn';

        $this->statusOptions = StaticStatuses::where('deleted', 0) // Exclude deleted statuses
            ->pluck('title', 'id') // Returns an associative array [id => title]
            ->toArray();
    }

    public function updateColumn($id, $column, $value)
    {
        TaskCategory::where('id', $id)->update([$column => $value]);
        $this->dispatch('refreshDatatable'); // Refresh table after update
    }

    public function columns(): array
    {
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
            Column::make('Status', 'status')
                ->sortable()
                ->searchable()
                ->format(fn ($value, $row) => view('livewire.inline-select', [
                    'id' => $row->id,
                    'column' => 'status',
                    'value' => $value,
                    'options' => $this->statusOptions, // Dropdown options
                ])),
            Column::make('Created By', 'creator.name')->sortable(),
            // Column::make('Deleted By', 'deleter.name')->sortable(),
            // Column::make('Deleted', 'deleted')->sortable()
            //     ->format(fn ($value) => $value ? 'Yes' : 'No'),
            Column::make('Created At', 'created_at')->sortable()
                ->format(fn ($value) => \Carbon\Carbon::parse($value)->format('Y-m-d H:i:s')),
            Column::make('Updated At', 'updated_at')->sortable()
                ->format(fn ($value) => \Carbon\Carbon::parse($value)->format('Y-m-d H:i:s')),

            // WireLinkColumn::make("Delete")
            //     ->title(fn ($row) => 'Delete')
            //     ->confirmMessage('Are you sure you want to delete this item?')
            //     ->action(fn ($row) => 'deleteCategory("' . $row->id . '")')
            //     ->attributes(fn ($row) => [
            //         'class' => 'px-3 py-1 bg-red-500 text-white rounded hover:bg-blue-600',
            //     ]),

        ];
    }

    public function builder(): Builder
    {
        return TaskCategory::query()
            ->where('deleted', 0)
            ->with(['creator', 'deleter']);
    }

    // public function deleteCategory($id)
    // {
    //     $category = TaskCategory::find($id);

    //     if ($category) {
    //         $category->update([
    //             'deleted' => 1,
    //             'deleted_by' => Auth::id(),
    //         ]);

    //         $this->dispatch('refreshDatatable'); // Refresh table after update
    //     }
    // }

    public function deleteSelected()
    {
        TaskCategory::whereIn('id', $this->selectedRows)
            ->update([
                'deleted' => 1,
                'deleted_by' => auth()->id(),
            ]);

        $this->selectedRows = []; // Clear selection after deletion
        $this->dispatch('refreshDatatable'); // Refresh table
    }
}
