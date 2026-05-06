<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Branch;

class MapBranchViewer extends Component
{
    public $branches;

    public function mount()
    {
        $this->branches = Branch::all(['name', 'latitude', 'longitude']);
    }

    public function render()
    {
        return view('livewire.map-branch-viewer');
    }
}
