<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "../../Database.php";

class Student{

    public $connection;

    function __construct() {
        $this->connection=(new Database())->getConnection();
    }

    public function isTestCode($code){
        try{
            $sql = "SELECT * FROM Exam WHERE code=?";
            $stm = $this->connection->prepare($sql);
            $stm->execute([$code["testCode"]]);
            $count = $stm->rowCount();
            if($count!=0){
                return "true";
            }else{
                return "false";
            }

        }
        catch(PDOException $e){
            echo "<div class='alert alert-danger' role='alert'>
                        Sorry, there was an error. " . $e->getMessage()."
                    </div>";
        }
    }

    public function insertStudentData($data){
        // $data["surname"];
//        try{
//            $sql = "SELECT * FROM Exam WHERE code=?";
//            $stm = $this->connection->prepare($sql);
//            $stm->execute([$code["testCode"]]);
//            $count = $stm->rowCount();
//            if($count!=0){
//                return "true";
//            }else{
//                return "false";
//            }
//
//        }
//        catch(PDOException $e){
//            echo "<div class='alert alert-danger' role='alert'>
//                        Sorry, there was an error. " . $e->getMessage()."
//                    </div>";
//        }
    }

}