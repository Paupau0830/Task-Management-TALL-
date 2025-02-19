<?php

namespace App\Http\Livewire;

use App\Models\TaskCategory;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TaskCategories extends Component
{
    public function render()
    {
        return view('livewire.task-categories');
    }
}
