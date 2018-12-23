<?php
error_reporting(E_ALL);
require_once('assets/DB/DataBaseConnection.php');
$id = +$_POST['id'];
$sql = "SELECT tracking_number from orders where id = $id";
echo ($dbClass->querySELECT($sql)[0]['tracking_number']);