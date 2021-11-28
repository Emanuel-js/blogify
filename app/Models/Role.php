<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Permission;
class Role extends Model
{
    use HasFactory;


    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permissions');
    }

    public function allRolePermissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permissions');
    }

}
