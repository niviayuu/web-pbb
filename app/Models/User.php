<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id_user';

    public function getAuthIdentifierName()
    {
        return 'id_user';
    }

    protected $fillable = [
        'id_role',
        'nama',
        'email',
        'password',
        'status',
        'no_hp',
        'instansi',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'id_role', 'id_role');
    }

    public function logAktivitas(): HasMany
    {
        return $this->hasMany(LogAktivitas::class, 'id_user', 'id_user');
    }

    public function pengaturan(): HasMany
    {
        return $this->hasMany(Pengaturan::class, 'id_user', 'id_user');
    }

    public function informasi(): HasMany
    {
        return $this->hasMany(Informasi::class, 'id_user', 'id_user');
    }
}
