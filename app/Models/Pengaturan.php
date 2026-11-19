<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pengaturan extends Model
{
    protected $table = 'pengaturan';
    protected $primaryKey = 'id_pengaturan';

    protected $fillable = [
        'id_user',
        'nama_pengaturan',
        'nilai_pengaturan',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}

