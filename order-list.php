<?php
error_reporting(E_ALL);
$arrayListOrders = $dbClass->querySELECT("select * from orders ORDER BY id DESC");
?>

<table id="order-list">
    <thead>
    <?php require_once ('order-list-thead.php');?>
    </thead>
    <tbody>
    <?php require_once ('order-list-tbody.php');?>
    </tbody>
</table>
