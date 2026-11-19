<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kecamatan;
use App\Models\TahunAnggaran;
use App\Models\TargetPajak;
use App\Models\RealisasiPajak;
use App\Services\DateFilterService;

class RealisasiTargetController extends Controller
{
    public function index(Request $request)
    {
        $filter = DateFilterService::resolve($request);
        $tahunList = TahunAnggaran::orderBy('tahun', 'desc')->get();
        $selectedTahunId = $filter['id_tahun'];
        $selectedTahun = TahunAnggaran::find($selectedTahunId) ?? $tahunList->first();
        $ratio = $filter['ratio'];
        $isCustom = $filter['is_custom'];

        $search = $request->get('search');

        $kecamatansQuery = Kecamatan::with(['desa.targetPajak' => function ($q) use ($selectedTahunId) {
            $q->where('id_tahun', $selectedTahunId);
        }, 'desa.realisasiPajak' => function ($q) use ($selectedTahunId) {
            $q->where('id_tahun', $selectedTahunId);
        }]);

        if ($search) {
            $kecamatansQuery->where('nama_kecamatan', 'like', "%{$search}%");
        }

        $kecamatans = $kecamatansQuery->get()->map(function ($kec) use ($ratio, $isCustom) {
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
            if ($persen >= 100) $status = 'Tercapai';
            elseif ($persen >= 70) $status = 'Mendekati Target';
            elseif ($persen < 30) $status = 'Capaian Rendah';

            return (object)[
                'id_kecamatan' => $kec->id_kecamatan,
                'nama' => $kec->nama_kecamatan,
                'kode' => $kec->kode_kecamatan,
                'total_desa' => $kec->desa->count(),
                'target' => $target,
                'realisasi' => $realisasi,
                'sisa' => $sisa,
                'persen' => $persen,
                'status' => $status,
            ];
        })->sortByDesc('realisasi')->values();

        $totalTarget = $kecamatans->sum('target');
        $totalRealisasi = $kecamatans->sum('realisasi');
        $totalSisa = $kecamatans->sum('sisa');
        $persenTotal = $totalTarget > 0 ? round(($totalRealisasi / $totalTarget) * 100, 1) : 0;
        $capaianRata = $persenTotal;

        return view('realisasi.index', compact(
            'tahunList',
            'selectedTahun',
            'kecamatans',
            'totalTarget',
            'totalRealisasi',
            'totalSisa',
            'persenTotal',
            'capaianRata',
            'search',
            'filter'
        ));
    }
}
