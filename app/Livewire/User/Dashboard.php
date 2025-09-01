<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\Building;
use App\Models\Room;
use App\Models\Cctv;

class Dashboard extends Component
{
    public $totalBuildings = 0;
    public $totalRooms = 0;
    public $totalCctvs = 0;
    public $onlineCctvs = 0;
    public $offlineCctvs = 0;
    public $maintenanceCctvs = 0;
    public $recentCctvs = [];

    public function mount()
    {
        $this->loadStats();
    }

    public function loadStats()
    {
        $this->totalBuildings = Building::count();
        $this->totalRooms = Room::count();
        $this->totalCctvs = Cctv::count();
        $this->onlineCctvs = Cctv::where('status', 'online')->count();
        $this->offlineCctvs = Cctv::where('status', 'offline')->count();
        $this->maintenanceCctvs = Cctv::where('status', 'maintenance')->count();
        
        // Get recent CCTVs with building and room info
        $this->recentCctvs = Cctv::with(['room.building'])
            ->latest()
            ->take(6)
            ->get();
    }

    public function render()
    {
        return view('livewire.user.dashboard')
            ->layout('components.layouts.app');
    }
}