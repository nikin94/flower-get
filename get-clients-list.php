<?php
error_reporting(E_ALL);
require_once('assets/DB/DataBaseConnection.php');
$sql = "select name, address, phone from orders";
$tmp = $dbClass->querySELECT($sql);
if(isset($_POST['getNames']) && $_POST['getNames']) {
    foreach ($tmp as $key => $item) {
        echo $item['name'] . '/';
    }
}elseif(isset($_POST['currentName']) && $_POST['currentName']){
    $arrValues = [];
    foreach ($tmp as $key => $item) {
        if($item['name'] === $_POST['currentName']){
            $arrValues['address'] = $item['address'];
            $arrValues['phone'] = $item['phone'];
        };
    }
    echo json_encode($arrValues);
}