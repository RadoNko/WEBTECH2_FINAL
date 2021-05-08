<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "Database.php";

class AnswerMathController{
    private PDO $conn;

    public function __construct(){
        $this->conn = (new Database())->getConnection();
    }

    public function insertAnswer($student_exam_fk, $question_fk, $answer){
        echo "QFK: ".$question_fk, "| AEXFK: ".$student_exam_fk, "| ANSW: ".$answer;

        try{
            $sql = "INSERT INTO AnswerTypeMath(question_type_fk, answer, student_exam_fk) VALUES(?, ?, ?)";
            $stm = $this->conn->prepare($sql);
            $stm->execute([$question_fk,$answer,$student_exam_fk]);

            //return $this->conn->lastInsertId();
        }
        catch(PDOException $e){
            echo "<div class='alert alert-danger' role='alert'>
                        Sorry, there was an error. " . $e->getMessage()."
                    </div>";
        }

    }

    private function setScore($points, $questionId){ //score set manually by teacher

        try{
            $stmt = $this->conn->prepare("UPDATE AnswerTypeMath SET points =:points WHERE id =:questionId");
            $stmt->bindParam(":points", $points); //TODO add PDO:: for float
            $stmt->bindParam(":questionId", $questionId, PDO::PARAM_INT);
            $stmt->execute();

            //return $this->conn->lastInsertId();
        }
        catch(PDOException $e){
            echo "<div class='alert alert-danger' role='alert'>
                        Sorry, there was an error. " . $e->getMessage()."
                    </div>";
        }

    }

}