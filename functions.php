<?php

function convertDateFormat($date){/*дату вида (yyyy-mm-dd hh:mm:ss) приводим к виду (dd-mm-yyyy hh:ss)*/
    $tmp = explode(' ',$date);
    return implode('-',array_reverse(explode('-',explode(' ',$date)[0]))).' '.explode(':',$tmp[1])[0].':'.explode(':',$tmp[1])[1];
}