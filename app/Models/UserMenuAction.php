<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMenuAction extends BaseModel
{

    protected $guarded = ['id'];

    public function menu()
    {
        return $this->belongsTo('App\Models\Menu', 'menu_id');
    }

    public function menuAction()
    {
        return $this->belongsTo('App\Models\MenuAction', 'menu_action_id');
    }

    public static function type(){
        /*
        these key will store in database and will work for user permission. So don't change these element key, otherwise user permission will be not working for these element. if you want to add new custom element please follow the example format .
        for example:
        return[
            'key' => 'Text'
        ];

      *Here key will store in database

     */
    return [
            'action' => 'Action',
            'section' => 'Section',
            'tab' => 'Tab',
            'button' => 'Button',
        ];
    }

    public static function getType($type)
    {
        $types = self::type();
        foreach ($types as $key=>$value){
            if($key == $type){
                return $value;
                exit();
            }
        }
    }
}
