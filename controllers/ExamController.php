<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("Database.php");
require_once("QuestionConnectController.php");
require_once("QuestionMultipleController.php");
require_once("QuestionMathController.php");

class ExamController
{

    private PDO $conn;

    public function __construct()
    {
        $this->conn = (new Database())->getConnection();
    }


    /* 
        READ ME YA CUNT

        Each question controller is called to get its question(s) for exam.
        If that type of question is not present in the exam, we filter it out through good ol' if(...) and don't store it in the exam array.
        The whole exam is returned as string in json format, so make sure that you follow the template in if(...) below.
        Exam keys (question types) MUST start with an uppercase letter because of javascript functionality on frontend.
    */
    public function getExam($examId)
    {

        $exam = [];

        $questionConnectController = new QuestionConnectController();
        $questionMultipleController = new QuestionMultipleController();

        $questionsConnect = $questionConnectController->getExamQuestions($examId);
        $questionsMultiple = $questionMultipleController->getExamQuestions($examId);

        //fullajtar
        $questionMathController = new QuestionMathController();
        $questionsMath = $questionMathController->getExamQuestions($examId);

        if (!empty($questionsConnect)) {

            $exam["QuestionTypeConnect"] = $questionsConnect;
        }

        if (!empty($questionsMultiple)) {

            $exam["QuestionTypeMultiple"] = $questionsMultiple;
        }

        if (!empty($questionsMath)) { //fullajtar

            $exam["QuestionTypeMath"] = $questionsMath;
        }

        return json_encode($exam, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    public function getAll()
    {

        try {
            $sql = "SELECT id, name, teacher_fk, code, is_active FROM Exam";

            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmnt = $this->conn->prepare($sql);
            $stmnt->execute();

            return json_encode($stmnt->fetchAll(PDO::FETCH_ASSOC), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        } catch (PDOException $e) {
            echo "<div class='alert alert-danger' role='alert'>
                        Sorry, there was an error. " . $e->getMessage() . "
                    </div>";
        }

        return json_encode($stmnt, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    public function toggle($examId)
    {
        try {
            $sql = "UPDATE Exam SET is_active = IF(is_active=1, 0, 1) WHERE id = ?";

            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmnt = $this->conn->prepare($sql);
            $stmnt->execute([$examId]);

            return json_encode($stmnt->fetchAll(PDO::FETCH_ASSOC), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        } catch (PDOException $e) {
            echo "<div class='alert alert-danger' role='alert'>
                        Sorry, there was an error. " . $e->getMessage() . "
                    </div>";
        }
    }
}
