<?php
error_reporting(E_ALL);
require_once('assets/DB/DataBaseConnection.php');
$arrayData = [];
$sql = '';
$id = +$_POST['id'];
//print_r($_POST);
/*
$_POST = [
    'id'=> 2,
    'name' =>'testing db test',
    'address' =>'address',
    'price_summary' =>'',
    'date_payment' =>'',
    'date_departure' =>''
];*/
foreach ($_POST as $key => $item) {/*переносим из POST в массив */
    if(isset($_POST[$key])){
        $arrayData["$key"] = '"'.str_replace('"',"'",$_POST["$key"]).'"';
    }else{
        $arrayData["$key"] = '\'-1\'';
    }
    if (mb_strpos($key, 'date_') === 0 && $item == 0) {
        $arrayData["$key"] = '\'0000-00-00 00:00:00\'';
    }
    if(isset($arrayData["list_flowers"])){
        $arrayData["list_flowers"] = str_replace('-',' ',$arrayData["list_flowers"]);
    }
}
foreach ($arrayData as $key => $item) {/*добавление данных в sql запрос*/
    if ($arrayData[$key] != 'null' && $key != 'id' && $arrayData[$key] != -1) {
        $sql .= " $key=$arrayData[$key], ";
    }
}
$sql = rtrim(trim($sql),",");/*Убираем запятую и пробелы в конце(и начале) строки*/
//echo gettype ($arrayData["tracking_number"]);
if (isset($arrayData['id'])) {
    $sql = "UPDATE orders SET $sql WHERE id = $id";
    echo $sql."\n";
    echo $dbClass->queryUPDATE($sql) ? '{"TYPE":"OK","MESSAGE":"Запись обновлена"}' : '{"TYPE":"ERROR","MESSAGE":"Ошибка!"}';
}
echo mysqli_error($dbClass->getDB());
