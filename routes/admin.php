<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\User\Index as UserIndex;
use App\Livewire\Admin\User\Create as UserCreate;
use App\Livewire\Admin\User\Edit as UserEdit;
use App\Livewire\Admin\Table\Index as TableIndex;
use App\Livewire\Admin\Table\Create as TableCreate;
use App\Livewire\Admin\Table\Edit as TableEdit;
use App\Livewire\Admin\Maps\Index as MapsIndex;
use App\Livewire\Admin\Maps\Create as MapsCreate;
use App\Livewire\Admin\Maps\Edit as MapsEdit;
use App\Livewire\Admin\Location\Index as LocationIndex;
use App\Livewire\Admin\Location\Create as LocationCreate;
use App\Livewire\Admin\Location\Edit as LocationEdit;
use App\Livewire\Admin\Contact\Index as ContactIndex;
use App\Livewire\Admin\Contact\Create as ContactCreate;
use App\Livewire\Admin\Contact\Edit as ContactEdit;
use App\Livewire\Admin\Notification\Index as NotificationIndex;
use App\Livewire\Admin\Notification\Show as NotificationShow;
use App\Livewire\Admin\Message;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Routes for administrators only
|
*/

Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    
    // User Management
    Route::get('/user-list', UserIndex::class)->name('user.list');
    Route::get('/create-user', UserCreate::class)->name('user.create');
    Route::get('/edit-user/{id}', UserEdit::class)->name('user.edit');
    
    // Table Management
    Route::get('/table-list', TableIndex::class)->name('table.list');
    Route::get('/create-table', TableCreate::class)->name('table.create');
    Route::get('/edit-table/{id}', TableEdit::class)->name('table.edit');
    
    // Maps Management
    Route::get('/maps-list', MapsIndex::class)->name('maps.list');
    Route::get('/create-maps', MapsCreate::class)->name('maps.create');
    Route::get('/edit-maps/{id}', MapsEdit::class)->name('maps.edit');
    
    // Location Management
    Route::get('/location-list', LocationIndex::class)->name('location.list');
    Route::get('/create-location', LocationCreate::class)->name('location.create');
    Route::get('/edit-location/{id}', LocationEdit::class)->name('location.edit');
    
    // Contact Management
    Route::get('/contact-list', ContactIndex::class)->name('contact.list');
    Route::get('/create-contact', ContactCreate::class)->name('contact.create');
    Route::get('/edit-contact/{id}', ContactEdit::class)->name('contact.edit');
    
    // Notification Management
    Route::get('/notification', NotificationIndex::class)->name('notification');
    Route::get('/notification/{id}', NotificationShow::class)->name('notification.show');
    
    // Message Management
    Route::get('/message', Message::class)->name('message');
});