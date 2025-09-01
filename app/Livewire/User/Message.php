<?php

namespace App\Livewire\User;

use App\Models\Message;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Message extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedUser = null;
    public $newMessage = '';
    public $messageType = 'text';
    public $users = [];
    public $conversations = [];
    public $currentConversation = null;

    public function mount()
    {
        $this->loadUsers();
        $this->loadConversations();
    }

    public function loadUsers()
    {
        $this->users = User::where('id', '!=', auth()->id())
            ->where('is_admin', true)
            ->orderBy('name')
            ->get();
    }

    public function loadConversations()
    {
        $this->conversations = Message::where('from_id', auth()->id())
            ->orWhere('to_id', auth()->id())
            ->with(['sender', 'recipient'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy(function ($message) {
                if ($message->from_id === auth()->id()) {
                    return $message->to_id;
                }
                return $message->from_id;
            })
            ->map(function ($messages) {
                $lastMessage = $messages->sortByDesc('created_at')->first();
                $otherUser = $lastMessage->from_id === auth()->id() 
                    ? $lastMessage->recipient 
                    : $lastMessage->sender;
                
                return [
                    'user' => $otherUser,
                    'last_message' => $lastMessage,
                    'unread_count' => $messages->where('to_id', auth()->id())
                        ->where('read_at', null)
                        ->count()
                ];
            })
            ->sortByDesc('last_message.created_at')
            ->values();
    }

    public function selectUser($userId)
    {
        $this->selectedUser = User::find($userId);
        $this->loadMessages();
    }

    public function loadMessages()
    {
        if (!$this->selectedUser) return;

        $this->currentConversation = Message::where(function ($query) {
            $query->where('from_id', auth()->id())
                  ->where('to_id', $this->selectedUser->id);
        })->orWhere(function ($query) {
            $query->where('from_id', $this->selectedUser->id)
                  ->where('to_id', auth()->id());
        })
        ->with(['sender', 'recipient'])
        ->orderBy('created_at', 'asc')
        ->get();

        // Mark messages as read
        Message::where('from_id', $this->selectedUser->id)
            ->where('to_id', auth()->id())
            ->where('read_at', null)
            ->update(['read_at' => now()]);
    }

    public function sendMessage()
    {
        if (empty(trim($this->newMessage)) return;

        Message::create([
            'from_id' => auth()->id(),
            'to_id' => $this->selectedUser->id,
            'message' => trim($this->newMessage),
            'type' => $this->messageType,
        ]);

        $this->newMessage = '';
        $this->loadMessages();
        $this->loadConversations();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.user.message')->layout('components.layouts.app');
    }
}