<?php

require_once "../../Database.php";
require_once("QuestionText.php");



class Exam{

    private $connection;

    public function __construct(){
        $this->connection = (new Database())->getConnection();
    }
    public function getExam($examId){
        $exam = [];

        $questionTextController = new QuestionText();

        $questionsText = $questionTextController->getExamQuestions($examId);

        if(!empty($questionsText)){

            $exam["QuestionTypeText"] = $questionsText;
        }

        return json_encode($exam, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
}
