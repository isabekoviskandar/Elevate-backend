<?php

namespace App\Livewire;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class UserComponent extends Component
{

    public $users;
    public $name;
    public $email;
    public $password;
    public $role_id;
    public $user_id; 
    public $roles;
    public $delete_id;
    public $createForm = false;
    public $editForm = false;

    public function submit()
    {
        $validateRules = [
            'name' => 'required',
            'email' => 'required|email',
            'role_id' => 'required'
        ];

        if (!$this->editForm) {
            $validateRules['password'] = 'required';
        }

        $this->validate($validateRules);

        if ($this->editForm) {
            $user = User::findOrFail($this->user_id);
            $updateData = [
                'name' => $this->name,
                'email' => $this->email,
                'role_id' => $this->role_id
            ];

            if ($this->password) {
                $updateData['password'] = Hash::make($this->password);
            }

            $user->update($updateData);
            session()->flash('message', 'User updated successfully!');
        } else {
            User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'role_id' => $this->role_id
            ]);
            session()->flash('message', 'User created successfully!');
        }

        $this->resetForm();
    }

    public function prepareDelete($id)
    {
        $this->delete_id = $id;
    }
    
    public function edit($id)
    {
        $user = User::find($id);
        $this->user_id = $user->id; 
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role_id = $user->role_id;
        $this->editForm = true;
        $this->createForm = true;
    }

    public function deleteConfirmed()
    {
        $user = User::findOrFail($this->delete_id);
        $user->delete();

        session()->flash('message', 'User deleted successfully!');
        $this->reset(['delete_id']);
    }

    public function resetForm()
    {
        $this->reset(['name', 'email', 'password', 'role_id', 'createForm', 'editForm']);
    }


    public function render()
    {
        $this->users = User::all();
        $this->roles = Role::all();
        return view('admin.users.index');
    }
}
