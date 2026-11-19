<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TargetPajak extends Model
{
    protected $table = 'target_pajak';
    protected $primaryKey = 'id_target';

    protected $fillable = [
        'id_desa',
        'id_tahun',
        'target_pajak',
    ];

    protected function casts(): array
    {
        return [
            'target_pajak' => 'float',
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

