<?php

namespace App\View\Components;

use App\Models\TaskCategory;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CategorySelect extends Component
{
    public $categories;
    public $model;

    public function __construct($model)
    {
        $this->categories = TaskCategory::where('deleted', 0)->get();
        $this->model = $model;
    }


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.category-select');
    }
}
