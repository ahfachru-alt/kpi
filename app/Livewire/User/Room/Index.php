<?php

namespace App\Livewire\User\Room;

use App\Models\Building;
use App\Models\Room;
use App\Models\Cctv;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $buildingFilter = '';
    public $statusFilter = '';
    public $cctvStatusFilter = '';
    public $buildings = [];
    public $selectedBuilding = null;
    public $selectedRoom = null;

    public function mount($building = null, $room = null)
    {
        $this->loadBuildings();
        
        if ($building) {
            $this->selectedBuilding = Building::find($building);
        }
        
        if ($room) {
            $this->selectedRoom = Room::find($room);
        }
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
        $this->selectedRoom = null;
        $this->resetPage();
    }

    public function selectRoom($roomId)
    {
        $this->selectedRoom = Room::find($roomId);
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

    public function updatingCctvStatusFilter()
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

        // Get CCTV statistics for the selected room
        $cctvStats = null;
        if ($this->selectedRoom) {
            $cctvStats = [
                'total' => $this->selectedRoom->cctvs->count(),
                'online' => $this->selectedRoom->cctvs->where('status', 'online')->count(),
                'offline' => $this->selectedRoom->cctvs->where('status', 'offline')->count(),
                'maintenance' => $this->selectedRoom->cctvs->where('status', 'maintenance')->count(),
            ];
        }

        return view('livewire.user.room.index', [
            'rooms' => $rooms,
            'cctvStats' => $cctvStats
        ])->layout('components.layouts.app');
    }
}