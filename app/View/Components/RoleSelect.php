<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Spatie\Permission\Models\Role;

class RoleSelect extends Component
{
    public $roles;
    public $model;

    public function __construct($model)
    {
        $this->roles = Role::all();
        $this->model = $model;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.role-select');
    }
}
