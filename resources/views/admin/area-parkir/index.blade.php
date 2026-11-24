@extends('layouts.app')

@section('content')

@php
    $zonaList = [
        'motor'   => ['judul' => '🏍️ Zona Khusus Motor (Area A & B)', 'icon' => '🏍️', 'warna' => '#c084fc'],
        'mobil'   => ['judul' => '🚗 Zona Khusus Mobil (Area C & D)', 'icon' => '🚗', 'warna' => '#818cf8'],
        'truk'    => ['judul' => '🚛 Zona Khusus Truk (Area E)',      'icon' => '🚛', 'warna' => '#fbbf24'],
        'lainnya' => ['judul' => '🚙 Zona Lainnya (Area F)',          'icon' => '🚙', 'warna' => '#34d399'],
    ];
@endphp

<div class="p-6">

    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-white">Area Parkir</h1>
            <p class="text-sm text-gray-400 mt-1">Denah slot terisi dan kosong berdasarkan jenis kendaraan</p>
        </div>

        <div class="flex items-center gap-4">
            {{-- Legenda Warna --}}
            <div class="flex items-center gap-3 bg-[#120d20] border border-purple-900/30 px-4 py-2.5 rounded-xl text-xs text-gray-300">
                <span class="flex items-center gap-1.5">
                    <i style="width:12px;height:12px;background:#e11d48;border-radius:3px;display:inline-block;"></i> Terisi
                </span>
                <span class="flex items-center gap-1.5">
                    <i style="width:12px;height:12px;border:1px dashed #10b981;border-radius:3px;display:inline-block;"></i> Kosong
                </span>
            </div>

            <a href="{{ route('admin.area-parkir.create') }}"
               class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-purple-600 to-indigo-700 text-white text-sm font-semibold">
                + Tambah Area
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-5 px-4 py-3 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- Kelompok per Jenis Kendaraan --}}
    <div class="space-y-8">
        @foreach($zonaList as $jenis => $info)
            @php $items = $areaParkir->where('jenis_kendaraan', $jenis); @endphp

            <div>
                <h2 class="text-base font-bold mb-3 pb-2 border-b border-purple-900/30 flex items-center justify-between"
                    style="color: {{ $info['warna'] }}">
                    <span>{{ $info['judul'] }}</span>
                    <span class="text-xs text-gray-400 font-normal">{{ $items->count() }} Area</span>
                </h2>

                @if($items->isEmpty())
                    <p class="text-xs text-gray-500 italic">Belum ada area pada kelompok ini.</p>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                        @foreach($items as $item)
                            @php
                                $kap  = (int) $item->kapasitas;
                                $isi  = (int) $item->terisi;
                                $sisa = max(0, $kap - $isi);
                            @endphp

                            <div class="bg-[#120d20] border border-purple-900/30 rounded-2xl p-5 flex flex-col justify-between">
                                <div>
                                    {{-- Nama Area & Sisa Slot --}}
                                    <div class="flex items-center justify-between mb-3">
                                        <h3 class="text-lg font-bold text-white">{{ $item->nama_area }}</h3>
                                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $sisa > 0 ? 'bg-emerald-500/15 text-emerald-400' : 'bg-rose-500/15 text-rose-400' }}">
                                            {{ $sisa > 0 ? 'Kosong: ' . $sisa : 'Penuh' }}
                                        </span>
                                    </div>

                                    {{-- Info Angka --}}
                                    <div class="flex justify-between text-xs text-gray-400 mb-2">
                                        <span>Terisi: <b class="text-rose-400">{{ $isi }}</b></span>
                                        <span>Kosong: <b class="text-emerald-400">{{ $sisa }}</b></span>
                                        <span>Total: <b class="text-white">{{ $kap }}</b></span>
                                    </div>

                                    {{-- Kotak Slot Visual (Bisa Di-scroll) --}}
                                    <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(38px, 1fr)); gap:5px; max-height:110px; overflow-y:auto; background:#0b0816; padding:8px; border-radius:10px; border:1px solid rgba(139,92,246,0.15); margin-bottom:14px;">
                                        @for($i = 1; $i <= $kap; $i++)
                                            @if($i <= $isi)
                                                <div title="Slot {{ $i }} Terisi"
                                                     style="height:26px; background:rgba(225,29,72,0.22); border:1px solid #f43f5e; border-radius:5px; display:flex; align-items:center; justify-content:center; font-size:10px; color:#fda4af; font-weight:700;">
                                                    {{ $info['icon'] }}
                                                </div>
                                            @else
                                                <div title="Slot {{ $i }} Kosong"
                                                     style="height:26px; background:rgba(16,185,129,0.06); border:1px dashed rgba(16,185,129,0.4); border-radius:5px; display:flex; align-items:center; justify-content:center; font-size:10px; color:#34d399;">
                                                    {{ $i }}
                                                </div>
                                            @endif
                                        @endfor
                                    </div>
                                </div>

                                {{-- Tombol Aksi --}}
                                <div class="flex justify-end gap-2 pt-2.5 border-t border-purple-900/20">
                                    <a href="{{ route('admin.area-parkir.show', $item->id_area) }}"
                                       class="px-3 py-1.5 rounded-lg bg-indigo-500/10 text-indigo-400 text-xs">Detail</a>
                                    <a href="{{ route('admin.area-parkir.edit', $item->id_area) }}"
                                       class="px-3 py-1.5 rounded-lg bg-purple-500/10 text-purple-400 text-xs">Edit</a>
                                    <form action="{{ route('admin.area-parkir.destroy', $item->id_area) }}" method="POST"
                                          onsubmit="return confirm('Hapus area ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="px-3 py-1.5 rounded-lg bg-rose-500/10 text-rose-400 text-xs">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @endforeach
    </div>

</div>

@endsection
