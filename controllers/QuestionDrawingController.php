<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "Database.php";

class QuestionDrawingController{
    public $connection;

    function __construct() {
        $this->connection=(new Database())->getConnection();
    }

    private function insertQuestion($name, $exam, $maxPoints){

        try{

            $sql = "INSERT INTO QuestionTypePicture(name, exam_fk, max_points) VALUES(?,?,?)";

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
}