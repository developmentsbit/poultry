<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface RoleInterface extends BaseInterface
{
    public function permission(Request $request,$id);
}
