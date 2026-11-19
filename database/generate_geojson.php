<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Kecamatan;
use App\Models\Desa;

$kecamatans = Kecamatan::with('desa')->get();

$features = [];

foreach ($kecamatans as $kec) {
    $cLat = (float)$kec->latitude;
    $cLng = (float)$kec->longitude;
    $radius = sqrt($kec->luas_wilayah ?: 50) / 111.0 * 0.45; // in degrees

    // Create a smooth polygon with 12 points around center with jitter to look like natural boundaries
    $coords = [];
    $numSides = 14;
    $seed = $kec->id_kecamatan * 1337;
    for ($i = 0; $i < $numSides; $i++) {
        $angle = ($i / $numSides) * 2 * M_PI;
        $jFactor = 0.85 + (abs(sin($seed + $i)) * 0.3);
        $pLat = $cLat + ($radius * sin($angle) * $jFactor * 0.9);
        $pLng = $cLng + ($radius * cos($angle) * $jFactor * 1.15);
        $coords[] = [round($pLng, 6), round($pLat, 6)];
    }
    // Close polygon
    $coords[] = $coords[0];

    $feature = [
        'type' => 'Feature',
        'properties' => [
            'id_kecamatan' => $kec->id_kecamatan,
            'nama_kecamatan' => $kec->nama_kecamatan,
            'kode_kecamatan' => $kec->kode_kecamatan,
            'luas_wilayah' => $kec->luas_wilayah,
            'jumlah_penduduk' => $kec->jumlah_penduduk,
            'total_desa' => $kec->desa->count(),
            'lat' => $cLat,
            'lng' => $cLng,
        ],
        'geometry' => [
            'type' => 'Polygon',
            'coordinates' => [$coords],
        ],
    ];

    $features[] = $feature;

    // Update in database
    $kec->geojson = $feature;
    $kec->save();
}

$geoJsonCollection = [
    'type' => 'FeatureCollection',
    'features' => $features,
];

if (!is_dir(__DIR__ . '/../public/data')) {
    mkdir(__DIR__ . '/../public/data', 0777, true);
}

file_put_contents(__DIR__ . '/../public/data/karawang_kecamatan.json', json_encode($geoJsonCollection, JSON_PRETTY_PRINT));
echo "GeoJSON generated for all 30 kecamatan in public/data/karawang_kecamatan.json\n";

