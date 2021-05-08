<?php

require_once("Database.php");

class AnswerConnectController{

    private PDO $conn;

    public function __construct(){
        $this->conn = (new Database())->getConnection();
    }

    // this inserts points too
    private function insertAnswerType($studentExamId, $questionId, $pointsForQuestion, $numberOfPairs, $option, $answer){

        $points = 0;

        if($option - 1 == $answer){

            $points = $pointsForQuestion / $numberOfPairs;
        }
       
        try{

            $sql = "INSERT INTO AnswerTypeConnect(student_exam_fk, question_type_fk, points)
                                VALUES(?, ?, ?)";

            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmnt = $this->conn->prepare($sql);
            $stmnt->execute([$studentExamId, $questionId, $points]);

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

    private function getPointsForQuestion($question){

        try{

            $sql = "SELECT max_points
                    FROM QuestionTypeConnect
                    WHERE id = ?";
            
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmnt = $this->conn->prepare($sql);
            $stmnt->execute([$question]);

            return $stmnt->fetchColumn();
        }
        catch(PDOException $e){
            echo "<div class='alert alert-danger' role='alert'>
                        Sorry, there was an error. " . $e->getMessage()."
                    </div>";
        }

    } 

    public function insertAnswers($studentExamId, $questionId, $pairs){

        $answerTypeId = null;

        $pointsForQuestion = $this->getPointsForQuestion($questionId);
        $numberOfPairs = sizeof($pairs);
        
        foreach($pairs as $key => $pair){

            $answerTypeId = $this->insertAnswerType($studentExamId, $questionId, $pointsForQuestion, $numberOfPairs, $pair["question"], $pair["answer"]);

            $this->insertAnswerPairs($answerTypeId, $pair["question"], $pair["answer"]);
        }
    }
}