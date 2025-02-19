<?php

namespace App\Http\Livewire;

use App\Models\TaskCategory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;

class TaskCategoryTable extends DataTableComponent
{
    // Define the model
    protected $model = TaskCategory::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setDefaultSort('created_at', 'desc');
        $this->setColumnSelectStatus(true);

        $this->listeners[] = 'refreshDatatable'; // Listen for the refresh event
    }

    public function refreshDatatable()
    {
        $this->setPage(1);
    }


    public function columns(): array
    {
        return [
            Column::make('ID', 'id')->sortable()->searchable(),
            Column::make('Title', 'title')->sortable()->searchable(),
            Column::make('Status', 'status')->sortable(),
            Column::make('Created By', 'creator.name')->sortable(),
            Column::make('Deleted By', 'deleter.name')->sortable(),
            Column::make('Deleted', 'deleted')->sortable()
                ->format(fn ($value) => $value ? 'Yes' : 'No'),
            Column::make('Created At', 'created_at')->sortable()
                ->format(fn ($value) => \Carbon\Carbon::parse($value)->format('Y-m-d H:i:s')),

            ButtonGroupColumn::make('Actions')
                ->buttons([
                    LinkColumn::make('Delete') // Delete Button
                        ->title(fn ($row) => 'Delete')
                        ->location(fn ($row) => '#')
                        ->attributes(fn ($row) => [
                            'class' => 'text-red-500 hover:underline cursor-pointer',
                            'wire:click' => "deleteCategory({$row->id})"
                        ]),
                ]),


        ];
    }

    public function builder(): Builder
    {
        return TaskCategory::query()
            ->where('deleted', 0)
            ->with(['creator', 'deleter']);
    }

    public function deleteCategory($id)
    {
        $category = TaskCategory::find($id);

        if ($category) {
            $category->update([
                'deleted' => 1,
                'deleted_by' => Auth::id(),
            ]);

            $this->dispatch('refreshDatatable'); // Refresh table after update
        }
    }
}
