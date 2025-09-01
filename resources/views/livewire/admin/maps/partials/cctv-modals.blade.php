<!-- Create CCTV Modal -->
@if($showCreateCctvModal)
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
                    <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10">
                        <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left w-full">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Create New CCTV</h3>
                        <div class="mt-4 space-y-4">
                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Building</label>
                                    <select wire:model="cctvForm.building_id" wire:change="onBuildingChange" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                        <option value="">Select Building</option>
                                        @foreach($buildings as $building)
                                            <option value="{{ $building->id }}">{{ $building->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('cctvForm.building_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Room</label>
                                    <select wire:model="cctvForm.room_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" {{ $cctvForm['building_id'] ? '' : 'disabled' }}>
                                        <option value="">Select Room</option>
                                        @foreach($rooms as $room)
                                            <option value="{{ $room->id }}">{{ $room->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('cctvForm.room_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Name</label>
                                <input wire:model="cctvForm.name" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                @error('cctvForm.name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">IP Address</label>
                                    <input wire:model="cctvForm.ip_address" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="192.168.1.100">
                                    @error('cctvForm.ip_address') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Status</label>
                                    <select wire:model="cctvForm.status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                        <option value="online">Online</option>
                                        <option value="offline">Offline</option>
                                        <option value="maintenance">Maintenance</option>
                                    </select>
                                    @error('cctvForm.status') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">RTSP URL</label>
                                    <input wire:model="cctvForm.rtsp_url" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="rtsp://192.168.1.100:554/stream">
                                    @error('cctvForm.rtsp_url') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Stream URL</label>
                                    <input wire:model="cctvForm.stream_url" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="http://localhost:8080/hls/stream.m3u8">
                                    @error('cctvForm.stream_url') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Model</label>
                                    <input wire:model="cctvForm.model" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="HD Camera Pro">
                                    @error('cctvForm.model') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Resolution</label>
                                    <input wire:model="cctvForm.resolution" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="1920x1080">
                                    @error('cctvForm.resolution') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Notes</label>
                                <textarea wire:model="cctvForm.notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"></textarea>
                                @error('cctvForm.notes') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <div class="bg-green-50 p-4 rounded-md">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-green-800">CCTV Placement</h3>
                                        <div class="mt-2 text-sm text-green-700">
                                            <p>The CCTV will be automatically placed on the map based on the building's coordinates.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                    <button wire:click="createCctv" type="button" class="inline-flex w-full justify-center rounded-md bg-green-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-500 sm:ml-3 sm:w-auto">
                        Create CCTV
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
@if($showViewCctvModal)
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
                                    <p class="mt-1 text-xs text-gray-500">Coordinates: {{ $selectedCctv->room->building->lat }}, {{ $selectedCctv->room->building->lng }}</p>
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
                                    <p class="mt-1 text-sm text-gray-900 font-mono">{{ $selectedCctv->stream_url ?: 'N/A' }}</p>
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
                    <button wire:click="openStreamCctvModal({{ $selectedCctv->id ?? 0 }})" type="button" class="inline-flex w-full justify-center rounded-md bg-green-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-500 sm:ml-3 sm:w-auto">
                        View Stream
                    </button>
                    <button wire:click="closeModals" type="button" class="mt-3 inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
@endif

<!-- Stream CCTV Modal -->
@if($showStreamCctvModal)
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