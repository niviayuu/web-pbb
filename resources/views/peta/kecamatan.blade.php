@extends('layouts.app')

@section('title', 'Kecamatan ' . $kecamatan->nama_kecamatan . ' - Peta Capaian PBB-P2')
@section('page-title', 'Kecamatan ' . $kecamatan->nama_kecamatan)
@section('page-subtitle', 'Detail data per desa/kelurahan pada Kecamatan ' . $kecamatan->nama_kecamatan . '.')

@section('content')
<div class="space-y-6">

    <!-- Back Button & Fast Switcher Row -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <a href="{{ route('peta.index') }}" class="inline-flex items-center space-x-2 text-xs font-bold text-slate-600 hover:text-blue-600 transition-colors">
            <i class="fa-solid fa-arrow-left"></i>
            <span>Kembali ke Peta Kecamatan</span>
        </a>

        <!-- Fast Kecamatan Switcher -->
        <div class="flex items-center space-x-2">
            <label class="text-xs text-slate-500 font-semibold">Pilih Kecamatan:</label>
            <select onchange="window.location.href='{{ url('/peta/kecamatan') }}/' + this.value" class="bg-white border border-slate-200 text-slate-800 text-xs font-bold rounded-xl px-3 py-1.5 focus:ring-2 focus:ring-blue-500 outline-none">
                @foreach($allKecamatan as $ak)
                    <option value="{{ $ak->id_kecamatan }}" {{ $ak->id_kecamatan == $kecamatan->id_kecamatan ? 'selected' : '' }}>
                        {{ $ak->nama_kecamatan }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Title with Large Pin Icon (Matching CILEBAR -- DONE.png) -->
    <div class="flex items-center space-x-3.5">
        <div class="w-12 h-12 rounded-2xl bg-blue-600 text-white flex items-center justify-center text-xl shadow-md">
            <i class="fa-solid fa-location-dot"></i>
        </div>
        <div>
            <h2 class="text-2xl font-black text-slate-900 tracking-tight leading-tight">Kecamatan {{ $kecamatan->nama_kecamatan }}</h2>
            <p class="text-xs text-slate-500 font-medium">Detail data capaian PBB-P2 per desa/kelurahan pada Kecamatan {{ $kecamatan->nama_kecamatan }}.</p>
        </div>
    </div>

    <!-- 5 Stat Cards (Matching CILEBAR -- DONE.png) -->
    <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-5 gap-3.5">
        <!-- 1: Total Target -->
        <div class="bg-white rounded-2xl p-4 border border-slate-200/90 shadow-xs flex items-center space-x-3">
            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg flex-shrink-0">
                <i class="fa-solid fa-bullseye"></i>
            </div>
            <div class="overflow-hidden">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider truncate">Total Target PBB-P2</p>
                <h4 class="text-sm font-extrabold text-slate-900 truncate">Rp{{ number_format($kecTarget, 0, ',', '.') }}</h4>
            </div>
        </div>

        <!-- 2: Total Realisasi -->
        <div class="bg-white rounded-2xl p-4 border border-slate-200/90 shadow-xs flex items-center space-x-3">
            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg flex-shrink-0">
                <i class="fa-solid fa-wallet"></i>
            </div>
            <div class="overflow-hidden">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider truncate">Total Realisasi</p>
                <h4 class="text-sm font-extrabold text-slate-900 truncate">Rp{{ number_format($kecRealisasi, 0, ',', '.') }}</h4>
            </div>
        </div>

        <!-- 3: Sisa Tagihan -->
        <div class="bg-white rounded-2xl p-4 border border-slate-200/90 shadow-xs flex items-center space-x-3">
            <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center text-lg flex-shrink-0">
                <i class="fa-solid fa-clock-rotate-left"></i>
            </div>
            <div class="overflow-hidden">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider truncate">Sisa Tagihan</p>
                <h4 class="text-sm font-extrabold text-slate-900 truncate">Rp{{ number_format($kecSisa, 0, ',', '.') }}</h4>
            </div>
        </div>

        <!-- 4: Capaian Realisasi Ring -->
        <div class="bg-white rounded-2xl p-4 border border-slate-200/90 shadow-xs flex items-center space-x-3">
            <div class="w-10 h-10 rounded-full border-4 border-emerald-500 flex items-center justify-center flex-shrink-0">
                <span class="text-[10px] font-black text-emerald-600">{{ round($kecPersen) }}%</span>
            </div>
            <div class="overflow-hidden">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider truncate">Capaian Realisasi</p>
                <h4 class="text-sm font-extrabold text-slate-900 truncate">{{ $kecPersen }}%</h4>
            </div>
        </div>

        <!-- 5: Jumlah Desa/Kelurahan -->
        <div class="bg-white rounded-2xl p-4 border border-slate-200/90 shadow-xs flex items-center space-x-3">
            <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-lg flex-shrink-0">
                <i class="fa-solid fa-house-user"></i>
            </div>
            <div class="overflow-hidden">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider truncate">Jumlah Desa</p>
                <h4 class="text-sm font-extrabold text-slate-900 truncate">{{ $totalDesa }} Desa</h4>
            </div>
        </div>
    </div>

    <!-- Map of Villages & Table of Villages -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        
        <!-- Left: Leaflet Map of Desa/Kelurahan (Col 7) -->
        <div class="lg:col-span-7 bg-white rounded-2xl p-4 border border-slate-200/90 shadow-xs relative flex flex-col">
            <!-- Map Header & Mode Toggle -->
            <div class="flex items-center justify-between mb-3 px-2">
                <span class="text-xs font-bold text-slate-800 flex items-center">
                    <i class="fa-solid fa-map-pin mr-1.5 text-blue-600"></i> Peta Desa/Kelurahan - Kecamatan {{ $kecamatan->nama_kecamatan }}
                </span>

                <div class="flex items-center space-x-2">
                    <div class="inline-flex p-0.5 rounded-lg bg-slate-100 border border-slate-200 text-xs font-semibold">
                        <button id="btnDesaPeta" onclick="switchDesaLayer('googleRoad')" class="px-2.5 py-1 rounded-md bg-blue-600 text-white shadow-xs transition-colors">
                            Peta
                        </button>
                        <button id="btnDesaSatelit" onclick="switchDesaLayer('googleSat')" class="px-2.5 py-1 rounded-md text-slate-600 hover:text-slate-900 transition-colors">
                            Satelit
                        </button>
                    </div>
                    <button onclick="toggleDesaFullScreen()" title="Fullscreen" class="p-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-xs transition-colors">
                        <i class="fa-solid fa-expand"></i>
                    </button>
                </div>
            </div>

            <!-- Leaflet Map Container -->
            <div id="desaMap" class="w-full h-[450px] rounded-xl overflow-hidden border border-slate-200 relative z-10"></div>
        </div>

        <!-- Right: Daftar Desa/Kelurahan Table (Col 5) -->
        <div class="lg:col-span-5 bg-white rounded-2xl p-4 border border-slate-200/90 shadow-xs flex flex-col h-[525px]">
            <h4 class="text-sm font-bold text-slate-900 mb-2.5">Daftar Desa/Kelurahan - Kecamatan {{ $kecamatan->nama_kecamatan }}</h4>

            <!-- Search Input -->
            <div class="relative mb-3">
                <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3 text-slate-400 text-xs"></i>
                <input type="text" id="searchDesa" placeholder="Cari Desa/Kelurahan..." 
                       class="w-full pl-9 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:ring-2 focus:ring-blue-500 focus:bg-white outline-none transition-all">
            </div>

            <!-- Scrollable Desa Table -->
            <div class="flex-1 overflow-y-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 sticky top-0 z-10 text-slate-500 font-bold uppercase tracking-wider border-b border-slate-100">
                        <tr>
                            <th class="py-2.5 px-3 w-10">No</th>
                            <th class="py-2.5 px-3">Nama Desa/Kelurahan</th>
                            <th class="py-2.5 px-3">Persentase</th>
                            <th class="py-2.5 px-3">Status</th>
                            <th class="py-2.5 px-2 w-8">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium">
                        @foreach($desasList as $index => $d)
                        <tr onclick="selectDesa({{ json_encode($d) }})" 
                            data-nama="{{ strtolower($d->nama) }}"
                            class="desa-row hover:bg-blue-50/60 cursor-pointer transition-colors {{ $d->id_desa == $selectedDesa->id_desa ? 'bg-blue-50/80 font-bold' : '' }}">
                            <td class="py-2.5 px-3 text-slate-400">{{ $index + 1 }}</td>
                            <td class="py-2.5 px-3 text-slate-900 font-semibold">{{ $d->nama }}</td>
                            <td class="py-2.5 px-3 font-bold text-slate-800">{{ $d->persen }}%</td>
                            <td class="py-2.5 px-3">
                                <span class="inline-flex items-center text-[11px] font-semibold text-slate-700">
                                    <span class="w-2 h-2 rounded-full mr-1.5" style="background-color: {{ $d->dotColor }}"></span>
                                    {{ $d->status }}
                                </span>
                            </td>
                            <td class="py-2.5 px-2 text-slate-400">
                                <i class="fa-solid fa-chevron-right text-[10px]"></i>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- Lower Section: Selected Desa Detail Card (Matching CILEBAR -- DONE.png) -->
    <div id="selectedDesaDetail" class="bg-white rounded-2xl p-6 border border-slate-200/90 shadow-xs space-y-6">
        <!-- Top Controls & Desa Title -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between pb-4 border-b border-slate-100 gap-3">
            <div class="flex items-center space-x-3">
                <div class="w-9 h-9 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center text-sm">
                    <i class="fa-solid fa-house-chimney"></i>
                </div>
                <div>
                    <h3 class="text-base font-extrabold text-slate-900">
                        Detail Desa <span id="dtlDesaNama">{{ $selectedDesa->nama }}</span> - Kecamatan {{ $kecamatan->nama_kecamatan }}
                    </h3>
                    <p class="text-xs text-slate-400">Rincian ketetapan, realisasi, dan objek pajak terdaftar</p>
                </div>
            </div>

            <div class="flex items-center space-x-2">
                <span class="px-3 py-1 bg-blue-50 border border-blue-200 text-blue-700 rounded-xl text-xs font-bold">
                    Kecamatan {{ $kecamatan->nama_kecamatan }}
                </span>
                <span class="px-3 py-1 bg-slate-100 border border-slate-200 text-slate-700 rounded-xl text-xs font-bold">
                    Tahun Pajak 2026
                </span>
            </div>
        </div>

        <!-- Top Row: Stats, Gauge, Alert Note -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-4 items-center">
            
            <!-- Desa Badge & Name (Col 2) -->
            <div class="lg:col-span-2 bg-slate-50 rounded-xl p-4 border border-slate-100 flex flex-col justify-center">
                <div class="flex items-center space-x-2 mb-1">
                    <span id="dtlDesaDot" class="w-3 h-3 rounded-full flex-shrink-0" style="background-color: {{ $selectedDesa->dotColor }}"></span>
                    <h4 id="dtlDesaNamaBadge" class="text-sm font-extrabold text-slate-900 truncate">{{ $selectedDesa->nama }}</h4>
                </div>
                <span id="dtlDesaBadge" class="inline-block text-[11px] font-bold text-slate-600">
                    {{ $selectedDesa->status }}
                </span>
            </div>

            <!-- Target PBB-P2 (Col 2) -->
            <div class="lg:col-span-2 bg-slate-50 rounded-xl p-4 border border-slate-100">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Target PBB-P2</p>
                <h4 id="dtlDesaTarget" class="text-sm font-black text-slate-900 mt-1">Rp{{ number_format($selectedDesa->target, 0, ',', '.') }}</h4>
            </div>

            <!-- Realisasi (Col 2) -->
            <div class="lg:col-span-2 bg-slate-50 rounded-xl p-4 border border-slate-100">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Realisasi</p>
                <h4 id="dtlDesaRealisasi" class="text-sm font-black text-slate-900 mt-1">Rp{{ number_format($selectedDesa->realisasi, 0, ',', '.') }}</h4>
            </div>

            <!-- Sisa Tagihan (Col 2) -->
            <div class="lg:col-span-2 bg-rose-50/60 rounded-xl p-4 border border-rose-100">
                <p class="text-[11px] font-bold text-rose-500 uppercase tracking-wider">Sisa Tagihan</p>
                <h4 id="dtlDesaSisa" class="text-sm font-black text-rose-700 mt-1">Rp{{ number_format($selectedDesa->sisa, 0, ',', '.') }}</h4>
            </div>

            <!-- Capaian Keseluruhan Gauge (Col 2) -->
            <div class="lg:col-span-2 bg-slate-50 rounded-xl p-4 border border-slate-100 flex items-center space-x-3">
                <div class="w-12 h-12 rounded-full border-4 border-emerald-500 flex items-center justify-center flex-shrink-0">
                    <span id="dtlDesaGauge" class="text-xs font-black text-emerald-600">{{ round($selectedDesa->persen) }}%</span>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Capaian</p>
                    <p class="text-xs font-extrabold text-slate-800">Keseluruhan</p>
                </div>
            </div>

            <!-- Informasi Alert (Col 2) -->
            <div class="lg:col-span-2 bg-blue-50/80 rounded-xl p-3 border border-blue-100 text-xs text-blue-900 flex flex-col justify-center">
                <div class="flex items-center space-x-1.5 font-bold mb-1">
                    <i class="fa-solid fa-circle-info text-blue-600"></i>
                    <span>Informasi</span>
                </div>
                <p id="dtlDesaInfo" class="text-[11px] text-blue-800 leading-snug">
                    Capaian pembayaran desa/kelurahan mencapai {{ $selectedDesa->persen }}%. Terus lakukan pendekatan dan sosialisasi kepada wajib pajak.
                </p>
            </div>

        </div>

        <!-- Bottom Row: Rincian Objek Pajak & Progress Bar -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-center pt-2">
            <!-- 3 Stat Blocks: Obyek Terdaftar, Lunas, Belum Lunas (Col 8) -->
            <div class="lg:col-span-8">
                <h5 class="text-xs font-bold text-slate-700 mb-3 uppercase tracking-wider">Rincian Pajak Desa/Kelurahan</h5>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <!-- Terdaftar -->
                    <div class="bg-slate-50 rounded-xl p-3.5 border border-slate-200/80 flex items-center space-x-3">
                        <div class="w-9 h-9 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center text-sm">
                            <i class="fa-solid fa-file-invoice"></i>
                        </div>
                        <div>
                            <p class="text-[11px] font-bold text-slate-400">Obyek Pajak Terdaftar</p>
                            <h4 id="dtlDesaTotalObjek" class="text-base font-black text-slate-900">{{ number_format($selectedDesa->totalObjek, 0, ',', '.') }}</h4>
                        </div>
                    </div>

                    <!-- Lunas -->
                    <div class="bg-emerald-50/60 rounded-xl p-3.5 border border-emerald-200/80 flex items-center space-x-3">
                        <div class="w-9 h-9 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center text-sm">
                            <i class="fa-solid fa-circle-check"></i>
                        </div>
                        <div>
                            <p class="text-[11px] font-bold text-emerald-600">Obyek Pajak Lunas</p>
                            <h4 id="dtlDesaLunasObjek" class="text-base font-black text-emerald-900">{{ number_format($selectedDesa->lunasObjek, 0, ',', '.') }}</h4>
                        </div>
                    </div>

                    <!-- Belum Lunas -->
                    <div class="bg-rose-50/60 rounded-xl p-3.5 border border-rose-200/80 flex items-center space-x-3">
                        <div class="w-9 h-9 rounded-lg bg-rose-100 text-rose-700 flex items-center justify-center text-sm">
                            <i class="fa-solid fa-clock"></i>
                        </div>
                        <div>
                            <p class="text-[11px] font-bold text-rose-600">Obyek Pajak Belum Lunas</p>
                            <h4 id="dtlDesaBelumLunasObjek" class="text-base font-black text-rose-900">{{ number_format($selectedDesa->belumLunasObjek, 0, ',', '.') }}</h4>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Progress Bar (Col 4) -->
            <div class="lg:col-span-4 bg-slate-50 rounded-xl p-4 border border-slate-100 flex flex-col justify-center">
                <div class="flex items-center justify-between text-xs font-bold mb-2">
                    <span class="text-slate-600">Persentase Capaian Realisasi</span>
                    <span id="dtlDesaProgressText" class="text-emerald-600 font-extrabold">{{ $selectedDesa->persen }}%</span>
                </div>
                <div class="w-full bg-slate-200 rounded-full h-3 overflow-hidden">
                    <div id="dtlDesaProgressBar" class="h-3 rounded-full bg-emerald-500 transition-all duration-500" style="width: {{ min(100, $selectedDesa->persen) }}%"></div>
                </div>
            </div>
        </div>

    </div>

</div>
@endsection

@push('scripts')
<script>
    // Initialize Village (Desa) Map
    const centerLat = {{ $kecamatan->latitude ?? -6.304 }};
    const centerLng = {{ $kecamatan->longitude ?? 107.307 }};

    const desaMap = L.map('desaMap', {
        zoomControl: true,
        attributionControl: false
    }).setView([centerLat, centerLng], 12);

    // Google Maps Tile Layers
    const gRoad = L.tileLayer('https://mt1.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', { maxZoom: 20 });
    const gSat = L.tileLayer('https://mt1.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', { maxZoom: 20 });
    gRoad.addTo(desaMap);
    let activeDesaTile = gRoad;

    function switchDesaLayer(type) {
        desaMap.removeLayer(activeDesaTile);
        if (type === 'googleRoad') {
            activeDesaTile = gRoad;
            document.getElementById('btnDesaPeta').className = 'px-2.5 py-1 rounded-md bg-blue-600 text-white shadow-xs transition-colors';
            document.getElementById('btnDesaSatelit').className = 'px-2.5 py-1 rounded-md text-slate-600 hover:text-slate-900 transition-colors';
        } else {
            activeDesaTile = gSat;
            document.getElementById('btnDesaSatelit').className = 'px-2.5 py-1 rounded-md bg-blue-600 text-white shadow-xs transition-colors';
            document.getElementById('btnDesaPeta').className = 'px-2.5 py-1 rounded-md text-slate-600 hover:text-slate-900 transition-colors';
        }
        activeDesaTile.addTo(desaMap);
    }

    function toggleDesaFullScreen() {
        const el = document.getElementById('desaMap');
        if (!document.fullscreenElement) {
            el.requestFullscreen().catch(err => alert(`Error: ${err.message}`));
        } else {
            document.exitFullscreen();
        }
    }

    // Desa List from Controller
    const desasData = @json($desasList);
    let selectedDesaLayer = null;
    let desaGeoLayer = null;

    // Load GeoJSON for this subdistrict's villages
    fetch("{{ asset('data/karawang_desa_by_kecamatan.json') }}")
        .then(res => res.json())
        .then(allDesaData => {
            const kecDesaFeatures = allDesaData[{{ $kecamatan->id_kecamatan }}];
            if (kecDesaFeatures && kecDesaFeatures.features) {
                desaGeoLayer = L.geoJSON(kecDesaFeatures, {
                    style: function(feature) {
                        return {
                            fillColor: feature.properties.color || '#FB923C',
                            weight: 2,
                            opacity: 1,
                            color: '#ffffff',
                            fillOpacity: 0.72
                        };
                    },
                    onEachFeature: function(feature, layer) {
                        const p = feature.properties;
                        const popupHtml = `
                            <div class="p-3.5 bg-white rounded-xl shadow-lg min-w-[210px]">
                                <div class="flex items-center justify-between mb-1.5">
                                    <h4 class="font-extrabold text-xs text-slate-900">${p.nama_desa}</h4>
                                    <i class="fa-solid fa-chevron-right text-[10px] text-blue-600"></i>
                                </div>
                                <div class="space-y-1 text-[11px] mb-2 text-slate-600">
                                    <div class="flex justify-between"><span>Target:</span> <span class="font-bold">Rp${formatNumber(p.target)}</span></div>
                                    <div class="flex justify-between"><span>Realisasi:</span> <span class="font-bold">Rp${formatNumber(p.realisasi)}</span></div>
                                    <div class="flex justify-between"><span>Sisa Tagihan:</span> <span class="font-bold">Rp${formatNumber(p.sisa)}</span></div>
                                    <div class="flex justify-between font-bold pt-1 border-t border-slate-100">
                                        <span>Capaian:</span> <span class="text-emerald-600">${p.persentase}%</span>
                                    </div>
                                </div>
                                <span class="inline-block px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-800">
                                    ${p.status}
                                </span>
                            </div>
                        `;
                        layer.bindPopup(popupHtml, { closeButton: false });

                        // Label
                        const dIcon = L.divIcon({
                            className: 'desa-label',
                            html: `<div style="text-align:center; font-size:9px; font-weight:800; color:#0f172a; text-shadow:0 0 3px #fff, 0 0 3px #fff; pointer-events:none;">
                                     ${p.nama_desa}<br><span style="font-weight:700;">${p.persentase}%</span>
                                   </div>`,
                            iconSize: [80, 24],
                            iconAnchor: [40, 12]
                        });
                        L.marker([p.lat, p.lng], { icon: dIcon, interactive: false }).addTo(desaMap);

                        layer.on('mouseover', function() {
                            this.setStyle({ weight: 3.5, color: '#1d4ed8', fillOpacity: 0.88 });
                            this.openPopup();
                        });

                        layer.on('mouseout', function() {
                            if (selectedDesaLayer !== this) {
                                desaGeoLayer.resetStyle(this);
                            }
                        });

                        layer.on('click', function() {
                            if (selectedDesaLayer) desaGeoLayer.resetStyle(selectedDesaLayer);
                            selectedDesaLayer = this;
                            this.setStyle({ weight: 4, color: '#2563eb', fillOpacity: 0.95 });

                            const matched = desasData.find(d => d.id_desa === p.id_desa);
                            if (matched) selectDesa(matched);
                        });
                    }
                }).addTo(desaMap);

                // Zoom to bounds
                desaMap.fitBounds(desaGeoLayer.getBounds(), { padding: [20, 20] });
            }
        });

    function formatNumber(num) {
        return new Intl.NumberFormat('id-ID').format(num);
    }

    // Update bottom detail section
    function selectDesa(desa) {
        document.getElementById('dtlDesaNama').innerText = desa.nama;
        document.getElementById('dtlDesaNamaBadge').innerText = desa.nama;
        document.getElementById('dtlDesaBadge').innerText = desa.status;
        document.getElementById('dtlDesaDot').style.backgroundColor = desa.dotColor;

        document.getElementById('dtlDesaTarget').innerText = 'Rp' + formatNumber(desa.target);
        document.getElementById('dtlDesaRealisasi').innerText = 'Rp' + formatNumber(desa.realisasi);
        document.getElementById('dtlDesaSisa').innerText = 'Rp' + formatNumber(desa.sisa);

        document.getElementById('dtlDesaGauge').innerText = Math.round(desa.persen) + '%';
        document.getElementById('dtlDesaProgressText').innerText = desa.persen + '%';

        const pBar = document.getElementById('dtlDesaProgressBar');
        pBar.style.width = Math.min(100, desa.persen) + '%';
        if (desa.persen >= 100) {
            pBar.className = 'h-3 rounded-full bg-emerald-500 transition-all duration-500';
        } else if (desa.persen >= 70) {
            pBar.className = 'h-3 rounded-full bg-yellow-500 transition-all duration-500';
        } else {
            pBar.className = 'h-3 rounded-full bg-orange-500 transition-all duration-500';
        }

        document.getElementById('dtlDesaTotalObjek').innerText = formatNumber(desa.totalObjek);
        document.getElementById('dtlDesaLunasObjek').innerText = formatNumber(desa.lunasObjek);
        document.getElementById('dtlDesaBelumLunasObjek').innerText = formatNumber(desa.belumLunasObjek);

        document.getElementById('dtlDesaInfo').innerText = 
            `Capaian pembayaran desa/kelurahan mencapai ${desa.persen}%. Terus lakukan pendekatan dan sosialisasi kepada wajib pajak untuk menyelesaikan sisa tagihan.`;

        // Highlight table row
        document.querySelectorAll('.desa-row').forEach(row => {
            row.classList.remove('bg-blue-50/80', 'font-bold');
            if (row.getAttribute('data-nama') === desa.nama.toLowerCase()) {
                row.classList.add('bg-blue-50/80', 'font-bold');
            }
        });

        // Pan map
        if (desa.lat && desa.lng) {
            desaMap.panTo([desa.lat, desa.lng]);
        }
    }

    // Search filter for desa list
    document.getElementById('searchDesa').addEventListener('input', function(e) {
        const query = e.target.value.toLowerCase().trim();
        document.querySelectorAll('.desa-row').forEach(row => {
            const nama = row.getAttribute('data-nama');
            if (nama.includes(query)) {
                row.style.display = 'table-row';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>
@endpush

