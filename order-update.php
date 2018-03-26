<?php
error_reporting(E_ALL);
//require_once('assets/DB/DataBaseConnection.php');
//$dbClass = new DataBaseConnection();
$arrayData = [];
$sql = '';
$id = +$_POST['id'];
/*
$_POST = [
    'id'=> 2,
    'name' =>'testing db test',
    'address' =>'address',
    'price_summary' =>'',
    'date_payment' =>'',
    'date_departure' =>''
];*/
foreach ($_POST as $key => $item) {/*переносим из POST в массив*/
    $arrayData["$key"] = !empty($_POST[$key]) ?  '\''.$_POST[$key].'\'' : '\'-1\'';
    /*if (mb_strpos($key, 'date_') === 0) {
        $arrayData["$key"] = '\'null\'';
    }*/
}
foreach ($arrayData as $key => $item) {/*добавление данных в sql запрос*/
    if ($arrayData[$key] != 'null' && $key != 'id' && $arrayData[$key] != -1) {
        $sql .= " $key=$arrayData[$key], ";
    }
}

foreach ($_POST as $item){
    echo $item."\n";
}

$sql = rtrim(trim($sql),",");/*Убираем запятую и пробелы в конце(и начале) строки*/
if (isset($arrayData['id'])) {
    $sql = "UPDATE orders SET $sql WHERE id = $id";
    echo $sql;
    if($dbClass->queryUPDATE($sql)){
        echo '{"TYPE":"OK","MESSAGE":"Запись обновлена"}';
    }else {
        echo '{"TYPE":"ERROR","MESSAGE":"Ошибка!"}';
    }
}
echo mysqli_error($dbClass->getDB());
