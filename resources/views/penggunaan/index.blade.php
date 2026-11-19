@extends('layouts.app')

@section('title', 'Penggunaan Pajak - BAPENDA Karawang')
@section('page-title', 'Penggunaan Pajak')
@section('page-subtitle', 'Realisasi penggunaan dana dari penerimaan PBB-P2 Kabupaten Karawang.')

@section('content')
<div class="space-y-6">

    <!-- 3 Stat Cards (Matching Penggunaan Pajak -- DONE.png) -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <!-- Total Penerimaan -->
        <div class="bg-white rounded-2xl p-6 border border-slate-200/90 shadow-xs flex items-center space-x-4">
            <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-2xl flex-shrink-0">
                <i class="fa-solid fa-wallet"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Penerimaan</p>
                <h3 class="text-xl xl:text-2xl font-black text-slate-900 mt-1">Rp{{ number_format($totalPenerimaan, 0, ',', '.') }}</h3>
            </div>
        </div>

        <!-- Total Penggunaan -->
        <div class="bg-white rounded-2xl p-6 border border-slate-200/90 shadow-xs flex items-center space-x-4">
            <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-2xl flex-shrink-0">
                <i class="fa-solid fa-money-bill-transfer"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Penggunaan</p>
                <h3 class="text-xl xl:text-2xl font-black text-emerald-600 mt-1">Rp{{ number_format($totalPenggunaan, 0, ',', '.') }}</h3>
            </div>
        </div>

        <!-- Sisa Dana -->
        <div class="bg-white rounded-2xl p-6 border border-slate-200/90 shadow-xs flex items-center space-x-4">
            <div class="w-14 h-14 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center text-2xl flex-shrink-0">
                <i class="fa-solid fa-clock-rotate-left"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Sisa Dana</p>
                <h3 class="text-xl xl:text-2xl font-black text-rose-600 mt-1">Rp{{ number_format($sisaDana, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>

    <!-- Middle Row: Donut Chart & Rincian Penggunaan Table -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <!-- Donut Chart (Col 5) -->
        <div class="lg:col-span-5 bg-white rounded-2xl p-6 border border-slate-200/90 shadow-xs flex flex-col justify-between">
            <h4 class="text-base font-bold text-slate-900 mb-4">Realisasi Penggunaan Dana</h4>

            <div class="flex flex-col sm:flex-row items-center justify-between gap-6 my-auto">
                <div class="w-44 h-44 relative flex items-center justify-center flex-shrink-0">
                    <canvas id="penggunaanDonutChart"></canvas>
                    <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                        <span class="text-2xl font-black text-slate-900">{{ $persenTerserap }}%</span>
                        <span class="text-[10px] text-slate-400 uppercase font-extrabold tracking-wider">Terserap</span>
                    </div>
                </div>

                <div class="space-y-2 text-xs w-full">
                    <div class="flex items-center justify-between">
                        <span class="flex items-center text-slate-600"><span class="w-3 h-3 rounded-full bg-blue-600 mr-2 flex-shrink-0"></span>Pembangunan Infrastruktur</span>
                        <span class="font-extrabold text-slate-900">42,3 %</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="flex items-center text-slate-600"><span class="w-3 h-3 rounded-full bg-cyan-500 mr-2 flex-shrink-0"></span>Pelayanan Publik</span>
                        <span class="font-extrabold text-slate-900">28,7 %</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="flex items-center text-slate-600"><span class="w-3 h-3 rounded-full bg-yellow-400 mr-2 flex-shrink-0"></span>Pemberdayaan Masyarakat</span>
                        <span class="font-extrabold text-slate-900">14,2 %</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="flex items-center text-slate-600"><span class="w-3 h-3 rounded-full bg-orange-500 mr-2 flex-shrink-0"></span>Administrasi Pemerintah</span>
                        <span class="font-extrabold text-slate-900">8,9 %</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="flex items-center text-slate-600"><span class="w-3 h-3 rounded-full bg-purple-500 mr-2 flex-shrink-0"></span>Lainnya</span>
                        <span class="font-extrabold text-slate-900">3,9 %</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rincian Penggunaan Table (Col 7) -->
        <div class="lg:col-span-7 bg-white rounded-2xl p-6 border border-slate-200/90 shadow-xs flex flex-col justify-between">
            <h4 class="text-base font-bold text-slate-900 mb-4">Rincian Penggunaan</h4>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-blue-50/70 text-slate-600 font-bold uppercase tracking-wider border-b border-blue-100">
                        <tr>
                            <th class="py-3 px-4">Program / Kegiatan</th>
                            <th class="py-3 px-4 text-right">Realisasi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium">
                        @foreach($penggunaan as $idx => $p)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="py-3.5 px-4 flex items-center space-x-2.5">
                                @php
                                    $colors = ['#2563eb', '#06b6d4', '#facc15', '#f97316', '#a855f7'];
                                    $dot = $colors[$idx % count($colors)];
                                @endphp
                                <span class="w-2.5 h-2.5 rounded-full flex-shrink-0" style="background-color: {{ $dot }}"></span>
                                <span class="font-bold text-slate-800">{{ $p->nama_program }}</span>
                            </td>
                            <td class="py-3.5 px-4 text-right font-black text-slate-900">
                                Rp{{ number_format($p->jumlah_realisasi, 0, ',', '.') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Bottom Row: Line Chart & Unduh Laporan -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-stretch">
        <!-- Line Chart: Grafik Penggunaan Dana (Col 8) -->
        <div class="lg:col-span-8 bg-white rounded-2xl p-6 border border-slate-200/90 shadow-xs flex flex-col justify-between">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h4 class="text-base font-bold text-slate-900">Grafik Penggunaan Dana <span class="text-xs font-normal text-slate-400">(12 Bulan Terakhir)</span></h4>
                </div>
                <div class="flex items-center space-x-4 text-xs font-semibold">
                    <span class="flex items-center text-blue-600"><span class="w-2.5 h-2.5 rounded-full bg-blue-600 mr-1.5"></span> Penerimaan</span>
                    <span class="flex items-center text-emerald-600"><span class="w-2.5 h-2.5 rounded-full bg-emerald-600 mr-1.5"></span> Penggunaan</span>
                </div>
            </div>

            <div class="h-64 w-full">
                <canvas id="monthlyTrendChart"></canvas>
            </div>
        </div>

        <!-- Unduh Laporan Card (Col 4) -->
        <div class="lg:col-span-4 bg-white rounded-2xl p-6 border border-slate-200/90 shadow-xs flex flex-col justify-between">
            <div class="space-y-4">
                <div class="flex items-start justify-between">
                    <div>
                        <h4 class="text-base font-bold text-slate-900">Unduh Laporan</h4>
                        <p class="text-xs text-slate-500 mt-2 leading-relaxed">
                            Lihat laporan detail pengguna dana PBB-P2 dalam format PDF resmi untuk kebutuhan pelaporan dan arsip daerah.
                        </p>
                    </div>
                    <div class="w-16 h-16 rounded-2xl bg-blue-50 text-blue-500 flex items-center justify-center text-3xl flex-shrink-0">
                        <i class="fa-solid fa-file-invoice"></i>
                    </div>
                </div>

                <div class="bg-slate-50 rounded-xl p-3 border border-slate-100 text-xs text-slate-600 space-y-1">
                    <div class="flex justify-between"><span>Format Dokumen:</span> <span class="font-bold">PDF / Cetak</span></div>
                    <div class="flex justify-between"><span>Tahun Anggaran:</span> <span class="font-bold">2026</span></div>
                    <div class="flex justify-between"><span>Status Audit:</span> <span class="font-bold text-emerald-600">Terverifikasi</span></div>
                </div>
            </div>

            <a href="{{ route('penggunaan.download') }}" target="_blank" class="w-full inline-flex items-center justify-center space-x-2 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold shadow-md transition-colors mt-4">
                <i class="fa-solid fa-download"></i>
                <span>Download Laporan</span>
            </a>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    // 1. Donut Chart
    const ctxDonut = document.getElementById('penggunaanDonutChart').getContext('2d');
    new Chart(ctxDonut, {
        type: 'doughnut',
        data: {
            datasets: [{
                data: [42.3, 28.7, 14.2, 8.9, 3.9],
                backgroundColor: ['#2563eb', '#06b6d4', '#facc15', '#f97316', '#a855f7'],
                borderWidth: 0,
                cutout: '74%'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                tooltip: { enabled: true },
                legend: { display: false }
            }
        }
    });

    // 2. Line Chart: 12 Bulan Terakhir (Matching Penggunaan Pajak -- DONE.png)
    const ctxLine = document.getElementById('monthlyTrendChart').getContext('2d');
    new Chart(ctxLine, {
        type: 'line',
        data: {
            labels: @json($monthlyLabels),
            datasets: [
                {
                    label: 'Penerimaan',
                    data: @json($monthlyPenerimaan),
                    borderColor: '#2563eb',
                    backgroundColor: 'rgba(37, 99, 235, 0.05)',
                    tension: 0.35,
                    fill: false,
                    pointRadius: 3,
                    pointHoverRadius: 6,
                },
                {
                    label: 'Penggunaan',
                    data: @json($monthlyPenggunaan),
                    borderColor: '#10b981',
                    backgroundColor: 'rgba(16, 185, 129, 0.05)',
                    tension: 0.35,
                    fill: false,
                    pointRadius: 3,
                    pointHoverRadius: 6,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(val) {
                            return 'Rp' + val + ' M';
                        }
                    },
                    grid: { color: '#f1f5f9' }
                },
                x: {
                    grid: { display: false }
                }
            },
            plugins: {
                legend: { display: false }
            }
        }
    });
</script>
@endpush

