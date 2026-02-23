<?php

namespace App\Livewire;

use Livewire\Component;

class ColocationManagement extends Component
{
    public $name = '';
    public $description = '';
    public $categories = []; // Array of strings for categories

    public function mount()
    {
        // Start with one empty category
        $this->categories = [['name' => '']];
    }

    public function addCategory()
    {
        $this->categories[] = ['name' => ''];
    }

    public function removeCategory($index)
    {
        unset($this->categories[$index]);
        $this->categories = array_values($this->categories);
    }

    public function render()
    {
        return view('livewire.colocation-management');
    }
}
