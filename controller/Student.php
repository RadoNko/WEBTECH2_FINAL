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
        try{
            $sql = "SELECT * FROM Student WHERE ais_id=?";
            $stm = $this->connection->prepare($sql);
            $stm->execute([$data["id"]]);
            $count = $stm->rowCount();
            $result=$stm->fetch();

            //je už v db alebo nie?
            if($count!=0){
                if($result["name"]==$data["name"] && $result["surname"]==$data["surname"])      //kontrola či sa pod rovnakym ais id neloguje ine meno
                    return "verified";
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
            //ziskaj FK idčka testu do nasledujuceho insertu
            $sql="SELECT id FROM Exam WHERE code=?";
            $stm = $this->connection->prepare($sql);
            $stm->execute([$data["testCode"]["testCode"]]);
            $examID=$stm->fetch();

            $sql = "INSERT INTO Student_Exam (student_fk, exam_fk,is_finished) VALUES (?,?,?)";
            $stm = $this->connection->prepare($sql);
            $stm->execute([$data["id"],$examID["id"],0]);
            return "studentExamInserted";
        }
        catch(PDOException $e){
                echo "<div class='alert alert-danger' role='alert'>
                            Sorry, there was an error. " . $e->getMessage()."
                        </div>";
            }

    }
}