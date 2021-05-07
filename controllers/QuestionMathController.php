<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "Database.php";

class QuestionMathController{
    public $connection;

    function __construct() {
        $this->connection=(new Database())->getConnection();
    }

    private function insertQuestion($name, $exam, $maxPoints){
        try{
            $sql = "INSERT INTO QuestionTypeMath(name, exam_fk, max_points) VALUES(?,?,?)";
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
       $examId = 1;//TODO //$this->insertExam(1);
        foreach($data as $key => $value){

            if($key === "question"){
                $questionId = $this->insertQuestion($data["question"], $examId, $data["points"]);
            }
        }
        return json_encode($questionId);
    }

    private function findExamQuestions($examId){

        try{

            $sql = "SELECT id, name AS 'question'
                    FROM QuestionTypeMath
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

        // questions with options (left side) and answers (right side)
        $data = [];

        foreach($questions as $question){
            $data[$question["question"]]["id"] = $question["id"];
        }

        return $data;
    }
}