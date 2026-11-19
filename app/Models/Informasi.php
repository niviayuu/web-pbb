<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Informasi extends Model
{
    protected $table = 'informasi';
    protected $primaryKey = 'id_informasi';

    protected $fillable = [
        'id_kategori',
        'id_user',
        'judul',
        'slug',
        'ringkasan',
        'isi',
        'gambar',
        'tanggal_publikasi',
        'penulis',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_publikasi' => 'datetime',
        ];
    }

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KategoriInformasi::class, 'id_kategori', 'id_kategori');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}

