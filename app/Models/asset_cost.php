<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class asset_cost extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded = [];

    public function title()
    {
        return $this->belongsTo('App\Models\asset_category','title_id');
    }
}
