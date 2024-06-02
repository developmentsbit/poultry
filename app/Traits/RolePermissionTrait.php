<?php

namespace App\Traits;

trait RolePermissionTrait
{
    public static function checkRoleHasPermission(String $model, String $function) : bool
    {
        $permissions = auth()->user()->getAllPermissions()->pluck('name')->toArray();

        if ($function == 'index'){
            return in_array(ucfirst($model).' List',$permissions);
        } elseif ($function == 'show'){
            return in_array(ucfirst($model).' View',$permissions);
        } else {
            return in_array(ucfirst($model).' '.ucfirst($function),$permissions);
        }
    }
}
