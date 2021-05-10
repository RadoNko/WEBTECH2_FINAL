<?php
session_start();
require_once("Database.php");
require_once("QuestionConnectController.php");
require_once("QuestionMultipleController.php");
require_once("QuestionMathController.php");
require_once("QuestionDrawingController.php");
require_once("QuestionText.php");
require_once ("AnswerMathController.php");


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
        $questionDrawingController = new QuestionDrawingController();

        $questionsMath = $questionMathController->getExamQuestions($examId);
        $questionsDrawing = $questionDrawingController->getExamQuestions($examId);


        if (!empty($questionsConnect)) {

            $exam["QuestionTypeConnect"] = $questionsConnect;
        }

        if (!empty($questionsMultiple)) {

            $exam["QuestionTypeMultiple"] = $questionsMultiple;
        }

        if (!empty($questionsMath)) { //fullajtar

            $exam["QuestionTypeMath"] = $questionsMath;
        }

        if (!empty($questionsDrawing)) { //fullajtar

            $exam["QuestionTypeDrawing"] = $questionsDrawing;
        }
        $questionTextController = new QuestionText();

        $questionsText = $questionTextController->getExamQuestions($examId);

        if(!empty($questionsText)){

            $exam["QuestionTypeText"] = $questionsText;
        }



        return json_encode($exam, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    public function create($name, $time, $code)
    {
        try {
            $sql = "INSERT INTO Exam(name,teacher_fk,code,is_active, time) VALUES (?,?,?,0,?)";
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmnt = $this->conn->prepare($sql);
            $stmnt->execute([$name, $_SESSION["logged_id"], $code, $time]);

            $_SESSION["exam_id"] = $this->conn->lastInsertId();
            return json_encode($stmnt->fetchAll(PDO::FETCH_ASSOC), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        } catch (PDOException $e) {
            echo "<div class='alert alert-danger' role='alert'>
                        Sorry, there was an error. " . $e->getMessage() . "
                    </div>";
        }
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

    public function getRateExam($student_exam_fk){

        $exam = [];

        $questionConnectController = new QuestionConnectController();
        $questionMultipleController = new QuestionMultipleController();

        $answersConnect = $questionConnectController->getStudentExamAnswers($student_exam_fk);
        $answersMultiple = $questionMultipleController->getStudentExamAnswers($student_exam_fk);

        $answerMathController = new AnswerMathController();
        $answersMath = $answerMathController->getAnswerWithQuestion($student_exam_fk);

        $answerDrawingController = new AnswerDrawingController();
        $answersDrawing = $answerDrawingController->getAnswerWithQuestion($student_exam_fk);

        $questionTextController = new QuestionText();
        $questionsText = $questionTextController->getAnswerWithQuestion($student_exam_fk);

        if(!empty($answersConnect)){

            $exam["QuestionTypeConnect"] = $answersConnect;
        }

        if(!empty($answersMultiple)){

            $exam["QuestionTypeMultiple"] = $answersMultiple;
        }

        if (!empty($answersMath)) {
            $exam["AnswerTypeMath"] = $answersMath;
        }

        if (!empty($answersDrawing)) {
            $exam["AnswerTypeDrawing"] = $answersDrawing;
        }

        if (!empty($questionsText)) {
            $exam["AnswerTypeText"] = $questionsText;
        }

        return json_encode($exam, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
}