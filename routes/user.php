<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\User\Dashboard;
use App\Livewire\User\Maps\Index as MapsIndex;
use App\Livewire\User\Location\Index as LocationIndex;
use App\Livewire\User\Room\Index as RoomIndex;
use App\Livewire\User\Cctv\Index as CctvIndex;
use App\Livewire\User\Cctv\ShowStream as CctvShowStream;
use App\Livewire\User\Contact\Index as ContactIndex;
use App\Livewire\User\Notification\Index as NotificationIndex;
use App\Livewire\User\Notification\Show as NotificationShow;
use App\Livewire\User\Message;

/*
|--------------------------------------------------------------------------
| User Routes
|--------------------------------------------------------------------------
|
| Routes for regular users (non-admin)
|
*/

Route::middleware(['auth', 'verified'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/maps', MapsIndex::class)->name('maps');
    Route::get('/location', LocationIndex::class)->name('location');
    Route::get('/location/room', RoomIndex::class)->name('location.room');
    Route::get('/location/room/cctv', CctvIndex::class)->name('location.room.cctv');
    Route::get('/location/room/cctv/show-stream-cctv', CctvShowStream::class)->name('location.room.cctv.show-stream');
    Route::get('/contact', ContactIndex::class)->name('contact');
    Route::get('/notification', NotificationIndex::class)->name('notification');
    Route::get('/notification/{id}', NotificationShow::class)->name('notification.show');
    Route::get('/message', Message::class)->name('message');
});