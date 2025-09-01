<div>
    <div class="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-3xl font-semibold leading-6 text-gray-900">Edit User</h1>
                <p class="mt-2 text-sm text-gray-700">
                    Update user information and settings
                </p>
            </div>
            <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                <a href="{{ route('admin.user.list') }}" 
                   class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 sm:w-auto">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Users
                </a>
            </div>
        </div>

        <form wire:submit.prevent="updateUser" class="mt-8 space-y-6">
            <div class="bg-white shadow sm:rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                        <!-- Name -->
                        <div class="sm:col-span-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                            <div class="mt-1">
                                <input wire:model="name" type="text" id="name" 
                                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" 
                                       placeholder="Enter full name">
                            </div>
                            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Email -->
                        <div class="sm:col-span-4">
                            <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                            <div class="mt-1">
                                <input wire:model="email" type="email" id="email" 
                                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" 
                                       placeholder="Enter email address">
                            </div>
                            @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Password -->
                        <div class="sm:col-span-4">
                            <label for="password" class="block text-sm font-medium text-gray-700">New Password</label>
                            <div class="mt-1">
                                <input wire:model="password" type="password" id="password" 
                                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" 
                                       placeholder="Leave blank to keep current password">
                            </div>
                            <p class="mt-1 text-sm text-gray-500">
                                Leave blank if you don't want to change the password.
                            </p>
                            @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Password Confirmation -->
                        @if($password)
                            <div class="sm:col-span-4">
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                                <div class="mt-1">
                                    <input wire:model="password_confirmation" type="password" id="password_confirmation" 
                                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" 
                                           placeholder="Confirm new password">
                                </div>
                            </div>
                        @endif

                        <!-- Admin Role -->
                        <div class="sm:col-span-4">
                            <div class="flex items-center">
                                <input wire:model="is_admin" type="checkbox" id="is_admin" 
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="is_admin" class="ml-2 block text-sm text-gray-900">
                                    Grant administrator privileges
                                </label>
                            </div>
                            <p class="mt-1 text-sm text-gray-500">
                                Administrators have access to all system features and user management.
                            </p>
                        </div>

                        <!-- Online Status -->
                        <div class="sm:col-span-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Online Status</label>
                                    <p class="mt-1 text-sm text-gray-500">
                                        Current status: 
                                        <span class="font-medium {{ $is_online ? 'text-green-600' : 'text-gray-600' }}">
                                            {{ $is_online ? 'Online' : 'Offline' }}
                                        </span>
                                    </p>
                                </div>
                                <button type="button" wire:click="toggleOnlineStatus" 
                                        class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                    Toggle Status
                                </button>
                            </div>
                        </div>

                        <!-- User Info -->
                        <div class="sm:col-span-4">
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <h4 class="text-sm font-medium text-gray-900 mb-3">User Information</h4>
                                <dl class="grid grid-cols-1 gap-x-4 gap-y-3 sm:grid-cols-2">
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">User ID</dt>
                                        <dd class="mt-1 text-sm text-gray-900 font-mono">{{ $user->id }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Created</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $user->created_at->format('M d, Y') }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Last Seen</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $user->last_seen_at ? $user->last_seen_at->format('M d, Y g:i A') : 'Never' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Email Verified</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $user->email_verified_at ? 'Yes' : 'No' }}</dd>
                                    </div>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.user.list') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Cancel
                </a>
                <button type="submit" 
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Update User
                </button>
            </div>
        </form>
    </div>
</div>