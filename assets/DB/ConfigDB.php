<?php
class ConfigDB{
    protected $dbHost =  'localhost';
    protected $dbName = 'flowers';
    protected $dbUser = 'root';
    protected $dbPassword = '';
    protected $dbPort = '3306';
}

define('MY_ROOT','http://'.$_SERVER['HTTP_HOST'].'/flowers/');