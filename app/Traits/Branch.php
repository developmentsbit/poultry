<?php
namespace App\Traits;

use App\Models\branch_info;

trait Branch
{
    public static function getName($id)
    {
        $data = branch_info::find($id);
        return $data->branch_name_en;
    }
}
