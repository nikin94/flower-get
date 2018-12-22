<?php
require_once('assets/DB/DataBaseConnection.php');
$dbClass = new DataBaseConnection();
$id = isset($_GET['id']) && is_numeric($_GET['id']) ? $_GET['id']:-1;
//if($dbClass->queryUPDATE("DELETE FROM orders WHERE id=".$id)){
if($dbClass->queryUPDATE("INSERT INTO orders_deleted SELECT * FROM orders WHERE id = ".$id) && $dbClass->queryUPDATE("DELETE FROM orders WHERE id = ".$id)){
    echo '{"TYPE":"OK","MESSAGE":"Запись перенесена в orders_deleted"}';
}else{
    echo '{"TYPE":"ERROR","MESSAGE":"Ошибка!"}';
}
echo mysqli_error($dbClass->getDB());