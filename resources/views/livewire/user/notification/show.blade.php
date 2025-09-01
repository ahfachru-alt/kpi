<div>
    <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <nav class="flex" aria-label="Breadcrumb">
                        <ol class="flex items-center space-x-4">
                            <li>
                                <div>
                                    <a href="{{ route('user.notification.index') }}" class="text-gray-400 hover:text-gray-500">
                                        <svg class="h-5 w-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                                        </svg>
                                        <span class="sr-only">Back to Notifications</span>
                                    </a>
                                </div>
                            </li>
                            <li>
                                <div class="flex items-center">
                                    <svg class="h-5 w-5 flex-shrink-0 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                    </svg>
                                    <a href="{{ route('user.notification.index') }}" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">
                                        Notifications
                                    </a>
                                </div>
                            </li>
                            <li>
                                <div class="flex items-center">
                                    <svg class="h-5 w-5 flex-shrink-0 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                    </svg>
                                    <span class="ml-4 text-sm font-medium text-gray-500">View</span>
                                </div>
                            </li>
                        </ol>
                    </nav>
                    <h1 class="text-3xl font-semibold leading-6 text-gray-900 mt-4">{{ $notification->title }}</h1>
                </div>
                <div class="flex items-center space-x-3">
                    @if(!$notification->is_read)
                        <button wire:click="markAsRead" 
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Mark as Read
                        </button>
                    @else
                        <button wire:click="markAsUnread" 
                                class="inline-flex items-center px-3 py-2 border border-gray-300 text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Mark as Unread
                        </button>
                    @endif
                </div>
            </div>
        </div>

        <!-- Notification Content -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <!-- Header -->
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 rounded-full {{ $notification->color }} flex items-center justify-center">
                            <i class="{{ $notification->icon }} text-white text-xl"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-semibold text-gray-900">{{ $notification->title }}</h2>
                            <div class="flex items-center space-x-2 mt-1">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $notification->type_color }}">
                                    {{ ucfirst($notification->type) }}
                                </span>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $notification->is_read ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $notification->is_read ? 'Read' : 'Unread' }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-sm text-gray-500">
                            {{ $notification->created_at->format('M d, Y') }}
                        </div>
                        <div class="text-sm text-gray-500">
                            {{ $notification->created_at->format('g:i A') }}
                        </div>
                        <div class="text-xs text-gray-400 mt-1">
                            {{ $notification->created_at->diffForHumans() }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Body -->
            <div class="px-6 py-6">
                <div class="prose max-w-none">
                    <p class="text-gray-700 text-lg leading-relaxed">{{ $notification->body }}</p>
                </div>

                <!-- Additional Data -->
                @if($notification->data && is_array($notification->data) && count($notification->data) > 0)
                    <div class="mt-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Additional Information</h3>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                @foreach($notification->data as $key => $value)
                                    <div class="flex justify-between">
                                        <span class="font-medium text-gray-700">{{ ucfirst(str_replace('_', ' ', $key)) }}:</span>
                                        <span class="text-gray-900">
                                            @if(is_array($value))
                                                <pre class="text-sm bg-white p-2 rounded border">{{ json_encode($value, JSON_PRETTY_PRINT) }}</pre>
                                            @elseif(is_bool($value))
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $value ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                    {{ $value ? 'Yes' : 'No' }}
                                                </span>
                                            @else
                                                {{ $value }}
                                            @endif
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Notification Metadata -->
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Notification Details</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <dl class="space-y-3">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Notification ID</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $notification->id }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Type</dt>
                                    <dd class="mt-1">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $notification->type_color }}">
                                            {{ ucfirst($notification->type) }}
                                        </span>
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Status</dt>
                                    <dd class="mt-1">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $notification->is_read ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $notification->is_read ? 'Read' : 'Unread' }}
                                        </span>
                                    </dd>
                                </div>
                            </dl>
                        </div>
                        <div>
                            <dl class="space-y-3">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Created At</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $notification->created_at->format('M d, Y g:i:s A') }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Updated At</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $notification->updated_at->format('M d, Y g:i:s A') }}</dd>
                                </div>
                                @if($notification->is_read)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Read At</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $notification->updated_at->format('M d, Y g:i:s A') }}</dd>
                                    </div>
                                @endif
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        @if(!$notification->is_read)
                            <button wire:click="markAsRead" 
                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Mark as Read
                            </button>
                        @else
                            <button wire:click="markAsUnread" 
                                    class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Mark as Unread
                            </button>
                        @endif
                    </div>
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('user.notification.index') }}" 
                           class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Back to Notifications
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Actions -->
        <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-6">
            <h3 class="text-lg font-medium text-blue-900 mb-4">Quick Actions</h3>
            <div class="flex flex-wrap gap-3">
                @if($notification->type === 'maintenance')
                    <a href="{{ route('user.cctv.index') }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                        View CCTV Status
                    </a>
                @endif
                
                @if($notification->type === 'security')
                    <a href="{{ route('user.contact.index') }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        Contact Security
                    </a>
                @endif
                
                <a href="{{ route('user.message.index') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                    Send Message
                </a>
            </div>
        </div>
    </div>
</div>