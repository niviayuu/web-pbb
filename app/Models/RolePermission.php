<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RolePermission extends Model
{
    protected $table = 'role_permissions';
    protected $primaryKey = 'id_role_permission';

    protected $fillable = [
        'id_role',
        'id_permission',
    ];

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'id_role', 'id_role');
    }

    public function permission(): BelongsTo
    {
        return $this->belongsTo(Permission::class, 'id_permission', 'id_role');
    }
}

