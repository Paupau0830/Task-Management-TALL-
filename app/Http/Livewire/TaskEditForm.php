<?php

namespace App\Http\Livewire;

use App\Models\TaskCategory;
use App\Models\Tasks;
use App\Models\User;
use Livewire\Component;

class TaskEditForm extends Component
{
    public $users;
    public $categories;
    public $taskID;
    public $tasks = [];
    public $newTask = '';
    public $newDescription = '';
    public $newCategory = '';
    public $assignedTo = '';
    public $status = '';

    public function render()
    {
        $this->users = User::all();
        $this->categories = TaskCategory::where([['deleted', 0], ['status', 1]])->get();
        return view('livewire.task-edit-form', [
            'users' => $this->users,
            'categories' => $this->categories,
        ]);
    }

    public function mount($id)
    {
        $task = Tasks::find($id);
        $this->newTask = $task->title;
        $this->newDescription = $task->description;
        $this->newCategory = $task->category;
        $this->assignedTo = $task->assigned_to;
        $this->status = $task->status;
    }

    public function updateTask()
    {
        $task = Tasks::find($this->taskID);
        $task->title = $this->newTask;
        $task->description = $this->newDescription;
        $task->category = $this->newCategory;
        $task->assigned_to = $this->assignedTo;
        $task->save();
        session()->flash('message', 'Task updated successfully.');
    }
}
