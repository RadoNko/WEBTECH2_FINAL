<?php
if (session_status() != 2){
    session_start();
}

require_once "Database.php";

class AnswerMathController{
    private PDO $conn;

    public function __construct(){
        $this->conn = (new Database())->getConnection();
    }

    public function insertAnswer($question_fk, $answer){
        $student_exam_fk = $_SESSION["student_exam_id"];
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

    public function getAnswerWithQuestion(){
        $student_exam_fk = $_SESSION["student_exam_id"];
        //SELECT * FROM `AnswerTypeMath` INNER JOIN QuestionTypeMath ON AnswerTypeMath.question_type_fk = QuestionTypeMath.id WHERE AnswerTypeMath.student_exam_fk = 1
        try{
            $stmt = $this->conn->prepare("SELECT * FROM AnswerTypeMath INNER JOIN QuestionTypeMath ON AnswerTypeMath.question_type_fk = QuestionTypeMath.id WHERE AnswerTypeMath.student_exam_fk =:student_exam_fk");
            $stmt->bindParam(":student_exam_fk", $student_exam_fk, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOException $e){
            echo "<div class='alert alert-danger' role='alert'>
                        Sorry, there was an error. " . $e->getMessage()."
                    </div>";
        }
    }

    public function setScore($points, $answerId){ //score set manually by teacher

        try{
            $stmt = $this->conn->prepare("UPDATE AnswerTypeMath SET points =:points WHERE id =:answerId");
            $stmt->bindParam(":points", $points); //TODO add PDO:: for float
            $stmt->bindParam(":answerId", $answerId, PDO::PARAM_INT);
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