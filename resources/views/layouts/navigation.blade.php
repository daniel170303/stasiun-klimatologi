<nav class="bg-white border-b border-gray-200 shadow-sm">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex justify-between h-16">

            {{-- LEFT: LOGO & MENU --}}
            <div class="flex items-center gap-6">

                {{-- Logo --}}
                <a href="{{ auth()->check() ? (auth()->user()->isAdmin() ? route('admin.dashboard') : route('pengunjung.dashboard')) : route('welcome') }}"
                   class="flex items-center gap-3 group">
                    <img src="{{ asset('images/Logo_BMKG.png') }}"
                         class="h-10 w-10 transition-transform group-hover:scale-105">
                    <div class="hidden md:block">
                        <p class="text-sm font-bold text-gray-900 leading-tight">
                            Stasiun Klimatologi
                        </p>
                        <p class="text-xs text-gray-600">
                            Kelas IV Yogyakarta
                        </p>
                    </div>
                </a>

                {{-- Desktop Menu --}}
                <div class="hidden md:flex space-x-1">
                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}"
                               class="px-3 py-2 rounded-md text-sm font-medium transition
                               {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-100' }}">
                                Dashboard
                            </a>

                            <a href="{{ route('admin.kunjungan.index') }}"
                               class="px-3 py-2 rounded-md text-sm font-medium transition
                               {{ request()->routeIs('admin.kunjungan.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-100' }}">
                                Kunjungan
                            </a>

                            <a href="{{ route('admin.kalender.index') }}"
                               class="px-3 py-2 rounded-md text-sm font-medium transition
                               {{ request()->routeIs('admin.kalender.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-100' }}">
                                Kalender
                            </a>

                            <a href="{{ route('admin.pegawai.index') }}"
                               class="px-3 py-2 rounded-md text-sm font-medium transition
                               {{ request()->routeIs('admin.pegawai.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-100' }}">
                                Pegawai
                            </a>
                        @else
                            <a href="{{ route('pengunjung.dashboard') }}"
                               class="px-3 py-2 rounded-md text-sm font-medium transition
                               {{ request()->routeIs('pengunjung.dashboard') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-100' }}">
                                Dashboard
                            </a>

                            <a href="{{ route('pengunjung.kunjungan.index') }}"
                               class="px-3 py-2 rounded-md text-sm font-medium transition
                               {{ request()->routeIs('pengunjung.kunjungan.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-100' }}">
                                Kunjungan Saya
                            </a>
                        @endif
                    @else
                        {{-- Guest Menu --}}
                        <a href="{{ route('welcome') }}"
                           class="px-3 py-2 rounded-md text-sm font-medium transition
                           {{ request()->routeIs('welcome') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-100' }}">
                            Beranda
                        </a>
                    @endauth
                </div>
            </div>

            {{-- RIGHT: USER DROPDOWN / LOGIN BUTTONS --}}
            <div class="flex items-center gap-3">
                @auth
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open"
                                class="flex items-center gap-2 px-3 py-2 rounded-md hover:bg-gray-100 transition">
                            <div class="h-8 w-8 rounded-full bg-indigo-600 flex items-center justify-center text-white font-semibold">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <span class="hidden md:block text-sm font-medium text-gray-700">
                                {{ Auth::user()->name }}
                            </span>
                            <svg class="h-4 w-4 transition-transform" :class="{ 'rotate-180': open }"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        {{-- Dropdown --}}
                        <div x-show="open" @click.away="open = false"
                             x-transition
                             class="absolute right-0 top-14 w-48 bg-white rounded-md shadow-lg border z-50">

                            <div class="px-4 py-2 border-b">
                                <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-600">{{ Auth::user()->email }}</p>
                            </div>

                            <a href="{{ route('profile.edit') }}"
                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Profile
                            </a>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                        class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    {{-- Guest Buttons --}}
                    <a href="{{ route('login') }}"
                       class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-indigo-600 rounded-md hover:bg-gray-100 transition">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}"
                       class="px-5 py-2 text-sm font-semibold bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg hover:from-indigo-700 hover:to-purple-700 transition shadow-md hover:shadow-lg transform hover:scale-105">
                        Daftar Sekarang
                    </a>
                @endauth
            </div>
        </div>
    </div>

    {{-- MOBILE MENU --}}
    <div class="md:hidden border-t" x-data="{ mobile: false }">
        <button @click="mobile = !mobile"
                class="w-full px-6 py-3 flex justify-between text-sm font-medium text-gray-700">
            Menu
            <svg class="h-5 w-5 transition-transform" :class="{ 'rotate-180': mobile }"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M19 9l-7 7-7-7"/>
            </svg>
        </button>

        <div x-show="mobile" x-transition class="px-4 py-3 bg-gray-50 space-y-1">
            @auth
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}"
                       class="block px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-100' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('admin.kunjungan.index') }}"
                       class="block px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('admin.kunjungan.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-100' }}">
                        Kunjungan
                    </a>
                    <a href="{{ route('admin.kalender.index') }}"
                       class="block px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('admin.kalender.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-100' }}">
                        Kalender
                    </a>
                    <a href="{{ route('admin.pegawai.index') }}"
                       class="block px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('admin.pegawai.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-100' }}">
                        Pegawai
                    </a>
                @else
                    <a href="{{ route('pengunjung.dashboard') }}"
                       class="block px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('pengunjung.dashboard') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-100' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('pengunjung.kunjungan.index') }}"
                       class="block px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('pengunjung.kunjungan.*') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-100' }}">
                        Kunjungan Saya
                    </a>
                @endif
            @else
                <a href="{{ route('welcome') }}"
                   class="block px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('welcome') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-700 hover:bg-gray-100' }}">
                    Beranda
                </a>
                <div class="pt-2 border-t border-gray-200 mt-2 space-y-2">
                    <a href="{{ route('login') }}"
                       class="block px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-100">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}"
                       class="block px-3 py-2 rounded-md text-sm font-medium bg-indigo-600 text-white hover:bg-indigo-700">
                        Daftar Sekarang
                    </a>
                </div>
            @endauth
        </div>
    </div>
</nav>

{{-- Alpine --}}
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>