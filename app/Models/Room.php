<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'building_id',
        'name',
        'description',
        'floor',
        'capacity',
        'status',
    ];

    protected $casts = [
        'floor' => 'integer',
        'capacity' => 'integer',
        'status' => 'string',
    ];

    /**
     * Get building that contains this room
     */
    public function building()
    {
        return $this->belongsTo(Building::class);
    }

    /**
     * Get CCTVs in this room
     */
    public function cctvs()
    {
        return $this->hasMany(Cctv::class);
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