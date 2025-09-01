<div>
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-semibold leading-6 text-gray-900">{{ $cctv->name }}</h1>
                    <p class="mt-2 text-sm text-gray-700">
                        {{ $cctv->room->building->name }} - {{ $cctv->room->name }}
                    </p>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $cctv->status === 'online' ? 'bg-green-100 text-green-800' : ($cctv->status === 'maintenance' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                        {{ ucfirst($cctv->status) }}
                    </span>
                    <button wire:click="refreshStream" 
                            class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Refresh
                    </button>
                </div>
            </div>
        </div>

        <!-- CCTV Information -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Stream Container -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="p-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Live Stream</h3>
                    </div>
                    
                    @if($isStreaming && !$streamError)
                        <div class="relative">
                            <video id="cctv-stream" controls class="w-full h-96 bg-black">
                                <source src="{{ $streamUrl }}" type="application/x-mpegURL">
                                Your browser does not support HLS video streaming.
                            </video>
                            
                            <!-- Stream Controls Overlay -->
                            <div class="absolute bottom-4 left-4 right-4 flex items-center justify-between bg-black bg-opacity-50 text-white p-2 rounded">
                                <div class="flex items-center space-x-2">
                                    <span class="inline-block w-2 h-2 bg-green-500 rounded-full"></span>
                                    <span class="text-sm">Live</span>
                                </div>
                                <div class="text-sm">
                                    {{ $cctv->ip_address }}
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center justify-center h-96 bg-gray-100">
                            <div class="text-center">
                                @if($streamError)
                                    <svg class="mx-auto h-12 w-12 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">Stream Unavailable</h3>
                                    <p class="mt-1 text-sm text-gray-500">{{ $streamError }}</p>
                                @else
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">No Stream Available</h3>
                                    <p class="mt-1 text-sm text-gray-500">This CCTV camera is not currently streaming.</p>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- CCTV Details -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="p-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Camera Details</h3>
                    </div>
                    <div class="p-4 space-y-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Name</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $cctv->name }}</dd>
                        </div>
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500">IP Address</dt>
                            <dd class="mt-1 text-sm font-mono text-gray-900">{{ $cctv->ip_address }}</dd>
                        </div>
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Model</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $cctv->model ?: 'N/A' }}</dd>
                        </div>
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Resolution</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $cctv->resolution ?: 'N/A' }}</dd>
                        </div>
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Status</dt>
                            <dd class="mt-1">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $cctv->status === 'online' ? 'bg-green-100 text-green-800' : ($cctv->status === 'maintenance' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                    {{ ucfirst($cctv->status) }}
                                </span>
                            </dd>
                        </div>
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Last Maintenance</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $cctv->last_maintenance ? $cctv->last_maintenance->format('M d, Y') : 'N/A' }}</dd>
                        </div>
                        
                        @if($cctv->notes)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Notes</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $cctv->notes }}</dd>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Location Info -->
                <div class="mt-6 bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="p-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Location</h3>
                    </div>
                    <div class="p-4 space-y-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Building</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $cctv->room->building->name }}</dd>
                        </div>
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Room</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $cctv->room->name }}</dd>
                        </div>
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Floor</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $cctv->room->floor }}</dd>
                        </div>
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Address</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $cctv->room->building->address }}</dd>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="mt-6 bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="p-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Quick Actions</h3>
                    </div>
                    <div class="p-4 space-y-3">
                        <a href="{{ route('user.maps') }}" 
                           class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-1.447-.894L15 4m0 13V4m0 0L9 7"></path>
                            </svg>
                            View on Map
                        </a>
                        
                        <a href="{{ route('user.room.index', ['building' => $cctv->room->building->id, 'room' => $cctv->room->id]) }}" 
                           class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            View Room
                        </a>
                        
                        <a href="{{ route('user.cctv.index') }}" 
                           class="w-full flex items-center justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                            </svg>
                            All CCTVs
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($isStreaming && !$streamError)
        <script>
            document.addEventListener('livewire:init', () => {
                // Initialize HLS.js for video streaming
                if (Hls.isSupported()) {
                    const video = document.getElementById('cctv-stream');
                    const hls = new Hls();
                    hls.loadSource('{{ $streamUrl }}');
                    hls.attachMedia(video);
                    
                    hls.on(Hls.Events.MANIFEST_PARSED, function() {
                        console.log('HLS stream loaded successfully');
                    });
                    
                    hls.on(Hls.Events.ERROR, function(event, data) {
                        console.error('HLS error:', data);
                        if (data.fatal) {
                            switch(data.type) {
                                case Hls.ErrorTypes.NETWORK_ERROR:
                                    console.error('Network error, trying to recover...');
                                    hls.startLoad();
                                    break;
                                case Hls.ErrorTypes.MEDIA_ERROR:
                                    console.error('Media error, trying to recover...');
                                    hls.recoverMediaError();
                                    break;
                                default:
                                    console.error('Fatal error, destroying HLS instance');
                                    hls.destroy();
                                    break;
                            }
                        }
                    });
                } else if (video.canPlayType('application/vnd.apple.mpegurl')) {
                    // For Safari which has native HLS support
                    video.src = '{{ $streamUrl }}';
                    video.addEventListener('loadedmetadata', function() {
                        console.log('Native HLS stream loaded successfully');
                    });
                }
            });
        </script>
    @endif
</div>