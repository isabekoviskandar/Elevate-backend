<?php

namespace App\Livewire;

use App\Models\Role;
use Livewire\Component;

class RoleComponent extends Component
{

    public $roles;
    public $name;
    public $editForm = false;
    public $showForm = false;
    public $role;
    public $delete_id;

    public function submit()
    {
        $this->validate([
            'name' => 'required|unique:roles'
        ]);
    
        if ($this->editForm) {
            $this->role->update([
                'name' => $this->name
            ]);
            session()->flash('message', 'Role updated successfully!');
        } else {
            Role::create([
                'name' => $this->name
            ]);
            session()->flash('message', 'Role created successfully!');
        }
        
        $this->resetForm();
    }

    public function edit($id)
    {
        $this->role = Role::find($id);
        $this->name = $this->role->name;
        $this->editForm = true;
        $this->showForm = true;
    }


    public function prepareDelete($id)
    {
        $this->delete_id = $id;
    }

    public function deleteConfirmed()
    {
        $role = Role::findOrFail($this->delete_id);
        $role->delete();

        session()->flash('message', 'Role deleted successfully!');
        $this->reset(['delete_id']);
    }


    public function resetForm()
    {
        $this->reset(['name', 'editForm', 'showForm', 'role']);
    }

    public function mount()
    {
        $this->roles = Role::all();
    }

    
    public function render()
    {
        return view('admin.roles.index');
    }
}
