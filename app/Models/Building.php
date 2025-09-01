<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'lat',
        'lng',
        'address',
        'status',
    ];

    protected $casts = [
        'lat' => 'decimal:8',
        'lng' => 'decimal:8',
        'status' => 'string',
    ];

    /**
     * Get rooms in this building
     */
    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    /**
     * Get all CCTVs in this building
     */
    public function cctvs()
    {
        return $this->hasManyThrough(Cctv::class, Room::class);
    }

    /**
     * Get online CCTVs count
     */
    public function getOnlineCctvCountAttribute()
    {
        return $this->cctvs()->where('status', 'online')->count();
    }

    /**
     * Get offline CCTVs count
     */
    public function getOfflineCctvCountAttribute()
    {
        return $this->cctvs()->where('status', 'offline')->count();
    }

    /**
     * Get maintenance CCTVs count
     */
    public function getMaintenanceCctvCountAttribute()
    {
        return $this->cctvs()->where('status', 'maintenance')->count();
    }
}