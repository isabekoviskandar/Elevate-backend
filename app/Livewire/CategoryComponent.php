<?php

namespace App\Livewire;

use App\Models\Category;
use Livewire\Component;

class CategoryComponent extends Component
{
    public $categories;
    public $name;
    public $category_id;
    Public $showForm = false;
    public $editForm = false;
    public $delete_id;

    public function submit()
    {
        $this->validate([
            'name' => 'required'
        ]);
    
        if ($this->editForm) {
            $category = Category::findOrFail($this->category_id);
            $category->update([
                'name' => $this->name
            ]);
            session()->flash('message', 'Category updated successfully!');
        } else {
            Category::create([
                'name' => $this->name
            ]);
            session()->flash('message', 'Category created successfully!');
        }
    
        $this->resetForm();
    }

    public function edit($id)
    {
        // dd($id);
        $category = Category::find($id);
        $this->category_id = $category->id;
        $this->name = $category->name;
        $this->editForm = true;
        $this->showForm = true;
    }

    public function prepareDelete($id)
    {
        $this->delete_id = $id;
    }

    public function deleteConfirmed()
    {
        $category = Category::findOrFail($this->delete_id);
        $category->delete();

        session()->flash('message', 'Category deleted successfully!');
        $this->reset(['delete_id']);
    }

    public function resetForm()
    {
        $this->reset(['name', 'showForm', 'editForm', 'category_id']);
    }

    public function render()
    {
        $this->categories = Category::all();
        return view('admin.category.index');
    }

    public function updateStatus($category_id, $is_active)
    {
        $category = Category::findOrFail($category_id);
        $category->update(['is_active' => $is_active]);
    
        session()->flash('message', 'Status updated successfully!');
    }
}
