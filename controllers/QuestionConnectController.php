<?php

require_once("Database.php");

class QuestionConnectController{

    private PDO $conn;

    public function __construct(){
        $this->conn = (new Database())->getConnection();
    }

    private function insertExam($exam){
        
        try{

            $sql = "INSERT INTO Exam(name)
                                VALUES(?)";

            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmnt = $this->conn->prepare($sql);
            $stmnt->execute([$exam]);

            return $this->conn->lastInsertId();

        }
        catch(PDOException $e){
            echo "<div class='alert alert-danger' role='alert'>
                        Sorry, there was an error. " . $e->getMessage()."
                    </div>";
        }

    }

    private function insertParentQuestion($question, $exam){

        try{

            $sql = "INSERT INTO QuestionTypeConnect(name, exam_fk)
                                VALUES(?, ?)";

            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmnt = $this->conn->prepare($sql);
            $stmnt->execute([$question, $exam]);

            return $this->conn->lastInsertId();

        }
        catch(PDOException $e){
            echo "<div class='alert alert-danger' role='alert'>
                        Sorry, there was an error. " . $e->getMessage()."
                    </div>";
        }

    }

    private function insertAnswerFromPair($answer, $is_left, $question_type){

        try{

            $sql = "INSERT INTO OptionTypeConnect(answer, is_left, question_type_fk)
                                VALUES(?, ?, ?)";

            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmnt = $this->conn->prepare($sql);
            $stmnt->execute([$answer, $is_left, $question_type]);

            return $this->conn->lastInsertId();

        }
        catch(PDOException $e){
            echo "<div class='alert alert-danger' role='alert'>
                        Sorry, there was an error. " . $e->getMessage()."
                    </div>";
        }

    }

    private function insertQuestionFromPair($question, $is_left, $question_type, $answer){

        try{

            $sql = "INSERT INTO OptionTypeConnect(answer, is_left, question_type_fk, connect_option_fk)
                                VALUES(?, ?, ?, ?)";

            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmnt = $this->conn->prepare($sql);
            $stmnt->execute([$question, $is_left, $question_type, $answer]);

            return $this->conn->lastInsertId();

        }
        catch(PDOException $e){
            echo "<div class='alert alert-danger' role='alert'>
                        Sorry, there was an error. " . $e->getMessage()."
                    </div>";
        }

    }


    public function insertQuestionAndAnswers($data){

        $examId = $this->insertExam(1);
        
        foreach($data as $key => $value){

            if($key === "question"){

                $questionId = $this->insertParentQuestion($value, $examId);
            }

            if($key === "pairs"){

                foreach($value as $pairKey => $pair){

                    $answerId = $this->insertAnswerFromPair($pair["answer"], 0, $questionId);
                    $this->insertQuestionFromPair($pair["question"], 1, $questionId, $answerId);
                }
            }            
        }
    }
}

?>