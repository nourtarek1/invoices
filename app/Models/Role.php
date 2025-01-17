<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
   protected $guarded = [];
   public function permissions()
   {

      return $this->belongsToMany(Permission::class, 'roles_permissions');
   }

   public function allRolePermission()
   {

      return $this->belongsToMany(Permission::class, 'roles_permissions');
   }
}
