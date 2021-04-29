<?php

require_once("Database.php");

class QuestionMultipleController{

    private PDO $conn;

    public function __construct(){
        $this->conn = (new Database())->getConnection();
    }

    private function insertTeacher($teacher){
        
        try{

            $sql = "INSERT INTO Teacher(username, password)
                                VALUES(?, ?)";

            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmnt = $this->conn->prepare($sql);
            $stmnt->execute([$teacher, "heslo"]);

            return $this->conn->lastInsertId();

        }
        catch(PDOException $e){
            echo "<div class='alert alert-danger' role='alert'>
                        Sorry, there was an error. " . $e->getMessage()."
                    </div>";
        }

    }

    private function insertExam($exam, $teacher){
        
        try{

            $sql = "INSERT INTO Exam(name, teacher_fk)
                                VALUES(?, ?)";

            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmnt = $this->conn->prepare($sql);
            $stmnt->execute([$exam, $teacher]);

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

        //$teacherId = $this->insertTeacher("ucitel");
        //$examId = $this->insertExam(1, $teacherId);
        
        foreach($data as $key => $value){

            if($key === "question"){

                $questionId = $this->insertQuestion($value, 2);
            }

            if($key === "answers"){
                foreach($value as $ansKey => $answer){

                    $this->insertAnswer($answer["name"], $answer["correct"], $questionId);
                    
                }
                
            }
            //echo $key;
            
        }
        //var_dump(json_decode($data));
    }
}

?>