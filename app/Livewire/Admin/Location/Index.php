<?php

namespace App\Livewire\Admin\Location;

use App\Models\Building;
use App\Models\Room;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class Index extends Component
{
    use WithPagination;

    // Tab management
    public $activeTab = 'buildings';

    // Building properties
    public $buildings;
    public $buildingStatusFilter = '';
    public $buildingSearch = '';

    // Room properties
    public $rooms;
    public $roomBuildingFilter = '';
    public $roomStatusFilter = '';
    public $roomSearch = '';

    // Modal states
    public $showCreateBuildingModal = false;
    public $showEditBuildingModal = false;
    public $showViewBuildingModal = false;
    public $showCreateRoomModal = false;
    public $showEditRoomModal = false;
    public $showViewRoomModal = false;

    // Form data
    public $buildingForm = [
        'name' => '',
        'description' => '',
        'lat' => '',
        'lng' => '',
        'address' => '',
        'status' => 'active'
    ];

    public $roomForm = [
        'building_id' => '',
        'name' => '',
        'description' => '',
        'floor' => '',
        'capacity' => '',
        'status' => 'active'
    ];

    // Selected items
    public $selectedBuilding = null;
    public $selectedRoom = null;

    // Lists for dropdowns
    public $buildingsList;

    // Computed properties
    public $totalCctvs;
    public $activeLocations;

    protected $queryString = [
        'activeTab' => ['except' => 'buildings'],
        'buildingStatusFilter' => ['except' => ''],
        'buildingSearch' => ['except' => ''],
        'roomBuildingFilter' => ['except' => ''],
        'roomStatusFilter' => ['except' => ''],
        'roomSearch' => ['except' => '']
    ];

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        // Load buildings with counts
        $buildingsQuery = Building::withCount(['rooms', 'cctvs'])
            ->withCount(['cctvs as online_cctv_count' => function ($query) {
                $query->where('status', 'online');
            }])
            ->withCount(['cctvs as offline_cctv_count' => function ($query) {
                $query->query->where('status', 'offline');
            }])
            ->withCount(['cctvs as maintenance_cctv_count' => function ($query) {
                $query->where('status', 'maintenance');
            }]);

        if ($this->buildingStatusFilter) {
            $buildingsQuery->where('status', $this->buildingStatusFilter);
        }

        if ($this->buildingSearch) {
            $buildingsQuery->where(function ($query) {
                $query->where('name', 'like', '%' . $this->buildingSearch . '%')
                    ->orWhere('description', 'like', '%' . $this->buildingSearch . '%')
                    ->orWhere('address', 'like', '%' . $this->buildingSearch . '%');
            });
        }

        $this->buildings = $buildingsQuery->paginate(10);

        // Load rooms with counts
        $roomsQuery = Room::with(['building'])
            ->withCount(['cctvs'])
            ->withCount(['cctvs as online_cctv_count' => function ($query) {
                $query->where('status', 'online');
            }])
            ->withCount(['cctvs as offline_cctv_count' => function ($query) {
                $query->where('status', 'offline');
            }])
            ->withCount(['cctvs as maintenance_cctv_count' => function ($query) {
                $query->where('status', 'maintenance');
            }]);

        if ($this->roomBuildingFilter) {
            $roomsQuery->where('building_id', $this->roomBuildingFilter);
        }

        if ($this->roomStatusFilter) {
            $roomsQuery->where('status', $this->roomStatusFilter);
        }

        if ($this->roomSearch) {
            $roomsQuery->where(function ($query) {
                $query->where('name', 'like', '%' . $this->roomSearch . '%')
                    ->orWhere('description', 'like', '%' . $this->roomSearch . '%');
            });
        }

        $this->rooms = $roomsQuery->paginate(10);

        // Load buildings list for dropdowns
        $this->buildingsList = Building::where('status', 'active')->get();

        // Calculate totals
        $this->totalCctvs = \App\Models\Cctv::count();
        $this->activeLocations = Building::where('status', 'active')->count() + Room::where('status', 'active')->count();
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
        $this->resetPage();
    }

    public function updatedBuildingStatusFilter()
    {
        $this->resetPage();
        $this->loadData();
    }

    public function updatedBuildingSearch()
    {
        $this->resetPage();
        $this->loadData();
    }

    public function updatedRoomBuildingFilter()
    {
        $this->resetPage();
        $this->loadData();
    }

    public function updatedRoomStatusFilter()
    {
        $this->resetPage();
        $this->loadData();
    }

    public function updatedRoomSearch()
    {
        $this->resetPage();
        $this->loadData();
    }

    // Building CRUD operations
    public function openCreateBuildingModal()
    {
        $this->resetBuildingForm();
        $this->showCreateBuildingModal = true;
    }

    public function openEditBuildingModal($buildingId)
    {
        $building = Building::findOrFail($buildingId);
        $this->buildingForm = [
            'name' => $building->name,
            'description' => $building->description,
            'lat' => $building->lat,
            'lng' => $building->lng,
            'address' => $building->address,
            'status' => $building->status
        ];
        $this->selectedBuilding = $building;
        $this->showEditBuildingModal = true;
    }

    public function openViewBuildingModal($buildingId)
    {
        $this->selectedBuilding = Building::withCount(['rooms', 'cctvs'])
            ->withCount(['cctvs as online_cctv_count' => function ($query) {
                $query->where('status', 'online');
            }])
            ->withCount(['cctvs as offline_cctv_count' => function ($query) {
                $query->where('status', 'offline');
            }])
            ->withCount(['cctvs as maintenance_cctv_count' => function ($query) {
                $query->where('status', 'maintenance');
            }])
            ->findOrFail($buildingId);
        $this->showViewBuildingModal = true;
    }

    public function createBuilding()
    {
        $this->validate([
            'buildingForm.name' => 'required|string|max:255',
            'buildingForm.description' => 'nullable|string',
            'buildingForm.lat' => 'required|numeric',
            'buildingForm.lng' => 'required|numeric',
            'buildingForm.address' => 'nullable|string|max:500',
            'buildingForm.status' => 'required|in:active,inactive,maintenance'
        ]);

        Building::create($this->buildingForm);

        $this->closeModals();
        $this->loadData();
        session()->flash('message', 'Building created successfully.');
    }

    public function updateBuilding()
    {
        $this->validate([
            'buildingForm.name' => 'required|string|max:255',
            'buildingForm.description' => 'nullable|string',
            'buildingForm.lat' => 'required|numeric',
            'buildingForm.lng' => 'required|numeric',
            'buildingForm.address' => 'nullable|string|max:500',
            'buildingForm.status' => 'required|in:active,inactive,maintenance'
        ]);

        $this->selectedBuilding->update($this->buildingForm);

        $this->closeModals();
        $this->loadData();
        session()->flash('message', 'Building updated successfully.');
    }

    public function deleteBuilding($buildingId)
    {
        $building = Building::findOrFail($buildingId);
        
        // Delete associated rooms and CCTVs
        $building->rooms()->delete();
        
        $building->delete();

        $this->loadData();
        session()->flash('message', 'Building deleted successfully.');
    }

    // Room CRUD operations
    public function openCreateRoomModal()
    {
        $this->resetRoomForm();
        $this->showCreateRoomModal = true;
    }

    public function openEditRoomModal($roomId)
    {
        $room = Room::findOrFail($roomId);
        $this->roomForm = [
            'building_id' => $room->building_id,
            'name' => $room->name,
            'description' => $room->description,
            'floor' => $room->floor,
            'capacity' => $room->capacity,
            'status' => $room->status
        ];
        $this->selectedRoom = $room;
        $this->showEditRoomModal = true;
    }

    public function openViewRoomModal($roomId)
    {
        $this->selectedRoom = Room::with(['building'])
            ->withCount(['cctvs'])
            ->withCount(['cctvs as online_cctv_count' => function ($query) {
                $query->where('status', 'online');
            }])
            ->withCount(['cctvs as offline_cctv_count' => function ($query) {
                $query->where('status', 'offline');
            }])
            ->withCount(['cctvs as maintenance_cctv_count' => function ($query) {
                $query->where('status', 'maintenance');
            }])
            ->findOrFail($roomId);
        $this->showViewRoomModal = true;
    }

    public function createRoom()
    {
        $this->validate([
            'roomForm.building_id' => 'required|exists:buildings,id',
            'roomForm.name' => 'required|string|max:255',
            'roomForm.description' => 'nullable|string',
            'roomForm.floor' => 'required|integer|min:0',
            'roomForm.capacity' => 'required|integer|min:1',
            'roomForm.status' => 'required|in:active,inactive,maintenance'
        ]);

        Room::create($this->roomForm);

        $this->closeModals();
        $this->loadData();
        session()->flash('message', 'Room created successfully.');
    }

    public function updateRoom()
    {
        $this->validate([
            'roomForm.building_id' => 'required|exists:buildings,id',
            'roomForm.name' => 'required|string|max:255',
            'roomForm.description' => 'nullable|string',
            'roomForm.floor' => 'required|integer|min:0',
            'roomForm.capacity' => 'required|integer|min:1',
            'roomForm.status' => 'required|in:active,inactive,maintenance'
        ]);

        $this->selectedRoom->update($this->roomForm);

        $this->closeModals();
        $this->loadData();
        session()->flash('message', 'Room updated successfully.');
    }

    public function deleteRoom($roomId)
    {
        $room = Room::findOrFail($roomId);
        
        // Delete associated CCTVs
        $room->cctvs()->delete();
        
        $room->delete();

        $this->loadData();
        session()->flash('message', 'Room deleted successfully.');
    }

    // Export functions
    public function exportBuildings()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\BuildingsExport($this->buildingStatusFilter, $this->buildingSearch),
            'buildings-' . now()->format('Y-m-d') . '.xlsx'
        );
    }

    public function exportRooms()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\RoomsExport($this->roomBuildingFilter, $this->roomStatusFilter, $this->roomSearch),
            'rooms-' . now()->format('Y-m-d') . '.xlsx'
        );
    }

    // Utility functions
    public function closeModals()
    {
        $this->showCreateBuildingModal = false;
        $this->showEditBuildingModal = false;
        $this->showViewBuildingModal = false;
        $this->showCreateRoomModal = false;
        $this->showEditRoomModal = false;
        $this->showViewRoomModal = false;
        $this->selectedBuilding = null;
        $this->selectedRoom = null;
        $this->resetBuildingForm();
        $this->resetRoomForm();
    }

    private function resetBuildingForm()
    {
        $this->buildingForm = [
            'name' => '',
            'description' => '',
            'lat' => '',
            'lng' => '',
            'address' => '',
            'status' => 'active'
        ];
    }

    private function resetRoomForm()
    {
        $this->roomForm = [
            'building_id' => '',
            'name' => '',
            'description' => '',
            'floor' => '',
            'capacity' => '',
            'status' => 'active'
        ];
    }

    public function render()
    {
        return view('livewire.admin.location.index');
    }
}