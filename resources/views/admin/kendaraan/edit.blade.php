@extends('layouts.app')

@section('title', 'Edit Kendaraan')

@section('content')

<div class="min-h-screen bg-[#0b0914] p-6 lg:p-8">

    <!-- Header -->
    <div class="mb-8">
        <a href="{{ route('admin.kendaraan.index') }}"
           class="inline-flex items-center gap-2 text-sm text-purple-400 hover:text-purple-300 mb-4">
            ← Kembali ke Data Kendaraan
        </a>

        <h1 class="text-3xl font-bold text-white">
            Edit Kendaraan
        </h1>

        <p class="text-gray-400 mt-1">
            Perbarui informasi kendaraan
        </p>
    </div>

    <!-- Form -->
    <div class="max-w-3xl">

        <div class="bg-[#120d20] border border-purple-900/40 rounded-2xl shadow-xl p-6 lg:p-8">

            @if ($errors->any())
                <div class="mb-6 bg-rose-500/10 border border-rose-500/30
                            text-rose-400 rounded-xl p-4">

                    <p class="font-semibold mb-2">
                        Ada kesalahan:
                    </p>

                    <ul class="list-disc list-inside text-sm space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>

                </div>
            @endif

            <form action="{{ route('admin.kendaraan.update', $kendaraan->id_kendaraan) }}"
                  method="POST"
                  class="space-y-6">

                @csrf
                @method('PUT')

                <!-- Plat Nomor -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        Plat Nomor
                    </label>

                    <input
                        type="text"
                        name="plat_nomor"
                        value="{{ old('plat_nomor', $kendaraan->plat_nomor) }}"
                        placeholder="Contoh: KT 1234 AB"
                        required
                        maxlength="15"
                        class="w-full px-4 py-3 rounded-xl
                               bg-[#171326]
                               border border-purple-900/40
                               text-white
                               placeholder-gray-500
                               focus:outline-none
                               focus:border-purple-500
                               focus:ring-1 focus:ring-purple-500"
                    >

                    @error('plat_nomor')
                        <p class="text-rose-400 text-xs mt-2">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Kode RFID -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        Kode Kartu RFID <span class="text-xs text-gray-400">(Opsional — klik kolom lalu tempelkan kartu)</span>
                    </label>

                    <input
                        type="text"
                        name="kode_rfid"
                        value="{{ old('kode_rfid', $kendaraan->kode_rfid) }}"
                        placeholder="Tempelkan kartu RFID di reader..."
                        autocomplete="off"
                        onkeydown="if(event.key==='Enter'){event.preventDefault();}"
                        class="w-full px-4 py-3 rounded-xl
                               bg-[#171326]
                               border border-purple-900/40
                               text-white
                               placeholder-gray-500
                               focus:outline-none
                               focus:border-purple-500
                               focus:ring-1 focus:ring-purple-500"
                    >

                    @error('kode_rfid')
                        <p class="text-rose-400 text-xs mt-2">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Jenis Kendaraan -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        Jenis Kendaraan
                    </label>

                    <select
                        name="jenis_kendaraan"
                        required
                        class="w-full px-4 py-3 rounded-xl
                               bg-[#171326]
                               border border-purple-900/40
                               text-gray-200
                               focus:outline-none
                               focus:border-purple-500
                               focus:ring-1 focus:ring-purple-500">

                        <option value="motor"
                            {{ old('jenis_kendaraan', $kendaraan->jenis_kendaraan) == 'motor' ? 'selected' : '' }}>
                            Motor
                        </option>

                        <option value="mobil"
                            {{ old('jenis_kendaraan', $kendaraan->jenis_kendaraan) == 'mobil' ? 'selected' : '' }}>
                            Mobil
                        </option>

                        <option value="truk"
                            {{ old('jenis_kendaraan') == 'truk' ? 'selected' : '' }}>
                           Truk
                        </option>

                        <option value="lainnya"
                            {{ old('jenis_kendaraan', $kendaraan->jenis_kendaraan) == 'lainnya' ? 'selected' : '' }}>
                            Lainnya
                        </option>

                    </select>

                    @error('jenis_kendaraan')
                        <p class="text-rose-400 text-xs mt-2">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Warna -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        Warna
                    </label>

                    <input
                        type="text"
                        name="warna"
                        value="{{ old('warna', $kendaraan->warna) }}"
                        placeholder="Contoh: Hitam"
                        required
                        maxlength="20"
                        class="w-full px-4 py-3 rounded-xl
                               bg-[#171326]
                               border border-purple-900/40
                               text-white
                               placeholder-gray-500
                               focus:outline-none
                               focus:border-purple-500
                               focus:ring-1 focus:ring-purple-500"
                    >

                    @error('warna')
                        <p class="text-rose-400 text-xs mt-2">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Pemilik -->
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">
                        Pemilik
                    </label>

                    <input
                        type="text"
                        name="pemilik"
                        value="{{ old('pemilik', $kendaraan->pemilik) }}"
                        placeholder="Nama pemilik kendaraan"
                        required
                        maxlength="100"
                        class="w-full px-4 py-3 rounded-xl
                               bg-[#171326]
                               border border-purple-900/40
                               text-white
                               placeholder-gray-500
                               focus:outline-none
                               focus:border-purple-500
                               focus:ring-1 focus:ring-purple-500"
                    >

                    @error('pemilik')
                        <p class="text-rose-400 text-xs mt-2">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- User -->
               <div>
                    <label class="block text-sm font-semibold text-purple-200 mb-2">
                        Petugas
                    </label>

                    <select
                        name="id_user"
                        class="w-full px-4 py-3 rounded-xl bg-[#100b24]
                            border border-purple-800/50 text-white
                            focus:outline-none focus:border-purple-500"
                        required
                    >
                        <option value="">-- Pilih Petugas --</option>

                        @foreach ($petugas as $p)
                            <option
                                value="{{ $p->id_user }}"
                                {{ old('id_user', $kendaraan->id_user) == $p->id_user ? 'selected' : '' }}
                            >
                                {{ $p->nama_lengkap }}
                            </option>
                        @endforeach
                    </select>

                    @error('id_user')
                        <p class="text-red-400 text-xs mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Tombol -->
                <div class="flex flex-col sm:flex-row gap-3 pt-4">

                    <a href="{{ route('admin.kendaraan.index') }}"
                       class="flex-1 text-center px-5 py-3 rounded-xl
                              bg-gray-800
                              border border-gray-700
                              text-gray-300
                              hover:bg-gray-700
                              transition">
                        Batal
                    </a>

                    <button
                        type="submit"
                        class="flex-1 px-5 py-3 rounded-xl
                               bg-gradient-to-r
                               from-purple-600
                               via-purple-700
                               to-indigo-700
                               text-white
                               font-semibold
                               shadow-lg shadow-purple-950/50
                               hover:brightness-110
                               transition">

                        💾 Simpan Perubahan

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection