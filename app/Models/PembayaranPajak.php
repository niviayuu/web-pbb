<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PembayaranPajak extends Model
{
    protected $table = 'pembayaran_pajak';
    protected $primaryKey = 'id_pembayaran';

    protected $fillable = [
        'id_objek_pajak',
        'tanggal_bayar',
        'tahun_pajak',
        'jumlah_bayar',
        'status_pembayaran',
        'metode_pembayaran',
        'nomor_transaksi',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_bayar' => 'date',
            'jumlah_bayar' => 'float',
            'tahun_pajak' => 'integer',
        ];
    }

    public function objekPajak(): BelongsTo
    {
        return $this->belongsTo(ObjekPajak::class, 'id_objek_pajak', 'id_objek_pajak');
    }
}

