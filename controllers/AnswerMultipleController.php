<?php

require_once("Database.php");

class AnswerMultipleController{

    private PDO $conn;

    public function __construct(){
        $this->conn = (new Database())->getConnection();
    }

    private function insertAnswerType($questionId, $studentExamId){

        try{

            $sql = "INSERT INTO AnswerTypeMultiple(question_type_fk, student_exam_fk)
                                VALUES(?, ?)";

            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmnt = $this->conn->prepare($sql);
            $stmnt->execute([$questionId, $studentExamId]);

            return $this->conn->lastInsertId();

        }
        catch(PDOException $e){
            echo "<div class='alert alert-danger' role='alert'>
                        Sorry, there was an error. " . $e->getMessage()."
                    </div>";
        }
    }

    private function insertOptionMarked($answer, $answerTypeId){

        try{

            $sql = "INSERT INTO OptionMarkedAsCorrect(option_type_fk, answer_type_fk)
                                VALUES(?, ?)";

            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmnt = $this->conn->prepare($sql);
            $stmnt->execute([$answer, $answerTypeId]);

        }
        catch(PDOException $e){
            echo "<div class='alert alert-danger' role='alert'>
                        Sorry, there was an error. " . $e->getMessage()."
                    </div>";
        }
    }

    public function insertAnswers($questionId, $studentExamId, $answers){

        $answerTypeId = null;

        foreach($answers as $key => $answer){

            $answerTypeId = $this->insertAnswerType($questionId, $studentExamId);

            $this->insertOptionMarked($answer["answer"], $answerTypeId);
        }
    }
}