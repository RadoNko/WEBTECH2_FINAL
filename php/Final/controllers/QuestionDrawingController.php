<?php
if (session_status() != 2){
    session_start();
}
require_once "Database.php";

class QuestionDrawingController{
    private $conn;

    public function __construct(){
        $this->conn = (new Database())->getConnection();
    }

    private function insertQuestion($name, $exam, $maxPoints){

        try{

            $sql = "INSERT INTO QuestionTypePicture(name, exam_fk, max_points) VALUES(?,?,?)";

            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stm = $this->conn->prepare($sql);
            $stm->execute([$name, $exam, $maxPoints]);

            return $this->conn->lastInsertId();

        }
        catch(PDOException $e){
            echo "<div class='alert alert-danger' role='alert'>
                        Sorry, there was an error. " . $e->getMessage()."
                    </div>";
        }

    }

    public function addQuestion($data){

        $examId = $_SESSION["exam_id"];

        foreach($data as $key => $value){

            if($key === "question"){
                $questionId = $this->insertQuestion($data["question"], $examId, $data["points"]);
            }
        }
        return json_encode($questionId);
    }

    private function findExamQuestions($examId){

        try{

            $sql = "SELECT id, name AS 'question',max_points AS 'points'
                    FROM QuestionTypePicture
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
            $data[$question["question"]]["points"] = $question["points"];

        }

        return $data;
    }
}