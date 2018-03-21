<?php
require_once('assets/DB/DataBaseConnection.php');
$dbClass = new DataBaseConnection();

$name = isset($_POST['name']) ? $_POST['name']:-1;
$address = isset($_POST['address']) ? $_POST['address']:-1;
$phone = isset($_POST['phone']) ? $_POST['phone']:'null';
$list_flowers = isset($_POST['list_flowers']) ? $_POST['list_flowers']:-1;
$price_flowers = isset($_POST['price_flowers']) ? $_POST['price_flowers']:'null';
$price_delivery = isset($_POST['price_delivery']) ? $_POST['price_delivery']:'null';
$price_summary = isset($_POST['price_summary']) ? $_POST['price_summary']:'null';
$date_create = isset($_POST['date_create']) ? $_POST['date_create']:'null';
$payment = isset($_POST['payment']) ? $_POST['payment']:'null';
$date_payment = !empty($_POST['date_payment']) ? "'{$_POST['date_payment']}'" : 'null';
$date_departure = isset($_POST['date_departure']) ? $_POST['date_departure']:'null';

$dbClass->queryUPDATE('insert into orders ("name","address","phone","list_flowers","price_flowers","price_delivery","price_summary","date_create","payment","date_payment","date_departure") values ('.$name.','.$address.','.$phone.','.$list_flowers.','.$price_flowers.','.$price_delivery.','.$price_summary.','.$date_create.','.$payment.','.$date_payment.','.$date_departure.')');