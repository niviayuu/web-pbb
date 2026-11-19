@extends('layouts.app')

@section('title', 'Manajemen Pengguna - BAPENDA Karawang')
@section('page-title', 'Manajemen Pengguna')
@section('page-subtitle', 'Daftar pengguna yang memiliki akses ke sistem PBB-P2')

@section('content')
<div class="space-y-6">

    <!-- 3 Stat Cards (Matching Pengaturan Sistem -- DONE.png) -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
        <!-- Total Pengguna -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/90 shadow-xs flex items-center space-x-4">
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl flex-shrink-0">
                <i class="fa-solid fa-users"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Pengguna</p>
                <h3 class="text-2xl font-black text-slate-900 mt-0.5">{{ $totalUsers }}</h3>
            </div>
        </div>

        <!-- Pengguna Aktif -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/90 shadow-xs flex items-center space-x-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl flex-shrink-0">
                <i class="fa-solid fa-user-check"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Pengguna Aktif</p>
                <h3 class="text-2xl font-black text-emerald-600 mt-0.5">{{ $aktifUsers }}</h3>
            </div>
        </div>

        <!-- Pengguna Nonaktif -->
        <div class="bg-white rounded-2xl p-5 border border-slate-200/90 shadow-xs flex items-center space-x-4">
            <div class="w-12 h-12 rounded-xl bg-slate-100 text-slate-500 flex items-center justify-center text-xl flex-shrink-0">
                <i class="fa-solid fa-user-slash"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Pengguna Nonaktif</p>
                <h3 class="text-2xl font-black text-slate-600 mt-0.5">{{ $nonaktifUsers }}</h3>
            </div>
        </div>
    </div>

    <!-- Table of Users (Matching Pengaturan Sistem -- DONE.png) -->
    <div class="bg-white rounded-2xl p-6 border border-slate-200/90 shadow-xs space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div class="flex items-center space-x-3">
                <div class="w-9 h-9 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center text-base">
                    <i class="fa-regular fa-user"></i>
                </div>
                <h3 class="text-base font-extrabold text-slate-900">Daftar Pengguna</h3>
            </div>

            <!-- Search Field -->
            <div class="relative w-full sm:w-64">
                <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3 text-slate-400 text-xs"></i>
                <input type="text" id="searchUser" placeholder="Cari nama pengguna..." 
                       class="w-full pl-9 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium focus:ring-2 focus:ring-blue-500 outline-none">
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 text-slate-500 font-bold uppercase tracking-wider border-b border-slate-100">
                    <tr>
                        <th class="py-3.5 px-4 w-12">No</th>
                        <th class="py-3.5 px-4">Nama Pengguna</th>
                        <th class="py-3.5 px-4">Email</th>
                        <th class="py-3.5 px-4">Peran</th>
                        <th class="py-3.5 px-4">Status</th>
                        <th class="py-3.5 px-4">Terakhir Login</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-medium">
                    @foreach($users as $idx => $u)
                    <tr class="user-row hover:bg-slate-50/70 transition-colors" data-nama="{{ strtolower($u->nama) }}">
                        <td class="py-3.5 px-4 text-slate-400">{{ $idx + 1 }}</td>
                        <td class="py-3.5 px-4 font-bold text-slate-900">{{ $u->nama }}</td>
                        <td class="py-3.5 px-4 text-slate-600 font-mono">{{ $u->email }}</td>
                        <td class="py-3.5 px-4">
                            @php
                                $roleBadge = 'bg-blue-100 text-blue-800';
                                if ($u->role?->nama_role === 'Administrator') $roleBadge = 'bg-blue-100 text-blue-800';
                                elseif ($u->role?->nama_role === 'Operator') $roleBadge = 'bg-sky-100 text-sky-800';
                                else $roleBadge = 'bg-purple-100 text-purple-800';
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-bold {{ $roleBadge }}">
                                <i class="fa-solid fa-user-shield text-[9px] mr-1.5"></i>
                                {{ $u->role->nama_role ?? 'Pengguna' }}
                            </span>
                        </td>
                        <td class="py-3.5 px-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold {{ $u->status === 'Aktif' ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-200 text-slate-700' }}">
                                <span class="w-1.5 h-1.5 rounded-full {{ $u->status === 'Aktif' ? 'bg-emerald-500' : 'bg-slate-400' }} mr-1.5"></span>
                                {{ $u->status }}
                            </span>
                        </td>
                        <td class="py-3.5 px-4 text-slate-500 font-semibold">
                            11 Nov 2026, 14:30 WIB
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
            <span>Menampilkan 1-{{ $users->count() }} dari {{ $users->count() }} data</span>
            <div class="flex items-center space-x-1">
                <button class="px-2.5 py-1 rounded-lg border border-slate-200 bg-slate-50 text-slate-400" disabled>&lsaquo;</button>
                <button class="px-3 py-1 rounded-lg bg-blue-600 text-white font-bold">1</button>
                <button class="px-2.5 py-1 rounded-lg border border-slate-200 bg-slate-50 text-slate-400" disabled>&rsaquo;</button>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    document.getElementById('searchUser').addEventListener('input', function(e) {
        const query = e.target.value.toLowerCase().trim();
        document.querySelectorAll('.user-row').forEach(row => {
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

