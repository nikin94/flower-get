<?php
error_reporting(E_ALL);
require_once('assets/DB/DataBaseConnection.php');
$arrayData = [];
$namesSQL = '';
$valuesSQL = '';
$sql = '';
$arrayData['date_create'] = '\''.date("Y-m-d H:i").'\'';
//print_r($_POST);
foreach ($_POST as $key => $item) {/*переносим из POST в массив*/
    $arrayData["$key"] = isset($_POST[$key]) ?  '\''.$_POST[$key].'\'' : '\'-1\'';
    if(($key == 'bus_delivery' || $key == 'payment' || $key == 'departure') && isset($arrayData["$key"])) $arrayData["$key"] = true;
    if (mb_strpos($key, 'date_') === 0) {
        if($key == 'date_create'){
            $arrayData["$key"] = date("Y-m-d H:i");
        }elseif($item == 0){
            $arrayData["$key"] = '\'0000-00-00 00:00:00\'';
        }else{
            $arrayData["$key"] = str_replace('T',' ', $arrayData["$key"]);
        }
    }
}
foreach ($arrayData as $key=>$item){
    $namesSQL.=$key.', ';
    $valuesSQL.=$item.', ';
}
//print_r($arrayData);
$namesSQL = rtrim(trim($namesSQL),",");
$valuesSQL = rtrim(trim($valuesSQL),",");
$sql = "insert into orders ($namesSQL) values ($valuesSQL)";
$dbClass->queryUPDATE($sql);
header("location: index.php?list=".mysqli_insert_id($dbClass->getDB()));