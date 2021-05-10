<?php
if (session_status() != 2){
    session_start();
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "Database.php";

class Student{

    public $connection;

    function __construct() {
        $this->connection=(new Database())->getConnection();
    }

    public function isTestCode($code){
        try{
            $sql = "SELECT * FROM Exam WHERE code=? AND is_active = 1";
            $stm = $this->connection->prepare($sql);
            $stm->execute([$code["testCode"]]);
            $count = $stm->rowCount();
            if($count!=0){
                return true;
            }else{
                return false;
            }

        }
        catch(PDOException $e){
            echo "<div class='alert alert-danger' role='alert'>
                        Sorry, there was an error. " . $e->getMessage()."
                    </div>";
        }
    }

    private function getExamID($testCode){
        $sql="SELECT id FROM Exam WHERE code=?";
        $stm = $this->connection->prepare($sql);
        $stm->execute([$testCode]);
        $examID=$stm->fetch();
        return $examID["id"];
    }


    public function insertStudentData($data){
        // $data["surname"];
        try{
            $sql = "SELECT * FROM Student WHERE ais_id=?";
            $stm = $this->connection->prepare($sql);
            $stm->execute([$data["id"]]);
            $count = $stm->rowCount();
            $result=$stm->fetch();

            //je už v db alebo nie?
            if($count!=0){
                if($result["name"]==$data["name"] && $result["surname"]==$data["surname"]){      //kontrola či sa pod rovnakym ais id neloguje ine meno
                    return "verified";
                }
                else
                    return "wrongData";
            }else{
                //nie je v table, urob insert
                $sql = "INSERT INTO Student (ais_id, name, surname) VALUES (?,?,?)";
                $stm = $this->connection->prepare($sql);
                $stm->execute([$data["id"],$data["name"],$data["surname"]]);
                return "inserted";
            }

        }
        catch(PDOException $e){
            echo "<div class='alert alert-danger' role='alert'>
                        Sorry, there was an error. " . $e->getMessage()."
                    </div>";
        }
    }

    public function insertStudentExam($data){
        try{
            //kontrola či sa student neloguje znova na ten isty test
            $sql = "SELECT * FROM Student_Exam WHERE student_fk=?";
            $stm = $this->connection->prepare($sql);
            $stm->execute([$data["id"]]);
            $count = $stm->rowCount();
            if($count!=0){
                return "alreadyFinished";
            }

            //ziskaj FK idčka testu do nasledujuceho insertu
            $examID=$this->getExamID($data["testCode"]["testCode"]);

            $sql = "INSERT INTO Student_Exam (student_fk, exam_fk,is_finished, left_website) VALUES (?,?,?,?)";
            $stm = $this->connection->prepare($sql);
            $stm->execute([$data["id"],$examID,0,0]);

            $_SESSION["student"]=true;
            $_SESSION["student_exam_id"]=$this->connection->lastInsertId();
            $_SESSION["teacher"]=false;
            $_SESSION["logged_id"]=$data["id"];

            return "studentExamInserted";
        }
        catch(PDOException $e){
                echo "<div class='alert alert-danger' role='alert'>
                            Sorry, there was an error. " . $e->getMessage()."
                        </div>";
            }

    }
}