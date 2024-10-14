<?php

namespace App\Traits;

use App\Models\Role;
use App\Models\Permission;
use App\Models\User;

trait HasRolesAndPermissions
{
    /**
     * Undocumented function
     *
     * @return boolean
     */
   
    /**
     * @return mixed
     */
    
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'users_roles','user_id');
    }

    /**
     * @return mixed
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'users_permissions');
    }

  
    /**
     * Check if the user has Role
     *
     * @param [type] $role
     * @return boolean
     */
}
