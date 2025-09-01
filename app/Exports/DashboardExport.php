<?php

namespace App\Exports;

use App\Models\User;
use App\Models\Building;
use App\Models\Room;
use App\Models\Cctv;
use App\Models\Contact;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class DashboardExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            'Users' => new UsersExport(),
            'Buildings' => new BuildingsExport(),
            'Rooms' => new RoomsExport(),
            'CCTVs' => new CctvsExport(),
            'Contacts' => new ContactsExport(),
        ];
    }
}

class UsersExport implements FromCollection, WithHeadings, WithMapping, WithTitle
{
    public function collection()
    {
        return User::all();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Email',
            'Role',
            'Status',
            'Last Seen',
            'Created At'
        ];
    }

    public function map($user): array
    {
        return [
            $user->id,
            $user->name,
            $user->email,
            $user->is_admin ? 'Admin' : 'User',
            $user->is_online ? 'Online' : 'Offline',
            $user->last_seen_at ? $user->last_seen_at->format('Y-m-d H:i:s') : 'Never',
            $user->created_at->format('Y-m-d H:i:s')
        ];
    }

    public function title(): string
    {
        return 'Users';
    }
}

class BuildingsExport implements FromCollection, WithHeadings, WithMapping, WithTitle
{
    public function collection()
    {
        return Building::all();
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
            'Created At'
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
            $building->status,
            $building->created_at->format('Y-m-d H:i:s')
        ];
    }

    public function title(): string
    {
        return 'Buildings';
    }
}

class RoomsExport implements FromCollection, WithHeadings, WithMapping, WithTitle
{
    public function collection()
    {
        return Room::with('building')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Building',
            'Name',
            'Description',
            'Floor',
            'Capacity',
            'Status',
            'Created At'
        ];
    }

    public function map($room): array
    {
        return [
            $room->id,
            $room->building->name,
            $room->name,
            $room->description,
            $room->floor,
            $room->capacity,
            $room->status,
            $room->created_at->format('Y-m-d H:i:s')
        ];
    }

    public function title(): string
    {
        return 'Rooms';
    }
}

class CctvsExport implements FromCollection, WithHeadings, WithMapping, WithTitle
{
    public function collection()
    {
        return Cctv::with(['room.building'])->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Building',
            'Room',
            'Name',
            'IP Address',
            'Status',
            'Model',
            'Resolution',
            'Last Maintenance',
            'Created At'
        ];
    }

    public function map($cctv): array
    {
        return [
            $cctv->id,
            $cctv->room->building->name,
            $cctv->room->name,
            $cctv->name,
            $cctv->ip_address,
            $cctv->status,
            $cctv->model,
            $cctv->resolution,
            $cctv->last_maintenance ? $cctv->last_maintenance->format('Y-m-d H:i:s') : 'Never',
            $cctv->created_at->format('Y-m-d H:i:s')
        ];
    }

    public function title(): string
    {
        return 'CCTVs';
    }
}

class ContactsExport implements FromCollection, WithHeadings, WithMapping, WithTitle
{
    public function collection()
    {
        return Contact::all();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Email',
            'Phone',
            'WhatsApp',
            'Address',
            'Type',
            'Status',
            'Created At'
        ];
    }

    public function map($contact): array
    {
        return [
            $contact->id,
            $contact->name,
            $contact->email,
            $contact->phone,
            $contact->whatsapp,
            $contact->address,
            $contact->type,
            $contact->status,
            $contact->created_at->format('Y-m-d H:i:s')
        ];
    }

    public function title(): string
    {
        return 'Contacts';
    }
}