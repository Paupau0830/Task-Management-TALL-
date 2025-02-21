<?php

namespace App\Http\Livewire;

use App\Models\TaskCategory;
use App\Models\Tasks;
use App\Models\User;
use Livewire\Component;

class TaskEdit extends Component
{
    public $users;
    public $categories;
    public $taskID;

    public function render()
    {
        $this->users = User::all();
        $this->categories = TaskCategory::where([['deleted', 0], ['status', 1]])->get();
        return view('livewire.task-edit', [
            'users' => $this->users,
            'categories' => $this->categories,
        ]);
    }

    public function mount($id)
    {
        $this->taskID = $id;
    }
}
