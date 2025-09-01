<?php

namespace App\Livewire\User\Message;

use App\Models\Message;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use App\Exports\MessagesExport;
use Maatwebsite\Excel\Facades\Excel;

class Index extends Component
{
    use WithPagination;

    public $showCreateModal = false;
    public $showEditModal = false;
    public $showViewModal = false;
    public $selectedMessage = null;
    public $form = [
        'to_id' => '',
        'message' => '',
        'type' => 'general'
    ];

    // Filters
    public $typeFilter = '';
    public $directionFilter = '';
    public $statusFilter = '';
    public $search = '';

    protected $listeners = [
        'messageCreated' => 'loadData',
        'messageUpdated' => 'loadData',
        'messageDeleted' => 'loadData'
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

    public function openEditModal(Message $message)
    {
        if ($message->from_id !== auth()->id()) {
            session()->flash('error', 'You can only edit your own messages.');
            return;
        }

        $this->selectedMessage = $message;
        $this->form = [
            'to_id' => $message->to_id,
            'message' => $message->message,
            'type' => $message->type
        ];
        $this->showEditModal = true;
    }

    public function openViewModal(Message $message)
    {
        $this->selectedMessage = $message;
        $this->showViewModal = true;
    }

    public function createMessage()
    {
        $this->validate([
            'form.to_id' => 'required|exists:users,id|different:' . auth()->id(),
            'form.message' => 'required|string|max:1000',
            'form.type' => 'required|in:general,emergency,maintenance,security,update'
        ]);

        Message::create([
            'from_id' => auth()->id(),
            'to_id' => $this->form['to_id'],
            'message' => $this->form['message'],
            'type' => $this->form['type']
        ]);

        $this->closeModals();
        $this->dispatch('messageCreated');
        session()->flash('message', 'Message sent successfully.');
    }

    public function updateMessage()
    {
        $this->validate([
            'form.to_id' => 'required|exists:users,id|different:' . auth()->id(),
            'form.message' => 'required|string|max:1000',
            'form.type' => 'required|in:general,emergency,maintenance,security,update'
        ]);

        $this->selectedMessage->update([
            'to_id' => $this->form['to_id'],
            'message' => $this->form['message'],
            'type' => $this->form['type']
        ]);

        $this->closeModals();
        $this->dispatch('messageUpdated');
        session()->flash('message', 'Message updated successfully.');
    }

    public function deleteMessage(Message $message)
    {
        if ($message->from_id !== auth()->id()) {
            session()->flash('error', 'You can only delete your own messages.');
            return;
        }

        $message->delete();
        $this->dispatch('messageDeleted');
        session()->flash('message', 'Message deleted successfully.');
    }

    public function markAsRead(Message $message)
    {
        if ($message->to_id === auth()->id()) {
            $message->markAsRead();
            $this->dispatch('messageUpdated');
        }
    }

    public function markAllAsRead()
    {
        Message::where('to_id', auth()->id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        $this->dispatch('messageUpdated');
        session()->flash('message', 'All messages marked as read.');
    }

    public function resetForm()
    {
        $this->form = [
            'to_id' => '',
            'message' => '',
            'type' => 'general'
        ];
        $this->selectedMessage = null;
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
        return User::where('id', '!=', auth()->id())
            ->orderBy('name')
            ->get();
    }

    public function exportToExcel()
    {
        $filename = 'messages_' . auth()->user()->name . '_' . now()->format('Y-m-d_H-i-s') . '.xlsx';
        
        return Excel::download(new MessagesExport(
            auth()->id(),
            $this->typeFilter,
            $this->directionFilter,
            $this->statusFilter,
            $this->search
        ), $filename);
    }

    public function getMessageStats()
    {
        $query = Message::query();
        
        // Apply direction filter
        if ($this->directionFilter === 'sent') {
            $query->where('from_id', auth()->id());
        } elseif ($this->directionFilter === 'received') {
            $query->where('to_id', auth()->id());
        } else {
            $query->where(function($q) {
                $q->where('from_id', auth()->id())
                  ->orWhere('to_id', auth()->id());
            });
        }

        if ($this->typeFilter) {
            $query->where('type', $this->typeFilter);
        }
        if ($this->statusFilter === 'read') {
            $query->whereNotNull('read_at');
        } elseif ($this->statusFilter === 'unread') {
            $query->whereNull('read_at');
        }
        if ($this->search) {
            $query->where('message', 'like', '%' . $this->search . '%');
        }

        return [
            'total' => $query->count(),
            'unread' => $query->whereNull('read_at')->count(),
            'read' => $query->whereNotNull('read_at')->count(),
            'sent_today' => Message::where('from_id', auth()->id())
                ->whereDate('created_at', today())
                ->count()
        ];
    }

    public function render()
    {
        $query = Message::with(['sender', 'recipient']);

        // Apply direction filter
        if ($this->directionFilter === 'sent') {
            $query->where('from_id', auth()->id());
        } elseif ($this->directionFilter === 'received') {
            $query->where('to_id', auth()->id());
        } else {
            $query->where(function($q) {
                $q->where('from_id', auth()->id())
                  ->orWhere('to_id', auth()->id());
            });
        }

        // Apply other filters
        if ($this->typeFilter) {
            $query->where('type', $this->typeFilter);
        }
        if ($this->statusFilter === 'read') {
            $query->whereNotNull('read_at');
        } elseif ($this->statusFilter === 'unread') {
            $query->whereNull('read_at');
        }
        if ($this->search) {
            $query->where('message', 'like', '%' . $this->search . '%');
        }

        $messages = $query->orderBy('created_at', 'desc')->paginate(15);
        $users = $this->getUsers();
        $stats = $this->getMessageStats();

        return view('livewire.user.message.index', [
            'messages' => $messages,
            'users' => $users,
            'stats' => $stats
        ]);
    }
}