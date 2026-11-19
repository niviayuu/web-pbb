<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JenisPajak extends Model
{
    protected $table = 'jenis_pajak';
    protected $primaryKey = 'id_jenis_pajak';

    protected $fillable = [
        'nama_jenis_pajak',
        'keterangan',
    ];

    public function objekPajak(): HasMany
    {
        return $this->hasMany(ObjekPajak::class, 'id_jenis_pajak', 'id_jenis_pajak');
    }
}

