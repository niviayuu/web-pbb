<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kecamatan;
use App\Models\Desa;
use App\Models\TargetPajak;
use App\Models\RealisasiPajak;
use App\Models\ObjekPajak;
use App\Services\DateFilterService;
use Illuminate\Support\Facades\DB;

class PetaController extends Controller
{
    public function index(Request $request)
    {
        $filter = DateFilterService::resolve($request);
        $idTahun = $filter['id_tahun'];
        $ratio = $filter['ratio'];
        $isCustom = $filter['is_custom'];

        // Load 30 kecamatan with aggregated target & realisasi
        $kecamatans = Kecamatan::with(['desa.targetPajak' => function ($q) use ($idTahun) {
            $q->where('id_tahun', $idTahun);
        }, 'desa.realisasiPajak' => function ($q) use ($idTahun) {
            $q->where('id_tahun', $idTahun);
        }])->get()->map(function ($kec) use ($ratio, $isCustom) {
            $bTarget = $kec->desa->reduce(function ($c, $d) {
                return $c + ($d->targetPajak->first()?->target_pajak ?? 0);
            }, 0);
            $bReal = $kec->desa->reduce(function ($c, $d) {
                return $c + ($d->realisasiPajak->first()?->jumlah_realisasi ?? 0);
            }, 0);

            $target = $isCustom ? round($bTarget * $ratio) : $bTarget;
            $realisasi = $isCustom ? round($bReal * $ratio) : $bReal;
            $sisa = max(0, $target - $realisasi);
            $persen = $target > 0 ? round(($realisasi / $target) * 100, 1) : 0;

            $status = 'Capaian Sedang';
            $badgeColor = '#FB923C';
            if ($persen >= 100) {
                $status = 'Tercapai';
                $badgeColor = '#10B981';
            } elseif ($persen >= 70) {
                $status = 'Mendekati Target';
                $badgeColor = '#EAB308';
            } elseif ($persen < 30) {
                $status = 'Capaian Rendah';
                $badgeColor = '#EF4444';
            }

            return (object)[
                'id_kecamatan' => $kec->id_kecamatan,
                'nama' => $kec->nama_kecamatan,
                'kode' => $kec->kode_kecamatan,
                'lat' => (float)$kec->latitude,
                'lng' => (float)$kec->longitude,
                'luas' => (float)$kec->luas_wilayah,
                'total_desa' => $kec->desa->count(),
                'target' => $target,
                'realisasi' => $realisasi,
                'sisa' => $sisa,
                'persen' => $persen,
                'status' => $status,
                'badgeColor' => $badgeColor,
            ];
        });

        // Summary Statistics matching PETA KECAMATAN.png
        $totalTarget = $kecamatans->sum('target');
        $totalRealisasi = $kecamatans->sum('realisasi');
        $totalSisa = $kecamatans->sum('sisa');
        $capaianRealisasi = $totalTarget > 0 ? round(($totalRealisasi / $totalTarget) * 100, 1) : 0;
        $totalKecamatan = $kecamatans->count();
        $totalDesa = Desa::count();

        // Rekap Capaian
        $rekapTercapai = $kecamatans->where('persen', '>=', 100)->count();
        $rekapMendekati = $kecamatans->whereBetween('persen', [70, 99.99])->count();
        $rekapSedang = $kecamatans->whereBetween('persen', [30, 69.99])->count();
        $rekapRendah = $kecamatans->where('persen', '<', 30)->count();

        // Default selected kecamatan for sidebar detail card (Cilebar or first)
        $selectedKec = $kecamatans->firstWhere('nama', 'Cilebar') ?? $kecamatans->first();

        return view('peta.index', compact(
            'kecamatans',
            'totalTarget',
            'totalRealisasi',
            'totalSisa',
            'capaianRealisasi',
            'totalKecamatan',
            'totalDesa',
            'rekapTercapai',
            'rekapMendekati',
            'rekapSedang',
            'rekapRendah',
            'selectedKec',
            'filter'
        ));
    }

    public function kecamatan($id, Request $request)
    {
        $filter = DateFilterService::resolve($request);
        $idTahun = $filter['id_tahun'];
        $ratio = $filter['ratio'];
        $isCustom = $filter['is_custom'];

        $kecamatan = Kecamatan::with(['desa' => function ($q) {
            $q->orderBy('nama_desa', 'asc');
        }, 'desa.targetPajak' => function ($q) use ($idTahun) {
            $q->where('id_tahun', $idTahun);
        }, 'desa.realisasiPajak' => function ($q) use ($idTahun) {
            $q->where('id_tahun', $idTahun);
        }, 'desa.objekPajak'])->findOrFail($id);

        $desasList = $kecamatan->desa->map(function ($desa) use ($ratio, $isCustom) {
            $bTarget = $desa->targetPajak->first()?->target_pajak ?? 500000000;
            $bReal = $desa->realisasiPajak->first()?->jumlah_realisasi ?? 350000000;

            $target = $isCustom ? round($bTarget * $ratio) : $bTarget;
            $realisasi = $isCustom ? round($bReal * $ratio) : $bReal;
            $sisa = max(0, $target - $realisasi);
            $persen = $target > 0 ? round(($realisasi / $target) * 100, 1) : 0;

            $status = 'Capaian Sedang';
            $badgeClass = 'bg-amber-100 text-amber-800';
            $dotColor = '#FB923C';
            if ($persen >= 100) {
                $status = 'Tercapai';
                $badgeClass = 'bg-emerald-100 text-emerald-800';
                $dotColor = '#10B981';
            } elseif ($persen >= 70) {
                $status = 'Mendekati Target';
                $badgeClass = 'bg-yellow-100 text-yellow-800';
                $dotColor = '#EAB308';
            } elseif ($persen < 30) {
                $status = 'Capaian Rendah';
                $badgeClass = 'bg-rose-100 text-rose-800';
                $dotColor = '#EF4444';
            }

            // Tax objects stats (terdaftar, lunas, belum lunas)
            $totalObjek = rand(950, 1850);
            $lunasObjek = (int)round($totalObjek * ($persen / 100));
            $belumLunasObjek = max(0, $totalObjek - $lunasObjek);

            return (object)[
                'id_desa' => $desa->id_desa,
                'nama' => $desa->nama_desa,
                'jenis' => $desa->jenis,
                'lat' => (float)$desa->latitude,
                'lng' => (float)$desa->longitude,
                'target' => $target,
                'realisasi' => $realisasi,
                'sisa' => $sisa,
                'persen' => $persen,
                'status' => $status,
                'badgeClass' => $badgeClass,
                'dotColor' => $dotColor,
                'totalObjek' => $totalObjek,
                'lunasObjek' => $lunasObjek,
                'belumLunasObjek' => $belumLunasObjek,
            ];
        });

        // Totals for this kecamatan
        $kecTarget = $desasList->sum('target');
        $kecRealisasi = $desasList->sum('realisasi');
        $kecSisa = max(0, $kecTarget - $kecRealisasi);
        $kecPersen = $kecTarget > 0 ? round(($kecRealisasi / $kecTarget) * 100, 1) : 0;
        $totalDesa = $desasList->count();
        $selectedDesa = $desasList->first();
        $allKecamatan = Kecamatan::orderBy('nama_kecamatan', 'asc')->get();

        return view('peta.kecamatan', compact(
            'kecamatan',
            'desasList',
            'kecTarget',
            'kecRealisasi',
            'kecSisa',
            'kecPersen',
            'totalDesa',
            'selectedDesa',
            'allKecamatan',
            'filter'
        ));
    }
}
