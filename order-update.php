<?php
require_once('assets/DB/DataBaseConnection.php');
$dbClass = new DataBaseConnection();
$id = isset($_POST['id']) && is_numeric($_POST['id']) ? $_POST['id']:-1;
$name = isset($_POST['name']) ? $_POST['id']:-1;
if($dbClass->queryUPDATE('UPDATE orders 
  SET date_payment='.$_POST['date_payment'].', 
      payment='.$_POST['payment'].' WHERE id='.$id)){
    echo '{"TYPE":"OK","MESSAGE":"Запись удалена"}';
}else{
    echo '{"TYPE":"OK","MESSAGE":"Ошибка!"}';
}
$dbClass->__destruct();