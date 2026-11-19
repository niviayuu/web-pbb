@extends('layouts.app')

@section('title', 'Informasi - BAPENDA Karawang')
@section('page-title', 'Informasi')
@section('page-subtitle', 'Berita, pengumuman, dan regulasi terbaru seputar PBB-P2')

@section('content')
<div class="space-y-6">

    <!-- Category Tabs (Matching Informasi -- DONE.png) -->
    <div class="flex flex-wrap items-center gap-2">
        <a href="{{ route('informasi.index', ['tab' => 'semua']) }}" 
           class="px-5 py-2 rounded-xl text-xs font-bold transition-all {{ $tab === 'semua' ? 'bg-blue-600 text-white shadow-xs' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200' }}">
            Semua
        </a>
        <a href="{{ route('informasi.index', ['tab' => 'berita']) }}" 
           class="px-5 py-2 rounded-xl text-xs font-bold transition-all {{ $tab === 'berita' ? 'bg-blue-600 text-white shadow-xs' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200' }}">
            Berita
        </a>
        <a href="{{ route('informasi.index', ['tab' => 'pengumuman']) }}" 
           class="px-5 py-2 rounded-xl text-xs font-bold transition-all {{ $tab === 'pengumuman' ? 'bg-blue-600 text-white shadow-xs' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200' }}">
            Pengumuman
        </a>
        <a href="{{ route('informasi.index', ['tab' => 'regulasi']) }}" 
           class="px-5 py-2 rounded-xl text-xs font-bold transition-all {{ $tab === 'regulasi' ? 'bg-blue-600 text-white shadow-xs' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200' }}">
            Regulasi
        </a>
        <a href="{{ route('informasi.index', ['tab' => 'faq']) }}" 
           class="px-5 py-2 rounded-xl text-xs font-bold transition-all {{ $tab === 'faq' ? 'bg-blue-600 text-white shadow-xs' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200' }}">
            FAQ
        </a>
    </div>

    <!-- Content Layout Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        
        <!-- Left: Berita Terbaru Section (Col 7) -->
        <div class="lg:col-span-7 bg-white rounded-2xl p-6 border border-slate-200/90 shadow-xs space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <h3 class="text-base font-bold text-slate-900">
                    {{ $tab === 'semua' ? 'Berita Terbaru' : ucfirst($tab) }}
                </h3>
                <span class="text-xs font-semibold text-blue-600">Menampilkan {{ $allInformasi->count() }} Data</span>
            </div>

            <!-- List of Articles -->
            <div class="space-y-4">
                @foreach($allInformasi as $idx => $item)
                <div class="p-4 rounded-xl border border-slate-100 hover:border-blue-200 hover:bg-blue-50/20 transition-all flex flex-col sm:flex-row gap-4 items-start">
                    <!-- Image or Category Icon -->
                    <div class="w-full sm:w-36 h-28 rounded-xl overflow-hidden bg-slate-100 flex-shrink-0 relative">
                        @if($item->gambar && file_exists(public_path('images/' . $item->gambar)))
                            <img src="{{ asset('images/' . $item->gambar) }}" alt="{{ $item->judul }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-blue-100 to-indigo-100 flex items-center justify-center text-blue-600 text-2xl">
                                @if($item->kategori->slug === 'berita')
                                    <i class="fa-regular fa-newspaper"></i>
                                @elseif($item->kategori->slug === 'pengumuman')
                                    <i class="fa-regular fa-bell"></i>
                                @elseif($item->kategori->slug === 'regulasi')
                                    <i class="fa-solid fa-scale-balanced"></i>
                                @else
                                    <i class="fa-solid fa-circle-question"></i>
                                @endif
                            </div>
                        @endif
                        <span class="absolute top-2 left-2 px-2 py-0.5 rounded-md text-[9px] font-bold bg-white/90 backdrop-blur-xs text-slate-700 shadow-xs uppercase">
                            {{ $item->kategori->nama_kategori }}
                        </span>
                    </div>

                    <!-- Article Details -->
                    <div class="flex-1 space-y-1.5">
                        <span class="text-[11px] font-semibold text-slate-400">
                            <i class="fa-regular fa-calendar mr-1"></i> {{ \Carbon\Carbon::parse($item->tanggal_publikasi)->translatedFormat('d M Y') }}
                        </span>
                        <h4 class="text-sm font-extrabold text-slate-900 leading-snug hover:text-blue-600 transition-colors">
                            {{ $item->judul }}
                        </h4>
                        <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed">
                            {{ $item->ringkasan ?? Str::limit(strip_tags($item->isi), 120) }}
                        </p>
                        <div class="pt-2">
                            <button onclick="openInfoModal({{ json_encode($item) }})" class="inline-flex items-center text-xs font-bold text-blue-600 hover:text-blue-800">
                                <span>Lihat Rincian</span>
                                <i class="fa-solid fa-arrow-right text-[10px] ml-1.5"></i>
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Right Side: Pengumuman, Regulasi & FAQ Cards (Col 5) -->
        <div class="lg:col-span-5 space-y-6">
            
            <!-- Pengumuman List Card (Matching Informasi -- DONE.png) -->
            <div class="bg-white rounded-2xl p-5 border border-slate-200/90 shadow-xs space-y-3">
                <div class="flex items-center justify-between pb-2 border-b border-slate-100">
                    <h4 class="text-sm font-bold text-slate-900 flex items-center">
                        <i class="fa-regular fa-bell text-amber-500 mr-2"></i> Pengumuman
                    </h4>
                    <a href="{{ route('informasi.index', ['tab' => 'pengumuman']) }}" class="text-[11px] font-bold text-blue-600 hover:underline">
                        Lihat Semua &rarr;
                    </a>
                </div>

                <div class="space-y-2.5">
                    @foreach($pengumumanList->take(3) as $p)
                    <div onclick="openInfoModal({{ json_encode($p) }})" class="flex items-start space-x-3 p-2.5 rounded-xl hover:bg-slate-50 cursor-pointer transition-colors">
                        <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-500 flex items-center justify-center flex-shrink-0 mt-0.5">
                            <i class="fa-solid fa-bell text-xs"></i>
                        </div>
                        <div class="flex-1">
                            <span class="text-[10px] font-bold text-slate-400 block">{{ \Carbon\Carbon::parse($p->tanggal_publikasi)->translatedFormat('d M Y') }}</span>
                            <h5 class="text-xs font-bold text-slate-800 leading-tight hover:text-blue-600">{{ $p->judul }}</h5>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Regulasi Card (Matching Informasi -- DONE.png) -->
            <div class="bg-white rounded-2xl p-5 border border-slate-200/90 shadow-xs space-y-3">
                <div class="flex items-center justify-between pb-2 border-b border-slate-100">
                    <h4 class="text-sm font-bold text-slate-900 flex items-center">
                        <i class="fa-solid fa-file-contract text-blue-600 mr-2"></i> Regulasi
                    </h4>
                    <a href="{{ route('informasi.index', ['tab' => 'regulasi']) }}" class="text-[11px] font-bold text-blue-600 hover:underline">
                        Lihat Semua &rarr;
                    </a>
                </div>

                <div class="space-y-2.5">
                    @foreach($regulasiList->take(3) as $r)
                    <div onclick="openInfoModal({{ json_encode($r) }})" class="flex items-start space-x-3 p-2.5 rounded-xl hover:bg-slate-50 cursor-pointer transition-colors">
                        <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0 mt-0.5">
                            <i class="fa-regular fa-file-lines text-xs"></i>
                        </div>
                        <div class="flex-1">
                            <h5 class="text-xs font-bold text-slate-800 leading-tight hover:text-blue-600">{{ $r->judul }}</h5>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- FAQ Accordion (Matching Informasi FAQ --- DONE.png) -->
            <div class="bg-white rounded-2xl p-5 border border-slate-200/90 shadow-xs space-y-3">
                <h4 class="text-sm font-bold text-slate-900 flex items-center">
                    <i class="fa-solid fa-circle-question text-teal-600 mr-2"></i> Pertanyaan yang Sering Diajukan (FAQ)
                </h4>

                <div class="space-y-2">
                    @foreach($faqList as $faq)
                    <details class="group bg-slate-50 rounded-xl p-3 border border-slate-100 transition-all">
                        <summary class="flex items-center justify-between cursor-pointer font-bold text-xs text-slate-800 list-none">
                            <span class="flex items-center pr-2">
                                <i class="fa-regular fa-circle-question text-blue-600 mr-2 text-xs"></i>
                                {{ $faq->judul }}
                            </span>
                            <i class="fa-solid fa-chevron-down text-slate-400 text-[10px] group-open:rotate-180 transition-transform"></i>
                        </summary>
                        <p class="text-xs text-slate-600 mt-2 pl-5 pt-2 border-t border-slate-200/60 leading-relaxed whitespace-pre-line">
                            {{ $faq->isi }}
                        </p>
                    </details>
                    @endforeach
                </div>
            </div>

        </div>

    </div>

</div>

<!-- Modal Popup for Article Detail (Matching Informasi Berita -- DONE.png and Informasi Pengumuman -- DONE-1.png) -->
<div id="infoModal" class="hidden fixed inset-0 z-50 bg-black/60 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-2xl w-full p-6 relative shadow-2xl max-h-[90vh] overflow-y-auto">
        <!-- Close Button -->
        <button onclick="closeInfoModal()" class="absolute top-5 right-5 w-8 h-8 rounded-full bg-slate-100 text-slate-500 hover:bg-slate-200 flex items-center justify-center transition-colors">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <!-- Category Badge -->
        <span id="modalKategori" class="inline-block px-3 py-1 rounded-full text-[11px] font-extrabold uppercase bg-blue-100 text-blue-700 mb-3">
            BERITA
        </span>

        <!-- Title -->
        <h3 id="modalJudul" class="text-xl font-black text-slate-900 leading-snug mb-2"></h3>
        
        <p class="text-xs text-slate-400 mb-4">
            Tanggal: <span id="modalTanggal" class="font-semibold text-slate-700"></span> &bull; 
            Penulis: <span id="modalPenulis" class="font-semibold text-slate-700"></span>
        </p>

        <!-- Featured Image -->
        <div id="modalImgContainer" class="w-full h-64 rounded-xl overflow-hidden mb-5 hidden">
            <img id="modalImg" src="" alt="Thumbnail" class="w-full h-full object-cover">
        </div>

        <!-- Body Content -->
        <div id="modalIsi" class="text-xs md:text-sm text-slate-700 leading-relaxed whitespace-pre-line space-y-3"></div>

        <div class="pt-6 mt-6 border-t border-slate-100 text-right">
            <button onclick="closeInfoModal()" class="px-5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold transition-colors">
                Tutup
            </button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function openInfoModal(item) {
        document.getElementById('modalKategori').innerText = item.kategori ? item.kategori.nama_kategori : 'INFORMASI';
        document.getElementById('modalJudul').innerText = item.judul;
        document.getElementById('modalTanggal').innerText = item.tanggal_publikasi;
        document.getElementById('modalPenulis').innerText = item.penulis || 'Humas BAPENDA Karawang';
        document.getElementById('modalIsi').innerText = item.isi;

        const imgContainer = document.getElementById('modalImgContainer');
        const imgEl = document.getElementById('modalImg');
        if (item.gambar) {
            imgEl.src = "{{ asset('images') }}/" + item.gambar;
            imgContainer.classList.remove('hidden');
        } else {
            imgContainer.classList.add('hidden');
        }

        document.getElementById('infoModal').classList.remove('hidden');
    }

    function closeInfoModal() {
        document.getElementById('infoModal').classList.add('hidden');
    }
</script>
@endpush

