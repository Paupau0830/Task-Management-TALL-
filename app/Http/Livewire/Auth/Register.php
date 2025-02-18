<?php

namespace App\Http\Livewire\Auth;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class Register extends Component
{
    public $name, $email, $password, $role, $password_confirmation;

    protected $rules = [
        'name' => 'required|min:3',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6|confirmed',
    ];

    public function register()
    {
        $this->validate();

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'user_role' => $this->role,
            'password' => Hash::make($this->password),
        ]);

        session()->flash('message', 'Registration successful!');
        return redirect()->route('login');
    }

    public function render()
    {
        return view('livewire.auth.register');
    }
}
