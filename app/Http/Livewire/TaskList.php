<?php

namespace App\Http\Livewire;

use App\Models\TaskCategory;
use App\Models\User;
use Livewire\Component;

class TaskList extends Component
{
    public $users;
    public $categories;
    public $tasks = [];
    public $newTask = '';
    public $newDescription = '';
    public $newCategory = '';
    public $assignedTo = '';

    public function addTask()
    {
        if (!empty($this->newTask) && !empty($this->newDescription) && !empty($this->newCategory) && !empty($this->assignedTo)) {
            $this->tasks[] = [
                'title' => $this->newTask,
                'description' => $this->newDescription,
                'category' => $this->newCategory,
                'assigned_to' => $this->assignedTo,
            ];

            $this->newTask = '';
            $this->newDescription = '';
            $this->newCategory = '';
            $this->assignedTo = '';
        }
    }

    public function removeTask($index)
    {
        unset($this->tasks[$index]);
        $this->tasks = array_values($this->tasks);
    }

    public function render()
    {
        $this->users = User::all();
        $this->categories = TaskCategory::where('deleted', '0')->get();
        return view('livewire.task-list', [
            'users' => $this->users,
            'categories' => $this->categories,
        ]);
    }
}
