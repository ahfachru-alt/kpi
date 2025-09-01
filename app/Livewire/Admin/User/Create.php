<?php

namespace App\Livewire\Admin\User;

use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class Create extends Component
{
    public $name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';
    public $is_admin = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => ['required', 'confirmed', Password::defaults()],
        'is_admin' => 'boolean',
    ];

    public function createUser()
    {
        $this->validate();

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'is_admin' => $this->is_admin,
            'email_verified_at' => now(), // Auto-verify for admin-created users
        ]);

        session()->flash('message', 'User created successfully!');
        
        return redirect()->route('admin.user.list');
    }

    public function render()
    {
        return view('livewire.admin.user.create')->layout('components.layouts.app');
    }
}