<?php
require_once('assets/DB/DataBaseConnection.php');
$dbClass = new DataBaseConnection();
$id = isset($_GET['id']) && is_numeric($_GET['id']) ? $_GET['id']:-1;
if($dbClass->queryUPDATE("DELETE FROM orders WHERE id=".$id)){
    echo '{"TYPE":"OK","MESSAGE":"Запись удалена"}';
}else{
    echo '{"TYPE":"OK","MESSAGE":"Ошибка!"}';
}
$dbClass->__destruct();