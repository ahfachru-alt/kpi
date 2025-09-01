<div>
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-3xl font-semibold leading-6 text-gray-900">Notifications</h1>
                <p class="mt-2 text-sm text-gray-700">
                    View and manage your system notifications
                </p>
            </div>
            <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                <button wire:click="markAllAsRead" 
                        class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 sm:w-auto">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Mark All Read
                </button>
            </div>
        </div>

        <!-- Filters -->
        <div class="mt-8 grid grid-cols-1 gap-4 sm:grid-cols-3">
            <!-- Type Filter -->
            <div>
                <label for="type-filter" class="block text-sm font-medium text-gray-700">Type</label>
                <select wire:model.live="typeFilter" id="type-filter" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    <option value="">All Types</option>
                    <option value="info">Info</option>
                    <option value="success">Success</option>
                    <option value="warning">Warning</option>
                    <option value="error">Error</option>
                    <option value="maintenance">Maintenance</option>
                    <option value="security">Security</option>
                </select>
            </div>

            <!-- Status Filter -->
            <div>
                <label for="status-filter" class="block text-sm font-medium text-gray-700">Status</label>
                <select wire:model.live="statusFilter" id="status-filter" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    <option value="">All Status</option>
                    <option value="unread">Unread</option>
                    <option value="read">Read</option>
                </select>
            </div>

            <!-- Search -->
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
                <div class="mt-1 relative">
                    <input wire:model.live.debounce.300ms="search" type="text" id="search" 
                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" 
                           placeholder="Search notifications...">
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notifications List -->
        <div class="mt-8">
            @if($notifications->count() > 0)
                <div class="space-y-4">
                    @foreach($notifications as $notification)
                        <div class="bg-white shadow rounded-lg p-6 hover:shadow-md transition-shadow duration-200 {{ $notification->is_read ? 'opacity-75' : 'border-l-4 border-l-blue-500' }}">
                            <div class="flex items-start justify-between">
                                <div class="flex items-start space-x-4 flex-1">
                                    <!-- Notification Icon -->
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 rounded-full {{ $notification->color }} flex items-center justify-center">
                                            <i class="{{ $notification->icon }} text-white text-lg"></i>
                                        </div>
                                    </div>
                                    
                                    <!-- Notification Content -->
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center space-x-2 mb-2">
                                            <h3 class="text-lg font-medium text-gray-900">{{ $notification->title }}</h3>
                                            @if(!$notification->is_read)
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    New
                                                </span>
                                            @endif
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $notification->type_color }}">
                                                {{ ucfirst($notification->type) }}
                                            </span>
                                        </div>
                                        
                                        <p class="text-sm text-gray-600 mb-3">{{ $notification->body }}</p>
                                        
                                        <!-- Additional Data -->
                                        @if($notification->data && is_array($notification->data) && count($notification->data) > 0)
                                            <div class="bg-gray-50 rounded-md p-3 mb-3">
                                                <h4 class="text-xs font-medium text-gray-700 mb-2">Additional Information:</h4>
                                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs">
                                                    @foreach($notification->data as $key => $value)
                                                        <div class="flex justify-between">
                                                            <span class="font-medium text-gray-600">{{ ucfirst(str_replace('_', ' ', $key)) }}:</span>
                                                            <span class="text-gray-800">{{ is_array($value) ? json_encode($value) : $value }}</span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                        
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center space-x-4 text-sm text-gray-500">
                                                <span>{{ $notification->created_at->format('M d, Y g:i A') }}</span>
                                                @if($notification->created_at->diffInHours(now()) < 24)
                                                    <span class="text-blue-600">{{ $notification->created_at->diffForHumans() }}</span>
                                                @endif
                                            </div>
                                            
                                            <div class="flex items-center space-x-2">
                                                @if($notification->is_read)
                                                    <button wire:click="markAsUnread({{ $notification->id }})" 
                                                            class="text-yellow-600 hover:text-yellow-800 text-sm font-medium">
                                                        Mark Unread
                                                    </button>
                                                @else
                                                    <button wire:click="markAsRead({{ $notification->id }})" 
                                                            class="text-green-600 hover:text-green-800 text-sm font-medium">
                                                        Mark Read
                                                    </button>
                                                @endif
                                                
                                                <a href="{{ route('user.notification.show', ['notification' => $notification->id]) }}" 
                                                   class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                                    View Details
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $notifications->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No notifications found</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        You're all caught up! No new notifications at the moment.
                    </p>
                </div>
            @endif
        </div>

        <!-- Quick Actions -->
        @if($notifications->count() > 0)
            <div class="mt-8 bg-gray-50 rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Actions</h3>
                <div class="flex flex-wrap gap-3">
                    <button wire:click="markAllAsRead" 
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Mark All as Read
                    </button>
                    
                    <button wire:click="clearAllRead" 
                            class="inline-flex items-center px-3 py-2 border border-gray-300 text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Clear Read Notifications
                    </button>
                    
                    <button wire:click="exportNotifications" 
                            class="inline-flex items-center px-3 py-2 border border-gray-300 text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Export to Excel
                    </button>
                </div>
            </div>
        @endif
    </div>
</div>