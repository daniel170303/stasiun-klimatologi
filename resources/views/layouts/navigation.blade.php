<nav class="bg-white border-b border-gray-200 shadow-sm">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex justify-between h-16">
            
            {{-- LEFT SIDE: LOGO & BRAND --}}
            <div class="flex items-center gap-4">
                {{-- Logo --}}
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group">
                    <img src="{{ asset('images/Logo_BMKG.png') }}" alt="Logo BMKG" class="h-10 w-10 transition-transform group-hover:scale-105">
                    <div class="hidden md:block">
                        <p class="text-sm font-bold text-gray-900 leading-tight">Stasiun Klimatologi</p>
                        <p class="text-xs text-gray-600">Kelas IV Yogyakarta</p>
                    </div>
                </a>

                {{-- Navigation Links --}}
                <div class="hidden md:flex space-x-1 ml-6">
                    @auth
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" 
                               class="px-3 py-2 rounded-md text-sm font-medium transition {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-100' }}">
                                Dashboard
                            </a>
                            <a href="{{ route('admin.kunjungan.index') }}" 
                               class="px-3 py-2 rounded-md text-sm font-medium transition {{ request()->routeIs('admin.kunjungan.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-100' }}">
                                Kelola Kunjungan
                            </a>
                            <a href="{{ route('admin.pegawai.index') }}" 
                               class="px-3 py-2 rounded-md text-sm font-medium transition {{ request()->routeIs('admin.pegawai.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-100' }}">
                                Kelola Pegawai
                            </a>
                        @elseif(auth()->user()->role === 'pengunjung')
                            <a href="{{ route('pengunjung.dashboard') }}" 
                               class="px-3 py-2 rounded-md text-sm font-medium transition {{ request()->routeIs('pengunjung.dashboard') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-100' }}">
                                Dashboard
                            </a>
                            <a href="{{ route('pengunjung.kunjungan.index') }}" 
                               class="px-3 py-2 rounded-md text-sm font-medium transition {{ request()->routeIs('pengunjung.kunjungan.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-100' }}">
                                Kunjungan Saya
                            </a>
                        @endif
                    @endauth
                </div>
            </div>

            {{-- RIGHT SIDE: USER MENU --}}
            <div class="flex items-center">
                @auth
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" 
                                class="flex items-center gap-2 px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-100 transition">
                            <div class="h-8 w-8 rounded-full bg-indigo-600 flex items-center justify-center text-white font-semibold">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <span class="hidden md:block">{{ auth()->user()->name }}</span>
                            <svg class="h-4 w-4 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        {{-- Dropdown Menu --}}
                        <div x-show="open" 
                             @click.away="open = false"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 border">
                            
                            <div class="px-4 py-2 border-b">
                                <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-600">{{ auth()->user()->email }}</p>
                                <p class="text-xs text-indigo-600 mt-1 capitalize">{{ auth()->user()->role }}</p>
                            </div>

                            @if(auth()->user()->role === 'pengunjung')
                                <a href="{{ route('pengunjung.profile.edit') }}" 
                                   class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <div class="flex items-center gap-2">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                        Profile
                                    </div>
                                </a>
                            @endif

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                    <div class="flex items-center gap-2">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                        </svg>
                                        Logout
                                    </div>
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="flex items-center gap-2">
                        <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-gray-900">
                            Login
                        </a>
                        <a href="{{ route('register') }}" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700 transition">
                            Register
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div class="md:hidden border-t" x-data="{ mobileOpen: false }">
        <button @click="mobileOpen = !mobileOpen" class="w-full px-6 py-3 flex items-center justify-between text-gray-700 hover:bg-gray-50">
            <span class="text-sm font-medium">Menu</span>
            <svg class="h-5 w-5 transition-transform" :class="{ 'rotate-180': mobileOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>

        <div x-show="mobileOpen" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-1"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="px-4 py-3 space-y-1 bg-gray-50">
            @auth
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" 
                       class="block px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-white' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('admin.kunjungan.index') }}" 
                       class="block px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('admin.kunjungan.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-white' }}">
                        Kelola Kunjungan
                    </a>
                    <a href="{{ route('admin.pegawai.index') }}" 
                       class="block px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('admin.pegawai.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-white' }}">
                        Kelola Pegawai
                    </a>
                @elseif(auth()->user()->role === 'pengunjung')
                    <a href="{{ route('pengunjung.dashboard') }}" 
                       class="block px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('pengunjung.dashboard') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-white' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('pengunjung.kunjungan.index') }}" 
                       class="block px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('pengunjung.kunjungan.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-white' }}">
                        Kunjungan Saya
                    </a>
                @endif
            @endauth
        </div>
    </div>
</nav>

{{-- Alpine.js for dropdown functionality --}}
@once
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endonce