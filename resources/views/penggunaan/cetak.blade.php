<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Realisasi Penggunaan Dana PBB-P2 TA 2026</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body class="bg-white p-8 max-w-4xl mx-auto text-slate-900 font-sans">
    <div class="no-print mb-6 flex justify-between items-center pb-4 border-b border-slate-200">
        <a href="{{ route('penggunaan.index') }}" class="text-xs font-bold text-blue-600">&larr; Kembali ke Sistem</a>
        <button onclick="window.print()" class="px-4 py-2 bg-blue-600 text-white rounded-xl text-xs font-bold shadow">
            Cetak / Simpan PDF
        </button>
    </div>

    <!-- Official Header with Karawang Emblem -->
    <div class="flex items-center space-x-5 pb-5 border-b-2 border-slate-900 mb-6">
        <img src="{{ asset('images/logo-karawang.png') }}" alt="Lambang Kabupaten Karawang" class="h-20 w-auto object-contain flex-shrink-0">
        <div class="text-center flex-1 pr-6">
            <h2 class="text-base font-bold uppercase tracking-wider text-slate-800">Pemerintah Kabupaten Karawang</h2>
            <h1 class="text-xl font-extrabold uppercase text-slate-900">Badan Pendapatan Daerah (BAPENDA)</h1>
            <p class="text-xs text-slate-600">Jl. Jend. A. Yani No. 1, Nagasari, Kec. Karawang Barat, Karawang 41312</p>
            <p class="text-xs text-slate-500 font-medium mt-0.5">Laporan Resmi Realisasi Alokasi Dana Bagi Hasil PBB-P2</p>
        </div>
    </div>

    <div class="space-y-4">
        <div class="grid grid-cols-2 text-xs">
            <div>
                <p><span class="font-bold">Total Penerimaan:</span> Rp292.942.200.000,00</p>
                <p><span class="font-bold">Total Penggunaan:</span> Rp247.560.800.000,00</p>
            </div>
            <div class="text-right">
                <p><span class="font-bold">Sisa Alokasi:</span> Rp45.381.400.000,00</p>
                <p><span class="font-bold">Persentase Terserap:</span> 84,5%</p>
            </div>
        </div>

        <table class="w-full text-xs border border-slate-300 mt-4">
            <thead>
                <tr class="bg-slate-100 border-b border-slate-300">
                    <th class="p-2 border-r border-slate-300 w-10 text-center">No</th>
                    <th class="p-2 border-r border-slate-300 text-left">Program / Bidang Penggunaan</th>
                    <th class="p-2 border-r border-slate-300 text-right">Pagu Anggaran</th>
                    <th class="p-2 border-r border-slate-300 text-right">Realisasi Dana</th>
                    <th class="p-2 text-center w-24">Capaian %</th>
                </tr>
            </thead>
            <tbody>
                @foreach($penggunaan as $idx => $p)
                <tr class="border-b border-slate-200">
                    <td class="p-2 border-r border-slate-300 text-center">{{ $idx + 1 }}</td>
                    <td class="p-2 border-r border-slate-300 font-semibold">{{ $p->nama_program }}</td>
                    <td class="p-2 border-r border-slate-300 text-right">Rp{{ number_format($p->jumlah_anggaran, 0, ',', '.') }}</td>
                    <td class="p-2 border-r border-slate-300 text-right font-bold">Rp{{ number_format($p->jumlah_realisasi, 0, ',', '.') }}</td>
                    <td class="p-2 text-center font-bold text-emerald-700">
                        {{ $p->jumlah_anggaran > 0 ? round(($p->jumlah_realisasi / $p->jumlah_anggaran) * 100, 1) : 0 }}%
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="pt-8 grid grid-cols-2 text-center text-xs">
            <div>
                <p>Mengetahui,</p>
                <p class="font-bold">Kepala BAPENDA Karawang</p>
                <div class="h-16"></div>
                <p class="font-bold underline">H. Aep Syaepuloh, SE</p>
                <p class="text-slate-500">NIP. 19750812 199803 1 004</p>
            </div>
            <div>
                <p>Karawang, {{ date('d F Y') }}</p>
                <p class="font-bold">Pejabat Pembuat Komitmen</p>
                <div class="h-16"></div>
                <p class="font-bold underline">Drs. H. Hendra Gunawan, M.Si</p>
                <p class="text-slate-500">NIP. 19800415 200501 1 008</p>
            </div>
        </div>
    </div>
</body>
</html>

