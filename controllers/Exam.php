<?php

require_once "Database.php";



class Exam{

    private $connection;

    public function __construct(){
        $this->connection = (new Database())->getConnection();
    }
    public function getExam($examId){
        $exam = [];



        return json_encode($exam, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
}
