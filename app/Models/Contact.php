<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'whatsapp',
        'address',
        'type',
        'status',
        'notes',
    ];

    protected $casts = [
        'status' => 'string',
        'type' => 'string',
    ];

    /**
     * Get contact type label
     */
    public function getTypeLabelAttribute(): string
    {
        return match($this->type) {
            'emergency' => 'Emergency',
            'maintenance' => 'Maintenance',
            'security' => 'Security',
            'general' => 'General',
            default => 'Unknown'
        };
    }

    /**
     * Get contact status label
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'active' => 'Active',
            'inactive' => 'Inactive',
            'pending' => 'Pending',
            default => 'Unknown'
        };
    }

    /**
     * Get contact type color
     */
    public function getTypeColorAttribute(): string
    {
        return match($this->type) {
            'emergency' => 'red',
            'maintenance' => 'yellow',
            'security' => 'blue',
            'general' => 'green',
            default => 'gray'
        };
    }

    /**
     * Get contact status color
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'active' => 'green',
            'inactive' => 'red',
            'pending' => 'yellow',
            default => 'gray'
        };
    }

    /**
     * Scope for active contacts
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope for specific type
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }
}