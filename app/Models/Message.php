<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'from_id',
        'to_id',
        'message',
        'read_at',
        'type',
    ];

    protected $casts = [
        'read_at' => 'datetime',
        'type' => 'string',
    ];

    /**
     * Get sender of the message
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'from_id');
    }

    /**
     * Get recipient of the message
     */
    public function recipient()
    {
        return $this->belongsTo(User::class, 'to_id');
    }

    /**
     * Check if message is read
     */
    public function isRead(): bool
    {
        return !is_null($this->read_at);
    }

    /**
     * Mark message as read
     */
    public function markAsRead()
    {
        if (!$this->isRead()) {
            $this->update(['read_at' => now()]);
        }
    }

    /**
     * Mark message as unread
     */
    public function markAsUnread()
    {
        $this->update(['read_at' => null]);
    }

    /**
     * Scope for unread messages
     */
    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }

    /**
     * Scope for read messages
     */
    public function scopeRead($query)
    {
        return $query->whereNotNull('read_at');
    }

    /**
     * Get message type icon
     */
    public function getTypeIconAttribute(): string
    {
        return match($this->type) {
            'text' => 'fas fa-comment',
            'image' => 'fas fa-image',
            'file' => 'fas fa-file',
            'system' => 'fas fa-cog',
            default => 'fas fa-envelope'
        };
    }

    /**
     * Get message type color
     */
    public function getTypeColorAttribute(): string
    {
        return match($this->type) {
            'text' => 'blue',
            'image' => 'green',
            'file' => 'purple',
            'system' => 'gray',
            default => 'blue'
        };
    }
}