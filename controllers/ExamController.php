<?php

require_once("Database.php");
require_once("QuestionConnectController.php");
require_once("QuestionMultipleController.php");

class ExamController{

    private PDO $conn;

    public function __construct(){
        $this->conn = (new Database())->getConnection();
    }

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