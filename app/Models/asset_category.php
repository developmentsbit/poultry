<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class asset_category extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded = [];

    public static function inactive($id)
    {
        asset_category::withTrashed()->find($id)->update([
            'status' => 0,
        ]);
        return;
    }

    public static function active($id)
    {
        asset_category::withTrashed()->find($id)->update([
            'status' => 1,
        ]);
        return;
    }

    public function invest()
    {
        return $this->hasMany('App\Models\asset_invest','title_id');
    }

    public function withdraw()
    {
        return $this->hasMany('App\Models\asset_cost','title_id');
    }
}
