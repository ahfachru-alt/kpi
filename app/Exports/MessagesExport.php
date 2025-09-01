<?php

namespace App\Exports;

use App\Models\Message;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class MessagesExport implements FromCollection, WithHeadings, WithMapping, WithTitle
{
    protected $userId;
    protected $typeFilter;
    protected $directionFilter;
    protected $statusFilter;
    protected $search;

    public function __construct($userId = null, $typeFilter = '', $directionFilter = '', $statusFilter = '', $search = '')
    {
        $this->userId = $userId;
        $this->typeFilter = $typeFilter;
        $this->directionFilter = $directionFilter;
        $this->statusFilter = $statusFilter;
        $this->search = $search;
    }

    public function collection()
    {
        $query = Message::with(['sender', 'recipient']);

        // Apply direction filter
        if ($this->directionFilter === 'sent') {
            $query->where('from_id', $this->userId);
        } elseif ($this->directionFilter === 'received') {
            $query->where('to_id', $this->userId);
        } else {
            $query->where(function($q) {
                $q->where('from_id', $this->userId)
                  ->orWhere('to_id', $this->userId);
            });
        }

        if ($this->typeFilter) {
            $query->where('type', $this->typeFilter);
        }
        if ($this->statusFilter === 'read') {
            $query->whereNotNull('read_at');
        } elseif ($this->statusFilter === 'unread') {
            $query->whereNull('read_at');
        }
        if ($this->search) {
            $query->where('message', 'like', '%' . $this->search . '%');
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Message',
            'Type',
            'Sender',
            'Recipient',
            'Status',
            'Sent At',
            'Read At'
        ];
    }

    public function map($message): array
    {
        return [
            $message->id,
            $message->message,
            ucfirst($message->type),
            $message->sender ? $message->sender->name : 'N/A',
            $message->recipient ? $message->recipient->name : 'N/A',
            $message->read_at ? 'Read' : 'Unread',
            $message->created_at->format('Y-m-d H:i:s'),
            $message->read_at ? $message->read_at->format('Y-m-d H:i:s') : 'N/A'
        ];
    }

    public function title(): string
    {
        return 'Messages';
    }
}