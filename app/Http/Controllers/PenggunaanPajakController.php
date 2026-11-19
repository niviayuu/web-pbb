<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PenggunaanPajak;
use App\Models\TahunAnggaran;
use App\Services\DateFilterService;

class PenggunaanPajakController extends Controller
{
    public function index(Request $request)
    {
        $filter = DateFilterService::resolve($request);
        $idTahun = $filter['id_tahun'];
        $ratio = $filter['ratio'];
        $isCustom = $filter['is_custom'];

        $penggunaan = PenggunaanPajak::where('id_tahun', $idTahun)->get()->map(function ($p) use ($ratio, $isCustom) {
            if ($isCustom) {
                $p->jumlah_anggaran = round($p->jumlah_anggaran * $ratio);
                $p->jumlah_realisasi = round($p->jumlah_realisasi * $ratio);
            }
            return $p;
        });

        $totalPenerimaan = round(292942200000 * ($isCustom ? $ratio : 1.0));
        $totalPenggunaan = $penggunaan->sum('jumlah_realisasi');
        $sisaDana = max(0, $totalPenerimaan - $totalPenggunaan);
        $persenTerserap = $totalPenerimaan > 0 ? round(($totalPenggunaan / $totalPenerimaan) * 100, 1) : 0;

        // Monthly trends for the 12-month line chart
        $monthlyLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agust', 'Sep', 'Okt', 'Nov', 'Des'];
        $basePenerimaan = [180, 210, 215, 215, 220, 240, 290, 292, 310, 325, 340, 370];
        $basePenggunaan = [120, 140, 145, 145, 148, 175, 210, 212, 235, 260, 275, 288];

        $monthlyPenerimaan = array_map(fn($v) => round($v * ($isCustom ? max(0.2, $ratio) : 1.0)), $basePenerimaan);
        $monthlyPenggunaan = array_map(fn($v) => round($v * ($isCustom ? max(0.2, $ratio) : 1.0)), $basePenggunaan);

        return view('penggunaan.index', compact(
            'penggunaan',
            'totalPenerimaan',
            'totalPenggunaan',
            'sisaDana',
            'persenTerserap',
            'monthlyLabels',
            'monthlyPenerimaan',
            'monthlyPenggunaan',
            'filter'
        ));
    }

    public function download(Request $request)
    {
        $filter = DateFilterService::resolve($request);
        $idTahun = $filter['id_tahun'];
        $ratio = $filter['ratio'];
        $isCustom = $filter['is_custom'];

        $penggunaan = PenggunaanPajak::where('id_tahun', $idTahun)->get()->map(function ($p) use ($ratio, $isCustom) {
            if ($isCustom) {
                $p->jumlah_anggaran = round($p->jumlah_anggaran * $ratio);
                $p->jumlah_realisasi = round($p->jumlah_realisasi * $ratio);
            }
            return $p;
        });

        return view('penggunaan.cetak', compact('penggunaan', 'filter'));
    }
}
