<?php
namespace App\Facades;

class GetOriginalDate{
    public function getDate($string,$explodeSign)
    {
        $explodeDate = explode($explodeSign,$string);

        $month = '';

        if($explodeDate[1] == 1)
        {
            $month = "January";
        }
        elseif($explodeDate[1] == 2)
        {
            $month = "February";
        }
        elseif($explodeDate[1] == 3)
        {
            $month = "March";
        }
        elseif($explodeDate[1] == 4)
        {
            $month = "April";
        }
        elseif($explodeDate[1] == 5)
        {
            $month = "May";
        }
        elseif($explodeDate[1] == 6)
        {
            $month = "June";
        }
        elseif($explodeDate[1] == 7)
        {
            $month = "July";
        }
        elseif($explodeDate[1] == 8)
        {
            $month = "Agust";
        }
        elseif($explodeDate[1] == 9)
        {
            $month = "September";
        }
        elseif($explodeDate[1] == 10)
        {
            $month = "October";
        }
        elseif($explodeDate[1] == 11)
        {
            $month = "November";
        }
        elseif($explodeDate[1] == 12)
        {
            $month = "December";
        }

        $result = $explodeDate[2].' '.$month.' '.$explodeDate['0'];

        return $result;
    }
}

?>
