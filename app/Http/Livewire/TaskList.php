<?php

namespace App\Http\Livewire;

use App\Models\TaskCategory;
use App\Models\Tasks;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
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
        // Validate input
        $this->validate([
            'newTask' => 'required|string|max:255',
            'newDescription' => 'required|string|max:255',
            'newCategory' => 'required',
            'assignedTo' => 'required',
        ]);

        // Create new task category
        Tasks::create([
            'title' => $this->newTask,
            'category' => $this->newCategory,
            'description' => $this->newDescription,
            'status' => 1, // Default value
            'assigned_to' => $this->assignedTo, // Logged-in user ID
            'created_by' => Auth::id(), // Logged-in user ID
            'deleted_by' => null, // No deleter at creation
            'completed_by' => null, // No completed by at creation
            'deleted' => false, // Default to not deleted
        ]);

        // Reset input field
        $this->newTask = '';
        $this->newDescription = '';
        $this->newCategory = '';
        $this->assignedTo = '';

        // Emit event to refresh table
        $this->dispatch('refreshDatatable');

        // Optional: Send a flash message (if using Alpine.js or similar)
        session()->flash('message', 'Task added successfully!');
    }

    public function removeTask($index)
    {
        unset($this->tasks[$index]);
        $this->tasks = array_values($this->tasks);
    }

    public function render()
    {
        $this->users = User::all();
        $this->categories = TaskCategory::where([['deleted', 0], ['status', 1]])->get();
        return view('livewire.task-list', [
            'users' => $this->users,
            'categories' => $this->categories,
        ]);
    }
}
