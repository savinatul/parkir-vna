@extends('layouts.app')

@section('content')

<div class="p-6 max-w-2xl mx-auto">

    <div class="mb-6">

        <h1 class="text-2xl font-bold text-white">
            Tambah Tarif
        </h1>

        <p class="text-sm text-gray-400 mt-1">
            Tambahkan tarif parkir baru
        </p>

    </div>


    <div class="bg-[#120d20]
                border border-purple-900/30
                rounded-2xl p-6">

        <form action="{{ route('admin.tarif.store') }}"
              method="POST"
              class="space-y-6">

            @csrf


            <div>

               <label class="block text-sm font-medium text-gray-200 mb-2">
                    Jenis Kendaraan
               </label>

                <select
                    id="jenis_kendaraan"
                    name="jenis_kendaraan"
                    required
                    class="w-full rounded-xl border border-purple-900/50
                        bg-[#171027] px-4 py-3 text-gray-200
                        focus:outline-none focus:border-purple-500
                        focus:ring-1 focus:ring-purple-500">

                    <option value="">-- Pilih Jenis Kendaraan --</option>
                    <option value="motor" {{ old('jenis_kendaraan') == 'motor' ? 'selected' : '' }}>
                        Motor
                    </option>
                    <option value="mobil" {{ old('jenis_kendaraan') == 'mobil' ? 'selected' : '' }}>
                        Mobil
                    </option>
                    <option value="truk" {{ old('jenis_kendaraan') == 'truk' ? 'selected' : '' }}>
                        Truk
                    </option>
                    <option value="lainnya" {{ old('jenis_kendaraan') == 'lainnya' ? 'selected' : '' }}>
                        Lainnya
                    </option>

                </select>

                @error('jenis_kendaraan')
                    <p class="text-rose-400 text-xs mt-2">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            <div>

                <label class="block text-sm font-medium text-gray-200 mb-2">
                    Tarif Per Jam
                </label>

                <select
                    id="tarif_perjam"
                    name="tarif_perjam"
                    required
                    class="w-full rounded-xl border border-purple-900/50
                        bg-[#171027] px-4 py-3 text-gray-200
                        focus:outline-none focus:border-purple-500
                        focus:ring-1 focus:ring-purple-500">

                    <option value="">-- Pilih Tarif --</option>

                    <option value="3000" {{ old('tarif_perjam') == '3000' ? 'selected' : '' }}>
                        Rp 3.000 / jam
                    </option>

                    <option value="5000" {{ old('tarif_perjam') == '5000' ? 'selected' : '' }}>
                        Rp 5.000 / jam
                    </option>

                    <option value="10000" {{ old('tarif_perjam') == '10000' ? 'selected' : '' }}>
                        Rp 10.000 / jam
                    </option>

                    <option value="15000" {{ old('tarif_perjam') == '15000' ? 'selected' : '' }}>
                        Rp 15.000 / jam
                    </option>

                </select>

                @error('tarif_perjam')
                    <p class="text-rose-400 text-xs mt-2">
                        {{ $message }}
                    </p>
                @enderror

            </div>


            <div class="flex justify-end gap-3 pt-4">

                <a href="{{ route('admin.tarif.index') }}"
                   class="px-5 py-3 rounded-xl
                          bg-gray-800 text-gray-300
                          text-sm hover:bg-gray-700">
                    Batal
                </a>

                <button type="submit"
                        class="px-5 py-3 rounded-xl
                               bg-gradient-to-r
                               from-purple-600 to-indigo-700
                               text-white text-sm font-semibold
                               hover:brightness-110">
                    Simpan
                </button>

            </div>

        </form>

    </div>

</div>

<script>
    document.getElementById('jenis_kendaraan').addEventListener('change', function () {
        const tarifSelect = document.getElementById('tarif_perjam');
        const hargaOtomatis = {
            'motor': '3000',
            'mobil': '5000',
            'truk': '10000',
            'lainnya': '15000'
        };

        tarifSelect.value = hargaOtomatis[this.value] || '';
    });
</script>

@endsection
