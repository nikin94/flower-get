<?php
$db = mysqli_connect('localhost','root','','flowers');
$id = isset($_GET['id']) && is_numeric($_GET['id']) ? $_GET['id']:-1;
if($db){
    if(mysqli_query($db,"DELETE FROM orders WHERE id=".$id)){
        echo '{"TYPE":"OK","MESSAGE":"Запись удалена"}';
    }else{
        echo '{"TYPE":"OK","MESSAGE":"Ошибка!"}';
    }
}
mysqli_close($db);