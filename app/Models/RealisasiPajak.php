<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RealisasiPajak extends Model
{
    protected $table = 'realisasi_pajak';
    protected $primaryKey = 'id_realisasi';

    protected $fillable = [
        'id_desa',
        'id_tahun',
        'jumlah_realisasi',
        'persentase',
    ];

    protected function casts(): array
    {
        return [
            'jumlah_realisasi' => 'float',
            'persentase' => 'float',
        ];
    }

    public function desa(): BelongsTo
    {
        return $this->belongsTo(Desa::class, 'id_desa', 'id_desa');
    }

    public function tahunAnggaran(): BelongsTo
    {
        return $this->belongsTo(TahunAnggaran::class, 'id_tahun', 'id_tahun');
    }
}

