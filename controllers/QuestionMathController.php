<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "Database.php";

class QuestionText{
    public $connection;

    function __construct() {
        $this->connection=(new Database())->getConnection();
    }


    private function insertExam($exam){

        try{

            $sql = "INSERT INTO Exam(name) VALUES(?)";

            $stm = $this->connection->prepare($sql);
            $stm->execute([$exam]);

            return $this->connection->lastInsertId();

        }
        catch(PDOException $e){
            echo "<div class='alert alert-danger' role='alert'>
                        Sorry, there was an error. " . $e->getMessage()."
                    </div>";
        }

    }

//    private function insertAnswer($question_fk,$answer,$student_exam_fk, $points){
//
//        try{
//            $sql = "INSERT INTO AnswerTypeText(question_type_fk, answer, student_exam_fk, points) VALUES(?, ?, ?,?)";
//            $stm = $this->connection->prepare($sql);
//            $stm->execute([$question_fk,$answer,$student_exam_fk,$points]);
//
//            //return $this->conn->lastInsertId();
//        }
//        catch(PDOException $e){
//            echo "<div class='alert alert-danger' role='alert'>
//                        Sorry, there was an error. " . $e->getMessage()."
//                    </div>";
//        }
//
//    }

    private function insertQuestion($name, $exam, $maxPoints){

        try{

            $sql = "INSERT INTO QuestionTypeText(name, exam_fk, max_points) VALUES(?,?,?)";

            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stm = $this->connection->prepare($sql);
            $stm->execute([$name, $exam, $maxPoints]);

            return $this->connection->lastInsertId();

        }
        catch(PDOException $e){
            echo "<div class='alert alert-danger' role='alert'>
                        Sorry, there was an error. " . $e->getMessage()."
                    </div>";
        }

    }

    public function addQuestion($data){

//        $examId = $this->insertExam(1);

        foreach($data as $key => $value){

            if($key === "question"){
                $questionId = $this->insertQuestion($data["question"], $data["answer"],1);
            }
        }
        return json_encode($questionId);
    }
}