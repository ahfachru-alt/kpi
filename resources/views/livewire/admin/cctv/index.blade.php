<div>
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-3xl font-semibold leading-6 text-gray-900">CCTV Management</h1>
                <p class="mt-2 text-sm text-gray-700">
                    Manage CCTV cameras, their streams, and monitoring status
                </p>
            </div>
            <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                <button wire:click="openCreateModal" 
                        class="inline-flex items-center justify-center rounded-md border border-transparent bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 sm:w-auto">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                    </svg>
                    Add CCTV
                </button>
            </div>
        </div>

        <!-- CCTV Stats -->
        <div class="mt-8 grid grid-cols-1 gap-5 sm:grid-cols-4">
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total CCTVs</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $cctvs->total() }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Online</dt>
                                <dd class="text-lg font-medium text-green-600">{{ $onlineCount }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Offline</dt>
                                <dd class="text-lg font-medium text-red-600">{{ $offlineCount }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Maintenance</dt>
                                <dd class="text-lg font-medium text-yellow-600">{{ $maintenanceCount }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="mt-8 grid grid-cols-1 gap-4 sm:grid-cols-5">
            <div>
                <label for="building-filter" class="block text-sm font-medium text-gray-700">Building</label>
                <select wire:model.live="buildingFilter" id="building-filter" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    <option value="">All Buildings</option>
                    @foreach($buildings as $building)
                        <option value="{{ $building->id }}">{{ $building->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="room-filter" class="block text-sm font-medium text-gray-700">Room</label>
                <select wire:model.live="roomFilter" id="room-filter" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" {{ $buildingFilter ? '' : 'disabled' }}>
                    <option value="">All Rooms</option>
                    @foreach($rooms as $room)
                        <option value="{{ $room->id }}">{{ $room->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="status-filter" class="block text-sm font-medium text-gray-700">Status</label>
                <select wire:model.live="statusFilter" id="status-filter" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    <option value="">All Status</option>
                    <option value="online">Online</option>
                    <option value="offline">Offline</option>
                    <option value="maintenance">Maintenance</option>
                </select>
            </div>

            <div>
                <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
                <div class="mt-1 relative">
                    <input wire:model.live.debounce.300ms="search" type="text" id="search" 
                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" 
                           placeholder="Search CCTVs...">
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Actions</label>
                <button wire:click="exportData" 
                        class="mt-1 inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Export Excel
                </button>
            </div>
        </div>

        <!-- Quick Building Selection -->
        <div class="mt-6">
            <h3 class="text-sm font-medium text-gray-700 mb-3">Quick Building Selection</h3>
            <div class="flex flex-wrap gap-2">
                @foreach($buildings as $building)
                    <button wire:click="selectBuilding({{ $building->id }})" 
                            class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md {{ $buildingFilter == $building->id ? 'bg-blue-100 text-blue-700 border-blue-300' : 'bg-white text-gray-700 hover:bg-gray-50' }} focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        {{ $building->name }}
                        <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">
                            {{ $building->cctvs_count }}
                        </span>
                    </button>
                @endforeach
            </div>
        </div>

        <!-- CCTVs Table -->
        <div class="mt-8">
            @if($cctvs->count() > 0)
                <div class="bg-white shadow overflow-hidden sm:rounded-md">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">CCTV</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Location</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Technical Details</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Last Maintenance</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($cctvs as $cctv)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <div class="h-10 w-10 rounded-full bg-purple-100 flex items-center justify-center">
                                                    <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $cctv->name }}</div>
                                                <div class="text-sm text-gray-500">IP: {{ $cctv->ip_address }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            <div class="font-medium">{{ $cctv->room->name }}</div>
                                            <div class="text-gray-500">{{ $cctv->room->building->name }}</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $cctv->status === 'online' ? 'bg-green-100 text-green-800' : ($cctv->status === 'maintenance' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                            <span class="w-2 h-2 mr-1.5 rounded-full {{ $cctv->status === 'online' ? 'bg-green-400' : ($cctv->status === 'maintenance' ? 'bg-yellow-400' : 'bg-red-400') }}"></span>
                                            {{ ucfirst($cctv->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            <div>Model: {{ $cctv->model ?: 'N/A' }}</div>
                                            <div>Resolution: {{ $cctv->resolution ?: 'N/A' }}</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        @if($cctv->last_maintenance)
                                            {{ $cctv->last_maintenance->format('M d, Y') }}
                                        @else
                                            <span class="text-gray-400">Never</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex items-center space-x-2">
                                            <button wire:click="openViewModal({{ $cctv->id }})" 
                                                    class="text-blue-600 hover:text-blue-900">
                                                View
                                            </button>
                                            <button wire:click="openEditModal({{ $cctv->id }})" 
                                                    class="text-indigo-600 hover:text-indigo-900">
                                                Edit
                                            </button>
                                            <button wire:click="openStreamModal({{ $cctv->id }})" 
                                                    class="text-green-600 hover:text-green-900">
                                                Stream
                                            </button>
                                            <button wire:click="deleteCctv({{ $cctv->id }})" 
                                                    class="text-red-600 hover:text-red-900"
                                                    onclick="return confirm('Are you sure you want to delete this CCTV?')">
                                                Delete
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $cctvs->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No CCTVs found</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        Get started by adding a new CCTV camera.
                    </p>
                    <div class="mt-6">
                        <button wire:click="openCreateModal" 
                                class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Add CCTV
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Create/Edit CCTV Modal -->
    @if($showCreateModal || $showEditModal)
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity z-50"></div>
        <div class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-2xl sm:p-6">
                    <div class="absolute right-0 top-0 pr-4 pt-4">
                        <button wire:click="closeModals" class="rounded-md bg-white text-gray-400 hover:text-gray-500">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left w-full">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">
                                {{ $showCreateModal ? 'Create New CCTV' : 'Edit CCTV' }}
                            </h3>
                            <div class="mt-4 space-y-4">
                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Building</label>
                                        <select wire:model="form.building_id" wire:change="onBuildingChange" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                            <option value="">Select Building</option>
                                            @foreach($buildings as $building)
                                                <option value="{{ $building->id }}">{{ $building->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('form.building_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Room</label>
                                        <select wire:model="form.room_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" {{ $form['building_id'] ? '' : 'disabled' }}>
                                            <option value="">Select Room</option>
                                            @foreach($rooms as $room)
                                                <option value="{{ $room->id }}">{{ $room->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('form.room_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Name</label>
                                    <input wire:model="form.name" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                    @error('form.name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">IP Address</label>
                                        <input wire:model="form.ip_address" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="192.168.1.100">
                                        @error('form.ip_address') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Status</label>
                                        <select wire:model="form.status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                            <option value="online">Online</option>
                                            <option value="offline">Offline</option>
                                            <option value="maintenance">Maintenance</option>
                                        </select>
                                        @error('form.status') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">RTSP URL</label>
                                        <input wire:model="form.rtsp_url" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="rtsp://192.168.1.100:554/stream">
                                        @error('form.rtsp_url') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Stream URL</label>
                                        <input wire:model="form.stream_url" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="http://localhost:8080/hls/stream.m3u8">
                                        @error('form.stream_url') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Model</label>
                                        <input wire:model="form.model" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="HD Camera Pro">
                                        @error('form.model') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Resolution</label>
                                        <input wire:model="form.resolution" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="1920x1080">
                                        @error('form.resolution') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Notes</label>
                                    <textarea wire:model="form.notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"></textarea>
                                    @error('form.notes') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                        <button wire:click="{{ $showCreateModal ? 'createCctv' : 'updateCctv' }}" type="button" class="inline-flex w-full justify-center rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 sm:ml-3 sm:w-auto">
                            {{ $showCreateModal ? 'Create CCTV' : 'Update CCTV' }}
                        </button>
                        <button wire:click="closeModals" type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- View CCTV Modal -->
    @if($showViewModal)
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity z-50"></div>
        <div class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-2xl sm:p-6">
                    <div class="absolute right-0 top-0 pr-4 pt-4">
                        <button wire:click="closeModals" class="rounded-md bg-white text-gray-400 hover:text-gray-500">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left w-full">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">CCTV Details</h3>
                            @if($selectedCctv)
                                <div class="mt-4 space-y-4">
                                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Name</label>
                                            <p class="mt-1 text-sm text-gray-900">{{ $selectedCctv->name }}</p>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Status</label>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $selectedCctv->status === 'online' ? 'bg-green-100 text-green-800' : ($selectedCctv->status === 'maintenance' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                                {{ ucfirst($selectedCctv->status) }}
                                            </span>
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Location</label>
                                        <p class="mt-1 text-sm text-gray-900">{{ $selectedCctv->room->name }} - {{ $selectedCctv->room->building->name }}</p>
                                    </div>

                                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">IP Address</label>
                                            <p class="mt-1 text-sm text-gray-900">{{ $selectedCctv->ip_address }}</p>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Model</label>
                                            <p class="mt-1 text-sm text-gray-900">{{ $selectedCctv->model ?: 'N/A' }}</p>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Resolution</label>
                                            <p class="mt-1 text-sm text-gray-900">{{ $selectedCctv->resolution ?: 'N/A' }}</p>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Last Maintenance</label>
                                            <p class="mt-1 text-sm text-gray-900">{{ $selectedCctv->last_maintenance ? $selectedCctv->last_maintenance->format('M d, Y') : 'Never' }}</p>
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">RTSP URL</label>
                                        <p class="mt-1 text-sm text-gray-900 font-mono">{{ $selectedCctv->rtsp_url }}</p>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Stream URL</label>
                                        <p class="mt-1 text-sm text-gray-900 font-mono">{{ $selectedCctv->stream_url }}</p>
                                    </div>

                                    @if($selectedCctv->notes)
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Notes</label>
                                            <p class="mt-1 text-sm text-gray-900">{{ $selectedCctv->notes }}</p>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                        <button wire:click="openEditModal({{ $selectedCctv->id ?? 0 }})" type="button" class="inline-flex w-full justify-center rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 sm:ml-3 sm:w-auto">
                            Edit CCTV
                        </button>
                        <button wire:click="closeModals" type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Stream Modal -->
    @if($showStreamModal)
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity z-50"></div>
        <div class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-4xl sm:p-6">
                    <div class="absolute right-0 top-0 pr-4 pt-4">
                        <button wire:click="closeModals" class="rounded-md bg-white text-gray-400 hover:text-gray-500">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left w-full">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Live Stream</h3>
                            @if($selectedCctv)
                                <div class="mt-4">
                                    <div class="mb-4">
                                        <h4 class="text-sm font-medium text-gray-700">{{ $selectedCctv->name }}</h4>
                                        <p class="text-sm text-gray-500">{{ $selectedCctv->room->name }} - {{ $selectedCctv->room->building->name }}</p>
                                    </div>
                                    
                                    <div class="bg-gray-900 rounded-lg overflow-hidden">
                                        @if($selectedCctv->status === 'online' && $selectedCctv->stream_url)
                                            <video id="cctv-stream-{{ $selectedCctv->id }}" class="w-full h-96" controls>
                                                <source src="{{ $selectedCctv->stream_url }}" type="application/x-mpegURL">
                                                Your browser does not support HLS video.
                                            </video>
                                            <script>
                                                if (Hls.isSupported()) {
                                                    const video = document.getElementById('cctv-stream-{{ $selectedCctv->id }}');
                                                    const hls = new Hls();
                                                    hls.loadSource('{{ $selectedCctv->stream_url }}');
                                                    hls.attachMedia(video);
                                                }
                                            </script>
                                        @else
                                            <div class="flex items-center justify-center h-96 text-white">
                                                <div class="text-center">
                                                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                                    </svg>
                                                    <p class="text-lg font-medium">Stream Unavailable</p>
                                                    <p class="text-sm text-gray-400">
                                                        @if($selectedCctv->status !== 'online')
                                                            CCTV is currently {{ $selectedCctv->status }}
                                                        @else
                                                            No stream URL configured
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                        <button wire:click="closeModals" type="button" class="inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>