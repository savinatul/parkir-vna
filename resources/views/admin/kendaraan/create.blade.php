@extends('layouts.app')

@section('title', 'Tambah Kendaraan')
@section('page_title', 'Tambah Kendaraan')
@section('page_subtitle', 'Tambahkan kendaraan baru ke dalam sistem')

@section('content')

<div class="max-w-3xl">

    <div class="glass-card rounded-2xl p-6">

        <form
            action="{{ route('admin.kendaraan.store') }}"
            method="POST"
            class="space-y-5"
        >

            @csrf

            {{-- PLAT --}}
            <div>

                <label class="block text-sm text-gray-300 mb-2">
                    Plat Nomor
                </label>

                <input
                    type="text"
                    name="plat_nomor"
                    value="{{ old('plat_nomor') }}"
                    placeholder="Contoh: KT 1234 AB"
                    class="w-full px-4 py-3 rounded-xl
                           bg-[#171026]
                           border border-purple-900/40
                           text-white
                           focus:outline-none
                           focus:border-purple-500"
                >

                @error('plat_nomor')
                    <p class="text-rose-400 text-xs mt-2">
                        {{ $message }}
                    </p>
                @enderror

            </div>

            {{-- KODE RFID --}}
            <div>
                <label class="block text-sm text-gray-300 mb-2">
                    Kode Kartu RFID <span class="text-xs text-gray-400">(Opsional — klik kolom lalu tempelkan kartu)</span>
                </label>

                <input
                    type="text"
                    name="kode_rfid"
                    value="{{ old('kode_rfid') }}"
                    placeholder="Tempelkan kartu RFID di reader..."
                    autocomplete="off"
                    onkeydown="if(event.key==='Enter'){event.preventDefault();}"
                    class="w-full px-4 py-3 rounded-xl
                           bg-[#171026]
                           border border-purple-900/40
                           text-white
                           focus:outline-none
                           focus:border-purple-500"
                >

                @error('kode_rfid')
                    <p class="text-rose-400 text-xs mt-2">
                        {{ $message }}
                    </p>
                @enderror
            </div>


            {{-- JENIS --}}
            <div>

                <label class="block text-sm text-gray-300 mb-2">
                    Jenis Kendaraan
                </label>

                <select
                    name="jenis_kendaraan"
                    class="w-full px-4 py-3 rounded-xl
                           bg-[#171026]
                           border border-purple-900/40
                           text-white
                           focus:outline-none
                           focus:border-purple-500"
                >

                    <option value="">
                        -- Pilih Jenis --
                    </option>

                    <option value="motor"
                        {{ old('jenis_kendaraan') == 'motor' ? 'selected' : '' }}>
                        Motor
                    </option>

                    <option value="mobil"
                        {{ old('jenis_kendaraan') == 'mobil' ? 'selected' : '' }}>
                        Mobil
                    </option>

                    <option value="truk"
                        {{ old('jenis_kendaraan') == 'truk' ? 'selected' : '' }}>
                       Truk
                    </option>

                    <option value="lainnya"
                        {{ old('jenis_kendaraan') == 'lainnya' ? 'selected' : '' }}>
                        Lainnya
                    </option>

                </select>

                @error('jenis_kendaraan')
                    <p class="text-rose-400 text-xs mt-2">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- WARNA --}}
            <div>

                <label class="block text-sm text-gray-300 mb-2">
                    Warna
                </label>

                <input
                    type="text"
                    name="warna"
                    value="{{ old('warna') }}"
                    placeholder="Contoh: Hitam"
                    class="w-full px-4 py-3 rounded-xl
                           bg-[#171026]
                           border border-purple-900/40
                           text-white"
                >

                @error('warna')
                    <p class="text-rose-400 text-xs mt-2">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- PEMILIK --}}
            <div>

                <label class="block text-sm text-gray-300 mb-2">
                    Nama Pemilik
                </label>

                <input
                    type="text"
                    name="pemilik"
                    value="{{ old('pemilik') }}"
                    placeholder="Nama pemilik kendaraan"
                    class="w-full px-4 py-3 rounded-xl
                           bg-[#171026]
                           border border-purple-900/40
                           text-white"
                >

                @error('pemilik')
                    <p class="text-rose-400 text-xs mt-2">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            {{-- PETUGAS --}}
           <div>
                <label class="block text-sm font-semibold text-purple-200 mb-2">
                    Petugas
                </label>

                <select
                    name="id_user"
                    class="w-full px-4 py-3 rounded-xl
                        bg-[#100b24]
                        border border-purple-800/50
                        text-white
                        focus:outline-none
                        focus:border-purple-500"
                    required
                >
                    <option value="">-- Pilih Petugas --</option>

                    @foreach ($petugas as $p)
                        <option
                            value="{{ $p->id_user }}"
                            {{ old('id_user') == $p->id_user ? 'selected' : '' }}
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


                {{-- BUTTON --}}
                <div class="flex gap-3 pt-3">

                    <a
                        href="{{ route('admin.kendaraan.index') }}"
                        class="px-5 py-3 rounded-xl
                            bg-gray-700/40
                            text-gray-300
                            text-sm"
                    >
                        Kembali
                    </a>

                    <button
                        type="submit"
                        class="px-6 py-3 rounded-xl
                            bg-gradient-to-r
                            from-purple-600
                            to-indigo-600
                            text-white
                            text-sm font-semibold"
                    >
                        Simpan Kendaraan
                    </button>

                </div>

            </form>

        </div>

</div>

@endsection