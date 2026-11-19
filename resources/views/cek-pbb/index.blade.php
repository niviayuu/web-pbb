@extends('layouts.app')

@section('title', 'Cek PBB Online - BAPENDA Karawang')
@section('page-title', 'Cek PBB Online')
@section('page-subtitle', 'Pengecekan mandiri status ketetapan, tagihan, dan riwayat pembayaran PBB-P2 Kabupaten Karawang.')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Search Header Card -->
    <div class="bg-gradient-to-r from-blue-700 via-blue-600 to-indigo-700 text-white rounded-2xl p-7 shadow-lg">
        <div class="max-w-xl">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-white/20 backdrop-blur-md mb-3">
                <i class="fa-solid fa-magnifying-glass mr-1.5"></i> Layanan Mandiri Wajib Pajak
            </span>
            <h2 class="text-2xl font-black mb-2">Cek Status Tagihan PBB-P2</h2>
            <p class="text-xs text-blue-100 leading-relaxed mb-6">
                Masukkan 18 digit Nomor Objek Pajak (NOP) yang tertera pada lembar SPPT Anda untuk melihat ketetapan dan rincian pembayaran.
            </p>

            <form action="{{ route('cek-pbb.index') }}" method="GET" class="space-y-3">
                <div class="flex flex-col sm:flex-row gap-2">
                    <div class="relative flex-1">
                        <i class="fa-solid fa-barcode absolute left-4 top-3.5 text-slate-400"></i>
                        <input type="text" name="nop" value="{{ $nop }}" required placeholder="Contoh: 32.15.001.001.001-0001.0" 
                               class="w-full pl-11 pr-4 py-3 bg-white text-slate-900 rounded-xl text-xs sm:text-sm font-bold placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-yellow-400 shadow-md">
                    </div>
                    <select name="tahun" class="px-4 py-3 bg-white text-slate-800 rounded-xl text-xs sm:text-sm font-bold focus:outline-none shadow-md">
                        <option value="2026" {{ $tahun == '2026' ? 'selected' : '' }}>Tahun 2026</option>
                        <option value="2025" {{ $tahun == '2025' ? 'selected' : '' }}>Tahun 2025</option>
                        <option value="2024" {{ $tahun == '2024' ? 'selected' : '' }}>Tahun 2024</option>
                    </select>
                    <button type="submit" class="px-6 py-3 bg-yellow-400 hover:bg-yellow-500 text-slate-900 font-extrabold rounded-xl text-xs sm:text-sm shadow-md transition-all flex items-center justify-center space-x-2">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <span>Cari NOP</span>
                    </button>
                </div>
            </form>

            @if(count($sampleNops) > 0)
            <div class="mt-4 pt-3 border-t border-white/20 flex flex-wrap items-center gap-2 text-xs">
                <span class="text-blue-200 text-[11px]">Contoh NOP Cepat:</span>
                @foreach($sampleNops as $sNop)
                    <a href="{{ route('cek-pbb.index', ['nop' => $sNop, 'tahun' => 2026]) }}" class="px-2.5 py-1 rounded-lg bg-white/10 hover:bg-white/20 text-white font-mono text-[11px] font-semibold transition-colors">
                        {{ $sNop }}
                    </a>
                @endforeach
            </div>
            @endif
        </div>
    </div>

    <!-- Search Result Card -->
    @if($nop)
        @if($objekPajak)
        <div class="bg-white rounded-2xl border border-slate-200/90 shadow-md overflow-hidden">
            <!-- Header Result Status -->
            <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 {{ $pembayaran ? 'bg-emerald-50/50' : 'bg-rose-50/50' }}">
                <div class="flex items-center space-x-3.5">
                    <div class="w-12 h-12 rounded-xl {{ $pembayaran ? 'bg-emerald-100 text-emerald-600' : 'bg-rose-100 text-rose-600' }} flex items-center justify-center text-xl shadow-xs">
                        <i class="fa-solid {{ $pembayaran ? 'fa-circle-check' : 'fa-circle-exclamation' }}"></i>
                    </div>
                    <div>
                        <span class="text-[11px] font-bold uppercase tracking-wider {{ $pembayaran ? 'text-emerald-700' : 'text-rose-700' }}">Status Pajak Tahun {{ $tahun }}</span>
                        <h3 class="text-xl font-black {{ $pembayaran ? 'text-emerald-800' : 'text-rose-800' }}">
                            {{ $pembayaran ? 'LUNAS TERBAYAR' : 'BELUM DIBAYAR (TERHUTANG)' }}
                        </h3>
                    </div>
                </div>

                <div class="text-left sm:text-right">
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Ketetapan Pajak</p>
                    <h2 class="text-2xl font-black text-slate-900">Rp{{ number_format($objekPajak->nilai_pajak, 0, ',', '.') }}</h2>
                </div>
            </div>

            <!-- Details Section -->
            <div class="p-6 space-y-6">
                <!-- 2 Column Details: Wajib Pajak & Objek Pajak -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Data Wajib Pajak -->
                    <div class="bg-slate-50 rounded-xl p-4 border border-slate-100 space-y-2.5 text-xs">
                        <h4 class="font-extrabold text-slate-900 text-sm flex items-center pb-2 border-b border-slate-200/80">
                            <i class="fa-regular fa-user text-blue-600 mr-2"></i> Data Wajib Pajak
                        </h4>
                        <div class="flex justify-between">
                            <span class="text-slate-500">Nama Wajib Pajak:</span>
                            <span class="font-bold text-slate-900">{{ $objekPajak->wajibPajak->nama_wajib_pajak }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">NIK / NPWP:</span>
                            <span class="font-mono text-slate-800">{{ $objekPajak->wajibPajak->nik_npwp ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">Alamat WP:</span>
                            <span class="font-medium text-slate-800 text-right">{{ $objekPajak->wajibPajak->alamat }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">No. Telepon:</span>
                            <span class="font-medium text-slate-800">{{ $objekPajak->wajibPajak->no_telepon ?? '-' }}</span>
                        </div>
                    </div>

                    <!-- Data Objek Pajak -->
                    <div class="bg-slate-50 rounded-xl p-4 border border-slate-100 space-y-2.5 text-xs">
                        <h4 class="font-extrabold text-slate-900 text-sm flex items-center pb-2 border-b border-slate-200/80">
                            <i class="fa-solid fa-map-location-dot text-indigo-600 mr-2"></i> Data Objek Pajak
                        </h4>
                        <div class="flex justify-between">
                            <span class="text-slate-500">Nomor Objek Pajak:</span>
                            <span class="font-mono font-bold text-blue-600">{{ $objekPajak->nop }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">Letak Objek:</span>
                            <span class="font-medium text-slate-800 text-right">{{ $objekPajak->alamat_objek }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">Wilayah:</span>
                            <span class="font-bold text-slate-900">
                                Desa {{ $objekPajak->desa->nama_desa ?? '-' }}, Kec. {{ $objekPajak->desa->kecamatan->nama_kecamatan ?? '-' }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">Luas Bumi / Bangunan:</span>
                            <span class="font-bold text-slate-900">{{ $objekPajak->luas_bumi }} m² / {{ $objekPajak->luas_bangunan }} m²</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">Sektor:</span>
                            <span class="font-semibold text-slate-700">{{ $objekPajak->jenisPajak->nama_jenis_pajak }}</span>
                        </div>
                    </div>
                </div>

                <!-- Payment Action or Receipt Details -->
                @if($pembayaran)
                <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-4 space-y-2 text-xs">
                    <h5 class="font-bold text-emerald-900 flex items-center">
                        <i class="fa-solid fa-receipt mr-2 text-emerald-600"></i> Bukti Transaksi Pembayaran Resmi
                    </h5>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 pt-2 text-slate-700">
                        <div>
                            <span class="text-slate-400 block text-[10px] uppercase">Nomor Transaksi</span>
                            <span class="font-mono font-bold">{{ $pembayaran->nomor_transaksi }}</span>
                        </div>
                        <div>
                            <span class="text-slate-400 block text-[10px] uppercase">Tanggal Bayar</span>
                            <span class="font-bold">{{ \Carbon\Carbon::parse($pembayaran->tanggal_bayar)->translatedFormat('d F Y') }}</span>
                        </div>
                        <div>
                            <span class="text-slate-400 block text-[10px] uppercase">Metode Pembayaran</span>
                            <span class="font-bold">{{ $pembayaran->metode_pembayaran }}</span>
                        </div>
                        <div>
                            <span class="text-slate-400 block text-[10px] uppercase">Jumlah Bayar</span>
                            <span class="font-bold text-emerald-700">Rp{{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
                @else
                <!-- Unpaid: Payment Simulation Form -->
                <div class="bg-rose-50 border border-rose-200 rounded-xl p-5 space-y-4">
                    <div>
                        <h4 class="font-bold text-rose-900 text-sm">Pembayaran PBB-P2 Online</h4>
                        <p class="text-xs text-rose-700 mt-0.5">Selesaikan kewajiban pajak Anda untuk mendukung percepatan pembangunan infrastruktur Karawang.</p>
                    </div>

                    <form action="{{ route('cek-pbb.bayar', $objekPajak->id_objek_pajak) }}" method="POST" class="flex flex-wrap items-center gap-3">
                        @csrf
                        <input type="hidden" name="tahun_pajak" value="{{ $tahun }}">
                        <select name="metode" class="bg-white border border-rose-200 rounded-xl px-3 py-2 text-xs font-semibold text-slate-800 outline-none">
                            <option value="Bank BJB Digi">Bank BJB Digi</option>
                            <option value="QRIS BJB">QRIS (Semua E-Wallet / Mobile Banking)</option>
                            <option value="Kantor Pos Indonesia">Kantor Pos Indonesia</option>
                            <option value="Gerai Indomaret / Alfamart">Gerai Minimarket</option>
                        </select>
                        <button type="submit" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-xs font-bold shadow-md transition-colors flex items-center space-x-2">
                            <i class="fa-solid fa-credit-card"></i>
                            <span>Bayar Sekarang (Rp{{ number_format($objekPajak->nilai_pajak, 0, ',', '.') }})</span>
                        </button>
                    </form>
                </div>
                @endif
            </div>
        </div>
        @else
        <div class="bg-white rounded-2xl border border-slate-200/90 p-12 text-center shadow-xs">
            <div class="w-16 h-16 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center text-2xl mx-auto mb-4">
                <i class="fa-solid fa-file-circle-xmark"></i>
            </div>
            <h3 class="text-base font-bold text-slate-800">NOP Tidak Ditemukan</h3>
            <p class="text-xs text-slate-500 max-w-md mx-auto mt-1">
                Data objek pajak dengan nomor <strong>{{ $nop }}</strong> tidak ditemukan dalam basis data tahun {{ $tahun }}. Mohon periksa kembali 18 digit NOP Anda.
            </p>
        </div>
        @endif
    @endif

</div>
@endsection

