<?php

namespace App\Livewire\User\Notification;

use App\Models\Notification;
use Livewire\Component;

class Show extends Component
{
    public Notification $notification;

    public function mount($notification)
    {
        $this->notification = $notification;
        
        // Mark as read if it's the user's notification and unread
        if ($this->notification->user_id === auth()->id() && !$this->notification->is_read) {
            $this->notification->markAsRead();
        }
    }

    public function markAsUnread()
    {
        if ($this->notification->user_id === auth()->id()) {
            $this->notification->markAsUnread();
        }
    }

    public function render()
    {
        return view('livewire.user.notification.show')->layout('components.layouts.app');
    }
}