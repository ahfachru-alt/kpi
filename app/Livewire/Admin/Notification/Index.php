<?php

namespace App\Livewire\Admin\Notification;

use App\Models\Notification;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $showCreateModal = false;
    public $showEditModal = false;
    public $showViewModal = false;
    public $selectedNotification = null;
    public $form = [
        'user_id' => '',
        'title' => '',
        'body' => '',
        'type' => 'info',
        'data' => ''
    ];

    // Filters
    public $userFilter = '';
    public $typeFilter = '';
    public $statusFilter = '';
    public $search = '';

    protected $listeners = [
        'notificationCreated' => 'loadData',
        'notificationUpdated' => 'loadData',
        'notificationDeleted' => 'loadData'
    ];

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        // Data will be loaded in render method
    }

    public function openCreateModal()
    {
        $this->resetForm();
        $this->showCreateModal = true;
    }

    public function openEditModal(Notification $notification)
    {
        $this->selectedNotification = $notification;
        $this->form = [
            'user_id' => $notification->user_id,
            'title' => $notification->title,
            'body' => $notification->body,
            'type' => $notification->type,
            'data' => $notification->data ? json_encode($notification->data) : ''
        ];
        $this->showEditModal = true;
    }

    public function openViewModal(Notification $notification)
    {
        $this->selectedNotification = $notification;
        $this->showViewModal = true;
    }

    public function createNotification()
    {
        $this->validate([
            'form.user_id' => 'required|exists:users,id',
            'form.title' => 'required|string|max:255',
            'form.body' => 'required|string',
            'form.type' => 'required|in:info,success,warning,error,security,maintenance',
            'form.data' => 'nullable|string'
        ]);

        $data = null;
        if (!empty($this->form['data'])) {
            $data = json_decode($this->form['data'], true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                $this->addError('form.data', 'Invalid JSON format');
                return;
            }
        }

        Notification::create([
            'user_id' => $this->form['user_id'],
            'title' => $this->form['title'],
            'body' => $this->form['body'],
            'type' => $this->form['type'],
            'data' => $data
        ]);

        $this->closeModals();
        $this->dispatch('notificationCreated');
        session()->flash('message', 'Notification sent successfully.');
    }

    public function updateNotification()
    {
        $this->validate([
            'form.user_id' => 'required|exists:users,id',
            'form.title' => 'required|string|max:255',
            'form.body' => 'required|string',
            'form.type' => 'required|in:info,success,warning,error,security,maintenance',
            'form.data' => 'nullable|string'
        ]);

        $data = null;
        if (!empty($this->form['data'])) {
            $data = json_decode($this->form['data'], true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                $this->addError('form.data', 'Invalid JSON format');
                return;
            }
        }

        $this->selectedNotification->update([
            'user_id' => $this->form['user_id'],
            'title' => $this->form['title'],
            'body' => $this->form['body'],
            'form.type' => $this->form['type'],
            'data' => $data
        ]);

        $this->closeModals();
        $this->dispatch('notificationUpdated');
        session()->flash('message', 'Notification updated successfully.');
    }

    public function deleteNotification(Notification $notification)
    {
        $notification->delete();
        $this->dispatch('notificationDeleted');
        session()->flash('message', 'Notification deleted successfully.');
    }

    public function markAsRead(Notification $notification)
    {
        $notification->markAsRead();
        $this->dispatch('notificationUpdated');
    }

    public function markAsUnread(Notification $notification)
    {
        $notification->markAsUnread();
        $this->dispatch('notificationUpdated');
    }

    public function resetForm()
    {
        $this->form = [
            'user_id' => '',
            'title' => '',
            'body' => '',
            'type' => 'info',
            'data' => ''
        ];
        $this->selectedNotification = null;
    }

    public function closeModals()
    {
        $this->showCreateModal = false;
        $this->showEditModal = false;
        $this->showViewModal = false;
        $this->resetForm();
    }

    public function getUsers()
    {
        return User::orderBy('name')->get();
    }

    public function getNotificationStats()
    {
        $query = Notification::query();
        
        if ($this->userFilter) {
            $query->where('user_id', $this->userFilter);
        }
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
        $query = Notification::with('user')
            ->orderBy('created_at', 'desc');

        // Apply filters
        if ($this->userFilter) {
            $query->where('user_id', $this->userFilter);
        }
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
        $users = $this->getUsers();
        $stats = $this->getNotificationStats();

        return view('livewire.admin.notification.index', [
            'notifications' => $notifications,
            'users' => $users,
            'stats' => $stats
        ]);
    }
}