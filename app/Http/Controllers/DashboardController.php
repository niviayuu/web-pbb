<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kecamatan;
use App\Models\Desa;
use App\Models\TargetPajak;
use App\Models\RealisasiPajak;
use App\Models\PenggunaanPajak;
use App\Models\Informasi;
use App\Services\DateFilterService;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $filter = DateFilterService::resolve($request);
        $idTahun = $filter['id_tahun'];
        $ratio = $filter['ratio'];
        $startDate = $filter['start_date'];
        $endDate = $filter['end_date'];
        $isCustom = $filter['is_custom'];

        // Aggregate targets & realizations
        $baseTarget = TargetPajak::where('id_tahun', $idTahun)->sum('target_pajak');
        $baseRealisasi = RealisasiPajak::where('id_tahun', $idTahun)->sum('jumlah_realisasi');

        // Scale target & realization if a custom sub-period is chosen
        $totalTarget = $isCustom ? round($baseTarget * $ratio) : $baseTarget;
        $totalRealisasi = $isCustom ? round($baseRealisasi * $ratio) : $baseRealisasi;
        $sisaTagihan = max(0, $totalTarget - $totalRealisasi);
        $persenCapaian = $totalTarget > 0 ? round(($totalRealisasi / $totalTarget) * 100, 1) : 0;

        // Breakdown Realisasi per Wilayah (Kecamatan)
        $realisasiPerKecamatan = Kecamatan::with(['desa.targetPajak' => function ($q) use ($idTahun) {
            $q->where('id_tahun', $idTahun);
        }, 'desa.realisasiPajak' => function ($q) use ($idTahun) {
            $q->where('id_tahun', $idTahun);
        }])->get()->map(function ($kec) use ($ratio, $isCustom) {
            $bTarget = $kec->desa->reduce(function ($carry, $d) {
                return $carry + ($d->targetPajak->first()?->target_pajak ?? 0);
            }, 0);
            $bReal = $kec->desa->reduce(function ($carry, $d) {
                return $carry + ($d->realisasiPajak->first()?->jumlah_realisasi ?? 0);
            }, 0);

            $target = $isCustom ? round($bTarget * $ratio) : $bTarget;
            $realisasi = $isCustom ? round($bReal * $ratio) : $bReal;
            $persen = $target > 0 ? round(($realisasi / $target) * 100, 1) : 0;

            return (object)[
                'id_kecamatan' => $kec->id_kecamatan,
                'nama' => $kec->nama_kecamatan,
                'target' => $target,
                'realisasi' => $realisasi,
                'persen' => $persen,
                'desa_count' => $kec->desa->count(),
            ];
        })->sortByDesc('realisasi')->values();

        // Penggunaan Pajak Breakdown
        $penggunaan = PenggunaanPajak::where('id_tahun', $idTahun)->get()->map(function ($p) use ($ratio, $isCustom) {
            if ($isCustom) {
                $p->jumlah_anggaran = round($p->jumlah_anggaran * $ratio);
                $p->jumlah_realisasi = round($p->jumlah_realisasi * $ratio);
            }
            return $p;
        });
        $totalPenggunaan = $penggunaan->sum('jumlah_realisasi');

        // Berita & Pengumuman Penting within date range or fallback to latest
        $infoQuery = Informasi::with('kategori')->where('status', 'Publik');
        if ($isCustom) {
            $infoQuery->whereBetween('tanggal_publikasi', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
        }
        $infoPenting = $infoQuery->orderBy('tanggal_publikasi', 'desc')->take(3)->get();
        if ($infoPenting->isEmpty()) {
            $infoPenting = Informasi::with('kategori')
                ->where('status', 'Publik')
                ->orderBy('tanggal_publikasi', 'desc')
                ->take(3)
                ->get();
        }

        return view('dashboard.index', compact(
            'totalTarget',
            'totalRealisasi',
            'sisaTagihan',
            'persenCapaian',
            'realisasiPerKecamatan',
            'penggunaan',
            'totalPenggunaan',
            'infoPenting',
            'filter'
        ));
    }
}
