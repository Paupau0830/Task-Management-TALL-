<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\TaskCategory;
use Illuminate\Support\Facades\Auth;

class TaskCategoryForm extends Component
{
    public $category; // Input field value

    public function addCategory()
    {
        // Validate input
        $this->validate([
            'category' => 'required|string|max:255',
        ]);

        // Create new task category
        TaskCategory::create([
            'title' => $this->category,
            'status' => 1, // Default value
            'created_by' => Auth::id(), // Logged-in user ID
            'deleted_by' => null, // No deleter at creation
            'deleted' => false, // Default to not deleted
        ]);

        // Reset input field
        $this->category = '';

        // Emit event to refresh table
        $this->dispatch('refreshDatatable');

        // Optional: Send a flash message (if using Alpine.js or similar)
        session()->flash('message', 'Category added successfully!');
    }

    public function render()
    {
        return view('livewire.task-category-form');
    }
}
