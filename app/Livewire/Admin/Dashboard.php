<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use App\Models\Building;
use App\Models\Room;
use App\Models\Cctv;
use App\Models\Contact;
use App\Models\Notification;
use App\Models\Message;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DashboardExport;

class Dashboard extends Component
{
    public $totalUsers = 0;
    public $onlineUsers = 0;
    public $offlineUsers = 0;
    public $totalBuildings = 0;
    public $totalRooms = 0;
    public $totalCctvs = 0;
    public $onlineCctvs = 0;
    public $offlineCctvs = 0;
    public $maintenanceCctvs = 0;
    public $totalContacts = 0;
    public $unreadNotifications = 0;
    public $unreadMessages = 0;

    public function mount()
    {
        $this->loadStats();
    }

    public function loadStats()
    {
        $this->totalUsers = User::count();
        $this->onlineUsers = User::where('is_online', true)->count();
        $this->offlineUsers = $this->totalUsers - $this->onlineUsers;
        
        $this->totalBuildings = Building::count();
        $this->totalRooms = Room::count();
        $this->totalCctvs = Cctv::count();
        $this->onlineCctvs = Cctv::where('status', 'online')->count();
        $this->offlineCctvs = Cctv::where('status', 'offline')->count();
        $this->maintenanceCctvs = Cctv::where('status', 'maintenance')->count();
        
        $this->totalContacts = Contact::count();
        $this->unreadNotifications = Notification::where('is_read', false)->count();
        $this->unreadMessages = Message::whereNull('read_at')->count();
    }

    public function exportData()
    {
        return Excel::download(new DashboardExport(), 'dashboard-data-' . now()->format('Y-m-d') . '.xlsx');
    }

    public function render()
    {
        return view('livewire.admin.dashboard')
            ->layout('components.layouts.app');
    }
}