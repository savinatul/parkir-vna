@extends('layouts.app')

@section('content')

<div class="p-6 max-w-2xl mx-auto">

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-white">
            Edit Area Parkir
        </h1>
        <p class="text-sm text-gray-400 mt-1">
            Perbarui informasi zona dan kapasitas slot parkir
        </p>
    </div>

    <div class="bg-[#120d20] border border-purple-900/30 rounded-2xl p-6">

        <form action="{{ route('admin.area-parkir.update', $areaParkir->id_area) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-200 mb-2">
                    Nama Area / Zona
                </label>
                <input type="text"
                       name="nama_area"
                       value="{{ old('nama_area', $areaParkir->nama_area) }}"
                       required
                       class="w-full rounded-xl border border-purple-900/50 bg-[#171027] px-4 py-3 text-gray-200
                              focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500">
                @error('nama_area')
                    <p class="text-rose-400 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-200 mb-2">
                    Peruntukan Kendaraan
                </label>
                <select name="jenis_kendaraan"
                        required
                        class="w-full rounded-xl border border-purple-900/50 bg-[#171027] px-4 py-3 text-gray-200
                               focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500">
                    <option value="">-- Pilih Jenis Kendaraan --</option>
                    <option value="motor" {{ old('jenis_kendaraan', $areaParkir->jenis_kendaraan) == 'motor' ? 'selected' : '' }}>
                        🏍️ Khusus Motor (Area A & B)
                    </option>
                    <option value="mobil" {{ old('jenis_kendaraan', $areaParkir->jenis_kendaraan) == 'mobil' ? 'selected' : '' }}>
                        🚗 Khusus Mobil (Area C & D)
                    </option>
                    <option value="truk" {{ old('jenis_kendaraan', $areaParkir->jenis_kendaraan) == 'truk' ? 'selected' : '' }}>
                        🚛 Khusus Truk (Area E)
                    </option>
                    <option value="lainnya" {{ old('jenis_kendaraan', $areaParkir->jenis_kendaraan) == 'lainnya' ? 'selected' : '' }}>
                        🚙 Lainnya (Area F)
                    </option>
                </select>
                @error('jenis_kendaraan')
                    <p class="text-rose-400 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-200 mb-2">
                    Kapasitas Maksimal (Jumlah Slot)
                </label>
                <input type="number"
                       name="kapasitas"
                       value="{{ old('kapasitas', $areaParkir->kapasitas) }}"
                       min="{{ max(1, (int) $areaParkir->terisi) }}"
                       required
                       class="w-full rounded-xl border border-purple-900/50 bg-[#171027] px-4 py-3 text-gray-200
                              focus:outline-none focus:border-purple-500 focus:ring-1 focus:ring-purple-500">
                <p class="text-xs text-gray-500 mt-1.5">
                    Saat ini terisi <span class="text-gray-300 font-semibold">{{ (int) $areaParkir->terisi }} slot</span>. Kapasitas tidak boleh kurang dari jumlah yang sedang terisi.
                </p>
                @error('kapasitas')
                    <p class="text-rose-400 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end gap-3 pt-4">
                <a href="{{ route('admin.area-parkir.index') }}"
                   class="px-5 py-3 rounded-xl bg-gray-800 text-gray-300 text-sm hover:bg-gray-700 transition">
                    Batal
                </a>

                <button type="submit"
                        class="px-5 py-3 rounded-xl bg-gradient-to-r from-purple-600 to-indigo-700
                               text-white text-sm font-semibold hover:brightness-110 transition">
                    Simpan Perubahan
                </button>
            </div>

        </form>

    </div>

</div>

@endsection
