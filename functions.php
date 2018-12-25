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

function printFlowersList($str){/*Вывод списка цветов в ячейке*/
    $str = str_replace('-',' ',$str);
    $arrayFlowers = explode(',',$str);
    foreach ($arrayFlowers as $key=>$string){
        $string = explode(' ',$string);
//        print_r($string);
        foreach ($string as $item) {
            $length = count($string)-1;
            if($string[$length] == $item && is_numeric(intval($string[$length]))){
                $string[$length] = '<b>'.strval(intval($string[$length])).'</b>';
//                echo $string[$length]."\n";
            }
        }
        $arrayFlowers[$key] = implode(' ', $string);
    }
    $i=1;
    echo '<ul>';
    foreach ($arrayFlowers as $key=>$item){
        echo "<li class='order-list-item-$i'><span>$i</span><p>".trim($item)."</p></li>";
        $i++;
    }
    echo '</ul>';
}