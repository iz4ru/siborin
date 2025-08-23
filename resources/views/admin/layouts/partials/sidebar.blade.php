<aside id="logo-sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0"
    aria-label="Sidebar">
    <div class="h-full px-3 pb-4 overflow-y-auto bg-white">
        <ul class="space-y-2 font-medium">
            <!-- Dashboard -->
            <li>
                <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                    <i class="fa-solid fa-home text-md"></i>
                    <span class="ml-3">Dashboard</span>
                </x-nav-link>
            </li>

            <!-- Dropdown Pages -->
            <li>
                <x-nav-link type="button" :active="request()->routeIs(['image.index', 'video.index', 'music.index', 'text.index'])"
                    class="flex cursor-pointer items-center p-2 w-full text-base font-normal text-gray-900 rounded-lg transition duration-75 group hover:bg-gray-100"
                    aria-controls="dropdown-pages" data-collapse-toggle="dropdown-pages">
                    <i class="fa-solid fa-images text-md"></i>
                    <span class="flex-1 ml-3 text-left whitespace-nowrap">Content</span>
                    <i class="fa-solid fa-chevron-down text-md"></i>
                </x-nav-link>
                <ul id="dropdown-pages" class="hidden py-2 space-y-2">
                    <li>
                        <div class="pl-5">
                            <x-nav-link href="{{ route('image.index') }}" :active="request()->routeIs('image.index')">
                                <i class="fa-solid fa-image text-md"></i>
                                <span class="ml-3">Images</span>
                            </x-nav-link>
                        </div>
                    </li>
                    <li>
                        <div class="pl-5">
                            <x-nav-link href="{{ route('video.index') }}" :active="request()->routeIs('video.index')">
                                <i class="fa-solid fa-video text-md"></i>
                                <span class="ml-3">Videos</span>
                            </x-nav-link>
                        </div>
                    </li>
                    <li>
                        <div class="pl-5">
                            <x-nav-link href="{{ route('music.index') }}" :active="request()->routeIs('music.index')">
                                <i class="fa-solid fa-music text-md"></i>
                                <span class="ml-3">Music</span>
                            </x-nav-link>
                        </div>
                    </li>
                    <li>
                        <div class="pl-5">
                            <x-nav-link href="{{ route('text.index') }}" :active="request()->routeIs('text.index')">
                                <i class="fa-solid fa-font text-md"></i>
                                <span class="ml-3">Texts</span>
                            </x-nav-link>
                        </div>
                    </li>
                </ul>
            </li>

            <!-- Logs -->
            <li>
                <x-nav-link href="#" :active="request()->routeIs('logs')">
                    <i class="fa-solid fa-clock-rotate-left text-md"></i>
                    <span class="ml-3">Logs</span>
                </x-nav-link>
            </li>
        </ul>
    </div>
</aside>
