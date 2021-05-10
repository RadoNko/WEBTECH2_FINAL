<?php
session_start();
require_once("Database.php");

class TeacherController
{

    private PDO $conn;

    public function __construct()
    {
        $this->conn = (new Database())->getConnection();
    }


    public function getAll()
    {
        try {
            $sql = "SELECT id,username,password FROM Teacher";

            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmnt = $this->conn->prepare($sql);
            $stmnt->execute();

            return json_encode($stmnt->fetchAll(PDO::FETCH_ASSOC), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        } catch (PDOException $e) {
            echo "<div class='alert alert-danger' role='alert'>
                        Sorry, there was an error. " . $e->getMessage() . "
                    </div>";
        }
    }
    function verifyTeacherLogin($data){
        try{
            $sql = "SELECT id,password FROM Teacher WHERE username=?";
            $stm = $this->conn->prepare($sql);
            $stm->execute([$data["nickname"]]);
            $result=$stm->fetch();


            if(password_verify($data["password"],$result["password"])==true){
                $_SESSION["student"]=false;
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
            $stm = $this->conn->prepare("SELECT username FROM Teacher WHERE username=?");
            $stm->execute([$data["nickname"]]);
            $count = $stm->rowCount();
            if($count!=0){
                return "alreadyRegistered";
            }

            $sql = "INSERT INTO Teacher (username,password) VALUES (?,?)";
            $hashedPSW=password_hash($data["password"], PASSWORD_DEFAULT);
            $stm = $this->conn->prepare($sql);
            $stm->execute([$data["nickname"],$hashedPSW]);

            $_SESSION["student"]=false;
            $_SESSION["teacher"]=true;
            $_SESSION["logged_id"]=$this->conn->lastInsertId();
            return "registered";
        }
        catch(PDOException $e){
            echo "<div class='alert alert-danger' role='alert'>
                        Sorry, there was an error. " . $e->getMessage()."
                    </div>";
        }
    }
}
