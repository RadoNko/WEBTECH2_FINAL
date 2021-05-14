<?php
if (session_status() != 2){
    session_start();
}
require_once("Database.php");
require_once("QuestionConnectController.php");
require_once("QuestionMultipleController.php");
require_once("QuestionMathController.php");
require_once("QuestionDrawingController.php");
require_once("QuestionText.php");
require_once("AnswerMathController.php");


class ExamController
{

    private $conn;

    public function __construct()
    {
        $this->conn = (new Database())->getConnection();
    }

    public function getExam($examId)
    {
        $examId = $_SESSION["exam_id"];
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
            return true;
            //return json_encode($stmnt->fetchAll(PDO::FETCH_ASSOC), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        } catch (PDOException $e) {
            echo "<div class='alert alert-danger' role='alert'>
                        Sorry, there was an error. " . $e->getMessage() . "
                    </div>";
        }
    }

    public function timeLeft()
    {
        try {
            $sql = "SELECT time FROM Exam where id = ?";

            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmnt = $this->conn->prepare($sql);
            $stmnt->execute([$_SESSION["exam_id"]]);

            $minutesToFinish = $stmnt->fetchAll(PDO::FETCH_ASSOC)[0]['time'];

            $sql = "SELECT start_time FROM Student_Exam WHERE student_fk = ?";
            $stmnt = $this->conn->prepare($sql);
            $stmnt->execute([$_SESSION["logged_id"]]);

            $finishUntil = strtotime($stmnt->fetchAll(PDO::FETCH_ASSOC)[0]['start_time']) + ($minutesToFinish * 60);

            return json_encode($finishUntil - time(), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
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
        $student_exam_fk=$_SESSION["student_exam_id"];

        $questionConnectController = new QuestionConnectController();
        $questionMultipleController = new QuestionMultipleController();

        $answersConnect = $questionConnectController->getStudentExamAnswers($student_exam_fk);
        $answersMultiple = $questionMultipleController->getStudentExamAnswers($student_exam_fk);

        $answerMathController = new AnswerMathController();
        $answersMath = $answerMathController->getAnswerWithQuestion();

        $answerDrawingController = new AnswerDrawingController();
        $answersDrawing = $answerDrawingController->getAnswerWithQuestion();

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

    public function getExamName($id){
        try {
            $sql = "SELECT name FROM Exam WHERE id = ?";
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmnt = $this->conn->prepare($sql);
            $stmnt->execute([$id]);

            return $stmnt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "<div class='alert alert-danger' role='alert'>
                        Sorry, there was an error. " . $e->getMessage() . "
                    </div>";
        }

        return json_encode($stmnt, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    public function updateStudentStatus(){

        $student_exam_fk = $_SESSION["student_exam_id"];

        try{

            $sql = "UPDATE Student_Exam
                    SET is_finished = 1
                    WHERE id = ?";
            
            $stmnt = $this->conn->prepare($sql);
            $stmnt->execute([$student_exam_fk]);
            
        }
        catch (PDOException $e) {
            echo "<div class='alert alert-danger' role='alert'>
                        Sorry, there was an error. " . $e->getMessage() . "
                    </div>";
        }


    }
}