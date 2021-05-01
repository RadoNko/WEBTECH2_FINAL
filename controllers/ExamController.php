<?php

require_once("Database.php");
require_once("QuestionConnectController.php");
require_once("QuestionMultipleController.php");

class ExamController{

    private PDO $conn;

    public function __construct(){
        $this->conn = (new Database())->getConnection();
    }


    /* 
        READ ME YA CUNT

        Each question controller is called to get its question(s) for exam.
        If that type of question is not present in the exam, we filter it out through good ol' if(...) and don't store it in the exam array.
        The whole exam is returned as string in json format, so make sure that you follow the template in if(...) below.
        Exam keys (question types) MUST start with an uppercase letter because of javascript functionality on frontend.
    */
    public function getExam($examId){

        $exam = [];

        $questionConnectController = new QuestionConnectController();
        $questionMultipleController = new QuestionMultipleController();

        $questionsConnect = $questionConnectController->getExamQuestions($examId);
        $questionsMultiple = $questionMultipleController->getExamQuestions($examId);

        if(!empty($questionsConnect)){

            $exam["QuestionTypeConnect"] = $questionsConnect;
        }

        if(!empty($questionsMultiple)){

            $exam["QuestionTypeMultiple"] = $questionsMultiple;
        }
        
        return json_encode($exam, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
}