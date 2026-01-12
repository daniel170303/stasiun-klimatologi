@extends('layouts.app')

@section('title', 'Edit Pegawai')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-900">Edit Pegawai</h1>
        <a href="{{ route('admin.pegawai.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
            Kembali
        </a>
    </div>

    <div class="bg-white shadow rounded-lg p-6">
        <form method="POST" action="{{ route('admin.pegawai.update', $pegawai) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">
                    Nama Lengkap <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="nama" 
                       name="nama" 
                       value="{{ old('nama', $pegawai->nama) }}"
                       required
                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('nama')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                    Email <span class="text-red-500">*</span>
                </label>
                <input type="email" 
                       id="email" 
                       name="email" 
                       value="{{ old('email', $pegawai->email) }}"
                       required
                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="no_hp" class="block text-sm font-medium text-gray-700 mb-2">
                    No. HP <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="no_hp" 
                       name="no_hp" 
                       value="{{ old('no_hp', $pegawai->no_hp) }}"
                       required
                       placeholder="Contoh: 08123456789"
                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('no_hp')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="keahlian" class="block text-sm font-medium text-gray-700 mb-2">
                    Keahlian
                </label>
                <input type="text" 
                       id="keahlian" 
                       name="keahlian" 
                       value="{{ old('keahlian', $pegawai->keahlian) }}"
                       placeholder="Contoh: Klimatologi, Meteorologi"
                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                @error('keahlian')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="status_aktif" class="block text-sm font-medium text-gray-700 mb-2">
                    Status <span class="text-red-500">*</span>
                </label>
                <select id="status_aktif" 
                        name="status_aktif" 
                        required
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="1" {{ old('status_aktif', $pegawai->status_aktif) == 1 ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ old('status_aktif', $pegawai->status_aktif) == 0 ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
                @error('status_aktif')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-3 pt-4">
                <button type="submit" class="flex-1 px-6 py-3 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 font-medium">
                    Update
                </button>
                <a href="{{ route('admin.pegawai.index') }}" class="px-6 py-3 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 font-medium">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection