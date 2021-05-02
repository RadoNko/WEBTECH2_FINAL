<?php

require_once("Database.php");

class AnswerConnectController{

    private PDO $conn;

    public function __construct(){
        $this->conn = (new Database())->getConnection();
    }

    private function insertAnswerType($studentExamId, $questionId){

        try{

            $sql = "INSERT INTO AnswerTypeConnect(student_exam_fk, question_type_fk)
                                VALUES(?, ?)";

            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmnt = $this->conn->prepare($sql);
            $stmnt->execute([$studentExamId, $questionId]);

            return $this->conn->lastInsertId();

        }
        catch(PDOException $e){
            echo "<div class='alert alert-danger' role='alert'>
                        Sorry, there was an error. " . $e->getMessage()."
                    </div>";
        }
    }

    private function insertAnswerPairs($answerTypeId, $option, $answer){

        try{

            $sql = "INSERT INTO LeftOption(answer_type_fk, option_type_fk, connected_to)
                                VALUES(?, ?, ?)";

            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmnt = $this->conn->prepare($sql);
            $stmnt->execute([$answerTypeId, $option, $answer]);

        }
        catch(PDOException $e){
            echo "<div class='alert alert-danger' role='alert'>
                        Sorry, there was an error. " . $e->getMessage()."
                    </div>";
        }
    }

    public function insertAnswers($studentExamId, $questionId, $pairs){

        $answerTypeId = null;

        foreach($pairs as $key => $pair){

            $answerTypeId = $this->insertAnswerType($studentExamId, $questionId);

            $this->insertAnswerPairs($answerTypeId, $pair["question"], $pair["answer"]);
        }
    }
}