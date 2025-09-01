<?php

namespace App\Livewire\Admin\Cctv;

use App\Models\Building;
use App\Models\Room;
use App\Models\Cctv;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    // Filters
    public $buildingFilter = '';
    public $roomFilter = '';
    public $statusFilter = '';
    public $search = '';

    // Modal states
    public $showCreateModal = false;
    public $showEditModal = false;
    public $showViewModal = false;
    public $showStreamModal = false;

    // Form data
    public $form = [
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

    // Selected CCTV
    public $selectedCctv = null;

    // Lists for dropdowns
    public $buildings;
    public $rooms = [];

    // Computed properties
    public $onlineCount;
    public $offlineCount;
    public $maintenanceCount;

    protected $queryString = [
        'buildingFilter' => ['except' => ''],
        'roomFilter' => ['except' => ''],
        'statusFilter' => ['except' => ''],
        'search' => ['except' => '']
    ];

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        // Load buildings
        $this->buildings = Building::withCount('cctvs')->get();

        // Load rooms based on building filter
        if ($this->buildingFilter) {
            $this->rooms = Room::where('building_id', $this->buildingFilter)->get();
        } else {
            $this->rooms = collect();
        }

        // Calculate counts
        $this->onlineCount = Cctv::where('status', 'online')->count();
        $this->offlineCount = Cctv::where('status', 'offline')->count();
        $this->maintenanceCount = Cctv::where('status', 'maintenance')->count();
    }

    public function updatedBuildingFilter()
    {
        $this->roomFilter = '';
        $this->resetPage();
        $this->loadData();
    }

    public function updatedRoomFilter()
    {
        $this->resetPage();
    }

    public function updatedStatusFilter()
    {
        $this->resetPage();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function selectBuilding($buildingId)
    {
        $this->buildingFilter = $buildingId;
        $this->roomFilter = '';
        $this->resetPage();
        $this->loadData();
    }

    // Modal operations
    public function openCreateModal()
    {
        $this->resetForm();
        $this->showCreateModal = true;
    }

    public function openEditModal($cctvId)
    {
        $cctv = Cctv::with(['room.building'])->findOrFail($cctvId);
        $this->form = [
            'building_id' => $cctv->room->building_id,
            'room_id' => $cctv->room_id,
            'name' => $cctv->name,
            'ip_address' => $cctv->ip_address,
            'rtsp_url' => $cctv->rtsp_url,
            'stream_url' => $cctv->stream_url,
            'status' => $cctv->status,
            'model' => $cctv->model,
            'resolution' => $cctv->resolution,
            'notes' => $cctv->notes
        ];
        $this->selectedCctv = $cctv;
        $this->loadData(); // Load rooms for the selected building
        $this->showEditModal = true;
    }

    public function openViewModal($cctvId)
    {
        $this->selectedCctv = Cctv::with(['room.building'])->findOrFail($cctvId);
        $this->showViewModal = true;
    }

    public function openStreamModal($cctvId)
    {
        $this->selectedCctv = Cctv::with(['room.building'])->findOrFail($cctvId);
        $this->showStreamModal = true;
    }

    public function closeModals()
    {
        $this->showCreateModal = false;
        $this->showEditModal = false;
        $this->showViewModal = false;
        $this->showStreamModal = false;
        $this->selectedCctv = null;
        $this->resetForm();
    }

    // CRUD operations
    public function createCctv()
    {
        $this->validate([
            'form.building_id' => 'required|exists:buildings,id',
            'form.room_id' => 'required|exists:rooms,id',
            'form.name' => 'required|string|max:255',
            'form.ip_address' => 'required|string|max:45',
            'form.rtsp_url' => 'required|url',
            'form.stream_url' => 'nullable|url',
            'form.status' => 'required|in:online,offline,maintenance',
            'form.model' => 'nullable|string|max:255',
            'form.resolution' => 'nullable|string|max:100',
            'form.notes' => 'nullable|string'
        ]);

        Cctv::create($this->form);

        $this->closeModals();
        $this->loadData();
        session()->flash('message', 'CCTV created successfully.');
    }

    public function updateCctv()
    {
        $this->validate([
            'form.building_id' => 'required|exists:buildings,id',
            'form.room_id' => 'required|exists:rooms,id',
            'form.name' => 'required|string|max:255',
            'form.ip_address' => 'required|string|max:45',
            'form.rtsp_url' => 'required|url',
            'form.stream_url' => 'nullable|url',
            'form.status' => 'required|in:online,offline,maintenance',
            'form.model' => 'nullable|string|max:255',
            'form.resolution' => 'nullable|string|max:100',
            'form.notes' => 'nullable|string'
        ]);

        $this->selectedCctv->update($this->form);

        $this->closeModals();
        $this->loadData();
        session()->flash('message', 'CCTV updated successfully.');
    }

    public function deleteCctv($cctvId)
    {
        $cctv = Cctv::findOrFail($cctvId);
        $cctv->delete();

        $this->loadData();
        session()->flash('message', 'CCTV deleted successfully.');
    }

    // Building change handler
    public function onBuildingChange()
    {
        $this->form['room_id'] = '';
        if ($this->form['building_id']) {
            $this->rooms = Room::where('building_id', $this->form['building_id'])->get();
        } else {
            $this->rooms = collect();
        }
    }

    // Export function
    public function exportData()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\CctvsExport($this->buildingFilter, $this->roomFilter, $this->statusFilter, $this->search),
            'cctvs-' . now()->format('Y-m-d') . '.xlsx'
        );
    }

    // Utility functions
    private function resetForm()
    {
        $this->form = [
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

    public function getCctvsProperty()
    {
        $query = Cctv::with(['room.building']);

        if ($this->buildingFilter) {
            $query->whereHas('room', function ($q) {
                $q->where('building_id', $this->buildingFilter);
            });
        }

        if ($this->roomFilter) {
            $query->where('room_id', $this->roomFilter);
        }

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('ip_address', 'like', '%' . $this->search . '%')
                    ->orWhere('model', 'like', '%' . $this->search . '%')
                    ->orWhere('notes', 'like', '%' . $this->search . '%');
            });
        }

        return $query->orderBy('name')->paginate(15);
    }

    public function render()
    {
        return view('livewire.admin.cctv.index');
    }
}