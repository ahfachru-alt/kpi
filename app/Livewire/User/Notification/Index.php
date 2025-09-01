<?php

namespace App\Livewire\User\Notification;

use App\Models\Notification;
use Livewire\Component;
use Livewire\WithPagination;
use App\Exports\NotificationsExport;
use Maatwebsite\Excel\Facades\Excel;

class Index extends Component
{
    use WithPagination;

    public $showViewModal = false;
    public $selectedNotification = null;

    // Filters
    public $typeFilter = '';
    public $statusFilter = '';
    public $search = '';

    protected $listeners = [
        'notificationUpdated' => 'loadData'
    ];

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        // Data will be loaded in render method
    }

    public function openViewModal(Notification $notification)
    {
        $this->selectedNotification = $notification;
        $this->showViewModal = true;
    }

    public function markAsRead(Notification $notification)
    {
        if ($notification->user_id === auth()->id()) {
            $notification->markAsRead();
            $this->dispatch('notificationUpdated');
        }
    }

    public function markAsUnread(Notification $notification)
    {
        if ($notification->user_id === auth()->id()) {
            $notification->markAsUnread();
            $this->dispatch('notificationUpdated');
        }
    }

    public function markAllAsRead()
    {
        Notification::where('user_id', auth()->id())
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $this->dispatch('notificationUpdated');
        session()->flash('message', 'All notifications marked as read.');
    }

    public function clearReadNotifications()
    {
        Notification::where('user_id', auth()->id())
            ->where('is_read', true)
            ->delete();

        $this->dispatch('notificationUpdated');
        session()->flash('message', 'Read notifications cleared.');
    }

    public function exportToExcel()
    {
        $filename = 'notifications_' . auth()->user()->name . '_' . now()->format('Y-m-d_H-i-s') . '.xlsx';
        
        return Excel::download(new NotificationsExport(
            auth()->id(),
            $this->typeFilter,
            $this->statusFilter,
            $this->search
        ), $filename);
    }

    public function closeModals()
    {
        $this->showViewModal = false;
        $this->selectedNotification = null;
    }

    public function getNotificationStats()
    {
        $query = Notification::where('user_id', auth()->id());
        
        if ($this->typeFilter) {
            $query->where('type', $this->typeFilter);
        }
        if ($this->statusFilter === 'read') {
            $query->where('is_read', true);
        } elseif ($this->statusFilter === 'unread') {
            $query->where('is_read', false);
        }
        if ($this->search) {
            $query->where(function($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('body', 'like', '%' . $this->search . '%');
            });
        }

        return [
            'total' => $query->count(),
            'unread' => $query->where('is_read', false)->count(),
            'read' => $query->where('is_read', true)->count()
        ];
    }

    public function render()
    {
        $query = Notification::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc');

        // Apply filters
        if ($this->typeFilter) {
            $query->where('type', $this->typeFilter);
        }
        if ($this->statusFilter === 'read') {
            $query->where('is_read', true);
        } elseif ($this->statusFilter === 'unread') {
            $query->where('is_read', false);
        }
        if ($this->search) {
            $query->where(function($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('body', 'like', '%' . $this->search . '%');
            });
        }

        $notifications = $query->paginate(15);
        $stats = $this->getNotificationStats();

        return view('livewire.user.notification.index', [
            'notifications' => $notifications,
            'stats' => $stats
        ]);
    }
}