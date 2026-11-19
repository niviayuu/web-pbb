<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PenggunaanPajak extends Model
{
    protected $table = 'penggunaan_pajak';
    protected $primaryKey = 'id_penggunaan';

    protected $fillable = [
        'id_tahun',
        'nama_program',
        'bidang_penggunaan',
        'jumlah_anggaran',
        'jumlah_realisasi',
        'bulan',
        'keterangan',
    ];

    protected function casts(): array
    {
        return [
            'jumlah_anggaran' => 'float',
            'jumlah_realisasi' => 'float',
        ];
    }

    public function tahunAnggaran(): BelongsTo
    {
        return $this->belongsTo(TahunAnggaran::class, 'id_tahun', 'id_tahun');
    }
}

