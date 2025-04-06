<?php

namespace App\Livewire;

use App\Models\Group;
use Livewire\Component;

class SearchGroups extends Component
{
    public $search = '';


    public function render()
    {
        if (strlen($this->search) > 2)
            $groups = Group::search($this->search)->with('oldestProduct', 'oldestProduct.oldestImage')->simplePaginate(5);
        else
            $groups = null;
        return view('livewire.search-groups', [
            'groups' =>  $groups,
            'searchTerm' => $this->search
        ]);
    }
}
