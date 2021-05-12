<?php
if (session_status() != 2){
    session_start();
}

require_once "Database.php";

class AnswerMultipleController{
    private $conn;

    public function __construct(){
        $this->conn = (new Database())->getConnection();
    }

    private function insertAnswerType($questionId, $studentExamId){
        $studentExamId = $_SESSION["student_exam_id"];

        try{

            $sql = "INSERT INTO AnswerTypeMultiple(question_type_fk, student_exam_fk)
                                VALUES(?, ?)";

            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmnt = $this->conn->prepare($sql);
            $stmnt->execute([$questionId, $studentExamId]);

            return $this->conn->lastInsertId();

        }
        catch(PDOException $e){
            echo "<div class='alert alert-danger' role='alert'>
                        Sorry, there was an error. " . $e->getMessage()."
                    </div>";
        }
    }

    private function insertOptionMarked($answer, $answerTypeId){

        try{

            $sql = "INSERT INTO OptionMarkedAsCorrect(option_type_fk, answer_type_fk)
                                VALUES(?, ?)";

            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmnt = $this->conn->prepare($sql);
            $stmnt->execute([$answer, $answerTypeId]);

        }
        catch(PDOException $e){
            echo "<div class='alert alert-danger' role='alert'>
                        Sorry, there was an error. " . $e->getMessage()."
                    </div>";
        }
    }

    // returns how many correct answers question has
    private function getNumberOfCorrectAnswers($question){

        try{

            $sql = "SELECT COUNT(is_correct)
                    FROM OptionTypeMultiple
                    WHERE is_correct = 1
                    AND question_type_fk = ?";
            
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmnt = $this->conn->prepare($sql);
            $stmnt->execute([$question]);

            return $stmnt->fetchColumn();
        }
        catch(PDOException $e){
            echo "<div class='alert alert-danger' role='alert'>
                        Sorry, there was an error. " . $e->getMessage()."
                    </div>";
        }

    }

    private function getNumberOfAllAnswers($question){

        try{

            $sql = "SELECT COUNT(is_correct)
                    FROM OptionTypeMultiple
                    WHERE question_type_fk = ?";
            
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmnt = $this->conn->prepare($sql);
            $stmnt->execute([$question]);

            return $stmnt->fetchColumn();
        }
        catch(PDOException $e){
            echo "<div class='alert alert-danger' role='alert'>
                        Sorry, there was an error. " . $e->getMessage()."
                    </div>";
        }
    }

    private function getPointsForQuestion($question){

        try{

            $sql = "SELECT max_points
                    FROM QuestionTypeMultiple
                    WHERE id = ?";
            
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmnt = $this->conn->prepare($sql);
            $stmnt->execute([$question]);

            return $stmnt->fetchColumn();
        }
        catch(PDOException $e){
            echo "<div class='alert alert-danger' role='alert'>
                        Sorry, there was an error. " . $e->getMessage()."
                    </div>";
        }

    }

    private function getPointsForAnswer($answer, $maxPoints, $correctAnswers){

        try{

            $sql = "SELECT is_correct
                    FROM OptionTypeMultiple
                    WHERE id = ?";
            
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmnt = $this->conn->prepare($sql);
            $stmnt->execute([$answer]);

            $isCorrect = $stmnt->fetchColumn();

            if($isCorrect){

                return $maxPoints / $correctAnswers;
            }
            
            return 0;
        }
        catch(PDOException $e){
            echo "<div class='alert alert-danger' role='alert'>
                        Sorry, there was an error. " . $e->getMessage()."
                    </div>";
        }
    }

    private function insertPointsForAnswer($answerTypeId, $answer, $maxPoints, $numberOfCorrectAnswers, $numberOfStudentAnswers, $numberOfAllAnswers, $redundantAnswers){

        if($numberOfStudentAnswers == $numberOfAllAnswers){

            $points = 0;
        }
        else if(($numberOfStudentAnswers > $numberOfCorrectAnswers) && ($numberOfStudentAnswers < $numberOfAllAnswers)){

            $points = $this->getPointsForAnswer($answer, $maxPoints, $numberOfCorrectAnswers);

            if($points && $redundantAnswers){

                $points = 0;
                $redundantAnswers = $redundantAnswers - 1;
            }

        }
        else{

            $points = $this->getPointsForAnswer($answer, $maxPoints, $numberOfCorrectAnswers);
        }


        
        try{

            $sql = "UPDATE AnswerTypeMultiple
                    SET points = ?
                    WHERE id = ?";

            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmnt = $this->conn->prepare($sql);
            $stmnt->execute([$points, $answerTypeId]);

            return $redundantAnswers;

        }
        catch(PDOException $e){
            echo "<div class='alert alert-danger' role='alert'>
                        Sorry, there was an error. " . $e->getMessage()."
                    </div>";
        }
    }

    public function insertAnswers($questionId, $studentExamId, $answers){
        $studentExamId = $_SESSION["student_exam_id"];

        $answerTypeId = null;

        $correctQuestionAnswersNum = $this->getNumberOfCorrectAnswers($questionId);
        $numberOfAllAnswers = $this->getNumberOfAllAnswers($questionId);
        $pointsForQuestion = $this->getPointsForQuestion($questionId);
        $numberOfStudentAnswers = sizeof($answers);

        if(($numberOfStudentAnswers - $correctQuestionAnswersNum) >= 0){

            $redundantAnswers = $numberOfStudentAnswers - $correctQuestionAnswersNum;
        }
        
        foreach($answers as $key => $answer){

            $answerTypeId = $this->insertAnswerType($questionId, $studentExamId);

            $this->insertOptionMarked($answer["answer"], $answerTypeId);

            $redundantAnswers = $this->insertPointsForAnswer($answerTypeId, $answer["answer"], $pointsForQuestion, $correctQuestionAnswersNum, $numberOfStudentAnswers, $numberOfAllAnswers, $redundantAnswers);
            
        }
    }
}