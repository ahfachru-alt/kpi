<div>
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-3xl font-semibold leading-6 text-gray-900">Maps Management</h1>
                <p class="mt-2 text-sm text-gray-700">
                    Manage building locations, CCTV placements, and geographic data
                </p>
            </div>
            <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                <div class="flex space-x-3">
                    <button wire:click="openCreateBuildingModal" 
                            class="inline-flex items-center justify-center rounded-md border border-transparent bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 sm:w-auto">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        Add Building
                    </button>
                    <button wire:click="openCreateCctvModal" 
                            class="inline-flex items-center justify-center rounded-md border border-transparent bg-green-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 sm:w-auto">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                        Add CCTV
                    </button>
                </div>
            </div>
        </div>

        <!-- Map Stats -->
        <div class="mt-8 grid grid-cols-1 gap-5 sm:grid-cols-4">
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Buildings</dt>
                                <dd class="text-lg font-medium text-gray-900">{{ $buildings->count() }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

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
                                <dd class="text-lg font-medium text-purple-600">{{ $cctvs->count() }}</dd>
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
                                <dt class="text-sm font-medium text-gray-500 truncate">Online CCTVs</dt>
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
                            <div class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V7.618a1 1 0 011.447-.894L9 12m0 8l6-3m-6 3V9m6 11l-5.447-2.724A1 1 0 0121 16.382V7.618a1 1 0 011.447-.894L21 12m0 8l-6-3m6 3V9"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Coverage Area</dt>
                                <dd class="text-lg font-medium text-yellow-600">{{ $coverageArea }} km²</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Map Controls -->
        <div class="mt-8 bg-white shadow rounded-lg p-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
                <div>
                    <h3 class="text-lg font-medium text-gray-900">Interactive Map</h3>
                    <p class="text-sm text-gray-500">Manage building locations and CCTV placements</p>
                </div>
                
                <div class="flex items-center space-x-4">
                    <!-- Layer Controls -->
                    <div class="flex items-center space-x-2">
                        <label class="flex items-center">
                            <input type="checkbox" wire:model="showBuildings" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <span class="ml-2 text-sm text-gray-700">Buildings</span>
                        </label>
                        <label class="flex items-center">
                            <input type="checkbox" wire:model="showCctvs" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <span class="ml-2 text-sm text-gray-700">CCTVs</span>
                        </label>
                    </div>

                    <!-- CCTV Status Filter -->
                    <select wire:model.live="cctvStatusFilter" class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        <option value="">All CCTVs</option>
                        <option value="online">Online Only</option>
                        <option value="offline">Offline Only</option>
                        <option value="maintenance">Maintenance Only</option>
                    </select>

                    <!-- Map Type Toggle -->
                    <div class="flex rounded-md shadow-sm">
                        <button wire:click="setMapType('street')" 
                                class="px-3 py-2 text-sm font-medium rounded-l-md border {{ $mapType === 'street' ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50' }}">
                            Street
                        </button>
                        <button wire:click="setMapType('satellite')" 
                                class="px-3 py-2 text-sm font-medium rounded-r-md border {{ $mapType === 'satellite' ? 'bg-blue-600 text-white border-blue-600' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-50' }}">
                            Satellite
                        </button>
                    </div>
                </div>
            </div>

            <!-- Map Container -->
            <div class="mt-6">
                <div id="admin-map" class="w-full h-96 rounded-lg border border-gray-300"></div>
            </div>

            <!-- Map Legend -->
            <div class="mt-4 flex flex-wrap items-center space-x-6 text-sm">
                <div class="flex items-center space-x-2">
                    <div class="w-4 h-4 bg-blue-500 rounded-full"></div>
                    <span class="text-gray-700">Buildings</span>
                </div>
                <div class="flex items-center space-x-2">
                    <div class="w-4 h-4 bg-green-500 rounded-full"></div>
                    <span class="text-gray-700">Online CCTVs</span>
                </div>
                <div class="flex items-center space-x-2">
                    <div class="w-4 h-4 bg-red-500 rounded-full"></div>
                    <span class="text-gray-700">Offline CCTVs</span>
                </div>
                <div class="flex items-center space-x-2">
                    <div class="w-4 h-4 bg-yellow-500 rounded-full"></div>
                    <span class="text-gray-700">Maintenance CCTVs</span>
                </div>
            </div>
        </div>

        <!-- Location Management -->
        <div class="mt-8 grid grid-cols-1 gap-6 lg:grid-cols-2">
            <!-- Buildings List -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Buildings</h3>
                    <p class="text-sm text-gray-500">Manage building locations and coordinates</p>
                </div>
                <div class="p-6">
                    @if($buildings->count() > 0)
                        <div class="space-y-4">
                            @foreach($buildings as $building)
                                <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-900">{{ $building->name }}</h4>
                                            <p class="text-xs text-gray-500">{{ $building->lat }}, {{ $building->lng }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <button wire:click="centerMapOnBuilding({{ $building->id }})" 
                                                class="text-blue-600 hover:text-blue-900 text-sm">
                                            Center
                                        </button>
                                        <button wire:click="openEditBuildingModal({{ $building->id }})" 
                                                class="text-indigo-600 hover:text-indigo-900 text-sm">
                                            Edit
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No buildings found</h3>
                            <p class="mt-1 text-sm text-gray-500">Add buildings to start mapping</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- CCTVs List -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">CCTVs</h3>
                    <p class="text-sm text-gray-500">Manage CCTV locations and status</p>
                </div>
                <div class="p-6">
                    @if($cctvs->count() > 0)
                        <div class="space-y-4">
                            @foreach($cctvs->take(10) as $cctv)
                                <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg hover:bg-gray-50">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                                            <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-900">{{ $cctv->name }}</h4>
                                            <p class="text-xs text-gray-500">{{ $cctv->room->building->name }} - {{ $cctv->room->name }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $cctv->status === 'online' ? 'bg-green-100 text-green-800' : ($cctv->status === 'maintenance' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                            {{ ucfirst($cctv->status) }}
                                        </span>
                                        <button wire:click="centerMapOnCctv({{ $cctv->id }})" 
                                                class="text-blue-600 hover:text-blue-900 text-sm">
                                            Center
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                            @if($cctvs->count() > 10)
                                <div class="text-center pt-4">
                                    <p class="text-sm text-gray-500">Showing 10 of {{ $cctvs->count() }} CCTVs</p>
                                    <a href="{{ route('admin.cctv.index') }}" class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                                        View All CCTVs
                                    </a>
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No CCTVs found</h3>
                            <p class="mt-1 text-sm text-gray-500">Add CCTVs to start monitoring</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Building Modals -->
    @include('livewire.admin.maps.partials.building-modals')

    <!-- CCTV Modals -->
    @include('livewire.admin.maps.partials.cctv-modals')

    <script>
        document.addEventListener('livewire:init', () => {
            let map;
            let buildingMarkers = [];
            let cctvMarkers = [];

            // Initialize map
            function initMap() {
                // Default center (Pertamina RU VI Balongan coordinates)
                const defaultCenter = [-6.2088, 106.8456];
                
                map = L.map('admin-map').setView(defaultCenter, 15);
                
                // Add tile layers
                const streetLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors'
                });
                
                const satelliteLayer = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                    attribution: '© Esri'
                });

                // Add default layer
                streetLayer.addTo(map);

                // Store layers for toggling
                window.mapLayers = {
                    street: streetLayer,
                    satellite: satelliteLayer
                };

                // Add scale control
                L.control.scale().addTo(map);

                // Add fullscreen control
                L.control.fullscreen().addTo(map);

                // Initialize markers
                updateMarkers();
            }

            // Update markers based on Livewire data
            function updateMarkers() {
                // Clear existing markers
                buildingMarkers.forEach(marker => map.removeLayer(marker));
                cctvMarkers.forEach(marker => map.removeLayer(marker));
                buildingMarkers = [];
                cctvMarkers = [];

                // Add building markers
                @if($showBuildings)
                    @foreach($buildings as $building)
                        const buildingMarker = L.circleMarker([{{ $building->lat }}, {{ $building->lng }}], {
                            radius: 8,
                            fillColor: '#3B82F6',
                            color: '#1E40AF',
                            weight: 2,
                            opacity: 1,
                            fillOpacity: 0.8
                        }).addTo(map);

                        buildingMarker.bindPopup(`
                            <div class="p-2">
                                <h3 class="font-semibold text-gray-900">{{ $building->name }}</h3>
                                <p class="text-sm text-gray-600">{{ $building->description ?: 'No description' }}</p>
                                <p class="text-xs text-gray-500 mt-1">Coordinates: {{ $building->lat }}, {{ $building->lng }}</p>
                                <div class="mt-2 flex space-x-2">
                                    <button onclick="Livewire.dispatch('openEditBuildingModal', { buildingId: {{ $building->id }} })" 
                                            class="px-2 py-1 text-xs bg-blue-600 text-white rounded hover:bg-blue-700">
                                        Edit
                                    </button>
                                </div>
                            </div>
                        `);

                        buildingMarkers.push(buildingMarker);
                    @endforeach
                @endif

                // Add CCTV markers
                @if($showCctvs)
                    @foreach($cctvs as $cctv)
                        @if($cctv->room && $cctv->room->building)
                            const cctvColor = '{{ $cctv->status === "online" ? "#10B981" : ($cctv->status === "maintenance" ? "#F59E0B" : "#EF4444") }}';
                            const cctvMarker = L.circleMarker([{{ $cctv->room->building->lat }}, {{ $cctv->room->building->lng }}], {
                                radius: 6,
                                fillColor: cctvColor,
                                color: cctvColor,
                                weight: 1,
                                opacity: 1,
                                fillOpacity: 0.8
                            }).addTo(map);

                            cctvMarker.bindPopup(`
                                <div class="p-2">
                                    <h3 class="font-semibold text-gray-900">{{ $cctv->name }}</h3>
                                    <p class="text-sm text-gray-600">{{ $cctv->room->name }} - {{ $cctv->room->building->name }}</p>
                                    <p class="text-xs text-gray-500 mt-1">Status: <span class="font-medium">{{ ucfirst($cctv->status) }}</span></p>
                                    <p class="text-xs text-gray-500">IP: {{ $cctv->ip_address }}</p>
                                    <div class="mt-2 flex space-x-2">
                                        <button onclick="Livewire.dispatch('openViewCctvModal', { cctvId: {{ $cctv->id }} })" 
                                                class="px-2 py-1 text-xs bg-blue-600 text-white rounded hover:bg-blue-700">
                                            View
                                        </button>
                                        <button onclick="Livewire.dispatch('openStreamCctvModal', { cctvId: {{ $cctv->id }} })" 
                                                class="px-2 py-1 text-xs bg-green-600 text-white rounded hover:bg-green-700">
                                            Stream
                                        </button>
                                    </div>
                                </div>
                            `);

                            cctvMarkers.push(cctvMarker);
                        @endif
                    @endforeach
                @endif
            }

            // Initialize map when component loads
            initMap();

            // Listen for Livewire events
            Livewire.on('updateMarkers', () => {
                updateMarkers();
            });

            Livewire.on('centerMap', (data) => {
                if (data.lat && data.lng) {
                    map.setView([data.lat, data.lng], 18);
                }
            });

            // Handle map type changes
            Livewire.on('changeMapType', (data) => {
                const currentLayer = window.mapLayers[data.type];
                if (currentLayer) {
                    map.eachLayer((layer) => {
                        if (layer instanceof L.TileLayer) {
                            map.removeLayer(layer);
                        }
                    });
                    currentLayer.addTo(map);
                }
            });
        });
    </script>
</div>