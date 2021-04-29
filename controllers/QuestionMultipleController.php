<?php

require_once("Database.php");

class QuestionMultipleController{

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

    private function insertAnswer($answer, $correct, $question){

        try{

            $sql = "INSERT INTO OptionTypeMultiple(answer, is_correct, question_type_fk)
                                VALUES(?, ?, ?)";

            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmnt = $this->conn->prepare($sql);
            $stmnt->execute([$answer, $correct, $question]);

            //return $this->conn->lastInsertId();

        }
        catch(PDOException $e){
            echo "<div class='alert alert-danger' role='alert'>
                        Sorry, there was an error. " . $e->getMessage()."
                    </div>";
        }

    }

    private function insertQuestion($question, $exam){

        try{

            $sql = "INSERT INTO QuestionTypeMultiple(name, exam_fk)
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

    public function insertQuestionAndAnswers($data){

        $examId = $this->insertExam(1);
        
        foreach($data as $key => $value){

            if($key === "question"){

                $questionId = $this->insertQuestion($value, $examId);
            }

            if($key === "answers"){

                foreach($value as $ansKey => $answer){

                    $this->insertAnswer($answer["name"], $answer["correct"], $questionId);
                }
            }            
        }
    }
}

?>