<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$tables = [
    'roles', 'permissions', 'role_permissions', 'users', 'log_aktivitas',
    'pengaturan', 'kategori_informasi', 'informasi', 'kecamatan', 'desa',
    'tahun_anggaran', 'target_pajak', 'realisasi_pajak', 'penggunaan_pajak',
    'wajib_pajak', 'jenis_pajak', 'objek_pajak', 'pembayaran_pajak'
];

$sql = "-- =====================================================\n";
$sql .= "-- Database: pbb_p2_karawang\n";
$sql .= "-- Sistem Informasi Geografis & Peta Capaian PBB-P2 Karawang\n";
$sql .= "-- Generated: " . date('Y-m-d H:i:s') . "\n";
$sql .= "-- =====================================================\n\n";

$sql .= "SET FOREIGN_KEY_CHECKS=0;\n\n";

foreach ($tables as $table) {
    $rows = DB::table($table)->get();
    $sql .= "-- -----------------------------------------------------\n";
    $sql .= "-- Data untuk tabel `$table` (" . count($rows) . " baris)\n";
    $sql .= "-- -----------------------------------------------------\n";

    if (count($rows) > 0) {
        $columns = array_keys((array)$rows[0]);
        $colList = implode('`, `', $columns);

        foreach (array_chunk($rows->all(), 50) as $chunk) {
            $sql .= "INSERT INTO `$table` (`$colList`) VALUES\n";
            $valLines = [];
            foreach ($chunk as $row) {
                $vals = [];
                foreach ($columns as $c) {
                    $v = $row->$c;
                    if (is_null($v)) {
                        $vals[] = "NULL";
                    } elseif (is_numeric($v)) {
                        $vals[] = $v;
                    } else {
                        $escaped = str_replace(["\\", "'", "\r", "\n"], ["\\\\", "\\'", "\\r", "\\n"], $v);
                        $vals[] = "'$escaped'";
                    }
                }
                $valLines[] = "  (" . implode(', ', $vals) . ")";
            }
            $sql .= implode(",\n", $valLines) . ";\n";
        }
    }
    $sql .= "\n";
}

$sql .= "SET FOREIGN_KEY_CHECKS=1;\n";

file_put_contents(__DIR__ . '/pbb_p2_karawang.sql', $sql);
echo "SQL export generated successfully at database/pbb_p2_karawang.sql (" . strlen($sql) . " bytes)\n";

