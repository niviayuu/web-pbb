<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Kecamatan;
use App\Models\Desa;

$kecamatans = Kecamatan::with(['desa.targetPajak', 'desa.realisasiPajak'])->get();

$desaByKecamatan = [];

foreach ($kecamatans as $kec) {
    $desaFeatures = [];
    $totalDesa = $kec->desa->count();

    foreach ($kec->desa as $index => $desa) {
        $cLat = (float)$desa->latitude;
        $cLng = (float)$desa->longitude;
        $radius = 0.012;

        $coords = [];
        $numSides = 10;
        $seed = $desa->id_desa * 997;
        for ($i = 0; $i < $numSides; $i++) {
            $angle = ($i / $numSides) * 2 * M_PI;
            $jFactor = 0.82 + (abs(sin($seed + $i)) * 0.35);
            $pLat = $cLat + ($radius * sin($angle) * $jFactor * 0.9);
            $pLng = $cLng + ($radius * cos($angle) * $jFactor * 1.15);
            $coords[] = [round($pLng, 6), round($pLat, 6)];
        }
        $coords[] = $coords[0];

        $target = $desa->targetPajak->where('id_tahun', 3)->first()?->target_pajak ?? 500000000;
        $realisasi = $desa->realisasiPajak->where('id_tahun', 3)->first()?->jumlah_realisasi ?? 350000000;
        $persen = $target > 0 ? round(($realisasi / $target) * 100, 1) : 0;
        $sisa = max(0, $target - $realisasi);

        $status = 'Capaian Sedang';
        $color = '#FB923C';
        if ($persen >= 100) {
            $status = 'Tercapai';
            $color = '#10B981';
        } elseif ($persen >= 70) {
            $status = 'Mendekati Target';
            $color = '#EAB308';
        } elseif ($persen < 30) {
            $status = 'Capaian Rendah';
            $color = '#EF4444';
        }

        $feature = [
            'type' => 'Feature',
            'properties' => [
                'id_desa' => $desa->id_desa,
                'id_kecamatan' => $desa->id_kecamatan,
                'nama_desa' => $desa->nama_desa,
                'nama_kecamatan' => $kec->nama_kecamatan,
                'kode_desa' => $desa->kode_desa,
                'jenis' => $desa->jenis,
                'target' => $target,
                'realisasi' => $realisasi,
                'sisa' => $sisa,
                'persentase' => $persen,
                'status' => $status,
                'color' => $color,
                'lat' => $cLat,
                'lng' => $cLng,
            ],
            'geometry' => [
                'type' => 'Polygon',
                'coordinates' => [$coords],
            ],
        ];

        $desaFeatures[] = $feature;
        $desa->geojson = $feature;
        $desa->save();
    }

    $desaByKecamatan[$kec->id_kecamatan] = [
        'type' => 'FeatureCollection',
        'features' => $desaFeatures,
    ];
}

file_put_contents(__DIR__ . '/../public/data/karawang_desa_by_kecamatan.json', json_encode($desaByKecamatan, JSON_PRETTY_PRINT));
echo "Generated desa features for all 309 villages in public/data/karawang_desa_by_kecamatan.json\n";

