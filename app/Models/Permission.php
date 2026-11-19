<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permission extends Model
{
    protected $table = 'permissions';
    protected $primaryKey = 'id_permission';

    protected $fillable = [
        'nama_permission',
        'deskripsi',
    ];

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_permissions', 'id_permission', 'id_role');
    }
}

