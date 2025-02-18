<?php

namespace App\Http\Livewire\Auth;

use Livewire\Component;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class Register extends Component
{
    public $name, $email, $password, $password_confirmation, $role;

    protected $rules = [
        'name' => 'required|min:3',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6|confirmed',
        'role' => 'required|exists:roles,name',
    ];

    public function register()
    {
        $this->validate();

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        // Assign the selected role
        $user->assignRole($this->role);

        session()->flash('message', 'Registration successful!');
        return redirect()->route('login');
    }

    public function render()
    {
        return view('livewire.auth.register', [
            'roles' => Role::all(),
        ]);
    }
}
