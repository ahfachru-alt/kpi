<div>
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-3xl font-semibold leading-6 text-gray-900">Interactive Maps</h1>
                <p class="mt-2 text-sm text-gray-700">
                    View CCTV locations on interactive maps with OpenStreetMap and satellite view
                </p>
            </div>
        </div>

        <!-- Status Filter -->
        <div class="mt-8 flex flex-wrap gap-4">
            <button wire:click="filterByStatus('all')" 
                    class="px-4 py-2 rounded-full text-sm font-medium {{ $selectedStatus === 'all' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                All CCTVs
            </button>
            <button wire:click="filterByStatus('online')" 
                    class="px-4 py-2 rounded-full text-sm font-medium {{ $selectedStatus === 'online' ? 'bg-green-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                <span class="inline-block w-3 h-3 bg-green-500 rounded-full mr-2"></span>
                Online
            </button>
            <button wire:click="filterByStatus('offline')" 
                    class="px-4 py-2 rounded-full text-sm font-medium {{ $selectedStatus === 'offline' ? 'bg-red-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                <span class="inline-block w-3 h-3 bg-red-500 rounded-full mr-2"></span>
                Offline
            </button>
            <button wire:click="filterByStatus('maintenance')" 
                    class="px-4 py-2 rounded-full text-sm font-medium {{ $selectedStatus === 'maintenance' ? 'bg-yellow-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                <span class="inline-block w-3 h-3 bg-yellow-500 rounded-full mr-2"></span>
                Maintenance
            </button>
        </div>

        <!-- Map Container -->
        <div class="mt-8">
            <div id="map" class="w-full h-96 rounded-lg shadow-lg"></div>
        </div>

        <!-- Legend -->
        <div class="mt-4 flex flex-wrap gap-4 text-sm text-gray-600">
            <div class="flex items-center">
                <span class="inline-block w-4 h-4 bg-green-500 rounded-full mr-2"></span>
                Online CCTV
            </div>
            <div class="flex items-center">
                <span class="inline-block w-4 h-4 bg-red-500 rounded-full mr-2"></span>
                Offline CCTV
            </div>
            <div class="flex items-center">
                <span class="inline-block w-4 h-4 bg-yellow-500 rounded-full mr-2"></span>
                Maintenance CCTV
            </div>
            <div class="flex items-center">
                <span class="inline-block w-4 h-4 bg-blue-500 rounded-full mr-2"></span>
                Building Location
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('livewire:init', () => {
            // Initialize map when component loads
            initMap();
        });

        function initMap() {
            // Initialize Leaflet map
            const map = L.map('map').setView([-6.2090, 106.8458], 15);

            // Add OpenStreetMap tile layer
            const osmLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            });

            // Add satellite tile layer
            const satelliteLayer = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                attribution: '© Esri'
            });

            // Add base layers control
            const baseMaps = {
                "OpenStreetMap": osmLayer,
                "Satellite": satelliteLayer
            };

            L.control.layers(baseMaps).addTo(map);

            // Add default layer
            osmLayer.addTo(map);

            // Add buildings as markers
            @foreach($buildings as $building)
                const building{{ $building->id }} = L.marker([{{ $building->lat }}, {{ $building->lng }}], {
                    icon: L.divIcon({
                        className: 'building-marker',
                        html: '<div class="w-6 h-6 bg-blue-500 rounded-full border-2 border-white shadow-lg"></div>',
                        iconSize: [24, 24],
                        iconAnchor: [12, 12]
                    })
                }).addTo(map);

                building{{ $building->id }}.bindPopup(`
                    <div class="p-2">
                        <h3 class="font-semibold text-lg">{{ $building->name }}</h3>
                        <p class="text-sm text-gray-600">{{ $building->description }}</p>
                        <p class="text-xs text-gray-500 mt-1">{{ $building->address }}</p>
                    </div>
                `);
            @endforeach

            // Add CCTV markers
            @foreach($cctvs as $cctv)
                const cctv{{ $cctv->id }} = L.marker([{{ $cctv->room->building->lat }}, {{ $cctv->room->building->lng }}], {
                    icon: L.divIcon({
                        className: 'cctv-marker',
                        html: '<div class="w-4 h-4 bg-{{ $cctv->status_color }}-500 rounded-full border-2 border-white shadow-lg"></div>',
                        iconSize: [16, 16],
                        iconAnchor: [8, 8]
                    })
                }).addTo(map);

                cctv{{ $cctv->id }}.bindPopup(`
                    <div class="p-2">
                        <h3 class="font-semibold">{{ $cctv->name }}</h3>
                        <p class="text-sm text-gray-600">{{ $cctv->room->building->name }} - {{ $cctv->room->name }}</p>
                        <p class="text-xs text-gray-500 mt-1">Status: {{ ucfirst($cctv->status) }}</p>
                        <a href="{{ route('user.location.room.cctv.show-stream', ['cctv' => $cctv->id]) }}" 
                           class="inline-block mt-2 px-3 py-1 bg-blue-600 text-white text-xs rounded hover:bg-blue-700">
                            View Stream
                        </a>
                    </div>
                `);
            @endforeach

            // Store map reference for Livewire updates
            window.cctvMap = map;
        }

        // Function to update map markers based on filter
        function updateMapMarkers(status) {
            // This function can be called from Livewire to update markers
            console.log('Updating map markers for status:', status);
        }
    </script>

    <style>
        .building-marker {
            background: transparent;
            border: none;
        }
        
        .cctv-marker {
            background: transparent;
            border: none;
        }
        
        .leaflet-popup-content {
            margin: 8px;
        }
        
        .leaflet-popup-content h3 {
            margin: 0 0 4px 0;
        }
        
        .leaflet-popup-content p {
            margin: 0 0 2px 0;
        }
    </style>
</div>