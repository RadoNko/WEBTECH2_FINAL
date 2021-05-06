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

    private function findExamQuestions($examId){
        
        try{

            $sql = "SELECT id, name AS 'question'
                    FROM QuestionTypeConnect
                    WHERE exam_fk = ?";

            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmnt = $this->conn->prepare($sql);
            $stmnt->execute([$examId]);

            return $stmnt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOException $e){
            echo "<div class='alert alert-danger' role='alert'>
                        Sorry, there was an error. " . $e->getMessage()."
                    </div>";
        }

    }

    private function getQuestionOptions($question_fk){

        try{

            $sql = "SELECT id, answer AS 'option'
                    FROM OptionTypeConnect
                    WHERE question_type_fk = ?
                    AND is_left = 1";

            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmnt = $this->conn->prepare($sql);
            $stmnt->execute([$question_fk]);

            return $stmnt->fetchAll(PDO::FETCH_ASSOC);
        
        }
        catch(PDOException $e){
            echo "<div class='alert alert-danger' role='alert'>
                        Sorry, there was an error. " . $e->getMessage()."
                    </div>";
        }
    }

    private function getQuestionAnswers($question_fk){

        try{

            $sql = "SELECT id, answer
                    FROM OptionTypeConnect
                    WHERE question_type_fk = ?
                    AND is_left = 0";

            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmnt = $this->conn->prepare($sql);
            $stmnt->execute([$question_fk]);

            return $stmnt->fetchAll(PDO::FETCH_ASSOC);
        
        }
        catch(PDOException $e){
            echo "<div class='alert alert-danger' role='alert'>
                        Sorry, there was an error. " . $e->getMessage()."
                    </div>";
        }
    }

    public function getExamQuestions($examId){
        
        $questions = $this->findExamQuestions($examId);

        // questions with options (left side) and answers (right side)
        $data = [];

        foreach($questions as $question){

            $data[$question["question"]]["id"] = $question["id"];
            $data[$question["question"]]["options"] = $this->getQuestionOptions($question["id"]);
            $data[$question["question"]]["answers"] = $this->getQuestionAnswers($question["id"]);
        }

        return $data;
    }
}

?>