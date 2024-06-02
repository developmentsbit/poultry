<?php
namespace App\Traits;

trait Date{
    public static function DateToDb($sign, $date)
    {
        $explode = explode($sign, $date);

        $date = $explode[2].'-'.$explode[1].'-'.$explode[0];

        return $date;
    }

    public static function DbtoDate($sign, $date)
    {
        $explode = explode($sign, $date);

        $date = $explode[2].'/'.$explode[1].'/'.$explode[0];

        return $date;
    }

    public static function getMonthName($monthNo)
    {
        if($monthNo == 1)
        {
            return 'January';
        }
        elseif($monthNo == 2)
        {
            return 'February';
        }
        elseif($monthNo == 3)
        {
            return 'March';
        }
        elseif($monthNo == 4)
        {
            return 'April';
        }
        elseif($monthNo == 5)
        {
            return 'May';
        }
        elseif($monthNo == 6)
        {
            return 'June';
        }
        elseif($monthNo == 7)
        {
            return 'July';
        }
        elseif($monthNo == 8)
        {
            return 'August';
        }
        elseif($monthNo == 9)
        {
            return 'September';
        }
        elseif($monthNo == 10)
        {
            return 'October';
        }
        elseif($monthNo == 11)
        {
            return 'November';
        }
        elseif($monthNo == 12)
        {
            return 'December';
        }
        else{
            return response('Invalid Month Number','403');
        }
    }
}
