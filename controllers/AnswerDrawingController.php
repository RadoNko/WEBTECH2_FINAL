<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "Database.php";

class AnswerDrawingController{
    private PDO $conn;

    public function __construct(){
        $this->conn = (new Database())->getConnection();
    }

    public function insertAnswer($student_exam_fk, $question_fk, $answer, $img){

        //see http://j-query.blogspot.fr/2011/02/save-base64-encoded-canvas-image-to-png.html
        $img = str_replace(' ', '+', str_replace('data:image/png;base64,', '', $img));
        $data = base64_decode($img);

        //create the image png file with the given name
        file_put_contents('/home/xfullajtar/public_html/Final/drawings/'. str_replace(' ', '_', $question_fk).'.png', $data);

        try{
            $sql = "INSERT INTO AnswerTypePicture(question_type_fk, answer, student_exam_fk) VALUES(?, ?, ?)";
            $stm = $this->conn->prepare($sql);
            $stm->execute([$question_fk,$answer,$student_exam_fk]);

            //return $this->conn->lastInsertId();
        }
        catch(PDOException $e){
            echo "<div class='alert alert-danger' role='alert'>
                        Sorry, there was an error. " . $e->getMessage()."
                    </div>";
        }

    }

    private function setScore($points, $questionId){ //score set manually by teacher

        try{
            $stmt = $this->conn->prepare("UPDATE AnswerTypePicture SET points =:points WHERE id =:questionId");
            $stmt->bindParam(":points", $points); //TODO add PDO:: for float
            $stmt->bindParam(":questionId", $questionId, PDO::PARAM_INT);
            $stmt->execute();

            //return $this->conn->lastInsertId();
        }
        catch(PDOException $e){
            echo "<div class='alert alert-danger' role='alert'>
                        Sorry, there was an error. " . $e->getMessage()."
                    </div>";
        }

    }

}