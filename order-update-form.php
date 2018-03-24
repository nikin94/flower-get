<?php
error_reporting(E_ALL);
require_once ('assets/DB/DataBaseConnection.php');
$id = $_POST['id'];
$arrayData = $dbClass->querySELECT("select * from orders WHERE id =".(+$id));
echo $arrayData;
?>

<form id="order-update-form" action="">
    <input type="text">
</form>
