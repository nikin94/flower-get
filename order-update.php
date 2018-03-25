<?php
error_reporting(E_ALL);
require_once('assets/DB/DataBaseConnection.php');
$dbClass = new DataBaseConnection();
$arrayData = [];
$sql = '';
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
    if (mb_strpos($key, 'date_') === 0) {
        $arrayData["$key"] = '\'null\'';
    }
}
foreach ($arrayData as $key => $item) {/*добавление данных в sql запрос*/
    if ($arrayData[$key] != 'null' && $key != 'id' && $arrayData[$key] != -1) {
        $sql .= " $key=$arrayData[$key], ";
    }
}
if (mb_substr($sql, strlen($sql) - 2, 1) == ',') {/*убираем запятую в конце строки*/
    $sql = mb_substr($sql, 0, -2);
}
/*
foreach ($arrayData as $key=>$item){
    echo $key.' = '.$item."<br>";
}
*/
if (isset($arrayData['id'])) {
    $sql = 'UPDATE orders SET ' . $sql . ' WHERE id=' . $arrayData['id'];
    //echo $sql;
    if($dbClass->queryUPDATE($sql)){
        echo '{"TYPE":"OK","MESSAGE":"Запись обновлена"}';
    }else {
        echo '{"TYPE":"ERROR","MESSAGE":"Ошибка!"}';
    }
    header('location: index.php?list=updated');
}



//echo mysqli_error($dbClass->getDB());
