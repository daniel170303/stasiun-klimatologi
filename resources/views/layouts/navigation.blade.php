<nav class="bg-gradient-to-r from-indigo-600 to-purple-600 border-b border-indigo-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('pengunjung.dashboard') }}" class="text-white font-bold text-xl">
                        Stasiun Klimatologi IV
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('admin.dashboard') ? 'border-white' : 'border-transparent' }} text-sm font-medium leading-5 text-white hover:border-white focus:outline-none transition duration-150 ease-in-out">
                            Dashboard
                        </a>
                        <a href="{{ route('admin.kunjungan.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('admin.kunjungan.*') ? 'border-white' : 'border-transparent' }} text-sm font-medium leading-5 text-white hover:border-white focus:outline-none transition duration-150 ease-in-out">
                            Kunjungan
                        </a>
                        <a href="{{ route('admin.kalender.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('admin.kalender.*') ? 'border-white' : 'border-transparent' }} text-sm font-medium leading-5 text-white hover:border-white focus:outline-none transition duration-150 ease-in-out">
                            Kalender
                        </a>
                        <a href="{{ route('admin.pegawai.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('admin.pegawai.*') ? 'border-white' : 'border-transparent' }} text-sm font-medium leading-5 text-white hover:border-white focus:outline-none transition duration-150 ease-in-out">
                            Pegawai
                        </a>
                    @elseif(auth()->user()->isPengunjung())
                        <a href="{{ route('pengunjung.dashboard') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('pengunjung.dashboard') ? 'border-white' : 'border-transparent' }} text-sm font-medium leading-5 text-white hover:border-white focus:outline-none transition duration-150 ease-in-out">
                            Dashboard
                        </a>
                        <a href="{{ route('pengunjung.kunjungan.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('pengunjung.kunjungan.*') ? 'border-white' : 'border-transparent' }} text-sm font-medium leading-5 text-white hover:border-white focus:outline-none transition duration-150 ease-in-out">
                            Kunjungan Saya
                        </a>
                    @endif
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <div class="ml-3 relative">
                    <button onclick="toggleDropdown()" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-indigo-700 hover:bg-indigo-800 focus:outline-none transition ease-in-out duration-150">
                        <div>{{ Auth::user()->name }}</div>
                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>

                    <div id="dropdown" class="hidden absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 z-50">
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                Log Out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

<script>
    function toggleDropdown() {
        document.getElementById('dropdown').classList.toggle('hidden');
    }

    window.addEventListener('click', function(e) {
        const dropdown = document.getElementById('dropdown');
        if (!e.target.closest('button') && !dropdown.classList.contains('hidden')) {
            dropdown.classList.add('hidden');
        }
    });
</script>