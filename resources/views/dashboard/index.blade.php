@extends('layouts.app')

@section('title', 'Beranda - Peta Capaian PBB-P2')
@section('page-title', 'Halo, Admin')
@section('page-subtitle', 'Selamat datang di Peta Capaian PBB-P2')

@section('content')
<div class="space-y-6">

    <!-- Hero Banner with Karawang Regency Office (Kantor Bupati Karawang) Background -->
    <div class="relative overflow-hidden rounded-2xl shadow-lg border border-blue-900/20 text-white min-h-[175px] md:min-h-[195px] flex items-center p-6 sm:p-8 md:p-9 bg-[#024d9c]">
        <!-- Background Image Gedung Bupati Karawang -->
        <img src="{{ asset('images/banner-beranda-karawang.jpg') }}" 
             alt="Gedung Bupati Kabupaten Karawang" 
             class="absolute inset-0 w-full h-full object-cover object-center pointer-events-none select-none">
        
        <!-- Smooth Blue Gradient Overlay on the left for maximum text contrast and legibility across all screen sizes -->
        <div class="absolute inset-0 bg-gradient-to-r from-[#024388]/95 via-[#024d9c]/80 via-35% md:via-40% to-transparent pointer-events-none"></div>

        <!-- Banner Content -->
        <div class="relative z-10 max-w-xl">
            <span class="inline-flex items-center px-3.5 py-1.5 rounded-full text-xs font-semibold bg-white/20 hover:bg-white/25 backdrop-blur-md text-white border border-white/25 shadow-xs mb-3 transition-colors">
                <i class="fa-solid fa-clock-rotate-left mr-1.5"></i> Data periode: {{ $filterLabel ?? '1 Jan 2026 - 31 Des 2026' }}
            </span>
            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold tracking-tight text-white mb-2 drop-shadow-sm">
                Peta Capaian PBB-P2
            </h1>
            <p class="text-sm sm:text-base text-blue-50 font-medium leading-relaxed drop-shadow-xs">
                Pajak Bumi dan Bangunan Perdesaan dan Perkotaan Kabupaten Karawang
            </p>
        </div>
    </div>

    <!-- Stats & Persentase Capaian Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- 3 Stat Cards in 2 columns -->
        <div class="lg:col-span-2 grid grid-cols-1 sm:grid-cols-3 gap-4">
            <!-- Stat 1: Sisa Tagihan -->
            <div class="bg-white rounded-2xl p-5 border border-slate-200/90 shadow-xs flex flex-col justify-between">
                <div class="flex items-center space-x-3 mb-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg">
                        <i class="fa-solid fa-money-bill-wave"></i>
                    </div>
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Target PBB-P2</span>
                </div>
                <div>
                    <h3 class="text-lg xl:text-xl font-extrabold text-slate-900 leading-tight">Rp{{ number_format($totalTarget, 0, ',', '.') }}</h3>
                    <p class="text-xs text-emerald-600 font-semibold mt-1 flex items-center">
                        <i class="fa-solid fa-arrow-trend-up mr-1"></i> +12,5% <span class="text-slate-400 font-normal ml-1">Dari Periode Lalu</span>
                    </p>
                </div>
            </div>

            <!-- Stat 2: Total Realisasi -->
            <div class="bg-white rounded-2xl p-5 border border-slate-200/90 shadow-xs flex flex-col justify-between">
                <div class="flex items-center space-x-3 mb-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg">
                        <i class="fa-solid fa-wallet"></i>
                    </div>
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Realisasi</span>
                </div>
                <div>
                    <h3 class="text-lg xl:text-xl font-extrabold text-slate-900 leading-tight">Rp{{ number_format($totalRealisasi, 0, ',', '.') }}</h3>
                    <p class="text-xs text-blue-600 font-semibold mt-1 flex items-center">
                        <i class="fa-solid fa-arrow-trend-up mr-1"></i> +8,3% <span class="text-slate-400 font-normal ml-1">Dari Periode Lalu</span>
                    </p>
                </div>
            </div>

            <!-- Stat 3: Sisa Tunggakan -->
            <div class="bg-white rounded-2xl p-5 border border-slate-200/90 shadow-xs flex flex-col justify-between">
                <div class="flex items-center space-x-3 mb-3">
                    <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center text-lg">
                        <i class="fa-solid fa-clock"></i>
                    </div>
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Sisa Tagihan</span>
                </div>
                <div>
                    <h3 class="text-lg xl:text-xl font-extrabold text-slate-900 leading-tight">Rp{{ number_format($sisaTagihan, 0, ',', '.') }}</h3>
                    <p class="text-xs text-rose-600 font-semibold mt-1 flex items-center">
                        <i class="fa-solid fa-arrow-trend-up mr-1"></i> +5,7% <span class="text-slate-400 font-normal ml-1">Dari Periode Lalu</span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Donut Chart: Persentase Capaian -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/90 shadow-xs flex flex-col justify-between">
            <h4 class="text-sm font-bold text-slate-800 mb-2">Persentase Capaian</h4>
            <div class="flex items-center justify-between">
                <div class="w-28 h-28 relative flex items-center justify-center">
                    <canvas id="capaianDonutChart"></canvas>
                    <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                        <span class="text-base font-extrabold text-slate-900">{{ $persenCapaian }}%</span>
                        <span class="text-[9px] text-slate-400 uppercase font-bold">Tercapai</span>
                    </div>
                </div>
                <div class="space-y-1 text-xs flex-1 pl-4">
                    <div class="flex items-center justify-between">
                        <span class="flex items-center text-slate-600"><span class="w-2.5 h-2.5 rounded-full bg-blue-600 mr-2"></span>Infrastruktur</span>
                        <span class="font-bold text-slate-800">42,3%</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="flex items-center text-slate-600"><span class="w-2.5 h-2.5 rounded-full bg-cyan-500 mr-2"></span>Pelayanan Publik</span>
                        <span class="font-bold text-slate-800">28,7%</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="flex items-center text-slate-600"><span class="w-2.5 h-2.5 rounded-full bg-amber-400 mr-2"></span>Pemberdayaan</span>
                        <span class="font-bold text-slate-800">14,2%</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="flex items-center text-slate-600"><span class="w-2.5 h-2.5 rounded-full bg-orange-500 mr-2"></span>Administrasi</span>
                        <span class="font-bold text-slate-800">8,9%</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="flex items-center text-slate-600"><span class="w-2.5 h-2.5 rounded-full bg-purple-500 mr-2"></span>Lainnya</span>
                        <span class="font-bold text-slate-800">3,9%</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Peta Capaian Section & Right Info Column -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Interactive Map Section -->
        <div class="lg:col-span-2 bg-white rounded-2xl p-6 border border-slate-200/90 shadow-xs flex flex-col">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-base font-bold text-slate-900">Peta Capaian PBB-P2</h3>
                <a href="{{ route('peta.index') }}" class="text-xs font-bold text-blue-600 hover:text-blue-700 flex items-center">
                    Buka Peta Penuh <i class="fa-solid fa-arrow-up-right-from-square ml-1.5 text-[10px]"></i>
                </a>
            </div>

            <!-- Leaflet Map Container -->
            <div id="miniMap" class="w-full h-80 rounded-xl overflow-hidden border border-slate-200 z-10"></div>

            <!-- Map Stats & Legend Row -->
            <div class="mt-4 pt-4 border-t border-slate-100 flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="w-full md:w-auto">
                    <p class="text-xs text-slate-400 font-semibold uppercase">Total Realisasi</p>
                    <p class="text-lg font-black text-slate-900">Rp{{ number_format($totalRealisasi, 0, ',', '.') }}</p>
                    <div class="w-48 bg-slate-100 rounded-full h-2 mt-1 overflow-hidden">
                        <div class="bg-blue-600 h-2 rounded-full" style="width: {{ min(100, $persenCapaian) }}%"></div>
                    </div>
                </div>

                <!-- Legend Indicators -->
                <div class="flex flex-wrap items-center gap-3 text-[11px] font-semibold text-slate-600">
                    <span class="flex items-center"><span class="w-2.5 h-2.5 rounded-full bg-emerald-500 mr-1.5"></span>&gt; 80%</span>
                    <span class="flex items-center"><span class="w-2.5 h-2.5 rounded-full bg-yellow-400 mr-1.5"></span>60 - 80%</span>
                    <span class="flex items-center"><span class="w-2.5 h-2.5 rounded-full bg-amber-400 mr-1.5"></span>40 - 60%</span>
                    <span class="flex items-center"><span class="w-2.5 h-2.5 rounded-full bg-orange-400 mr-1.5"></span>20 - 40%</span>
                    <span class="flex items-center"><span class="w-2.5 h-2.5 rounded-full bg-rose-500 mr-1.5"></span>&lt; 20%</span>
                </div>

                <a href="{{ route('peta.index') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold shadow-xs transition-colors whitespace-nowrap">
                    Lihat Detail Peta <i class="fa-solid fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>

        <!-- Right Side: Info Penting & Cek PBB Online -->
        <div class="space-y-6 flex flex-col">
            <!-- Info Penting -->
            <div class="bg-white rounded-2xl p-5 border border-slate-200/90 shadow-xs flex-1">
                <div class="flex items-center space-x-2 mb-4">
                    <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-500 flex items-center justify-center">
                        <i class="fa-solid fa-bullhorn text-sm"></i>
                    </div>
                    <h3 class="text-sm font-bold text-slate-900">Info Penting</h3>
                </div>

                <div class="space-y-3">
                    @foreach($infoPenting as $info)
                    <a href="{{ route('informasi.index') }}" class="flex items-center justify-between p-3 rounded-xl border border-slate-100 hover:border-blue-200 hover:bg-blue-50/50 transition-all group">
                        <div class="flex items-start space-x-3">
                            <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-xs mt-0.5 flex-shrink-0">
                                @if($info->kategori->slug == 'berita')
                                    <i class="fa-regular fa-newspaper"></i>
                                @elseif($info->kategori->slug == 'pengumuman')
                                    <i class="fa-regular fa-bell"></i>
                                @else
                                    <i class="fa-solid fa-file-shield"></i>
                                @endif
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-slate-900 group-hover:text-blue-600 leading-snug line-clamp-1">{{ $info->judul }}</h4>
                                <p class="text-[11px] text-slate-400 mt-0.5">{{ \Carbon\Carbon::parse($info->tanggal_publikasi)->translatedFormat('d M Y') }}</p>
                            </div>
                        </div>
                        <i class="fa-solid fa-chevron-right text-slate-300 group-hover:text-blue-600 text-xs ml-2"></i>
                    </a>
                    @endforeach
                </div>
            </div>

            <!-- Cek PBB Online Promo Card (Matching BERANDA.png) -->
            <div class="bg-gradient-to-br from-blue-50 to-indigo-50/80 rounded-2xl p-5 border border-blue-100 shadow-xs">
                <div class="flex items-center space-x-3 mb-2">
                    <div class="w-9 h-9 rounded-xl bg-blue-600 text-white flex items-center justify-center shadow-xs">
                        <i class="fa-solid fa-receipt"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-extrabold text-slate-900">Cek PBB Online</h4>
                        <p class="text-[11px] text-slate-500">Kini lebih mudah, cepat, dan aman!</p>
                    </div>
                </div>
                <p class="text-xs text-slate-600 mb-4 leading-relaxed">
                    Periksa tagihan dan riwayat pembayaran PBB-P2 dengan mudah menggunakan 18 digit Nomor Objek Pajak (NOP).
                </p>
                <a href="{{ route('cek-pbb.index') }}" class="w-full inline-flex items-center justify-center px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold shadow-xs transition-colors">
                    Akses Sekarang <i class="fa-solid fa-arrow-right ml-1.5"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Table: Realisasi Per Wilayah (Matching BERANDA.png) -->
    <div class="bg-white rounded-2xl p-6 border border-slate-200/90 shadow-xs">
        <div class="flex items-center justify-between mb-5">
            <div>
                <h3 class="text-base font-bold text-slate-900">Realisasi Per Wilayah</h3>
                <p class="text-xs text-slate-400">Peringkat penerimaan PBB-P2 berdasarkan kecamatan di Kabupaten Karawang</p>
            </div>
            <a href="{{ route('realisasi.index') }}" class="text-xs font-bold text-blue-600 hover:text-blue-700 flex items-center">
                Lihat Semua (30 Kecamatan) <i class="fa-solid fa-arrow-right ml-1.5"></i>
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50/80 text-slate-500 font-bold uppercase tracking-wider border-b border-slate-100">
                    <tr>
                        <th class="py-3.5 px-4 w-12">No</th>
                        <th class="py-3.5 px-4">Wilayah</th>
                        <th class="py-3.5 px-4">Target</th>
                        <th class="py-3.5 px-4">Realisasi</th>
                        <th class="py-3.5 px-4 w-60">Capaian</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @foreach($realisasiPerKecamatan->take(6) as $index => $item)
                    <tr class="hover:bg-slate-50/60 transition-colors">
                        <td class="py-3.5 px-4 text-slate-400">{{ $index + 1 }}</td>
                        <td class="py-3.5 px-4 font-bold text-slate-900">
                            <a href="{{ route('peta.kecamatan', $item->id_kecamatan) }}" class="hover:text-blue-600 hover:underline">
                                {{ $item->nama }}
                            </a>
                        </td>
                        <td class="py-3.5 px-4 text-slate-600">Rp{{ number_format($item->target, 0, ',', '.') }}</td>
                        <td class="py-3.5 px-4 font-bold text-slate-900">Rp{{ number_format($item->realisasi, 0, ',', '.') }}</td>
                        <td class="py-3.5 px-4">
                            <div class="flex items-center space-x-3">
                                <span class="font-extrabold w-12 {{ $item->persen >= 100 ? 'text-emerald-600' : ($item->persen >= 70 ? 'text-blue-600' : 'text-amber-600') }}">
                                    {{ $item->persen }}%
                                </span>
                                <div class="flex-1 bg-slate-100 rounded-full h-2.5 overflow-hidden">
                                    <div class="h-2.5 rounded-full {{ $item->persen >= 100 ? 'bg-emerald-500' : ($item->persen >= 70 ? 'bg-blue-600' : ($item->persen >= 50 ? 'bg-amber-500' : 'bg-rose-500')) }}" style="width: {{ min(100, $item->persen) }}%"></div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    // 1. Donut Chart for Capaian
    const ctx = document.getElementById('capaianDonutChart').getContext('2d');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            datasets: [{
                data: [42.3, 28.7, 14.2, 8.9, 3.9],
                backgroundColor: ['#2563eb', '#06b6d4', '#facc15', '#f97316', '#a855f7'],
                borderWidth: 0,
                cutout: '72%'
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

    // 2. Leaflet Mini Map with Google Maps Roadmap Layer
    const miniMap = L.map('miniMap', {
        zoomControl: true,
        scrollWheelZoom: false,
    }).setView([-6.304, 107.307], 10);

    // Google Maps Roadmap tile layer
    const googleRoadmap = L.tileLayer('https://mt1.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
        maxZoom: 19,
        attribution: '&copy; Google Maps'
    }).addTo(miniMap);

    // Load GeoJSON for the 30 kecamatan
    fetch("{{ asset('data/karawang_kecamatan.json') }}")
        .then(res => res.json())
        .then(data => {
            const kecTargetMap = {
                @foreach($realisasiPerKecamatan as $k)
                "{{ $k->nama }}": {
                    target: "{{ number_format($k->target, 0, ',', '.') }}",
                    realisasi: "{{ number_format($k->realisasi, 0, ',', '.') }}",
                    persen: {{ $k->persen }},
                    id: {{ $k->id_kecamatan }}
                },
                @endforeach
            };

            function getColor(persen) {
                if (persen >= 100) return '#10B981';
                if (persen >= 70) return '#EAB308';
                if (persen >= 40) return '#FB923C';
                if (persen >= 20) return '#F97316';
                return '#EF4444';
            }

            L.geoJSON(data, {
                style: function (feature) {
                    const info = kecTargetMap[feature.properties.nama_kecamatan] || { persen: 50 };
                    return {
                        fillColor: getColor(info.persen),
                        weight: 1.5,
                        opacity: 1,
                        color: '#ffffff',
                        fillOpacity: 0.65
                    };
                },
                onEachFeature: function (feature, layer) {
                    const nama = feature.properties.nama_kecamatan;
                    const info = kecTargetMap[nama] || { target: 0, realisasi: 0, persen: 0, id: 1 };

                    layer.bindTooltip(`<strong>${nama}</strong><br>Capaian: ${info.persen}%`, {
                        direction: 'top',
                        sticky: true
                    });

                    layer.on('click', function () {
                        window.location.href = "{{ url('/peta/kecamatan') }}/" + info.id;
                    });
                }
            }).addTo(miniMap);
        })
        .catch(err => console.error("Error loading mini map geojson:", err));
</script>
@endpush

