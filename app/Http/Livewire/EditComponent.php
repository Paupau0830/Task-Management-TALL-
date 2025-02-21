<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class EditComponent extends Component
{
    public $userId, $name, $email, $role, $password, $password_confirmation;
    public $manageUsers, $editTasks, $deleteTasks, $createTasks, $manageLegends;

    public function mount($id)
    {
        $this->reset();

        $user = User::findOrFail($id);

        $this->userId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->roles->first()->name ?? '';

        // Load Permissions
        $this->manageUsers = $user->hasPermissionTo('manage users');
        $this->editTasks = $user->hasPermissionTo('edit tasks');
        $this->deleteTasks = $user->hasPermissionTo('delete tasks');
        $this->createTasks = $user->hasPermissionTo('create tasks');
        $this->manageLegends = $user->hasPermissionTo('manage legends');
    }

    public function updateUser()
    {
        $this->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email,' . $this->userId,
        ]);

        $user = User::findOrFail($this->userId);
        $user->update([
            'name' => $this->name,
            'email' => $this->email,
        ]);

        // If password detected, then validate and update
        if ($this->password) {
            $this->validate([
                'password' => 'required|min:6|confirmed',
            ]);

            $user->update([
                'password' => bcrypt($this->password),
            ]);
        }

        // Update Role
        if ($this->role) {
            $user->syncRoles([$this->role]);
        }

        // Update Permissions
        $permissions = collect([
            'manage users' => $this->manageUsers,
            'edit tasks' => $this->editTasks,
            'delete tasks' => $this->deleteTasks,
            'create tasks' => $this->createTasks,
            'manage legends' => $this->manageLegends,
        ])->filter()->keys()->toArray();

        $user->syncPermissions($permissions);

        session()->flash('message', 'User updated successfully!');
        return redirect()->route('user-management');
    }

    public function render()
    {
        return view('livewire.edit-component', [
            'roles' => Role::pluck('name', 'id'),
        ]);
    }
}
