<?php

namespace App\Exports;

use App\Models\Room;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class RoomsExport implements FromCollection, WithHeadings, WithMapping, WithTitle
{
    protected $buildingFilter;
    protected $statusFilter;
    protected $searchFilter;

    public function __construct($buildingFilter = '', $statusFilter = '', $searchFilter = '')
    {
        $this->buildingFilter = $buildingFilter;
        $this->statusFilter = $statusFilter;
        $this->searchFilter = $searchFilter;
    }

    public function collection()
    {
        $query = Room::with(['building'])
            ->withCount(['cctvs']);

        if ($this->buildingFilter) {
            $query->where('building_id', $this->buildingFilter);
        }

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        if ($this->searchFilter) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->searchFilter . '%')
                    ->orWhere('description', 'like', '%' . $this->searchFilter . '%');
            });
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Building',
            'Description',
            'Floor',
            'Capacity',
            'Status',
            'Total CCTVs',
            'Created At',
            'Updated At'
        ];
    }

    public function map($room): array
    {
        return [
            $room->id,
            $room->name,
            $room->building->name,
            $room->description,
            $room->floor,
            $room->capacity,
            ucfirst($room->status),
            $room->cctvs_count,
            $room->created_at->format('Y-m-d H:i:s'),
            $room->updated_at->format('Y-m-d H:i:s')
        ];
    }

    public function title(): string
    {
        return 'Rooms';
    }
}