<?php
error_reporting(E_ALL);
require_once('assets/DB/DataBaseConnection.php');
$sql = "select name from orders";
$tmp = $dbClass->querySELECT($sql);
$arrayCompared = [];
$names = [];
$nameValue = mb_strtolower($_POST['nameValue']);
foreach ($tmp as $item) {
    $names[] = mb_strtolower($item['name']);
}
if($nameValue) {
    foreach ($names as $key => $item) {
        if (mb_strpos($item, $nameValue) !== false) {
            $arrayCompared[] = $item;
        };
    }
}
echo $arrayCompared;