<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    protected $table = 'roles';
    protected $primaryKey = 'id_role';

    protected $fillable = [
        'nama_role',
        'deskripsi',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'id_role', 'id_role');
    }

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'role_permissions', 'id_role', 'id_permission');
    }
}

