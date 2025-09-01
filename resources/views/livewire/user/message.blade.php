<div>
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-3xl font-semibold leading-6 text-gray-900">Messages</h1>
                <p class="mt-2 text-sm text-gray-700">
                    Communicate with administrators and support staff
                </p>
            </div>
        </div>

        <div class="mt-8 flex h-96 bg-white rounded-lg shadow-lg overflow-hidden">
            <!-- Sidebar - Conversations List -->
            <div class="w-1/3 border-r border-gray-200 bg-gray-50">
                <div class="p-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Conversations</h3>
                    <div class="mt-2 relative">
                        <input wire:model.live.debounce.300ms="search" type="text" 
                               class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" 
                               placeholder="Search users...">
                    </div>
                </div>
                
                <div class="overflow-y-auto h-full">
                    @if($conversations->count() > 0)
                        <div class="divide-y divide-gray-200">
                            @foreach($conversations as $conversation)
                                <button wire:click="selectUser({{ $conversation['user']->id }})" 
                                        class="w-full p-4 text-left hover:bg-gray-100 focus:outline-none focus:bg-gray-100 {{ $selectedUser && $selectedUser->id === $conversation['user']->id ? 'bg-blue-50 border-r-2 border-blue-500' : '' }}">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                                <span class="text-sm font-semibold text-blue-600">
                                                    {{ strtoupper(substr($conversation['user']->name, 0, 2)) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="ml-3 flex-1 min-w-0">
                                            <div class="flex items-center justify-between">
                                                <p class="text-sm font-medium text-gray-900 truncate">
                                                    {{ $conversation['user']->name }}
                                                </p>
                                                @if($conversation['unread_count'] > 0)
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                        {{ $conversation['unread_count'] }}
                                                    </span>
                                                @endif
                                            </div>
                                            <p class="text-sm text-gray-500 truncate">
                                                {{ $conversation['last_message']->message }}
                                            </p>
                                            <p class="text-xs text-gray-400 mt-1">
                                                {{ $conversation['last_message']->created_at->diffForHumans() }}
                                            </p>
                                        </div>
                                    </div>
                                </button>
                            @endforeach
                        </div>
                    @else
                        <div class="p-4 text-center text-gray-500">
                            <p>No conversations yet</p>
                            <p class="text-sm mt-1">Start a conversation with an administrator</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Main Chat Area -->
            <div class="flex-1 flex flex-col">
                @if($selectedUser)
                    <!-- Chat Header -->
                    <div class="p-4 border-b border-gray-200 bg-white">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                    <span class="text-sm font-semibold text-blue-600">
                                        {{ strtoupper(substr($selectedUser->name, 0, 2)) }}
                                    </span>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-lg font-medium text-gray-900">{{ $selectedUser->name }}</h3>
                                    <p class="text-sm text-gray-500">
                                        @if($selectedUser->isOnline())
                                            <span class="inline-flex items-center">
                                                <span class="w-2 h-2 bg-green-400 rounded-full mr-2"></span>
                                                Online
                                            </span>
                                        @else
                                            <span class="text-gray-400">Offline</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Messages -->
                    <div class="flex-1 overflow-y-auto p-4 space-y-4" id="messages-container">
                        @if($currentConversation && $currentConversation->count() > 0)
                            @foreach($currentConversation as $message)
                                <div class="flex {{ $message->from_id === auth()->id() ? 'justify-end' : 'justify-start' }}">
                                    <div class="max-w-xs lg:max-w-md px-4 py-2 rounded-lg {{ $message->from_id === auth()->id() ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-900' }}">
                                        <div class="flex items-center space-x-2 mb-1">
                                            <span class="text-xs {{ $message->from_id === auth()->id() ? 'text-blue-100' : 'text-gray-500' }}">
                                                {{ $message->sender->name }}
                                            </span>
                                            <span class="text-xs {{ $message->from_id === auth()->id() ? 'text-blue-100' : 'text-gray-500' }}">
                                                {{ $message->created_at->format('g:i A') }}
                                            </span>
                                        </div>
                                        <p class="text-sm">{{ $message->message }}</p>
                                        @if($message->type !== 'text')
                                            <div class="mt-2">
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $message->type_color }}">
                                                    <i class="{{ $message->type_icon }} mr-1"></i>
                                                    {{ ucfirst($message->type) }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center text-gray-500 py-8">
                                <p>No messages yet</p>
                                <p class="text-sm mt-1">Start the conversation!</p>
                            </div>
                        @endif
                    </div>

                    <!-- Message Input -->
                    <div class="p-4 border-t border-gray-200 bg-white">
                        <div class="flex space-x-3">
                            <div class="flex-1">
                                <div class="flex items-center space-x-2">
                                    <select wire:model="messageType" class="text-sm border-gray-300 rounded-md focus:border-blue-500 focus:ring-blue-500">
                                        <option value="text">Text</option>
                                        <option value="question">Question</option>
                                        <option value="request">Request</option>
                                        <option value="feedback">Feedback</option>
                                    </select>
                                    <input wire:model="newMessage" type="text" 
                                           class="flex-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" 
                                           placeholder="Type your message..." 
                                           wire:keydown.enter="sendMessage">
                                </div>
                            </div>
                            <button wire:click="sendMessage" 
                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                @else
                    <!-- No User Selected -->
                    <div class="flex-1 flex items-center justify-center">
                        <div class="text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No conversation selected</h3>
                            <p class="mt-1 text-sm text-gray-500">
                                Select a user from the sidebar to start messaging
                            </p>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Available Users -->
        @if($users->count() > 0)
            <div class="mt-8">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Start New Conversation</h3>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach($users as $user)
                        <div class="bg-white overflow-hidden shadow rounded-lg hover:shadow-lg transition-shadow duration-200">
                            <div class="p-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                            <span class="text-sm font-semibold text-blue-600">
                                                {{ strtoupper(substr($user->name, 0, 2)) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="ml-4 flex-1">
                                        <h4 class="text-sm font-medium text-gray-900">{{ $user->name }}</h4>
                                        <p class="text-sm text-gray-500">{{ $user->email }}</p>
                                        <div class="mt-2">
                                            @if($user->isOnline())
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    <span class="w-2 h-2 bg-green-400 rounded-full mr-1"></span>
                                                    Online
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                    Offline
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <button wire:click="selectUser({{ $user->id }})" 
                                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                            Message
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <script>
        // Auto-scroll to bottom of messages
        document.addEventListener('livewire:updated', function() {
            const container = document.getElementById('messages-container');
            if (container) {
                container.scrollTop = container.scrollHeight;
            }
        });
    </script>
</div>