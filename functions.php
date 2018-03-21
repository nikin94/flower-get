<?php

function convertDateFormat($datetime){/*дату вида (yyyy-mm-dd hh:mm:ss) приводим к виду (dd-mm-yyyy hh:mm)*/
    if(isset($datetime) && $datetime) {
        $date = explode(' ', $datetime)[0];
        $time = explode(' ', $datetime)[1];
        $dateY = explode('-', $date)[0];
        $dateM = explode('-', $date)[1];
        $dateD = explode('-', $date)[2];
        $timeH = explode(':', $time)[0];
        $timeM = explode(':', $time)[1];
        //$timeS = explode(':', $time)[2];
        return $dateD . '-' . $dateM . '-' . $dateY . ' ' . $timeH . ':' . $timeM;
    }
}

function printFlowersList($str){/*В список цветов вместо запятых вставляем переносы*/
    $arrayFlowers = explode(',',$str);
    foreach ($arrayFlowers as $item){
        echo $item."<br>";
    }
}
