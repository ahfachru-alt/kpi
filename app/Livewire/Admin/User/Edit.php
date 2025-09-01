<?php

namespace App\Livewire\Admin\User;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class Edit extends Component
{
    public User $user;
    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';
    public $is_admin = false;
    public $is_online = false;

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $this->user->id,
            'password' => ['nullable', 'confirmed', Password::defaults()],
            'is_admin' => 'boolean',
            'is_online' => 'boolean',
        ];
    }

    public function mount($user)
    {
        $this->user = $user;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->is_admin = $user->is_admin;
        $this->is_online = $user->is_online;
    }

    public function updateUser()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'is_admin' => $this->is_admin,
            'is_online' => $this->is_online,
        ];

        // Only update password if provided
        if (!empty($this->password)) {
            $data['password'] = Hash::make($this->password);
        }

        $this->user->update($data);

        session()->flash('message', 'User updated successfully!');
        
        return redirect()->route('admin.user.list');
    }

    public function toggleOnlineStatus()
    {
        $this->is_online = !$this->is_online;
        $this->user->update(['is_online' => $this->is_online]);
    }

    public function render()
    {
        return view('livewire.admin.user.edit')->layout('components.layouts.app');
    }
}