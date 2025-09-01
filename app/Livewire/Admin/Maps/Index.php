<?php

namespace App\Livewire\Admin\Maps;

use App\Models\Building;
use App\Models\Cctv;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    // Properties for building modals
    public $showCreateBuildingModal = false;
    public $showEditBuildingModal = false;
    public $showViewBuildingModal = false;
    public $selectedBuilding = null;
    public $buildingForm = [
        'name' => '',
        'description' => '',
        'lat' => '',
        'lng' => '',
        'address' => '',
        'status' => 'active'
    ];

    // Properties for CCTV modals
    public $showCreateCctvModal = false;
    public $showViewCctvModal = false;
    public $showStreamCctvModal = false;
    public $selectedCctv = null;
    public $cctvForm = [
        'building_id' => '',
        'room_id' => '',
        'name' => '',
        'ip_address' => '',
        'rtsp_url' => '',
        'stream_url' => '',
        'status' => 'online',
        'model' => '',
        'resolution' => '',
        'notes' => ''
    ];

    // Map properties
    public $mapCenter = [0, 0];
    public $mapZoom = 13;
    public $showBuildings = true;
    public $showCctvs = true;
    public $cctvStatusFilter = 'all';
    public $mapType = 'street';

    // Data properties
    public $buildings = [];
    public $cctvs = [];
    public $rooms = [];

    protected $listeners = [
        'buildingCreated' => 'loadData',
        'buildingUpdated' => 'loadData',
        'buildingDeleted' => 'loadData',
        'cctvCreated' => 'loadData',
        'cctvUpdated' => 'loadData',
        'cctvDeleted' => 'loadData'
    ];

    public function mount()
    {
        $this->loadData();
        $this->setMapCenter();
    }

    public function loadData()
    {
        $this->buildings = Building::with(['rooms', 'cctvs'])->get();
        $this->cctvs = Cctv::with(['room.building'])->get();
        
        // Calculate map center based on buildings
        $this->setMapCenter();
    }

    public function setMapCenter()
    {
        if ($this->buildings->count() > 0) {
            $avgLat = $this->buildings->avg('lat');
            $avgLng = $this->buildings->avg('lng');
            $this->mapCenter = [$avgLat, $avgLng];
        }
    }

    // Building Modal Methods
    public function openCreateBuildingModal()
    {
        $this->resetBuildingForm();
        $this->showCreateBuildingModal = true;
    }

    public function openEditBuildingModal(Building $building)
    {
        $this->selectedBuilding = $building;
        $this->buildingForm = [
            'name' => $building->name,
            'description' => $building->description,
            'lat' => $building->lat,
            'lng' => $building->lng,
            'address' => $building->address,
            'status' => $building->status
        ];
        $this->showEditBuildingModal = true;
    }

    public function openViewBuildingModal(Building $building)
    {
        $this->selectedBuilding = $building;
        $this->showViewBuildingModal = true;
    }

    public function createBuilding()
    {
        $this->validate([
            'buildingForm.name' => 'required|string|max:255',
            'buildingForm.description' => 'nullable|string',
            'buildingForm.lat' => 'required|numeric|between:-90,90',
            'buildingForm.lng' => 'required|numeric|between:-180,180',
            'buildingForm.address' => 'required|string|max:500',
            'buildingForm.status' => 'required|in:active,inactive'
        ]);

        Building::create($this->buildingForm);
        
        $this->closeModals();
        $this->dispatch('buildingCreated');
        session()->flash('message', 'Building created successfully.');
    }

    public function updateBuilding()
    {
        $this->validate([
            'buildingForm.name' => 'required|string|max:255',
            'buildingForm.description' => 'nullable|string',
            'buildingForm.lat' => 'required|numeric|between:-90,90',
            'buildingForm.lng' => 'required|numeric|between:-180,180',
            'buildingForm.address' => 'required|string|max:500',
            'buildingForm.status' => 'required|in:active,inactive'
        ]);

        $this->selectedBuilding->update($this->buildingForm);
        
        $this->closeModals();
        $this->dispatch('buildingUpdated');
        session()->flash('message', 'Building updated successfully.');
    }

    public function deleteBuilding(Building $building)
    {
        if ($building->rooms()->count() > 0) {
            session()->flash('error', 'Cannot delete building with existing rooms.');
            return;
        }

        $building->delete();
        $this->dispatch('buildingDeleted');
        session()->flash('message', 'Building deleted successfully.');
    }

    // CCTV Modal Methods
    public function openCreateCctvModal()
    {
        $this->resetCctvForm();
        $this->showCreateCctvModal = true;
    }

    public function openViewCctvModal(Cctv $cctv)
    {
        $this->selectedCctv = $cctv;
        $this->showViewCctvModal = true;
    }

    public function openStreamCctvModal($cctvId)
    {
        $this->selectedCctv = Cctv::find($cctvId);
        $this->showStreamCctvModal = true;
    }

    public function createCctv()
    {
        $this->validate([
            'cctvForm.building_id' => 'required|exists:buildings,id',
            'cctvForm.room_id' => 'required|exists:rooms,id',
            'cctvForm.name' => 'required|string|max:255',
            'cctvForm.ip_address' => 'required|ip',
            'cctvForm.rtsp_url' => 'required|url',
            'cctvForm.stream_url' => 'nullable|url',
            'cctvForm.status' => 'required|in:online,offline,maintenance',
            'cctvForm.model' => 'nullable|string|max:255',
            'cctvForm.resolution' => 'nullable|string|max:100',
            'cctvForm.notes' => 'nullable|string'
        ]);

        Cctv::create($this->cctvForm);
        
        $this->closeModals();
        $this->dispatch('cctvCreated');
        session()->flash('message', 'CCTV created successfully.');
    }

    // Helper Methods
    public function onBuildingChange()
    {
        $this->cctvForm['room_id'] = '';
        if ($this->cctvForm['building_id']) {
            $this->rooms = Building::find($this->cctvForm['building_id'])->rooms;
        } else {
            $this->rooms = collect();
        }
    }

    public function resetBuildingForm()
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

    public function resetCctvForm()
    {
        $this->cctvForm = [
            'building_id' => '',
            'room_id' => '',
            'name' => '',
            'ip_address' => '',
            'rtsp_url' => '',
            'stream_url' => '',
            'status' => 'online',
            'model' => '',
            'resolution' => '',
            'notes' => ''
        ];
        $this->rooms = collect();
    }

    public function closeModals()
    {
        $this->showCreateBuildingModal = false;
        $this->showEditBuildingModal = false;
        $this->showViewBuildingModal = false;
        $this->showCreateCctvModal = false;
        $this->showViewCctvModal = false;
        $this->showStreamCctvModal = false;
        $this->selectedBuilding = null;
        $this->selectedCctv = null;
        $this->resetBuildingForm();
        $this->resetCctvForm();
    }

    // Map Control Methods
    public function toggleBuildings()
    {
        $this->showBuildings = !$this->showBuildings;
    }

    public function toggleCctvs()
    {
        $this->showCctvs = !$this->showCctvs;
    }

    public function setCctvStatusFilter($status)
    {
        $this->cctvStatusFilter = $status;
    }

    public function toggleMapType()
    {
        $this->mapType = $this->mapType === 'street' ? 'satellite' : 'street';
    }

    public function getFilteredCctvs()
    {
        if ($this->cctvStatusFilter === 'all') {
            return $this->cctvs;
        }
        
        return $this->cctvs->where('status', $this->cctvStatusFilter);
    }

    public function getMapStats()
    {
        return [
            'total_buildings' => $this->buildings->count(),
            'total_cctvs' => $this->cctvs->count(),
            'online_cctvs' => $this->cctvs->where('status', 'online')->count(),
            'coverage_area' => 'Balongan Refinery Complex'
        ];
    }

    public function render()
    {
        $mapStats = $this->getMapStats();
        $filteredCctvs = $this->getFilteredCctvs();
        
        return view('livewire.admin.maps.index', [
            'mapStats' => $mapStats,
            'filteredCctvs' => $filteredCctvs
        ]);
    }
}