<?php

namespace App\Livewire\Admin\Message;

use App\Models\Message;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $showCreateModal = false;
    public $showEditModal = false;
    public $showViewModal = false;
    public $selectedMessage = null;
    public $form = [
        'from_id' => '',
        'to_id' => '',
        'message' => '',
        'type' => 'general'
    ];

    // Filters
    public $senderFilter = '';
    public $recipientFilter = '';
    public $typeFilter = '';
    public $statusFilter = '';
    public $search = '';

    protected $listeners = [
        'messageCreated' => 'loadData',
        'messageUpdated' => 'loadData',
        'messageDeleted' => 'loadData'
    ];

    public function mount()
    {
        $this->form['from_id'] = auth()->id();
        $this->loadData();
    }

    public function loadData()
    {
        // Data will be loaded in render method
    }

    public function openCreateModal()
    {
        $this->resetForm();
        $this->form['from_id'] = auth()->id();
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
            'from_id' => $message->from_id,
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
            'form.to_id' => 'required|exists:users,id|different:form.from_id',
            'form.message' => 'required|string|max:1000',
            'form.type' => 'required|in:general,emergency,maintenance,security,update'
        ]);

        Message::create([
            'from_id' => $this->form['from_id'],
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
            'form.to_id' => 'required|exists:users,id|different:form.from_id',
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

    public function markAsUnread(Message $message)
    {
        if ($message->to_id === auth()->id()) {
            $message->markAsUnread();
            $this->dispatch('messageUpdated');
        }
    }

    public function resetForm()
    {
        $this->form = [
            'from_id' => '',
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

    public function getMessageStats()
    {
        $query = Message::query();
        
        if ($this->senderFilter) {
            $query->where('from_id', $this->senderFilter);
        }
        if ($this->recipientFilter) {
            $query->where('to_id', $this->recipientFilter);
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
            'sent_today' => $query->where('from_id', auth()->id())
                ->whereDate('created_at', today())
                ->count()
        ];
    }

    public function render()
    {
        $query = Message::with(['sender', 'recipient'])
            ->orderBy('created_at', 'desc');

        // Apply filters
        if ($this->senderFilter) {
            $query->where('from_id', $this->senderFilter);
        }
        if ($this->recipientFilter) {
            $query->where('to_id', $this->recipientFilter);
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

        $messages = $query->paginate(15);
        $users = $this->getUsers();
        $stats = $this->getMessageStats();

        return view('livewire.admin.message.index', [
            'messages' => $messages,
            'users' => $users,
            'stats' => $stats
        ]);
    }
}