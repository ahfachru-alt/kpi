<?php

namespace App\Livewire\Admin\Contact;

use App\Models\Contact;
use Livewire\Component;
use Livewire\WithPagination;
use App\Exports\ContactsExport;
use Maatwebsite\Excel\Facades\Excel;

class Index extends Component
{
    use WithPagination;

    public $showCreateModal = false;
    public $showEditModal = false;
    public $showViewModal = false;
    public $selectedContact = null;
    public $form = [
        'name' => '',
        'email' => '',
        'phone' => '',
        'whatsapp' => '',
        'address' => '',
        'type' => 'department',
        'status' => 'active',
        'notes' => ''
    ];

    // Filters
    public $typeFilter = '';
    public $statusFilter = '';
    public $search = '';

    protected $listeners = [
        'contactCreated' => 'loadData',
        'contactUpdated' => 'loadData',
        'contactDeleted' => 'loadData'
    ];

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        // Data will be loaded in render method
    }

    public function openCreateModal()
    {
        $this->resetForm();
        $this->showCreateModal = true;
    }

    public function openEditModal(Contact $contact)
    {
        $this->selectedContact = $contact;
        $this->form = [
            'name' => $contact->name,
            'email' => $contact->email,
            'phone' => $contact->phone,
            'whatsapp' => $contact->whatsapp,
            'address' => $contact->address,
            'type' => $contact->type,
            'status' => $contact->status,
            'notes' => $contact->notes
        ];
        $this->showEditModal = true;
    }

    public function openViewModal(Contact $contact)
    {
        $this->selectedContact = $contact;
        $this->showViewModal = true;
    }

    public function createContact()
    {
        $this->validate([
            'form.name' => 'required|string|max:255',
            'form.email' => 'nullable|email|max:255',
            'form.phone' => 'nullable|string|max:20',
            'form.whatsapp' => 'nullable|string|max:20',
            'form.address' => 'required|string|max:500',
            'form.type' => 'required|in:emergency,department,staff',
            'form.status' => 'required|in:active,inactive',
            'form.notes' => 'nullable|string'
        ]);

        Contact::create($this->form);

        $this->closeModals();
        $this->dispatch('contactCreated');
        session()->flash('message', 'Contact created successfully.');
    }

    public function updateContact()
    {
        $this->validate([
            'form.name' => 'required|string|max:255',
            'form.email' => 'nullable|email|max:255',
            'form.phone' => 'nullable|string|max:20',
            'form.whatsapp' => 'nullable|string|max:20',
            'form.address' => 'required|string|max:500',
            'form.type' => 'required|in:emergency,department,staff',
            'form.status' => 'required|in:active,inactive',
            'form.notes' => 'nullable|string'
        ]);

        $this->selectedContact->update($this->form);

        $this->closeModals();
        $this->dispatch('contactUpdated');
        session()->flash('message', 'Contact updated successfully.');
    }

    public function deleteContact(Contact $contact)
    {
        $contact->delete();
        $this->dispatch('contactDeleted');
        session()->flash('message', 'Contact deleted successfully.');
    }

    public function resetForm()
    {
        $this->form = [
            'name' => '',
            'email' => '',
            'phone' => '',
            'whatsapp' => '',
            'address' => '',
            'type' => 'department',
            'status' => 'active',
            'notes' => ''
        ];
        $this->selectedContact = null;
    }

    public function closeModals()
    {
        $this->showCreateModal = false;
        $this->showEditModal = false;
        $this->showViewModal = false;
        $this->resetForm();
    }

    public function exportToExcel()
    {
        $filename = 'contacts_' . now()->format('Y-m-d_H-i-s') . '.xlsx';
        
        return Excel::download(new ContactsExport(
            $this->typeFilter,
            $this->statusFilter,
            $this->search
        ), $filename);
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

        return view('livewire.admin.contact.index', [
            'contacts' => $contacts,
            'stats' => $stats
        ]);
    }
}