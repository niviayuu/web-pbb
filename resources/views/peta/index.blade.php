@extends('layouts.app')

@section('title', 'Peta Capaian PBB-P2 - Kabupaten Karawang')
@section('page-title', 'Peta Capaian PBB-P2')
@section('page-subtitle', 'Pantau capaian target dan realisasi pajak PBB-P2 di setiap kecamatan untuk mendukung pembangunan kabupaten Karawang.')

@section('content')
<div class="space-y-6">

    <!-- 6 Summary Stat Cards (Matching PETA KECAMATAN.png) -->
    <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-6 gap-3.5">
        <!-- 1: Total Target -->
        <div class="bg-white rounded-2xl p-4 border border-slate-200/90 shadow-xs flex items-center space-x-3">
            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg flex-shrink-0">
                <i class="fa-solid fa-bullseye"></i>
            </div>
            <div class="overflow-hidden">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider truncate">Total Target PBB-P2</p>
                <h4 class="text-sm font-extrabold text-slate-900 truncate">Rp{{ number_format($totalTarget, 0, ',', '.') }}</h4>
            </div>
        </div>

        <!-- 2: Total Realisasi -->
        <div class="bg-white rounded-2xl p-4 border border-slate-200/90 shadow-xs flex items-center space-x-3">
            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg flex-shrink-0">
                <i class="fa-solid fa-wallet"></i>
            </div>
            <div class="overflow-hidden">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider truncate">Total Realisasi</p>
                <h4 class="text-sm font-extrabold text-slate-900 truncate">Rp{{ number_format($totalRealisasi, 0, ',', '.') }}</h4>
            </div>
        </div>

        <!-- 3: Sisa Tagihan -->
        <div class="bg-white rounded-2xl p-4 border border-slate-200/90 shadow-xs flex items-center space-x-3">
            <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center text-lg flex-shrink-0">
                <i class="fa-solid fa-clock-rotate-left"></i>
            </div>
            <div class="overflow-hidden">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider truncate">Sisa Tagihan PBB-P2</p>
                <h4 class="text-sm font-extrabold text-slate-900 truncate">Rp{{ number_format($totalSisa, 0, ',', '.') }}</h4>
            </div>
        </div>

        <!-- 4: Capaian Realisasi Ring -->
        <div class="bg-white rounded-2xl p-4 border border-slate-200/90 shadow-xs flex items-center space-x-3">
            <div class="w-10 h-10 rounded-full border-4 border-emerald-500 flex items-center justify-center flex-shrink-0">
                <span class="text-[10px] font-black text-emerald-600">{{ round($capaianRealisasi) }}%</span>
            </div>
            <div class="overflow-hidden">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider truncate">Capaian Realisasi</p>
                <h4 class="text-sm font-extrabold text-slate-900 truncate">{{ $capaianRealisasi }}%</h4>
            </div>
        </div>

        <!-- 5: Total Kecamatan -->
        <div class="bg-white rounded-2xl p-4 border border-slate-200/90 shadow-xs flex items-center space-x-3">
            <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-lg flex-shrink-0">
                <i class="fa-regular fa-building"></i>
            </div>
            <div class="overflow-hidden">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider truncate">Total Kecamatan</p>
                <h4 class="text-sm font-extrabold text-slate-900 truncate">{{ $totalKecamatan }} Kecamatan</h4>
            </div>
        </div>

        <!-- 6: Total Desa/Kelurahan -->
        <div class="bg-white rounded-2xl p-4 border border-slate-200/90 shadow-xs flex items-center space-x-3">
            <div class="w-10 h-10 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center text-lg flex-shrink-0">
                <i class="fa-solid fa-house-chimney"></i>
            </div>
            <div class="overflow-hidden">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider truncate">Total Desa/Kelurahan</p>
                <h4 class="text-sm font-extrabold text-slate-900 truncate">{{ $totalDesa }} Desa/Kelurahan</h4>
            </div>
        </div>
    </div>

    <!-- Main Map & Right List Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        
        <!-- Left: Interactive Leaflet Map (Col 8) -->
        <div class="lg:col-span-8 bg-white rounded-2xl p-4 border border-slate-200/90 shadow-xs relative flex flex-col">
            <!-- Map Layers & Tool Controls -->
            <div class="flex items-center justify-between mb-3 px-2">
                <div class="flex items-center space-x-2">
                    <span class="text-xs font-bold text-slate-700 flex items-center">
                        <i class="fa-solid fa-layer-group mr-1.5 text-blue-600"></i> Mode Peta:
                    </span>
                    <div class="inline-flex p-0.5 rounded-lg bg-slate-100 border border-slate-200 text-xs font-semibold">
                        <button id="btnPeta" onclick="switchLayer('googleRoad')" class="px-3 py-1 rounded-md bg-blue-600 text-white shadow-xs transition-colors">
                            Peta
                        </button>
                        <button id="btnSatelit" onclick="switchLayer('googleSat')" class="px-3 py-1 rounded-md text-slate-600 hover:text-slate-900 transition-colors">
                            Satelit
                        </button>
                        <button id="btnOsm" onclick="switchLayer('osm')" class="px-3 py-1 rounded-md text-slate-600 hover:text-slate-900 transition-colors">
                            OSM
                        </button>
                    </div>
                </div>

                <div class="flex items-center space-x-2">
                    <button onclick="map.setView([-6.304, 107.307], 10)" title="Reset View" class="p-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-xs font-bold transition-colors">
                        <i class="fa-solid fa-arrows-to-dot mr-1"></i> Pusatkan
                    </button>
                    <button onclick="toggleFullScreen()" title="Fullscreen" class="p-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-xs transition-colors">
                        <i class="fa-solid fa-expand"></i>
                    </button>
                </div>
            </div>

            <!-- Map Viewport -->
            <div id="karawangMap" class="w-full h-[620px] rounded-xl overflow-hidden border border-slate-200 relative z-10"></div>

            <!-- Legend Row Below Map (Matching PETA KECAMATAN.png) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4 pt-3 border-t border-slate-100">
                <!-- Keterangan Warna -->
                <div class="bg-slate-50/80 rounded-xl p-3 border border-slate-100">
                    <h5 class="text-xs font-bold text-slate-800 mb-2">Keterangan Warna</h5>
                    <div class="grid grid-cols-2 gap-2 text-xs">
                        <div class="flex items-center space-x-2">
                            <span class="w-3.5 h-3.5 rounded-full bg-emerald-500 flex-shrink-0"></span>
                            <span class="text-slate-600 font-medium">≥ 100% <span class="text-slate-400">(Tercapai)</span></span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="w-3.5 h-3.5 rounded-full bg-yellow-400 flex-shrink-0"></span>
                            <span class="text-slate-600 font-medium">70 - 99% <span class="text-slate-400">(Mendekati)</span></span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="w-3.5 h-3.5 rounded-full bg-orange-400 flex-shrink-0"></span>
                            <span class="text-slate-600 font-medium">30 - 69% <span class="text-slate-400">(Sedang)</span></span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="w-3.5 h-3.5 rounded-full bg-rose-500 flex-shrink-0"></span>
                            <span class="text-slate-600 font-medium">≤ 30% <span class="text-slate-400">(Rendah)</span></span>
                        </div>
                    </div>
                </div>

                <!-- Rekap Capaian -->
                <div class="bg-slate-50/80 rounded-xl p-3 border border-slate-100">
                    <h5 class="text-xs font-bold text-slate-800 mb-2">Rekap Capaian</h5>
                    <div class="grid grid-cols-2 gap-2 text-xs">
                        <div class="flex items-center justify-between pr-2">
                            <span class="flex items-center text-slate-600"><span class="w-2.5 h-2.5 rounded-full bg-emerald-500 mr-1.5"></span>Tercapai</span>
                            <span class="font-bold text-slate-900">{{ $rekapTercapai }} Kecamatan</span>
                        </div>
                        <div class="flex items-center justify-between pr-2">
                            <span class="flex items-center text-slate-600"><span class="w-2.5 h-2.5 rounded-full bg-yellow-400 mr-1.5"></span>Mendekati</span>
                            <span class="font-bold text-slate-900">{{ $rekapMendekati }} Kecamatan</span>
                        </div>
                        <div class="flex items-center justify-between pr-2">
                            <span class="flex items-center text-slate-600"><span class="w-2.5 h-2.5 rounded-full bg-orange-400 mr-1.5"></span>Sedang</span>
                            <span class="font-bold text-slate-900">{{ $rekapSedang }} Kecamatan</span>
                        </div>
                        <div class="flex items-center justify-between pr-2">
                            <span class="flex items-center text-slate-600"><span class="w-2.5 h-2.5 rounded-full bg-rose-500 mr-1.5"></span>Rendah</span>
                            <span class="font-bold text-slate-900">{{ $rekapRendah }} Kecamatan</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Daftar Kecamatan & Detail Card (Col 4) -->
        <div class="lg:col-span-4 space-y-4">
            
            <!-- Daftar Kecamatan List -->
            <div class="bg-white rounded-2xl p-4 border border-slate-200/90 shadow-xs flex flex-col h-[400px]">
                <h4 class="text-sm font-bold text-slate-900 mb-2.5">Daftar Kecamatan</h4>

                <!-- Search Input -->
                <div class="relative mb-3">
                    <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3 text-slate-400 text-xs"></i>
                    <input type="text" id="searchKecamatan" placeholder="Cari Kecamatan..." 
                           class="w-full pl-9 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:ring-2 focus:ring-blue-500 focus:bg-white outline-none transition-all">
                </div>

                <!-- Scrollable Kecamatan List -->
                <div id="kecamatanListContainer" class="flex-1 overflow-y-auto space-y-1.5 pr-1">
                    @foreach($kecamatans as $kec)
                    <div onclick="selectKecamatan({{ json_encode($kec) }})" 
                         data-nama="{{ strtolower($kec->nama) }}"
                         class="kec-item flex items-center justify-between p-2.5 rounded-xl border border-transparent hover:border-slate-200 hover:bg-slate-50 cursor-pointer transition-all {{ $kec->id_kecamatan == $selectedKec->id_kecamatan ? 'bg-blue-50/70 border-blue-200' : '' }}">
                        <div class="flex items-center space-x-2.5 truncate">
                            <span class="w-3 h-3 rounded-full flex-shrink-0" style="background-color: {{ $kec->badgeColor }}"></span>
                            <span class="text-xs font-bold text-slate-800 truncate">{{ $kec->nama }}</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="text-xs font-black text-slate-700">{{ $kec->persen }}%</span>
                            <i class="fa-solid fa-chevron-right text-[10px] text-slate-400"></i>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Selected Kecamatan Detail Card (Matching PETA KECAMATAN.png) -->
            <div id="detailKecCard" class="bg-white rounded-2xl p-5 border border-slate-200/90 shadow-xs space-y-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <div class="w-7 h-7 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center text-xs">
                            <i class="fa-solid fa-location-dot"></i>
                        </div>
                        <h4 id="cardKecNama" class="text-sm font-extrabold text-slate-900">Kecamatan {{ $selectedKec->nama }}</h4>
                    </div>
                    <span id="cardKecBadge" class="px-2.5 py-0.5 rounded-full text-[11px] font-bold {{ $selectedKec->persen >= 100 ? 'bg-emerald-100 text-emerald-800' : ($selectedKec->persen >= 70 ? 'bg-yellow-100 text-yellow-800' : 'bg-orange-100 text-orange-800') }}">
                        {{ $selectedKec->status }}
                    </span>
                </div>

                <div class="space-y-2 text-xs pt-1">
                    <div class="flex items-center justify-between py-1 border-b border-slate-100">
                        <span class="text-slate-500">Target PBB-P2</span>
                        <span id="cardKecTarget" class="font-extrabold text-slate-900">Rp{{ number_format($selectedKec->target, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex items-center justify-between py-1 border-b border-slate-100">
                        <span class="text-slate-500">Realisasi</span>
                        <span id="cardKecRealisasi" class="font-extrabold text-slate-900">Rp{{ number_format($selectedKec->realisasi, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex items-center justify-between py-1 border-b border-slate-100">
                        <span class="text-slate-500">Sisa Tagihan</span>
                        <span id="cardKecSisa" class="font-extrabold text-slate-900">Rp{{ number_format($selectedKec->sisa, 0, ',', '.') }}</span>
                    </div>
                    <div class="pt-1">
                        <div class="flex items-center justify-between text-[11px] font-bold mb-1">
                            <span class="text-slate-600">Capaian Target</span>
                            <span id="cardKecPersen" class="text-emerald-600 font-extrabold">{{ $selectedKec->persen }}%</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden">
                            <div id="cardKecProgressBar" class="h-2.5 rounded-full bg-emerald-500 transition-all duration-500" style="width: {{ min(100, $selectedKec->persen) }}%"></div>
                        </div>
                    </div>
                </div>

                <!-- Info Notice Alert -->
                <div id="cardKecAlert" class="bg-blue-50/80 border border-blue-100 rounded-xl p-3 flex items-start space-x-2.5 text-xs text-blue-900">
                    <i class="fa-solid fa-circle-info text-blue-600 mt-0.5 flex-shrink-0"></i>
                    <p id="cardKecAlertText" class="leading-relaxed">
                        @if($selectedKec->persen >= 100)
                            Target penerimaan PBB-P2 pada kecamatan ini telah tercapai dengan optimal. Pertahankan pencapaian ini!
                        @else
                            Capaian masih di bawah 100%. Perlu ditingkatkan sosialisasi dan pengelolaan pembayaran PBB-P2 di wilayah ini.
                        @endif
                    </p>
                </div>

                <!-- Action Button linking to detail desa map -->
                <a id="cardKecBtnDetail" href="{{ route('peta.kecamatan', $selectedKec->id_kecamatan) }}" 
                   class="w-full flex items-center justify-center space-x-2 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold shadow-md transition-all">
                    <span>Lihat Detail Kecamatan <span id="btnDetailKecNama">{{ $selectedKec->nama }}</span></span>
                    <i class="fa-solid fa-chevron-right text-[10px]"></i>
                </a>
            </div>

        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    // Initialize Karawang Regency Map
    const map = L.map('karawangMap', {
        zoomControl: true,
        attributionControl: false
    }).setView([-6.304, 107.307], 10);

    // Google Maps Tile Layers
    const googleRoadmap = L.tileLayer('https://mt1.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', { maxZoom: 20 });
    const googleSatellite = L.tileLayer('https://mt1.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', { maxZoom: 20 });
    const osmLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19 });

    // Default layer: Google Roadmap
    googleRoadmap.addTo(map);
    let currentLayer = googleRoadmap;

    function switchLayer(layerType) {
        map.removeLayer(currentLayer);
        document.getElementById('btnPeta').className = 'px-3 py-1 rounded-md text-slate-600 hover:text-slate-900 transition-colors';
        document.getElementById('btnSatelit').className = 'px-3 py-1 rounded-md text-slate-600 hover:text-slate-900 transition-colors';
        document.getElementById('btnOsm').className = 'px-3 py-1 rounded-md text-slate-600 hover:text-slate-900 transition-colors';

        if (layerType === 'googleRoad') {
            currentLayer = googleRoadmap;
            document.getElementById('btnPeta').className = 'px-3 py-1 rounded-md bg-blue-600 text-white shadow-xs transition-colors';
        } else if (layerType === 'googleSat') {
            currentLayer = googleSatellite;
            document.getElementById('btnSatelit').className = 'px-3 py-1 rounded-md bg-blue-600 text-white shadow-xs transition-colors';
        } else {
            currentLayer = osmLayer;
            document.getElementById('btnOsm').className = 'px-3 py-1 rounded-md bg-blue-600 text-white shadow-xs transition-colors';
        }
        currentLayer.addTo(map);
    }

    function toggleFullScreen() {
        const el = document.getElementById('karawangMap');
        if (!document.fullscreenElement) {
            el.requestFullscreen().catch(err => alert(`Error: ${err.message}`));
        } else {
            document.exitFullscreen();
        }
    }

    // Kecamatan Dataset from Controller
    const kecDataset = @json($kecamatans);
    const kecDataMap = {};
    kecDataset.forEach(k => {
        kecDataMap[k.nama] = k;
    });

    let geoJsonLayer = null;
    let selectedLayer = null;

    function getColor(persen) {
        if (persen >= 100) return '#10B981'; // Green
        if (persen >= 70) return '#EAB308';  // Yellow
        if (persen >= 30) return '#FB923C';  // Orange
        return '#EF4444';                    // Red
    }

    // Load GeoJSON for the 30 subdistricts
    fetch("{{ asset('data/karawang_kecamatan.json') }}")
        .then(res => res.json())
        .then(geoData => {
            geoJsonLayer = L.geoJSON(geoData, {
                style: function (feature) {
                    const info = kecDataMap[feature.properties.nama_kecamatan] || { persen: 50 };
                    return {
                        fillColor: getColor(info.persen),
                        weight: 2,
                        opacity: 1,
                        color: '#ffffff',
                        dashArray: '3',
                        fillOpacity: 0.72
                    };
                },
                onEachFeature: function (feature, layer) {
                    const nama = feature.properties.nama_kecamatan;
                    const info = kecDataMap[nama] || { target: 0, realisasi: 0, sisa: 0, persen: 0, status: 'Sedang' };

                    // Custom styled Popup matching PETA KECAMATAN.png
                    const popupHtml = `
                        <div class="p-4 bg-white rounded-xl shadow-lg min-w-[220px]">
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="font-extrabold text-sm text-slate-900">${nama}</h4>
                                <i class="fa-solid fa-chevron-right text-xs text-blue-600"></i>
                            </div>
                            <div class="space-y-1 text-xs mb-3">
                                <div class="flex justify-between text-slate-500">
                                    <span>Target PBB-P2</span>
                                    <span class="font-bold text-slate-800">Rp${formatNumber(info.target)}</span>
                                </div>
                                <div class="flex justify-between text-slate-500">
                                    <span>Total Realisasi</span>
                                    <span class="font-bold text-slate-800">Rp${formatNumber(info.realisasi)}</span>
                                </div>
                                <div class="flex justify-between text-slate-500">
                                    <span>Sisa Tagihan</span>
                                    <span class="font-bold text-slate-800">Rp${formatNumber(info.sisa)}</span>
                                </div>
                                <div class="flex justify-between pt-1 border-t border-slate-100 font-bold">
                                    <span class="text-slate-700">Capaian Target</span>
                                    <span class="text-emerald-600 font-extrabold">${info.persen}%</span>
                                </div>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold ${info.persen >= 100 ? 'bg-emerald-100 text-emerald-800' : (info.persen >= 70 ? 'bg-yellow-100 text-yellow-800' : 'bg-orange-100 text-orange-800')}">
                                    <span class="w-1.5 h-1.5 rounded-full ${info.persen >= 100 ? 'bg-emerald-500' : (info.persen >= 70 ? 'bg-yellow-500' : 'bg-orange-500')} mr-1"></span>
                                    ${info.status}
                                </span>
                                <a href="{{ url('/peta/kecamatan') }}/${info.id_kecamatan}" class="text-[11px] font-bold text-blue-600 hover:underline">
                                    Detail &rarr;
                                </a>
                            </div>
                        </div>
                    `;

                    layer.bindPopup(popupHtml, { closeButton: false });

                    // Centroid label on map
                    const lat = feature.properties.lat;
                    const lng = feature.properties.lng;
                    const labelIcon = L.divIcon({
                        className: 'kec-label',
                        html: `<div style="text-align:center; font-size:10px; font-weight:800; color:#0f172a; text-shadow:0 0 3px #ffffff, 0 0 3px #ffffff; pointer-events:none;">
                                 ${nama}<br><span style="font-weight:700; color:#1e293b;">${info.persen}%</span>
                               </div>`,
                        iconSize: [80, 26],
                        iconAnchor: [40, 13]
                    });
                    L.marker([lat, lng], { icon: labelIcon, interactive: false }).addTo(map);

                    // Hover effects
                    layer.on('mouseover', function () {
                        this.setStyle({
                            weight: 3.5,
                            color: '#1d4ed8',
                            dashArray: '',
                            fillOpacity: 0.88
                        });
                        this.openPopup();
                    });

                    layer.on('mouseout', function () {
                        if (selectedLayer !== this) {
                            geoJsonLayer.resetStyle(this);
                        }
                    });

                    // Click event: selects kecamatan & updates right card
                    layer.on('click', function () {
                        if (selectedLayer) geoJsonLayer.resetStyle(selectedLayer);
                        selectedLayer = this;
                        this.setStyle({
                            weight: 4,
                            color: '#2563eb',
                            dashArray: '',
                            fillOpacity: 0.92
                        });
                        selectKecamatan(info);
                    });
                }
            }).addTo(map);
        });

    function formatNumber(num) {
        return new Intl.NumberFormat('id-ID').format(num);
    }

    // Function to update the right sidebar card
    function selectKecamatan(kec) {
        document.getElementById('cardKecNama').innerText = 'Kecamatan ' + kec.nama;
        document.getElementById('btnDetailKecNama').innerText = kec.nama;
        document.getElementById('cardKecTarget').innerText = 'Rp' + formatNumber(kec.target);
        document.getElementById('cardKecRealisasi').innerText = 'Rp' + formatNumber(kec.realisasi);
        document.getElementById('cardKecSisa').innerText = 'Rp' + formatNumber(kec.sisa);
        document.getElementById('cardKecPersen').innerText = kec.persen + '%';

        const pBar = document.getElementById('cardKecProgressBar');
        pBar.style.width = Math.min(100, kec.persen) + '%';
        if (kec.persen >= 100) {
            pBar.className = 'h-2.5 rounded-full bg-emerald-500 transition-all duration-500';
        } else if (kec.persen >= 70) {
            pBar.className = 'h-2.5 rounded-full bg-yellow-500 transition-all duration-500';
        } else {
            pBar.className = 'h-2.5 rounded-full bg-orange-500 transition-all duration-500';
        }

        const badge = document.getElementById('cardKecBadge');
        badge.innerText = kec.status;
        badge.className = 'px-2.5 py-0.5 rounded-full text-[11px] font-bold ' + 
            (kec.persen >= 100 ? 'bg-emerald-100 text-emerald-800' : (kec.persen >= 70 ? 'bg-yellow-100 text-yellow-800' : 'bg-orange-100 text-orange-800'));

        const alertText = document.getElementById('cardKecAlertText');
        if (kec.persen >= 100) {
            alertText.innerText = 'Target penerimaan PBB-P2 pada kecamatan ini telah tercapai dengan optimal. Pertahankan pencapaian ini!';
        } else {
            alertText.innerText = 'Capaian masih di bawah 100%. Perlu ditingkatkan sosialisasi dan pengelolaan pembayaran PBB-P2 di wilayah ini.';
        }

        document.getElementById('cardKecBtnDetail').href = "{{ url('/peta/kecamatan') }}/" + kec.id_kecamatan;

        // Fly map to the kecamatan center
        if (kec.lat && kec.lng) {
            map.flyTo([kec.lat, kec.lng], 11, { duration: 1.2 });
        }
    }

    // Search filter for kecamatan list
    document.getElementById('searchKecamatan').addEventListener('input', function(e) {
        const query = e.target.value.toLowerCase().trim();
        document.querySelectorAll('.kec-item').forEach(item => {
            const nama = item.getAttribute('data-nama');
            if (nama.includes(query)) {
                item.style.display = 'flex';
            } else {
                item.style.display = 'none';
            }
        });
    });
</script>
@endpush

