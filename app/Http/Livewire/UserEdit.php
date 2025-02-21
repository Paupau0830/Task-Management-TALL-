<?php

namespace App\Http\Livewire;

use Livewire\Component;

class UserEdit extends Component
{
    public $id;

    public function render()
    {
        return view('livewire.user-edit');
    }

    public function mount($id)
    {
        $this->id = $id;
    }
}
