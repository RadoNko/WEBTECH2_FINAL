<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "Database.php";

class Teacher{

    public $connection;

    function __construct() {
        $this->connection=(new Database())->getConnection();
    }

    function verifyTeacherLogin($data){
        try{
            $sql = "SELECT id,password FROM Teacher WHERE username=?";
            $stm = $this->connection->prepare($sql);
            $stm->execute([$data["nickname"]]);
            $result=$stm->fetch();


            if(password_verify($data["password"],$result["password"])==true){
                session_start();
                $_SESSION["teacher"]=true;
                $_SESSION["logged_id"]=$result["id"];
                return "verified";
            }else{
                return "wrongPassword";
            }
        }
        catch(PDOException $e){
            echo "<div class='alert alert-danger' role='alert'>
                        Sorry, there was an error. " . $e->getMessage()."
                    </div>";
        }
    }

    function registerTeacher($data){
        try{
            $sql = "INSERT INTO Teacher (username,password) VALUES (?,?)";
            $hashedPSW=password_hash($data["password"], PASSWORD_DEFAULT);
            $stm = $this->connection->prepare($sql);
            $stm->execute([$data["nickname"],$hashedPSW]);

            session_start();
            $_SESSION["teacher"]=true;
            $_SESSION["logged_id"]=$this->connection->lastInsertId();
            return "registered";
        }
        catch(PDOException $e){
            echo "<div class='alert alert-danger' role='alert'>
                        Sorry, there was an error. " . $e->getMessage()."
                    </div>";
        }
    }

}