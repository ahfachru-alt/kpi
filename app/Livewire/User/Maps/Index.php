<?php

namespace App\Livewire\User\Maps;

use Livewire\Component;
use App\Models\Building;
use App\Models\Cctv;

class Index extends Component
{
    public $buildings = [];
    public $cctvs = [];
    public $selectedStatus = 'all';

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        $this->buildings = Building::all();
        $this->cctvs = Cctv::with(['room.building'])->get();
    }

    public function filterByStatus($status)
    {
        $this->selectedStatus = $status;
    }

    public function render()
    {
        $filteredCctvs = $this->cctvs;
        
        if ($this->selectedStatus !== 'all') {
            $filteredCctvs = $this->cctvs->where('status', $this->selectedStatus);
        }

        return view('livewire.user.maps.index', compact('filteredCctvs'))
            ->layout('components.layouts.app');
    }
}