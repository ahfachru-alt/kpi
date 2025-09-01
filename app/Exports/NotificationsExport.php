<?php

namespace App\Exports;

use App\Models\Notification;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class NotificationsExport implements FromCollection, WithHeadings, WithMapping, WithTitle
{
    protected $userId;
    protected $typeFilter;
    protected $statusFilter;
    protected $search;

    public function __construct($userId = null, $typeFilter = '', $statusFilter = '', $search = '')
    {
        $this->userId = $userId;
        $this->typeFilter = $typeFilter;
        $this->statusFilter = $statusFilter;
        $this->search = $search;
    }

    public function collection()
    {
        $query = Notification::with('user');

        if ($this->userId) {
            $query->where('user_id', $this->userId);
        }
        if ($this->typeFilter) {
            $query->where('type', $this->typeFilter);
        }
        if ($this->statusFilter === 'read') {
            $query->where('is_read', true);
        } elseif ($this->statusFilter === 'unread') {
            $query->where('is_read', false);
        }
        if ($this->search) {
            $query->where(function($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('body', 'like', '%' . $this->search . '%');
            });
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Title',
            'Body',
            'Type',
            'Status',
            'Recipient',
            'Data',
            'Created At',
            'Updated At'
        ];
    }

    public function map($notification): array
    {
        return [
            $notification->id,
            $notification->title,
            $notification->body,
            ucfirst($notification->type),
            $notification->is_read ? 'Read' : 'Unread',
            $notification->user ? $notification->user->name : 'N/A',
            $notification->data ? json_encode($notification->data) : 'N/A',
            $notification->created_at->format('Y-m-d H:i:s'),
            $notification->updated_at->format('Y-m-d H:i:s')
        ];
    }

    public function title(): string
    {
        return 'Notifications';
    }
}