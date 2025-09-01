<?php

namespace App\Livewire\Admin\User;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';

    protected $paginationTheme = 'tailwind';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $users = User::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->when($this->statusFilter, function ($query) {
                if ($this->statusFilter === 'online') {
                    $query->where('is_online', true);
                } elseif ($this->statusFilter === 'offline') {
                    $query->where('is_online', false);
                }
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.admin.user.index', compact('users'))
            ->layout('components.layouts.app');
    }
}