<?php

namespace App\Exports;

use App\Models\Building;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class BuildingsExport implements FromCollection, WithHeadings, WithMapping, WithTitle
{
    protected $statusFilter;
    protected $searchFilter;

    public function __construct($statusFilter = '', $searchFilter = '')
    {
        $this->statusFilter = $statusFilter;
        $this->searchFilter = $searchFilter;
    }

    public function collection()
    {
        $query = Building::withCount(['rooms', 'cctvs']);

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        if ($this->searchFilter) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->searchFilter . '%')
                    ->orWhere('description', 'like', '%' . $this->searchFilter . '%')
                    ->orWhere('address', 'like', '%' . $this->searchFilter . '%');
            });
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Description',
            'Latitude',
            'Longitude',
            'Address',
            'Status',
            'Total Rooms',
            'Total CCTVs',
            'Created At',
            'Updated At'
        ];
    }

    public function map($building): array
    {
        return [
            $building->id,
            $building->name,
            $building->description,
            $building->lat,
            $building->lng,
            $building->address,
            ucfirst($building->status),
            $building->rooms_count,
            $building->cctvs_count,
            $building->created_at->format('Y-m-d H:i:s'),
            $building->updated_at->format('Y-m-d H:i:s')
        ];
    }

    public function title(): string
    {
        return 'Buildings';
    }
}