<?php
error_reporting(E_ALL);
require_once('assets/DB/DataBaseConnection.php');
$arrayData = [];
$namesSQL = '';
$valuesSQL = '';
$sql = '';
$arrayData['date_create'] = '\''.date("Y-m-d H:i").'\'';
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
$namesSQL = rtrim(trim($namesSQL),",");
$valuesSQL = rtrim(trim($valuesSQL),",");
$sql = "insert into orders ($namesSQL) values ($valuesSQL)";
$dbClass->queryUPDATE($sql);
header('location: index.php?list=added');
echo mysqli_error($dbClass->getDB());
/*
foreach ($arrayData as $key=>$item) {
    echo $key.' = '.$item."\n<br>";
}*/
/*
$name = isset($_POST['name']) ? $_POST['name']:-1;
$address = isset($_POST['address']) ? $_POST['address']:-1;
$phone = isset($_POST['phone']) ? $_POST['phone']:'null';
$list_flowers = isset($_POST['list_flowers']) ? $_POST['list_flowers']:-1;
$price_flowers = isset($_POST['price_flowers']) ? $_POST['price_flowers']:'null';
$price_delivery = isset($_POST['price_delivery']) ? $_POST['price_delivery']:'null';
$bus_delivery = isset($_POST['bus_delivery'])? '1' : '0';
$price_summary = isset($_POST['price_summary']) ? $_POST['price_summary']:'null';
$date_create = date("Y-m-d H:i");
$payment = isset($_POST['payment']) ? '1':'0';
$date_payment = !empty($_POST['date_payment']) ? "{$_POST['date_payment']}" : '0000-00-00 00:00';
$date_payment = str_replace('T',' ', $date_payment);
$date_departure = !empty($_POST['date_departure']) ? "{$_POST['date_departure']}":'0000-00-00 00:00';
$date_departure = str_replace('T',' ', $date_departure);
*/