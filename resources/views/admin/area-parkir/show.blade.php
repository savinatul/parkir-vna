@extends('layouts.app')

@section('content')

@php
    $kapasitas = (int) $areaParkir->kapasitas;
    $terisi = (int) $areaParkir->terisi;
    $tersedia = max(0, $kapasitas - $terisi);
    $persen = $kapasitas > 0 ? round(($terisi / $kapasitas) * 100) : 0;
    $jenis = $areaParkir->jenis_kendaraan ?? 'mobil';

    $config = match($jenis) {
        'motor'   => ['icon' => '🏍️', 'label' => 'Area Khusus Motor',   'badge' => 'bg-purple-500/15 text-purple-300 border-purple-500/30'],
        'mobil'   => ['icon' => '🚗', 'label' => 'Area Khusus Mobil',   'badge' => 'bg-indigo-500/15 text-indigo-300 border-indigo-500/30'],
        'truk'    => ['icon' => '🚛', 'label' => 'Area Khusus Truk',    'badge' => 'bg-amber-500/15 text-amber-300 border-amber-500/30'],
        default   => ['icon' => '🚙', 'label' => 'Area Kendaraan Lain', 'badge' => 'bg-emerald-500/15 text-emerald-300 border-emerald-500/30'],
    };
@endphp

<div class="p-6 max-w-5xl mx-auto">

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg border text-xs font-semibold mb-2 {{ $config['badge'] }}">
                {{ $config['icon'] }} {{ $config['label'] }}
            </span>
            <h1 class="text-2xl font-bold text-white">
                Detail {{ $areaParkir->nama_area }}
            </h1>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('admin.area-parkir.edit', $areaParkir->id_area) }}"
               class="px-4 py-2.5 rounded-xl bg-purple-500/15 border border-purple-500/30 text-purple-300 text-sm font-medium hover:bg-purple-500/25 transition">
                Edit Area
            </a>
            <a href="{{ route('admin.area-parkir.index') }}"
               class="px-4 py-2.5 rounded-xl bg-gray-800 text-gray-300 text-sm hover:bg-gray-700 transition">
                ← Kembali
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="bg-[#120d20] border border-purple-900/30 rounded-2xl p-5">
            <p class="text-xs text-gray-400">Total Kapasitas</p>
            <p class="text-2xl font-bold text-white mt-1">{{ $kapasitas }} <span class="text-sm font-normal text-gray-400">Slot</span></p>
        </div>

        <div class="bg-[#120d20] border border-rose-500/20 rounded-2xl p-5">
            <p class="text-xs text-gray-400">Slot Terisi</p>
            <p class="text-2xl font-bold text-rose-400 mt-1">{{ $terisi }} <span class="text-sm font-normal text-gray-400">Kendaraan ({{ $persen }}%)</span></p>
        </div>

        <div class="bg-[#120d20] border border-emerald-500/20 rounded-2xl p-5">
            <p class="text-xs text-gray-400">Slot Tersedia (Kosong)</p>
            <p class="text-2xl font-bold text-emerald-400 mt-1">{{ $tersedia }} <span class="text-sm font-normal text-gray-400">Slot</span></p>
        </div>
    </div>

    <div class="bg-[#120d20] border border-purple-900/30 rounded-2xl p-6">

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-5 pb-4 border-b border-purple-900/20">
            <div>
                <h2 class="text-base font-bold text-white">Peta Denah Slot Parkir</h2>
                <p class="text-xs text-gray-400 mt-0.5">Visualisasi seluruh petak parkir pada {{ $areaParkir->nama_area }}</p>
            </div>

            <div class="flex items-center gap-5 text-xs text-gray-300">
                <div class="flex items-center gap-2">
                    <span style="width: 14px; height: 14px; background: rgba(244, 63, 94, 0.25); border: 1px solid #f43f5e; border-radius: 4px; display: inline-block;"></span>
                    <span>Terisi</span>
                </div>
                <div class="flex items-center gap-2">
                    <span style="width: 14px; height: 14px; background: rgba(16, 185, 129, 0.08); border: 1px dashed rgba(16, 185, 129, 0.5); border-radius: 4px; display: inline-block;"></span>
                    <span>Kosong</span>
                </div>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(75px, 1fr)); gap: 10px; max-height: 420px; overflow-y: auto; padding-right: 4px;">
            @for($i = 1; $i <= $kapasitas; $i++)
                @if($i <= $terisi)
                    <div style="height: 64px; background: rgba(244, 63, 94, 0.16); border: 1px solid rgba(244, 63, 94, 0.55); border-radius: 10px; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center;">
                        <span style="font-size: 16px; line-height: 1;">{{ $config['icon'] }}</span>
                        <span style="font-size: 11px; font-weight: 700; color: #fda4af; margin-top: 4px;">Slot #{{ $i }}</span>
                        <span style="font-size: 9px; color: rgba(253, 164, 175, 0.75);">Terisi</span>
                    </div>
                @else
                    <div style="height: 64px; background: rgba(16, 185, 129, 0.05); border: 1.5px dashed rgba(16, 185, 129, 0.35); border-radius: 10px; display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center;">
                        <span style="font-size: 12px; font-weight: 700; color: #34d399;">P-{{ $i }}</span>
                        <span style="font-size: 9px; color: rgba(52, 211, 153, 0.7); margin-top: 2px;">Kosong</span>
                    </div>
                @endif
            @endfor
        </div>

    </div>

</div>

@endsection
