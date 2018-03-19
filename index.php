<?php
 error_reporting(E_ALL);
require_once('assets/DB/DataBaseConnection.php');
$dbClass = new DataBaseConnection();

?>
<!doctype html>
<html lang="ru">
<head>
<?php require_once("assets/templates/head_config.php")?>
</head>
<body>
<?php require_once("assets/templates/header.php")?>
<?php require_once("orders-list.php");?>
<script src="//code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="assets/js/script.js"></script>
</body>
</html>
