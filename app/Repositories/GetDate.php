<?php
namespace App\Repositories;

use Illuminate\Support\Facades\Facade;

class GetDate extends Facade{

    protected static function getFacadeAccessor ()
    {
        return 'GetDateFormat';
    }
}
?>
