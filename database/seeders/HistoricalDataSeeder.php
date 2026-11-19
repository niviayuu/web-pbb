<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HistoricalDataSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        // 1. Check existing targets for 2026 (id_tahun = 3)
        $targets2026 = DB::table('target_pajak')->where('id_tahun', 3)->get();
        if ($targets2026->isEmpty()) {
            return;
        }

        // 2. Populate 2025 (id_tahun = 2) if empty
        $count2025 = DB::table('target_pajak')->where('id_tahun', 2)->count();
        if ($count2025 === 0) {
            foreach ($targets2026 as $t) {
                $target2025 = round($t->target_pajak * 0.92, -5);
                $real2025 = round($target2025 * (0.93 + (rand(1, 10) / 100)), -5);
                $persen2025 = round(($real2025 / max(1, $target2025)) * 100, 2);

                DB::table('target_pajak')->insert([
                    'id_desa' => $t->id_desa,
                    'id_tahun' => 2,
                    'target_pajak' => $target2025,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);

                DB::table('realisasi_pajak')->insert([
                    'id_desa' => $t->id_desa,
                    'id_tahun' => 2,
                    'jumlah_realisasi' => $real2025,
                    'persentase' => $persen2025,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }

        // 3. Populate 2024 (id_tahun = 1) if empty
        $count2024 = DB::table('target_pajak')->where('id_tahun', 1)->count();
        if ($count2024 === 0) {
            foreach ($targets2026 as $t) {
                $target2024 = round($t->target_pajak * 0.84, -5);
                $real2024 = round($target2024 * (0.95 + (rand(1, 8) / 100)), -5);
                $persen2024 = round(($real2024 / max(1, $target2024)) * 100, 2);

                DB::table('target_pajak')->insert([
                    'id_desa' => $t->id_desa,
                    'id_tahun' => 1,
                    'target_pajak' => $target2024,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);

                DB::table('realisasi_pajak')->insert([
                    'id_desa' => $t->id_desa,
                    'id_tahun' => 1,
                    'jumlah_realisasi' => $real2024,
                    'persentase' => $persen2024,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }

        // 4. Populate Penggunaan Pajak for 2025 and 2024 if empty
        if (DB::table('penggunaan_pajak')->where('id_tahun', 2)->count() === 0) {
            $penggunaan2026 = DB::table('penggunaan_pajak')->where('id_tahun', 3)->get();
            foreach ($penggunaan2026 as $p) {
                DB::table('penggunaan_pajak')->insert([
                    'id_tahun' => 2,
                    'nama_program' => $p->nama_program,
                    'bidang_penggunaan' => $p->bidang_penggunaan,
                    'jumlah_anggaran' => round($p->jumlah_anggaran * 0.91),
                    'jumlah_realisasi' => round($p->jumlah_realisasi * 0.94),
                    'keterangan' => 'Penyaluran APBD Dana Bagi Hasil PBB-P2 TA 2025',
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);

                DB::table('penggunaan_pajak')->insert([
                    'id_tahun' => 1,
                    'nama_program' => $p->nama_program,
                    'bidang_penggunaan' => $p->bidang_penggunaan,
                    'jumlah_anggaran' => round($p->jumlah_anggaran * 0.83),
                    'jumlah_realisasi' => round($p->jumlah_realisasi * 0.85),
                    'keterangan' => 'Penyaluran APBD Dana Bagi Hasil PBB-P2 TA 2024',
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }
    }
}

