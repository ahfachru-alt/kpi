<div class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-72 lg:flex-col">
    <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-white px-6 pb-4 border-r border-gray-200">
        <!-- Logo -->
        <div class="flex h-16 shrink-0 items-center">
            <img class="h-12 w-auto" src="{{ asset('images/pertamina.png') }}" alt="Pertamina">
            <div class="ml-3">
                <h1 class="text-lg font-semibold text-gray-900">PLATFORM</h1>
                <p class="text-xs text-gray-500">CCTV Monitoring</p>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="flex flex-1 flex-col">
            <ul role="list" class="flex flex-1 flex-col gap-y-7">
                <li>
                    <ul role="list" class="-mx-2 space-y-1">
                        <!-- Dashboard -->
                        <li>
                            <a href="{{ route('admin.dashboard') }}" 
                               class="{{ request()->routeIs('admin.dashboard') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:text-blue-600 hover:bg-blue-50' }} group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
                                <i class="fas fa-chart-line {{ request()->routeIs('admin.dashboard') ? 'text-blue-700' : 'text-gray-400 group-hover:text-blue-600' }} h-6 w-6 shrink-0"></i>
                                DASHBOARD
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- USER Section -->
                <li>
                    <div class="text-xs font-semibold leading-6 text-gray-400 uppercase tracking-wider">USER</div>
                    <ul role="list" class="-mx-2 mt-2 space-y-1">
                        <li>
                            <a href="{{ route('admin.user.list') }}" 
                               class="{{ request()->routeIs('admin.user.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:text-blue-600 hover:bg-blue-50' }} group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
                                <i class="fas fa-users {{ request()->routeIs('admin.user.*') ? 'text-blue-700' : 'text-gray-400 group-hover:text-blue-600' }} h-6 w-6 shrink-0"></i>
                                USER LIST
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.user.create') }}" 
                               class="{{ request()->routeIs('admin.user.create') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:text-blue-600 hover:bg-blue-50' }} group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
                                <i class="fas fa-user-plus {{ request()->routeIs('admin.user.create') ? 'text-blue-700' : 'text-gray-400 group-hover:text-blue-600' }} h-6 w-6 shrink-0"></i>
                                CREATE USER
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- MAPS Section -->
                <li>
                    <div class="text-xs font-semibold leading-6 text-gray-400 uppercase tracking-wider">MAPS</div>
                    <ul role="list" class="-mx-2 mt-2 space-y-1">
                        <li>
                            <a href="{{ route('admin.maps.list') }}" 
                               class="{{ request()->routeIs('admin.maps.list') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:text-blue-600 hover:bg-blue-50' }} group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
                                <i class="fas fa-map-marked-alt {{ request()->routeIs('admin.maps.list') ? 'text-blue-700' : 'text-gray-400 group-hover:text-blue-600' }} h-6 w-6 shrink-0"></i>
                                MAPS LIST
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.maps.create') }}" 
                               class="{{ request()->routeIs('admin.maps.create') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:text-blue-600 hover:bg-blue-50' }} group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
                                <i class="fas fa-plus-circle {{ request()->routeIs('admin.maps.create') ? 'text-blue-700' : 'text-gray-400 group-hover:text-blue-600' }} h-6 w-6 shrink-0"></i>
                                CREATE MAPS
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- LOCATION Section -->
                <li>
                    <div class="text-xs font-semibold leading-6 text-gray-400 uppercase tracking-wider">LOCATION</div>
                    <ul role="list" class="-mx-2 mt-2 space-y-1">
                        <li>
                            <a href="{{ route('admin.location.list') }}" 
                               class="{{ request()->routeIs('admin.location.list') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:text-blue-600 hover:bg-blue-50' }} group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
                                <i class="fas fa-map-pin {{ request()->routeIs('admin.location.list') ? 'text-blue-700' : 'text-gray-400 group-hover:text-blue-600' }} h-6 w-6 shrink-0"></i>
                                LOCATION LIST
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.location.create') }}" 
                               class="{{ request()->routeIs('admin.location.create') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:text-blue-600 hover:bg-blue-50' }} group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
                                <i class="fas fa-plus-circle {{ request()->routeIs('admin.location.create') ? 'text-blue-700' : 'text-gray-400 group-hover:text-blue-600' }} h-6 w-6 shrink-0"></i>
                                CREATE LOCATION
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- CONTACT Section -->
                <li>
                    <div class="text-xs font-semibold leading-6 text-gray-400 uppercase tracking-wider">CONTACT</div>
                    <ul role="list" class="-mx-2 mt-2 space-y-1">
                        <li>
                            <a href="{{ route('admin.contact.list') }}" 
                               class="{{ request()->routeIs('admin.contact.list') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:text-blue-600 hover:bg-blue-50' }} group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
                                <i class="fas fa-address-book {{ request()->routeIs('admin.contact.list') ? 'text-blue-700' : 'text-gray-400 group-hover:text-blue-600' }} h-6 w-6 shrink-0"></i>
                                CONTACT LIST
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.contact.create') }}" 
                               class="{{ request()->routeIs('admin.contact.create') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:text-blue-600 hover:bg-blue-50' }} group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
                                <i class="fas fa-plus-circle {{ request()->routeIs('admin.contact.create') ? 'text-blue-700' : 'text-gray-400 group-hover:text-blue-600' }} h-6 w-6 shrink-0"></i>
                                CREATE CONTACT
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- NOTIFICATION Section -->
                <li>
                    <div class="text-xs font-semibold leading-6 text-gray-400 uppercase tracking-wider">NOTIFICATION</div>
                    <ul role="list" class="-mx-2 mt-2 space-y-1">
                        <li>
                            <a href="{{ route('admin.notification') }}" 
                               class="{{ request()->routeIs('admin.notification*') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:text-blue-600 hover:bg-blue-50' }} group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
                                <i class="fas fa-bell {{ request()->routeIs('admin.notification*') ? 'text-blue-700' : 'text-gray-400 group-hover:text-blue-600' }} h-6 w-6 shrink-0"></i>
                                NOTIFICATION
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- MESSAGE Section -->
                <li>
                    <div class="text-xs font-semibold leading-6 text-gray-400 uppercase tracking-wider">MESSAGE</div>
                    <ul role="list" class="-mx-2 mt-2 space-y-1">
                        <li>
                            <a href="{{ route('admin.message') }}" 
                               class="{{ request()->routeIs('admin.message') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:text-blue-600 hover:bg-blue-50' }} group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
                                <i class="fas fa-envelope {{ request()->routeIs('admin.message') ? 'text-blue-700' : 'text-gray-400 group-hover:text-blue-600' }} h-6 w-6 shrink-0"></i>
                                MESSAGE
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- THEME Section -->
                <li>
                    <div class="text-xs font-semibold leading-6 text-gray-400 uppercase tracking-wider">THEME</div>
                    <ul role="list" class="-mx-2 mt-2 space-y-1">
                        <li>
                            <div class="flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
                                <i class="fas fa-palette text-gray-400 h-6 w-6 shrink-0"></i>
                                <div class="flex space-x-2">
                                    <button onclick="setTheme('light')" class="p-1 rounded {{ localStorage.getItem('theme') === 'light' ? 'bg-blue-100 text-blue-700' : 'text-gray-400 hover:text-blue-600' }}">
                                        <i class="fas fa-sun"></i>
                                    </button>
                                    <button onclick="setTheme('dark')" class="p-1 rounded {{ localStorage.getItem('theme') === 'dark' ? 'bg-blue-100 text-blue-700' : 'text-gray-400 hover:text-blue-600' }}">
                                        <i class="fas fa-moon"></i>
                                    </button>
                                    <button onclick="setTheme('system')" class="p-1 rounded {{ localStorage.getItem('theme') === 'system' ? 'bg-blue-100 text-blue-700' : 'text-gray-400 hover:text-blue-600' }}">
                                        <i class="fas fa-desktop"></i>
                                    </button>
                                </div>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</div>