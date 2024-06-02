<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class product_information extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded = [];

    public function stock()
    {
        return $this->hasMany('App\Models\stock','pdt_id');
    }
}
