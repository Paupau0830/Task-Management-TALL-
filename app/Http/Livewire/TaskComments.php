<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Comment;
use App\Models\Comments;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TaskComments extends Component
{
    public $taskId;
    public $newComment;

    protected $rules = [
        'newComment' => 'required|string|max:500',
    ];

    public function mount($taskId)
    {
        $this->taskId = $taskId;
    }

    public function addComment()
    {
        $this->validate();

        Comments::create([
            'task_id' => $this->taskId,
            'user_id' => Auth::id(),
            'content' => $this->newComment,
        ]);

        $this->newComment = ''; // Clear input
        $this->dispatch('refreshComments');
    }

    public function deleteComment($commentId)
    {
        Comments::where('id', $commentId)->where('user_id', Auth::id())->delete();
        $this->dispatch('refreshComments');
    }

    public function render()
    {
        return view('livewire.task-comments', [
            'comments' => Comments::where('task_id', $this->taskId)->latest()->get(),
        ]);
    }
}
