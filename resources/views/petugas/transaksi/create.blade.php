@extends('layouts.app')

@section('page_title', 'Kendaraan Masuk')
@section('page_subtitle', 'Input kendaraan yang masuk area parkir')

@section('content')

<div class="max-w-3xl mx-auto">

    @if(session('error'))
        <div class="mb-5 bg-red-500/20 border border-red-400/30 text-red-300 px-5 py-4 rounded-xl">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-5 bg-red-500/20 border border-red-400/30 text-red-300 px-5 py-4 rounded-xl">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white/5 border border-white/10 rounded-2xl p-7">

        <h2 class="text-xl font-bold text-white mb-6">
            🚗 Kendaraan Masuk
        </h2>

        <form action="{{ route('petugas.transaksi.store') }}"
              method="POST"
              class="space-y-6">

            @csrf

            {{-- Kendaraan --}}
            <div>
                <label class="block text-gray-300 mb-2">
                    Kendaraan
                </label>

                <select
                    name="id_kendaraan"
                    id="id_kendaraan"
                    required
                    class="w-full bg-gray-900 border border-white/10 rounded-xl px-4 py-3 text-white"
                >
                    <option value="">-- Pilih Kendaraan --</option>

                    @foreach ($kendaraan as $k)
                        <option
                            value="{{ $k->id_kendaraan }}"
                            data-jenis="{{ strtolower(trim($k->jenis_kendaraan)) }}"
                            {{ old('id_kendaraan') == $k->id_kendaraan ? 'selected' : '' }}
                        >
                            {{ $k->plat_nomor }} - {{ ucfirst($k->jenis_kendaraan) }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Tarif Parkir --}}
            <div>
                <label class="block text-gray-300 mb-2">
                    Tarif Parkir
                </label>

                <select
                    name="id_tarif"
                    id="id_tarif"
                    required
                    class="w-full bg-gray-900 border border-white/10 rounded-xl px-4 py-3 text-white"
                >
                    <option value="">-- Pilih Tarif --</option>

                    @foreach($tarif as $t)
                        <option
                            value="{{ $t->id_tarif }}"
                            data-jenis="{{ strtolower(trim($t->jenis_kendaraan)) }}"
                            {{ old('id_tarif') == $t->id_tarif ? 'selected' : '' }}
                        >
                            {{ ucfirst($t->jenis_kendaraan) }} - Rp{{ number_format($t->tarif_perjam, 0, ',', '.') }}/jam
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Area Parkir --}}
            <div>
                <label class="block text-gray-300 mb-2">
                    Area Parkir
                </label>

                <select name="id_area"
                        id="id_area"
                        required
                        class="w-full bg-gray-900 border border-white/10 rounded-xl px-4 py-3 text-white">

                    <option value="">-- Pilih Area --</option>

                    @foreach($area as $item)
                        @php
                            $sisa = max(0, (int) $item->kapasitas - (int) $item->terisi);
                            $jenisArea = strtolower(trim($item->jenis_kendaraan ?? 'mobil'));
                        @endphp

                        <option value="{{ $item->id_area }}"
                                data-jenis="{{ $jenisArea }}"
                                {{ $sisa <= 0 ? 'disabled' : '' }}
                                {{ old('id_area') == $item->id_area ? 'selected' : '' }}>
                            {{ $item->nama_area }} ({{ ucfirst($jenisArea) }}) — Terisi {{ $item->terisi }}/{{ $item->kapasitas }} {{ $sisa <= 0 ? '[PENUH]' : '' }}
                        </option>
                    @endforeach

                </select>
                <p id="info-area" class="text-xs text-purple-300 mt-2 hidden"></p>
            </div>

            {{-- Tombol --}}
            <div class="flex justify-end gap-3 pt-4">

                <a href="{{ route('petugas.transaksi.index') }}"
                   class="px-5 py-3 rounded-xl bg-gray-700 hover:bg-gray-600 text-white">
                    Batal
                </a>

                <button type="submit"
                        class="px-5 py-3 rounded-xl bg-purple-600 hover:bg-purple-700 text-white font-semibold">
                    Simpan Kendaraan Masuk
                </button>

            </div>

        </form>

    </div>

</div>

{{-- Tarif & Filter Area Otomatis --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    const kendaraan = document.getElementById('id_kendaraan');
    const tarif = document.getElementById('id_tarif');
    const area = document.getElementById('id_area');
    const infoArea = document.getElementById('info-area');

    function sesuaikanKendaraan() {
        const selected = kendaraan.options[kendaraan.selectedIndex];

        if (!selected || !selected.value) {
            tarif.value = '';
            area.value = '';
            infoArea.classList.add('hidden');
            Array.from(area.options).forEach(opt => opt.hidden = false);
            return;
        }

        const jenisKendaraan = selected.dataset.jenis;

        // 1. Pilih Tarif Otomatis
        for (let i = 0; i < tarif.options.length; i++) {
            const option = tarif.options[i];
            if (option.dataset.jenis === jenisKendaraan) {
                tarif.value = option.value;
                break;
            }
        }

        // 2. Filter Area Parkir Sesuai Jenis Kendaraan
        let areaCocokPertama = '';
        let jumlahAreaCocok = 0;

        Array.from(area.options).forEach(option => {
            if (!option.value) {
                option.hidden = false;
                return;
            }

            if (option.dataset.jenis === jenisKendaraan) {
                option.hidden = false;
                jumlahAreaCocok++;
                if (!areaCocokPertama && !option.disabled) {
                    areaCocokPertama = option.value;
                }
            } else {
                option.hidden = true;
            }
        });

        // Otomatis pilih area pertama yang tersedia & sesuai jenis kendaraan
        area.value = areaCocokPertama;

        infoArea.classList.remove('hidden');
        if (jumlahAreaCocok > 0) {
            infoArea.textContent = 'Menampilkan ' + jumlahAreaCocok + ' area khusus untuk ' + jenisKendaraan + '.';
        } else {
            infoArea.textContent = 'Belum ada area parkir yang tersedia untuk kategori ' + jenisKendaraan + '.';
        }
    }

    kendaraan.addEventListener('change', sesuaikanKendaraan);

    // Jalankan saat halaman dimuat (berguna jika ada old() input saat validasi gagal)
    if (kendaraan.value) {
        sesuaikanKendaraan();
    }

});
</script>

@endsection
