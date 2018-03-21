<?php
require_once ('ConfigDB.php');

class DataBaseConnection extends ConfigDB{
    private $db;
    public function __construct(){
        $this->getConnect();
    }
    public function __destruct(){
        mysqli_close($this->getConnect());
    }
    public function getConnect(){
        if($this->db){
            return $this->db;
        }
        return $this->db = mysqli_connect(
            $this->dbHost,
            $this->dbUser,
            $this->dbPassword,
            $this->dbName,
            $this->dbPort
        );
    }

    public function querySELECT($sql){
        $this->getConnect();
        $arrayList = [];
        if($matrix = mysqli_query($this->db, $sql)){
            while ($item = mysqli_fetch_assoc($matrix)){
                $arrayList[] = $item;
            }
        }
        return $arrayList;
    }

    public function queryUPDATE($sql){
        $this->getConnect();
        if(mysqli_query($this->db, $sql))return true;
        return false;
    }
    public function getDB(){
        return $this->db;
    }
}