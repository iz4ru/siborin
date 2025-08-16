<aside id="logo-sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0"
    aria-label="Sidebar">
    <div class="h-full px-3 pb-4 overflow-y-auto bg-white">
        <ul class="space-y-2 font-medium">
            <li>
                <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                    <i class="fa-solid fa-home hover:bg-gray-100 text-md"></i>
                    <span class="ms-3">Dashboard</span>
                </x-nav-link>
            </li>
            <li>
                <x-nav-link href="#" :active="request()->routeIs('/')">
                    <i class="fa-solid fa-image hover:bg-gray-100 text-md"></i>
                    <span class="ms-3">Content</span>
                </x-nav-link>
            </li>
            <li>
                <x-nav-link href="#" :active="request()->routeIs('/')">
                    <i class="fa-solid fa-clock-rotate-left hover:bg-gray-100 text-md"></i>
                    <span class="ms-3">Logs</span>
                </x-nav-link>
            </li>
        </ul>
    </div>
</aside>
