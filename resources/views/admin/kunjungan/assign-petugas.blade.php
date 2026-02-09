@extends('layouts.app')

@section('title', 'Assign Petugas')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-900">Assign Petugas</h1>
        <a href="{{ route('admin.kunjungan.show', $kunjungan) }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
            Kembali
        </a>
    </div>

    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Informasi Kunjungan</h2>
        <div class="grid grid-cols-2 gap-4 mb-6 p-4 bg-gray-50 rounded-md">
            <div>
                <p class="text-sm text-gray-600">Instansi</p>
                <p class="font-medium">{{ $kunjungan->pengunjung->nama_instansi }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Tanggal Kunjungan</p>
                <p class="font-medium">{{ $kunjungan->tanggal_disetujui->format('d F Y') }}</p>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.kunjungan.proses-assign-petugas', $kunjungan) }}" class="space-y-6" id="assignForm">
            @csrf

            <div>
                <div class="flex justify-between items-center mb-3">
                    <label class="block text-sm font-medium text-gray-700">
                        Pilih Petugas (2-3 orang) <span class="text-red-500">*</span>
                    </label>
                    <span id="selectedCount" class="text-sm text-gray-600">
                        Terpilih: <span class="font-semibold text-indigo-600">0</span> dari 3
                    </span>
                </div>

                <!-- Search Box -->
                <div class="mb-4">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input type="text" 
                               id="searchPegawai" 
                               placeholder="Cari berdasarkan nama, email, atau keahlian..."
                               class="pl-10 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <p class="mt-1 text-xs text-gray-500">
                        Ketik untuk mencari pegawai secara real-time
                    </p>
                </div>

                <!-- Filter & Sort Options -->
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Filter Keahlian</label>
                        <select id="filterKeahlian" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Semua Keahlian</option>
                            @php
                                $keahlianList = $pegawaiList->pluck('keahlian')->filter()->unique()->sort();
                            @endphp
                            @foreach($keahlianList as $keahlian)
                            <option value="{{ $keahlian }}">{{ $keahlian }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Urutkan Berdasarkan</label>
                        <select id="sortBy" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="tugas_asc">Frekuensi Paling Sedikit</option>
                            <option value="tugas_desc">Frekuensi Paling Banyak</option>
                            <option value="nama_asc">Nama A-Z</option>
                            <option value="nama_desc">Nama Z-A</option>
                        </select>
                    </div>
                </div>

                <!-- Pegawai List -->
                <div id="pegawaiContainer" class="space-y-3 max-h-96 overflow-y-auto border rounded-lg p-3 bg-gray-50">
                    @forelse($pegawaiList as $pegawai)
                    <label class="pegawai-item flex items-start p-4 border rounded-lg cursor-pointer hover:bg-white transition bg-white"
                           data-nama="{{ strtolower($pegawai->nama) }}"
                           data-email="{{ strtolower($pegawai->email) }}"
                           data-keahlian="{{ strtolower($pegawai->keahlian ?? '') }}"
                           data-tugas="{{ $pegawai->kunjungans_count ?? 0 }}">
                        <input type="checkbox" 
                               name="pegawai_ids[]" 
                               value="{{ $pegawai->id }}"
                               {{ in_array($pegawai->id, old('pegawai_ids', [])) ? 'checked' : '' }}
                               class="pegawai-checkbox mt-1 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        <div class="ml-3 flex-1">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2">
                                        <p class="font-medium text-gray-900">{{ $pegawai->nama }}</p>
                                        @php
                                            $jumlahTugas = $pegawai->kunjungans_count ?? 0;
                                        @endphp
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $jumlahTugas == 0 ? 'bg-green-100 text-green-800' : ($jumlahTugas <= 3 ? 'bg-blue-100 text-blue-800' : 'bg-orange-100 text-orange-800') }}">
                                            <svg class="h-3 w-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                            </svg>
                                            {{ $jumlahTugas }} tugas
                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-600 mt-1">
                                        <span class="inline-flex items-center">
                                            <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                            </svg>
                                            {{ $pegawai->keahlian ?? 'Tidak ada keahlian' }}
                                        </span>
                                    </p>
                                </div>
                                <div class="text-right text-sm text-gray-500">
                                    <p class="flex items-center justify-end">
                                        <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                        {{ $pegawai->email }}
                                    </p>
                                    <p class="flex items-center justify-end mt-1">
                                        <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                        </svg>
                                        {{ $pegawai->no_hp }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </label>
                    @empty
                    <p class="text-gray-500 text-center py-8">Tidak ada pegawai aktif tersedia</p>
                    @endforelse
                </div>

                <!-- No Results Message -->
                <div id="noResults" class="hidden text-center py-8 text-gray-500">
                    <svg class="h-12 w-12 mx-auto text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="font-medium">Tidak ada pegawai yang sesuai dengan pencarian</p>
                    <p class="text-sm mt-1">Coba gunakan kata kunci lain</p>
                </div>
                
                @error('pegawai_ids')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
                
                <p class="mt-2 text-sm text-gray-500">
                    <span class="inline-flex items-center">
                        <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Pilih minimal 2 dan maksimal 3 petugas untuk kunjungan ini
                    </span>
                </p>

                <!-- Legend Info -->
                <div class="mt-3 p-3 bg-blue-50 border border-blue-200 rounded-md">
                    <p class="text-xs font-medium text-blue-900 mb-2">Keterangan Badge Tugas:</p>
                    <div class="flex flex-wrap gap-3 text-xs">
                        <span class="inline-flex items-center">
                            <span class="w-3 h-3 bg-green-500 rounded-full mr-1"></span>
                            <span class="text-gray-700">Hijau = Belum ada tugas (0)</span>
                        </span>
                        <span class="inline-flex items-center">
                            <span class="w-3 h-3 bg-blue-500 rounded-full mr-1"></span>
                            <span class="text-gray-700">Biru = Sedikit tugas (1-3)</span>
                        </span>
                        <span class="inline-flex items-center">
                            <span class="w-3 h-3 bg-orange-500 rounded-full mr-1"></span>
                            <span class="text-gray-700">Orange = Banyak tugas (>3)</span>
                        </span>
                    </div>
                </div>
            </div>

            @if($pegawaiList->count() >= 2)
            <div class="flex gap-3">
                <button type="submit" id="submitBtn" class="flex-1 px-6 py-3 bg-purple-600 text-white rounded-md hover:bg-purple-700 font-medium disabled:bg-gray-400 disabled:cursor-not-allowed">
                    Tugaskan Petugas
                </button>
                <a href="{{ route('admin.kunjungan.show', $kunjungan) }}" class="px-6 py-3 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 font-medium">
                    Batal
                </a>
            </div>
            @else
            <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-md">
                <p class="text-sm text-yellow-800">
                    Minimal 2 pegawai aktif diperlukan untuk menugaskan petugas. Silakan tambah pegawai terlebih dahulu.
                </p>
            </div>
            @endif
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchPegawai');
    const filterKeahlian = document.getElementById('filterKeahlian');
    const sortBy = document.getElementById('sortBy');
    const pegawaiItems = document.querySelectorAll('.pegawai-item');
    const pegawaiContainer = document.getElementById('pegawaiContainer');
    const noResults = document.getElementById('noResults');
    const checkboxes = document.querySelectorAll('.pegawai-checkbox');
    const selectedCountSpan = document.querySelector('#selectedCount span');
    const submitBtn = document.getElementById('submitBtn');
    const form = document.getElementById('assignForm');

    // Sort Function
    function sortPegawai() {
        const sortValue = sortBy.value;
        const itemsArray = Array.from(pegawaiItems);
        
        itemsArray.sort((a, b) => {
            switch(sortValue) {
                case 'tugas_asc':
                    return parseInt(a.dataset.tugas) - parseInt(b.dataset.tugas);
                case 'tugas_desc':
                    return parseInt(b.dataset.tugas) - parseInt(a.dataset.tugas);
                case 'nama_asc':
                    return a.dataset.nama.localeCompare(b.dataset.nama);
                case 'nama_desc':
                    return b.dataset.nama.localeCompare(a.dataset.nama);
                default:
                    return 0;
            }
        });
        
        // Re-append sorted items
        itemsArray.forEach(item => {
            pegawaiContainer.appendChild(item);
        });
    }

    // Search Function
    function filterPegawai() {
        const searchTerm = searchInput.value.toLowerCase();
        const keahlianFilter = filterKeahlian.value.toLowerCase();
        let visibleCount = 0;

        pegawaiItems.forEach(item => {
            const nama = item.dataset.nama;
            const email = item.dataset.email;
            const keahlian = item.dataset.keahlian;

            const matchSearch = nama.includes(searchTerm) || 
                              email.includes(searchTerm) || 
                              keahlian.includes(searchTerm);
            
            const matchKeahlian = !keahlianFilter || keahlian.includes(keahlianFilter);

            if (matchSearch && matchKeahlian) {
                item.style.display = 'flex';
                visibleCount++;
            } else {
                item.style.display = 'none';
            }
        });

        // Show/hide no results message
        if (visibleCount === 0) {
            pegawaiContainer.style.display = 'none';
            noResults.classList.remove('hidden');
        } else {
            pegawaiContainer.style.display = 'block';
            noResults.classList.add('hidden');
        }
    }

    // Update Selected Count
    function updateSelectedCount() {
        const checkedCount = document.querySelectorAll('.pegawai-checkbox:checked').length;
        selectedCountSpan.textContent = checkedCount;
        
        // Update button state
        if (checkedCount >= 2 && checkedCount <= 3) {
            submitBtn.disabled = false;
            submitBtn.classList.remove('bg-gray-400', 'cursor-not-allowed');
            submitBtn.classList.add('bg-purple-600', 'hover:bg-purple-700');
        } else {
            submitBtn.disabled = true;
            submitBtn.classList.add('bg-gray-400', 'cursor-not-allowed');
            submitBtn.classList.remove('bg-purple-600', 'hover:bg-purple-700');
        }
    }

    // Event Listeners
    searchInput.addEventListener('input', filterPegawai);
    filterKeahlian.addEventListener('change', filterPegawai);
    sortBy.addEventListener('change', sortPegawai);
    
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const checkedCount = document.querySelectorAll('.pegawai-checkbox:checked').length;
            
            // Limit to 3 selections
            if (checkedCount > 3) {
                this.checked = false;
                alert('Maksimal 3 petugas yang dapat dipilih');
            }
            
            updateSelectedCount();
        });
    });

    // Form validation
    form.addEventListener('submit', function(e) {
        const checkedCount = document.querySelectorAll('.pegawai-checkbox:checked').length;
        
        if (checkedCount < 2) {
            e.preventDefault();
            alert('Minimal 2 petugas harus dipilih');
            return false;
        }
        
        if (checkedCount > 3) {
            e.preventDefault();
            alert('Maksimal 3 petugas yang dapat dipilih');
            return false;
        }
    });

    // Initialize
    sortPegawai(); // Sort on page load (default: tugas paling sedikit)
    updateSelectedCount();

    // Keyboard shortcut: Ctrl/Cmd + F to focus search
    document.addEventListener('keydown', function(e) {
        if ((e.ctrlKey || e.metaKey) && e.key === 'f') {
            e.preventDefault();
            searchInput.focus();
        }
    });
});
</script>
@endsection