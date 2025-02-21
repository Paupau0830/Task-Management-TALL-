<?php

namespace App\View\Components;

use App\Models\TaskStatuses;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TaskStatusSelect extends Component
{
    public $statuses;
    public $model;

    public function __construct($model)
    {
        $this->statuses = TaskStatuses::where('deleted', 0)->get();
        $this->model = $model;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.task-status-select');
    }
}
