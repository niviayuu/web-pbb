@extends('layouts.app')

@section('title', 'Keamanan Sistem - BAPENDA Karawang')
@section('page-title', 'Keamanan Sistem')
@section('page-subtitle', 'Daftar aktivitas keamanan dan catatan audit akses ke sistem PBB-P2')

@section('content')
<div class="space-y-6">

    <!-- 4 Security Stat Cards (Matching Keamanan Sistem -- DONE.png) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Status Keamanan Akun -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/90 shadow-xs flex items-center space-x-3.5">
            <div class="w-11 h-11 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg flex-shrink-0">
                <i class="fa-solid fa-shield-halved"></i>
            </div>
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Status Keamanan</p>
                <h4 class="text-sm font-black text-emerald-600 mt-0.5 flex items-center">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 mr-1.5 animate-pulse"></span> Aman
                </h4>
            </div>
        </div>

        <!-- Login Terakhir -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/90 shadow-xs flex items-center space-x-3.5">
            <div class="w-11 h-11 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg flex-shrink-0">
                <i class="fa-regular fa-clock"></i>
            </div>
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Login Terakhir</p>
                <h4 class="text-xs font-black text-slate-800 mt-0.5">11 Nov 2026, 14:30 WIB</h4>
            </div>
        </div>

        <!-- Sesi Aktif -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/90 shadow-xs flex items-center space-x-3.5">
            <div class="w-11 h-11 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg flex-shrink-0">
                <i class="fa-solid fa-laptop"></i>
            </div>
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Sesi Aktif</p>
                <h4 class="text-sm font-black text-emerald-600 mt-0.5 flex items-center">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 mr-1.5"></span> 1 Perangkat
                </h4>
            </div>
        </div>

        <!-- Aktivitas Mencurigakan -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/90 shadow-xs flex items-center space-x-3.5">
            <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg flex-shrink-0">
                <i class="fa-solid fa-check"></i>
            </div>
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Aktivitas Mencurigakan</p>
                <h4 class="text-sm font-black text-slate-800 mt-0.5">Tidak Ada</h4>
            </div>
        </div>
    </div>

    <!-- Middle: Riwayat Login Table & Kebijakan Sandi -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        
        <!-- Riwayat Login Table (Col 8) -->
        <div class="lg:col-span-8 bg-white rounded-2xl p-6 border border-slate-200/90 shadow-xs space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                <div class="flex items-center space-x-2.5">
                    <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-xs">
                        <i class="fa-solid fa-clock-rotate-left"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-slate-900">Riwayat Login</h4>
                        <p class="text-[11px] text-slate-400">Catatan aktivitas login ke dalam sistem PBB-P2</p>
                    </div>
                </div>

                <div class="text-xs font-bold text-slate-600 bg-slate-50 border border-slate-200 rounded-xl px-3 py-1.5">
                    <span>7 Hari Terakhir</span>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider border-b border-slate-100">
                        <tr>
                            <th class="py-3 px-3.5">Tanggal dan Waktu</th>
                            <th class="py-3 px-3.5">Pengguna</th>
                            <th class="py-3 px-3.5">Perangkat</th>
                            <th class="py-3 px-3.5">IP Address</th>
                            <th class="py-3 px-3.5">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 font-medium">
                        @foreach($logs as $log)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="py-3 px-3.5 text-slate-700 font-semibold">
                                {{ \Carbon\Carbon::parse($log->waktu)->format('d M Y, H:i') }} WIB
                            </td>
                            <td class="py-3 px-3.5 font-bold text-slate-900">{{ $log->user->nama ?? 'Administrator' }}</td>
                            <td class="py-3 px-3.5 text-slate-600">{{ $log->perangkat ?? 'Chrome-Windows' }}</td>
                            <td class="py-3 px-3.5 font-mono text-slate-500">{{ $log->ip_address ?? '192.168.1.1' }}</td>
                            <td class="py-3 px-3.5">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span>
                                    {{ $log->status }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Kebijakan Kata Sandi Card (Col 4) -->
        <div class="lg:col-span-4 bg-white rounded-2xl p-6 border border-slate-200/90 shadow-xs space-y-4">
            <div class="flex items-center space-x-3 pb-3 border-b border-slate-100">
                <div class="w-9 h-9 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center text-sm">
                    <i class="fa-solid fa-lock"></i>
                </div>
                <div>
                    <h4 class="text-sm font-extrabold text-slate-900">Kebijakan Kata Sandi</h4>
                    <p class="text-[11px] text-slate-400">Ketentuan keamanan kata sandi akun</p>
                </div>
            </div>

            <div class="space-y-3 text-xs">
                <div class="flex items-center space-x-2.5 text-slate-700 font-medium">
                    <i class="fa-solid fa-circle-check text-emerald-500"></i>
                    <span>Minimal 8 karakter</span>
                </div>
                <div class="flex items-center space-x-2.5 text-slate-700 font-medium">
                    <i class="fa-solid fa-circle-check text-emerald-500"></i>
                    <span>Mengandung huruf besar dan kecil</span>
                </div>
                <div class="flex items-center space-x-2.5 text-slate-700 font-medium">
                    <i class="fa-solid fa-circle-check text-emerald-500"></i>
                    <span>Mengandung angka</span>
                </div>
                <div class="flex items-center space-x-2.5 text-slate-700 font-medium">
                    <i class="fa-solid fa-circle-check text-emerald-500"></i>
                    <span>Mengandung simbol (!@#$%^&*)</span>
                </div>
                <div class="flex items-center space-x-2.5 text-slate-700 font-medium">
                    <i class="fa-solid fa-circle-check text-emerald-500"></i>
                    <span>Harus diganti secara berkala (setiap 90 hari)</span>
                </div>
            </div>

            <div class="bg-blue-50/80 border border-blue-100 rounded-xl p-3 text-[11px] text-blue-900 flex items-start space-x-2 mt-4">
                <i class="fa-solid fa-circle-info text-blue-600 mt-0.5 flex-shrink-0"></i>
                <p class="leading-relaxed">
                    Kata sandi yang kuat menjaga keamanan data perpajakan daerah Kabupaten Karawang dari akses yang tidak berhak.
                </p>
            </div>
        </div>

    </div>

    <!-- Bottom: Informasi Keamanan Tambahan & Bar Chart -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-stretch">
        <!-- Informasi Keamanan Tambahan (Col 8) -->
        <div class="lg:col-span-8 bg-white rounded-2xl p-6 border border-slate-200/90 shadow-xs flex flex-col justify-between">
            <div>
                <h4 class="text-sm font-bold text-slate-900 mb-1 flex items-center">
                    <i class="fa-solid fa-shield-cat text-blue-600 mr-2"></i> Informasi Keamanan Tambahan
                </h4>
                <p class="text-xs text-slate-400 mb-4">Detail pengamanan infrastruktur server dan aplikasi</p>

                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 pt-2">
                    <div class="bg-slate-50 rounded-xl p-3 border border-slate-100">
                        <p class="text-[10px] text-slate-400 font-bold uppercase">Versi Sistem</p>
                        <p class="text-xs font-black text-slate-800 mt-1">v1.0.0 (Secure)</p>
                    </div>
                    <div class="bg-slate-50 rounded-xl p-3 border border-slate-100">
                        <p class="text-[10px] text-slate-400 font-bold uppercase">Status Proteksi</p>
                        <p class="text-xs font-black text-emerald-600 mt-1 flex items-center">
                            <i class="fa-solid fa-shield-check mr-1"></i> Aman
                        </p>
                    </div>
                    <div class="bg-slate-50 rounded-xl p-3 border border-slate-100">
                        <p class="text-[10px] text-slate-400 font-bold uppercase">Terakhir Diperbarui</p>
                        <p class="text-xs font-black text-slate-800 mt-1">07 Nov 2026</p>
                    </div>
                    <div class="bg-slate-50 rounded-xl p-3 border border-slate-100">
                        <p class="text-[10px] text-slate-400 font-bold uppercase">Mode Akses</p>
                        <p class="text-xs font-black text-slate-800 mt-1">RBAC Protected</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Aktivitas Akses Terbaru Bar Chart (Col 4) -->
        <div class="lg:col-span-4 bg-white rounded-2xl p-6 border border-slate-200/90 shadow-xs flex flex-col justify-between">
            <h4 class="text-sm font-bold text-slate-900 mb-1 flex items-center">
                <i class="fa-solid fa-chart-simple text-blue-600 mr-2"></i> Aktivitas Akses Terbaru
            </h4>
            <p class="text-xs text-slate-400 mb-3">Ringkasan aktivitas selama 30 hari terakhir</p>

            <div class="h-32 w-full">
                <canvas id="accessBarChart"></canvas>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    const ctxBar = document.getElementById('accessBarChart').getContext('2d');
    new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4'],
            datasets: [{
                data: [65, 58, 72, 85],
                backgroundColor: '#3b82f6',
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: { beginAtZero: true, grid: { color: '#f8fafc' }, ticks: { font: { size: 9 } } },
                x: { grid: { display: false }, ticks: { font: { size: 9 } } }
            },
            plugins: { legend: { display: false } }
        }
    });
</script>
@endpush

