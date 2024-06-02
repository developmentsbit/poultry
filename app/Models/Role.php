<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends \Spatie\Permission\Models\Role
{
    use SoftDeletes;
    protected $guarded = ['id'];

    public function scopeActive($query){
        return $query->where('status',1);
    }

    public function scopeInactive($query){
        return $query->where('status',0);
    }

}
