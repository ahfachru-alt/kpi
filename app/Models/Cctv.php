<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cctv extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'name',
        'ip_address',
        'rtsp_url',
        'stream_url',
        'status',
        'model',
        'resolution',
        'last_maintenance',
        'notes',
    ];

    protected $casts = [
        'last_maintenance' => 'datetime',
        'status' => 'string',
    ];

    /**
     * Get room that contains this CCTV
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * Get building through room
     */
    public function building()
    {
        return $this->room->building;
    }

    /**
     * Get HLS stream URL
     */
    public function getHlsUrlAttribute()
    {
        $ip = str_replace(['.', ':', '@'], '_', parse_url($this->ip_address, PHP_URL_HOST));
        return asset('live/' . $ip . '.m3u8');
    }

    /**
     * Check if CCTV is online
     */
    public function isOnline(): bool
    {
        return $this->status === 'online';
    }

    /**
     * Check if CCTV is offline
     */
    public function isOffline(): bool
    {
        return $this->status === 'offline';
    }

    /**
     * Check if CCTV is in maintenance
     */
    public function isMaintenance(): bool
    {
        return $this->status === 'maintenance';
    }

    /**
     * Get status color for UI
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'online' => 'green',
            'offline' => 'red',
            'maintenance' => 'yellow',
            default => 'gray'
        };
    }
}