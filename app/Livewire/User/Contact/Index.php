<?php

namespace App\Livewire\User\Contact;

use App\Models\Contact;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $showViewModal = false;
    public $selectedContact = null;

    // Filters
    public $typeFilter = '';
    public $statusFilter = '';
    public $search = '';

    protected $listeners = [
        'contactUpdated' => 'loadData'
    ];

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        // Data will be loaded in render method
    }

    public function openViewModal(Contact $contact)
    {
        $this->selectedContact = $contact;
        $this->showViewModal = true;
    }

    public function closeModals()
    {
        $this->showViewModal = false;
        $this->selectedContact = null;
    }

    public function getContactStats()
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

        return [
            'total' => $query->count(),
            'active' => $query->where('status', 'active')->count(),
            'emergency' => $query->where('type', 'emergency')->where('status', 'active')->count(),
            'department' => $query->where('type', 'department')->where('status', 'active')->count()
        ];
    }

    public function render()
    {
        $query = Contact::query();

        // Apply filters
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

        $contacts = $query->orderBy('type')
            ->orderBy('name')
            ->paginate(15);
        $stats = $this->getContactStats();

        return view('livewire.user.contact.index', [
            'contacts' => $contacts,
            'stats' => $stats
        ]);
    }
}