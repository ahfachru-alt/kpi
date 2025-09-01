<div>
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-3xl font-semibold leading-6 text-gray-900">Location Management</h1>
                <p class="mt-2 text-sm text-gray-700">
                    Browse buildings and rooms to find specific locations
                </p>
            </div>
        </div>

        <!-- Filters -->
        <div class="mt-8 grid grid-cols-1 gap-4 sm:grid-cols-3">
            <!-- Building Filter -->
            <div>
                <label for="building-filter" class="block text-sm font-medium text-gray-700">Building</label>
                <select wire:model.live="buildingFilter" id="building-filter" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    <option value="">All Buildings</option>
                    @foreach($buildings as $building)
                        <option value="{{ $building->id }}">{{ $building->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Status Filter -->
            <div>
                <label for="status-filter" class="block text-sm font-medium text-gray-700">Status</label>
                <select wire:model.live="statusFilter" id="status-filter" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    <option value="">All Status</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                    <option value="maintenance">Maintenance</option>
                </select>
            </div>

            <!-- Search -->
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
                <div class="mt-1 relative">
                    <input wire:model.live.debounce.300ms="search" type="text" id="search" 
                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" 
                           placeholder="Search rooms or buildings...">
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Building Selection -->
        @if($buildings->count() > 0)
            <div class="mt-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Building Selection</h3>
                <div class="flex flex-wrap gap-2">
                    @foreach($buildings as $building)
                        <button wire:click="selectBuilding({{ $building->id }})" 
                                class="px-4 py-2 text-sm font-medium rounded-full {{ $selectedBuilding && $selectedBuilding->id === $building->id ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                            {{ $building->name }}
                        </button>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Rooms Grid -->
        <div class="mt-8">
            @if($rooms->count() > 0)
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach($rooms as $room)
                        <div class="bg-white overflow-hidden shadow rounded-lg">
                            <div class="p-6">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="ml-4 flex-1">
                                        <h3 class="text-lg font-medium text-gray-900">{{ $room->name }}</h3>
                                        <p class="text-sm text-gray-500">{{ $room->building->name }}</p>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $room->status === 'active' ? 'bg-green-100 text-green-800' : ($room->status === 'maintenance' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                            {{ ucfirst($room->status) }}
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="mt-4">
                                    <p class="text-sm text-gray-600">{{ $room->description ?: 'No description available' }}</p>
                                    <div class="mt-3 flex items-center justify-between text-sm text-gray-500">
                                        <span>Floor: {{ $room->floor }}</span>
                                        <span>Capacity: {{ $room->capacity }}</span>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-500">
                                            CCTV: {{ $room->cctvs->count() }}
                                        </span>
                                        <a href="{{ route('user.room.index', ['building' => $room->building->id, 'room' => $room->id]) }}" 
                                           class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                            View Details →
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $rooms->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No rooms found</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        Try adjusting your search criteria or building selection.
                    </p>
                </div>
            @endif
        </div>
    </div>
</div>