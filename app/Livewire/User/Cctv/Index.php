<?php

namespace App\Livewire\User\Cctv;

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
    public $roomFilter = '';
    public $statusFilter = '';
    public $buildings = [];
    public $rooms = [];
    public $selectedBuilding = null;
    public $selectedRoom = null;

    public function mount($building = null, $room = null)
    {
        $this->loadBuildings();
        
        if ($building) {
            $this->selectedBuilding = Building::find($building);
            $this->loadRooms();
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

    public function loadRooms()
    {
        if ($this->selectedBuilding) {
            $this->rooms = Room::where('building_id', $this->selectedBuilding->id)
                ->where('status', 'active')
                ->orderBy('name')
                ->get();
        } else {
            $this->rooms = collect();
        }
    }

    public function selectBuilding($buildingId)
    {
        $this->selectedBuilding = Building::find($buildingId);
        $this->selectedRoom = null;
        $this->loadRooms();
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

    public function updatingRoomFilter()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Cctv::query()
            ->with(['room.building']);

        if ($this->selectedBuilding) {
            $query->whereHas('room', function ($q) {
                $q->where('building_id', $this->selectedBuilding->id);
            });
        }

        if ($this->selectedRoom) {
            $query->where('room_id', $this->selectedRoom->id);
        }

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('ip_address', 'like', '%' . $this->search . '%')
                  ->orWhere('model', 'like', '%' . $this->search . '%')
                  ->orWhereHas('room', function ($rq) {
                      $rq->where('name', 'like', '%' . $this->search . '%');
                  })
                  ->orWhereHas('room.building', function ($bq) {
                      $bq->where('name', 'like', '%' . $this->search . '%');
                  });
            });
        }

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        $cctvs = $query->orderBy('name')
            ->paginate(12);

        // Get CCTV statistics
        $cctvStats = [
            'total' => Cctv::count(),
            'online' => Cctv::where('status', 'online')->count(),
            'offline' => Cctv::where('status', 'offline')->count(),
            'maintenance' => Cctv::where('status', 'maintenance')->count(),
        ];

        return view('livewire.user.cctv.index', [
            'cctvs' => $cctvs,
            'cctvStats' => $cctvStats
        ])->layout('components.layouts.app');
    }
}