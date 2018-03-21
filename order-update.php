<?php
require_once('assets/DB/DataBaseConnection.php');
$dbClass = new DataBaseConnection();
$id = isset($_POST['id']) && is_numeric($_POST['id']) ? $_POST['id']:-1;
$name = isset($_POST['name']) ? $_POST['name']:-1;
$address = isset($_POST['address']) ? $_POST['address']:-1;
$date_payment = !empty($_POST['date_payment']) ? "'{$_POST['date_payment']}'" : 'null';
$sql = 'UPDATE orders SET date_payment='.$date_payment.', payment='.$_POST["payment"].' WHERE id='.$id;
if($dbClass->queryUPDATE($sql)){
    echo '{"TYPE":"OK","MESSAGE":"Запись обновлена"}';
}else{
    echo '{"TYPE":"ERROR","MESSAGE":"Ошибка!"}';
}
//echo mysqli_error($dbClass->getDB());
