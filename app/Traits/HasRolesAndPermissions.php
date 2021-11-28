<?php

namespace App\Traits;

use App\Models\Role;
use App\Models\Permission;
trait HasRolesAndPermissions
{

    /**
     * Undocumented function
     *
     * @return boolean
     */
    public function isAdmin()
    {
        if(!$this->roles == null) {
        if($this->roles->contains('name', 'Admin')){
            return true;
        }}
    }
    /**
     * @return mixed
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class,'user_roles');
    }

    /**
     * @return mixed
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class,'user_permissions');
    }

    /**
     * Check if the user has Role
     *
     * @param [type] $role
     * @return boolean
     */
    public function hasRole($role)
    {
        if( strpos($role, ',') !== false ){//check if this is an list of roles

            $listOfRoles = explode(',',$role);

            foreach ($listOfRoles as $role) {
                if ($this->roles->contains('name', $role)) {
                    return true;
                }
            }
        }else{
         if(!$this->roles== null){
            if ($this->roles->contains('name', $role)) {
                return true;
            }
         }
        }

        return false;
    }
}
