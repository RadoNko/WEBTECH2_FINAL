<?php
if (session_status() != 2){
    session_start();
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once "Database.php";

class QuestionText
{
    public $conn;

    function __construct()
    {
        $this->conn = (new Database())->getConnection();
    }

    private function insertQuestion($name, $correct_answer, $exam, $points)
    {

        try {

            $sql = "INSERT INTO QuestionTypeText(name,correct_answer, exam_fk, max_points) VALUES(?,?,?,?)";

            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stm = $this->conn->prepare($sql);
            $stm->execute([$name, $correct_answer, $exam, $points]);

            return $this->conn->lastInsertId();

        } catch (PDOException $e) {
            echo "<div class='alert alert-danger' role='alert'>
                        Sorry, there was an error. " . $e->getMessage() . "
                    </div>";
        }

    }

    public function addQuestion($data)
    {

        foreach ($data as $key => $value) {

            if ($key === "question") {
                $questionId = $this->insertQuestion($data["question"], $data["answer"], $_SESSION["exam_id"], $data["points"]);
            }
        }

        return json_encode($questionId);
    }


    public function getExamQuestions($examId)
    {


        $sql = "SELECT id, name AS 'question',max_points AS 'points' FROM QuestionTypeText WHERE exam_fk = ?";

        $stm = $this->conn->prepare($sql);
        $stm->execute([$examId]);

        $questions = $stm->fetchAll(PDO::FETCH_ASSOC);

        $data = [];

        foreach ($questions as $question) {
            $data[$question["question"]]["id"] = $question["id"];
            $data[$question["question"]]["points"] = $question["points"];
        }

        return $data;
    }

    private function getCorrectAnswer($data)
    {
        $sql = "SELECT correct_answer, max_points FROM QuestionTypeText WHERE id=? AND exam_fk = ?";
        $stm = $this->conn->prepare($sql);
        $stm->execute([$data["questionId"], $data["examId"]]);
        return $stm->fetch(PDO::FETCH_ASSOC);
    }

    public function insertAnswers($data)
    {
        // odpoved $data["answers"][0]["answer"];
        // $data["examId"], $data["studentId"], $data["studentExamId"], $data["questionId"]
        //  potom sa budu niektore data brat zo session
        $answer = $data["answers"][0]["answer"];

        try {
            //vyber spravnu odpoved + pocet bodov za nu
            $result = $this->getCorrectAnswer($data);


            $sql = "INSERT INTO AnswerTypeText(question_type_fk,answer, student_exam_fk, points) VALUES(?,?,?,?)";
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stm = $this->conn->prepare($sql);

            if ($result["correct_answer"] == $answer) {
                //odpovede sedia -> dostane max body
                $stm->execute([$data["questionId"], $answer, $data["studentExamId"], $result["max_points"]]);
                return $this->conn->lastInsertId();
            } else {
                //odpovede nesedia -> dostane holy bačov
                $stm->execute([$data["questionId"], $answer, $data["studentExamId"], 0]);
                return $this->conn->lastInsertId();
            }

        } catch (PDOException $e) {
            echo "<div class='alert alert-danger' role='alert'>
                        Sorry, there was an error. " . $e->getMessage() . "
                    </div>";
        }

    }

    public function getAnswerWithQuestion($student_exam_fk){
        //SELECT * FROM `AnswerTypeMath` INNER JOIN QuestionTypeMath ON AnswerTypeMath.question_type_fk = QuestionTypeMath.id WHERE AnswerTypeMath.student_exam_fk = 1
        try{
            $stm = $this->conn->prepare("SELECT * FROM AnswerTypeText INNER JOIN QuestionTypeText ON AnswerTypeText.question_type_fk = QuestionTypeText.id WHERE AnswerTypeText.student_exam_fk =:student_exam_fk");
            $stm->bindParam(":student_exam_fk", $student_exam_fk, PDO::PARAM_INT);
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOException $e){
            echo "<div class='alert alert-danger' role='alert'>
                        Sorry, there was an error. " . $e->getMessage()."
                    </div>";
        }
    }

    public function setScore($points, $answerId){ //score set manually by teacher

        try{
            $stmt = $this->conn->prepare("UPDATE AnswerTypeText SET points =:points WHERE id =:answerId");
            $stmt->bindParam(":points", $points); //TODO add PDO:: for float
            $stmt->bindParam(":answerId", $answerId, PDO::PARAM_INT);
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