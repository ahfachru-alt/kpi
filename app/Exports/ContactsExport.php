<?php

namespace App\Exports;

use App\Models\Contact;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class ContactsExport implements FromCollection, WithHeadings, WithMapping, WithTitle
{
    protected $typeFilter;
    protected $statusFilter;
    protected $search;

    public function __construct($typeFilter = '', $statusFilter = '', $search = '')
    {
        $this->typeFilter = $typeFilter;
        $this->statusFilter = $statusFilter;
        $this->search = $search;
    }

    public function collection()
    {
        $query = Contact::query();

        if ($this->typeFilter) {
            $query->where('type', $this->typeFilter);
        }
        if ($this->statusFilter === 'active') {
            $query->where('status', 'active');
        } elseif ($this->statusFilter === 'inactive') {
            $query->where('status', 'inactive');
        }
        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%')
                  ->orWhere('phone', 'like', '%' . $this->search . '%')
                  ->orWhere('address', 'like', '%' . $this->search . '%');
            });
        }

        return $query->orderBy('type')->orderBy('name')->get();
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
            'Notes',
            'Created At',
            'Updated At'
        ];
    }

    public function map($contact): array
    {
        return [
            $contact->id,
            $contact->name,
            $contact->email ?: 'N/A',
            $contact->phone ?: 'N/A',
            $contact->whatsapp ?: 'N/A',
            $contact->address,
            ucfirst($contact->type),
            ucfirst($contact->status),
            $contact->notes ?: 'N/A',
            $contact->created_at->format('Y-m-d H:i:s'),
            $contact->updated_at->format('Y-m-d H:i:s')
        ];
    }

    public function title(): string
    {
        return 'Contacts';
    }
}