<?php

namespace App\Exports;

use App\Models\Cctv;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class CctvsExport implements FromCollection, WithHeadings, WithMapping, WithTitle
{
    protected $buildingFilter;
    protected $roomFilter;
    protected $statusFilter;
    protected $searchFilter;

    public function __construct($buildingFilter = '', $roomFilter = '', $statusFilter = '', $searchFilter = '')
    {
        $this->buildingFilter = $buildingFilter;
        $this->roomFilter = $roomFilter;
        $this->statusFilter = $statusFilter;
        $this->searchFilter = $searchFilter;
    }

    public function collection()
    {
        $query = Cctv::with(['room.building']);

        if ($this->buildingFilter) {
            $query->whereHas('room', function ($q) {
                $q->where('building_id', $this->buildingFilter);
            });
        }

        if ($this->roomFilter) {
            $query->where('room_id', $this->roomFilter);
        }

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        if ($this->searchFilter) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->searchFilter . '%')
                    ->orWhere('ip_address', 'like', '%' . $this->searchFilter . '%')
                    ->orWhere('model', 'like', '%' . $this->searchFilter . '%')
                    ->orWhere('notes', 'like', '%' . $this->searchFilter . '%');
            });
        }

        return $query->orderBy('name')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'IP Address',
            'Location',
            'Building',
            'Room',
            'Status',
            'Model',
            'Resolution',
            'RTSP URL',
            'Stream URL',
            'Last Maintenance',
            'Notes',
            'Created At',
            'Updated At'
        ];
    }

    public function map($cctv): array
    {
        return [
            $cctv->id,
            $cctv->name,
            $cctv->ip_address,
            $cctv->room->name . ' - ' . $cctv->room->building->name,
            $cctv->room->building->name,
            $cctv->room->name,
            ucfirst($cctv->status),
            $cctv->model ?: 'N/A',
            $cctv->resolution ?: 'N/A',
            $cctv->rtsp_url,
            $cctv->stream_url ?: 'N/A',
            $cctv->last_maintenance ? $cctv->last_maintenance->format('Y-m-d H:i:s') : 'Never',
            $cctv->notes ?: 'N/A',
            $cctv->created_at->format('Y-m-d H:i:s'),
            $cctv->updated_at->format('Y-m-d H:i:s')
        ];
    }

    public function title(): string
    {
        return 'CCTVs';
    }
}