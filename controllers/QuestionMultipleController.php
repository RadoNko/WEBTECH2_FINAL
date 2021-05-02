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

    private function findExamQuestions($examId){
        
        try{

            $sql = "SELECT id, name AS 'question'
                    FROM QuestionTypeMultiple
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

    public function getExamQuestions($examId){
        
        $questions = $this->findExamQuestions($examId);

        // questions with answers
        $data = [];

        foreach($questions as $question){

            try{

                $sql = "SELECT id, answer
                        FROM OptionTypeMultiple
                        WHERE question_type_fk = ?";

                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $stmnt = $this->conn->prepare($sql);
                $stmnt->execute([$question["id"]]);

                $data[$question["question"]]["id"] = $question["id"];
                $data[$question["question"]]["answers"] = $stmnt->fetchAll(PDO::FETCH_ASSOC);
            
            }
            catch(PDOException $e){
                echo "<div class='alert alert-danger' role='alert'>
                            Sorry, there was an error. " . $e->getMessage()."
                        </div>";
            }
        }

        return $data;
    }
}

?>