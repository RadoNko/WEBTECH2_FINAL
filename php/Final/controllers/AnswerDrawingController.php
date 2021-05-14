<?php
if (session_status() != 2){
    session_start();
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "Database.php";

class AnswerDrawingController{
    private $conn;

    public function __construct(){
        $this->conn = (new Database())->getConnection();
    }

    public function insertAnswer($question_fk, $img){
        $student_exam_fk = $_SESSION["student_exam_id"];

        //see http://j-query.blogspot.fr/2011/02/save-base64-encoded-canvas-image-to-png.html
        $img = str_replace(' ', '+', str_replace('data:image/png;base64,', '', $img));
        $data = base64_decode($img);

        //create the image png file with the given name
        file_put_contents(dirname(__DIR__).'/drawings/'. str_replace(' ', '_', $student_exam_fk.'-'.$question_fk).'.png', $data);

        try{
            $sql = "INSERT INTO AnswerTypePicture(question_type_fk, student_exam_fk) VALUES(?, ?)";
            $stm = $this->conn->prepare($sql);
            $stm->execute([$question_fk, $student_exam_fk]);
        }
        catch(PDOException $e){
            echo "<div class='alert alert-danger' role='alert'>
                        Sorry, there was an error. " . $e->getMessage()."
                    </div>";
        }

    }

    public function setScore($points, $questionId){ //score set manually by teacher

        try{
            $stmt = $this->conn->prepare("UPDATE AnswerTypePicture SET points =:points WHERE question_type_fk =:questionId");
            $stmt->bindParam(":points", $points); //TODO add PDO:: for float
            $stmt->bindParam(":questionId", $questionId, PDO::PARAM_INT);
            $stmt->execute();

            return $this->conn->lastInsertId();
        }
        catch(PDOException $e){
            echo "<div class='alert alert-danger' role='alert'>
                        Sorry, there was an error. " . $e->getMessage()."
                    </div>";
        }

    }

    public function getAnswerWithQuestion(){
        $student_exam_fk = $_SESSION["student_exam_id"];
        try{
            $stmt = $this->conn->prepare("SELECT * FROM AnswerTypePicture INNER JOIN QuestionTypePicture ON AnswerTypePicture.question_type_fk = QuestionTypePicture.id WHERE AnswerTypePicture.student_exam_fk =:student_exam_fk");
            $stmt->bindParam(":student_exam_fk", $student_exam_fk, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOException $e){
            echo "<div class='alert alert-danger' role='alert'>
                        Sorry, there was an error. " . $e->getMessage()."
                    </div>";
        }
    }

}