<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends BaseModel
{

    protected $guarded = ['id'];

    //protected $attributes = ['created_by','updated_by','deleted_by'];
    public function __construct(array $attributes = array())
    {
        $this->setRawAttributes(array(
            'created_by' => @auth()->user()->id,
            'updated_by' => @auth()->user()->id,
        ), true);
        parent::__construct($attributes);
    }

    protected static function boot() {
        parent::boot();

        static::deleting(function($menu) {
            $menu->userMenuAction()->delete();
        });

        static::restoring(function($menu) {
            $menu->userMenuAction()->restore();
        });
    }

    public function parent()
    {
        return $this->belongsTo('App\Models\Menu', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany('App\Models\Menu', 'parent_id')->orderBy('order_by','asc');
    }

    public function userMenuAction()
    {
        return $this->hasMany('App\Models\UserMenuAction', 'menu_id')->orderBy('order_by','asc')->where('status',1);
    }
}
