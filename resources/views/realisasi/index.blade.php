@extends('layouts.app')

@section('title', 'Realisasi & Target - BAPENDA Karawang')
@section('page-title', 'Realisasi & Target PBB-P2')
@section('page-subtitle', 'Monitoring perbandingan target penetapan dan realisasi penerimaan PBB-P2 Kabupaten Karawang.')

@section('content')
<div class="space-y-6">

    <!-- Filters & Actions Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-5 rounded-2xl border border-slate-200/90 shadow-xs">
        <form method="GET" action="{{ route('realisasi.index') }}" class="flex flex-wrap items-center gap-3">
            <!-- Year Selector -->
            <div>
                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Tahun Anggaran</label>
                <select name="tahun" onchange="this.form.submit()" class="bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs font-bold text-slate-800 outline-none focus:ring-2 focus:ring-blue-500">
                    @foreach($tahunList as $th)
                        <option value="{{ $th->id_tahun }}" {{ $selectedTahun->id_tahun == $th->id_tahun ? 'selected' : '' }}>
                            Tahun {{ $th->tahun }} ({{ $th->status }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Search Field -->
            <div>
                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Cari Kecamatan</label>
                <div class="relative">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-2.5 text-slate-400 text-xs"></i>
                    <input type="text" name="search" value="{{ $search }}" placeholder="Nama kecamatan..." 
                           class="pl-8 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:ring-2 focus:ring-blue-500 outline-none w-48">
                </div>
            </div>

            <div class="pt-4">
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold shadow-xs transition-colors">
                    Filter Data
                </button>
            </div>
        </form>

        <div class="flex items-center space-x-2 pt-2 sm:pt-0">
            <button onclick="window.print()" class="px-3.5 py-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 rounded-xl text-xs font-bold shadow-xs transition-colors flex items-center space-x-1.5">
                <i class="fa-solid fa-print text-slate-400"></i>
                <span>Cetak Rekap</span>
            </button>
        </div>
    </div>

    <!-- 4 Summary Metric Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-2xl p-5 border border-slate-200/90 shadow-xs">
            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Target Ketetapan</p>
            <h3 class="text-xl font-black text-slate-900 mt-1">Rp{{ number_format($totalTarget, 0, ',', '.') }}</h3>
            <p class="text-xs text-slate-500 mt-1">30 Kecamatan se-Karawang</p>
        </div>
        <div class="bg-white rounded-2xl p-5 border border-slate-200/90 shadow-xs">
            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Penerimaan Realisasi</p>
            <h3 class="text-xl font-black text-emerald-600 mt-1">Rp{{ number_format($totalRealisasi, 0, ',', '.') }}</h3>
            <p class="text-xs text-emerald-600 font-semibold mt-1">Tercapai {{ $capaianRata }}%</p>
        </div>
        <div class="bg-white rounded-2xl p-5 border border-slate-200/90 shadow-xs">
            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Sisa Tagihan / Piutang</p>
            <h3 class="text-xl font-black text-rose-600 mt-1">Rp{{ number_format($totalSisa, 0, ',', '.') }}</h3>
            <p class="text-xs text-rose-600 font-semibold mt-1">{{ round(100 - $capaianRata, 1) }}% Belum Terealisasi</p>
        </div>
        <div class="bg-white rounded-2xl p-5 border border-slate-200/90 shadow-xs">
            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Rata-rata Capaian</p>
            <h3 class="text-xl font-black text-blue-600 mt-1">{{ $capaianRata }}%</h3>
            <div class="w-full bg-slate-100 rounded-full h-2 mt-2 overflow-hidden">
                <div class="bg-blue-600 h-2 rounded-full" style="width: {{ min(100, $capaianRata) }}%"></div>
            </div>
        </div>
    </div>

    <!-- Data Table of 30 Kecamatan -->
    <div class="bg-white rounded-2xl p-6 border border-slate-200/90 shadow-xs">
        <div class="flex items-center justify-between mb-5">
            <div>
                <h3 class="text-base font-bold text-slate-900">Rincian Realisasi & Target per Kecamatan</h3>
                <p class="text-xs text-slate-400">Data Tahun Anggaran {{ $selectedTahun->tahun }}</p>
            </div>
            <span class="text-xs font-bold text-slate-500 bg-slate-100 px-3 py-1 rounded-xl">
                Menampilkan {{ $kecamatans->count() }} Wilayah
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider border-b border-slate-200">
                    <tr>
                        <th class="py-3.5 px-4 w-12">No</th>
                        <th class="py-3.5 px-4">Nama Kecamatan</th>
                        <th class="py-3.5 px-4">Desa/Kel.</th>
                        <th class="py-3.5 px-4">Target PBB-P2</th>
                        <th class="py-3.5 px-4">Realisasi</th>
                        <th class="py-3.5 px-4">Sisa Tagihan</th>
                        <th class="py-3.5 px-4 w-48">Capaian Target</th>
                        <th class="py-3.5 px-4">Status</th>
                        <th class="py-3.5 px-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @forelse($kecamatans as $idx => $k)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="py-3.5 px-4 text-slate-400">{{ $idx + 1 }}</td>
                        <td class="py-3.5 px-4 font-bold text-slate-900">{{ $k->nama }}</td>
                        <td class="py-3.5 px-4 text-slate-600">{{ $k->total_desa }} Desa</td>
                        <td class="py-3.5 px-4 text-slate-700">Rp{{ number_format($k->target, 0, ',', '.') }}</td>
                        <td class="py-3.5 px-4 font-extrabold text-slate-900">Rp{{ number_format($k->realisasi, 0, ',', '.') }}</td>
                        <td class="py-3.5 px-4 text-rose-600 font-semibold">Rp{{ number_format($k->sisa, 0, ',', '.') }}</td>
                        <td class="py-3.5 px-4">
                            <div class="flex items-center space-x-2">
                                <span class="font-extrabold w-12 text-slate-800">{{ $k->persen }}%</span>
                                <div class="flex-1 bg-slate-100 rounded-full h-2 overflow-hidden">
                                    <div class="h-2 rounded-full {{ $k->persen >= 100 ? 'bg-emerald-500' : ($k->persen >= 70 ? 'bg-yellow-400' : ($k->persen >= 30 ? 'bg-orange-400' : 'bg-rose-500')) }}" style="width: {{ min(100, $k->persen) }}%"></div>
                                </div>
                            </div>
                        </td>
                        <td class="py-3.5 px-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold {{ $k->persen >= 100 ? 'bg-emerald-100 text-emerald-800' : ($k->persen >= 70 ? 'bg-yellow-100 text-yellow-800' : 'bg-orange-100 text-orange-800') }}">
                                {{ $k->status }}
                            </span>
                        </td>
                        <td class="py-3.5 px-4 text-center">
                            <a href="{{ route('peta.kecamatan', $k->id_kecamatan) }}" class="inline-flex items-center space-x-1 px-2.5 py-1 bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white rounded-lg text-xs font-bold transition-all">
                                <span>Peta Desa</span>
                                <i class="fa-solid fa-arrow-right text-[10px]"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="py-8 text-center text-slate-400">
                            Tidak ada kecamatan yang sesuai dengan pencarian "{{ $search }}".
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

