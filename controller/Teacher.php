<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "../../Database.php";

class Teacher{

    public $connection;

    function __construct() {
        $this->connection=(new Database())->getConnection();
    }

    public function getMessage($data){
//        foreach($data as $key => $value){
//
//            if($key === "name"){
//                return $data["name"];
//            }
//        }
        return 1;
    }

}