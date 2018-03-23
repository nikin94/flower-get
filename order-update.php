<?php
error_reporting(E_ALL);
require_once('assets/DB/DataBaseConnection.php');
$dbClass = new DataBaseConnection();

$id = isset($_POST['id']) && is_numeric($_POST['id']) ? $_POST['id'] : -1;
$name = isset($_POST['name']) ? $_POST['name'] : -1;
$address = isset($_POST['address']) ? $_POST['address'] : -1;
$phone = isset($_POST['phone']) ? $_POST['phone'] : 'null';
$list_flowers = isset($_POST['list_flowers']) ? $_POST['list_flowers'] : -1;
$price_flowers = isset($_POST['price_flowers']) ? $_POST['price_flowers'] : 'null';
$price_delivery = isset($_POST['price_delivery']) ? $_POST['price_delivery'] : 'null';
$price_summary = isset($_POST['price_summary']) ? $_POST['price_summary'] : -1;
$date_create = !empty($_POST['date_create']) ? "'{$_POST['date_create']}'" : -1;
$payment = isset($_POST["payment"]) ? $_POST['payment'] : "null";
$date_payment = !empty($_POST['date_payment']) ? "'{$_POST['date_payment']}'" : 'null';
$date_departure = !empty($_POST['date_departure']) ? "'{$_POST['date_departure']}'" : 'null';

//echo $date_departure."\n";

$arrayData = [];
//$arrayData['id'] = $id;
$arrayData['name'] = $name;
$arrayData['address'] = $address;
$arrayData['phone'] = $phone;
$arrayData['list_flowers'] = $list_flowers;
$arrayData['price_flowers'] = $price_flowers;
$arrayData['price_delivery'] = $price_delivery;
$arrayData['price_summary'] = $price_summary;
$arrayData['date_create'] = $date_create;
$arrayData['payment'] = $payment;
$arrayData['date_payment'] = $date_payment;
$arrayData['date_departure'] = $date_departure;

$sql = '';
foreach ($arrayData as $key=>$item){
    if ($arrayData[$key] != 'null' && $arrayData[$key] != -1) {
        $sql .= " $key=$arrayData[$key], ";
    }
}
if(mb_substr($sql, strlen($sql)-2, 1) == ','){/*убираем запятую в конце строки*/
    $sql = mb_substr($sql, 0, -2);
}

$sql = 'UPDATE orders SET ' . $sql . ' WHERE id=' . $id;

if ($dbClass->queryUPDATE($sql)) {
    echo '{"TYPE":"OK","MESSAGE":"Запись обновлена"}';
} else {
    echo '{"TYPE":"ERROR","MESSAGE":"Ошибка!"}';
}
echo mysqli_error($dbClass->getDB());
