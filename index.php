<?php
error_reporting(E_ALL);
require_once('assets/DB/DataBaseConnection.php');
require_once('functions.php');

?>
<!doctype html>
<html lang="ru">
<head>
<?php require_once("assets/templates/head_config.php")?>
</head>
<body>
<?php require_once("assets/templates/header.php")?>
<?php
if (isset($_GET['list'])){/*$_SERVER['REQUEST_URI']*/
    require_once("order-list.php");
}elseif (isset($_GET['add'])){
    require_once("order-add-form.php");
}
?>

<script src="//code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="assets/js/jquery-animate-colors.js"></script>
<script src="assets/js/script.js"></script>
</body>
</html>
