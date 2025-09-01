<?php

namespace App\Livewire\User\Location;

use App\Models\Building;
use App\Models\Room;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $buildingFilter = '';
    public $statusFilter = '';
    public $buildings = [];
    public $selectedBuilding = null;

    public function mount()
    {
        $this->loadBuildings();
    }

    public function loadBuildings()
    {
        $this->buildings = Building::where('status', 'active')
            ->orderBy('name')
            ->get();
    }

    public function selectBuilding($buildingId)
    {
        $this->selectedBuilding = Building::find($buildingId);
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingBuildingFilter()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Room::query()
            ->with(['building', 'cctvs']);

        if ($this->selectedBuilding) {
            $query->where('building_id', $this->selectedBuilding->id);
        }

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%')
                  ->orWhereHas('building', function ($bq) {
                      $bq->where('name', 'like', '%' . $this->search . '%');
                  });
            });
        }

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        $rooms = $query->orderBy('name')
            ->paginate(12);

        return view('livewire.user.location.index', [
            'rooms' => $rooms
        ])->layout('components.layouts.app');
    }
}