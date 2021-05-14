<?php
if (session_status() != 2){
    session_start();
}
require_once("Database.php");

class QuestionConnectController{

    private $conn;

    public function __construct(){
        $this->conn = (new Database())->getConnection();
    }

    private function insertParentQuestion($question, $exam, $points){

        try{

            $sql = "INSERT INTO QuestionTypeConnect(name, exam_fk, max_points)
                                VALUES(?, ?, ?)";

            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmnt = $this->conn->prepare($sql);
            $stmnt->execute([$question, $exam, $points]);

            return $this->conn->lastInsertId();

        }
        catch(PDOException $e){
            echo "<div class='alert alert-danger' role='alert'>
                        Sorry, there was an error. " . $e->getMessage()."
                    </div>";
        }

    }

    private function insertAnswerFromPair($answer, $is_left, $question_type){

        try{

            $sql = "INSERT INTO OptionTypeConnect(answer, is_left, question_type_fk)
                                VALUES(?, ?, ?)";

            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmnt = $this->conn->prepare($sql);
            $stmnt->execute([$answer, $is_left, $question_type]);

            return $this->conn->lastInsertId();

        }
        catch(PDOException $e){
            echo "<div class='alert alert-danger' role='alert'>
                        Sorry, there was an error. " . $e->getMessage()."
                    </div>";
        }

    }

    private function insertQuestionFromPair($question, $is_left, $question_type, $answer){

        try{

            $sql = "INSERT INTO OptionTypeConnect(answer, is_left, question_type_fk, connect_option_fk)
                                VALUES(?, ?, ?, ?)";

            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmnt = $this->conn->prepare($sql);
            $stmnt->execute([$question, $is_left, $question_type, $answer]);

            return $this->conn->lastInsertId();

        }
        catch(PDOException $e){
            echo "<div class='alert alert-danger' role='alert'>
                        Sorry, there was an error. " . $e->getMessage()."
                    </div>";
        }

    }


    public function insertQuestionAndAnswers($data){

        //$examId = $this->insertExam(1);
        
        foreach($data as $key => $value){

            if($key === "question"){

                $questionId = $this->insertParentQuestion($value, $_SESSION["exam_id"], $data["points"]);
            }

            if($key === "pairs"){

                foreach($value as $pairKey => $pair){

                    $answerId = $this->insertAnswerFromPair($pair["answer"], 0, $questionId);
                    $this->insertQuestionFromPair($pair["question"], 1, $questionId, $answerId);
                }
            }            
        }
    }

    private function findExamQuestions($examId){
        
        try{

            $sql = "SELECT id, name AS 'question', max_points AS 'points'
                    FROM QuestionTypeConnect
                    WHERE exam_fk = ?";

            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmnt = $this->conn->prepare($sql);
            $stmnt->execute([$examId]);

            return $stmnt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOException $e){
            echo "<div class='alert alert-danger' role='alert'>
                        Sorry, there was an error. " . $e->getMessage()."
                    </div>";
        }

    }

    private function getQuestionOptions($question_fk){

        try{

            $sql = "SELECT id, answer AS 'option'
                    FROM OptionTypeConnect
                    WHERE question_type_fk = ?
                    AND is_left = 1";

            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmnt = $this->conn->prepare($sql);
            $stmnt->execute([$question_fk]);

            return $stmnt->fetchAll(PDO::FETCH_ASSOC);
        
        }
        catch(PDOException $e){
            echo "<div class='alert alert-danger' role='alert'>
                        Sorry, there was an error. " . $e->getMessage()."
                    </div>";
        }
    }

    private function getQuestionAnswers($question_fk){

        try{

            $sql = "SELECT id, answer
                    FROM OptionTypeConnect
                    WHERE question_type_fk = ?
                    AND is_left = 0";

            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmnt = $this->conn->prepare($sql);
            $stmnt->execute([$question_fk]);

            return $stmnt->fetchAll(PDO::FETCH_ASSOC);
        
        }
        catch(PDOException $e){
            echo "<div class='alert alert-danger' role='alert'>
                        Sorry, there was an error. " . $e->getMessage()."
                    </div>";
        }
    }

    public function getExamQuestions($examId){
        
        $questions = $this->findExamQuestions($examId);

        // questions with options (left side) and answers (right side)
        $data = [];

        foreach($questions as $question){

            $data[$question["question"]]["id"] = $question["id"];
            $data[$question["question"]]["points"] = $question["points"];
            $data[$question["question"]]["options"] = $this->getQuestionOptions($question["id"]);
            $data[$question["question"]]["answers"] = $this->getQuestionAnswers($question["id"]);
        }

        return $data;
    }

    private function getExamId($studentExamId){
        
        try{

            $sql = "SELECT exam_fk
                    FROM Student_Exam
                    WHERE id = ?";

            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmnt = $this->conn->prepare($sql);
            $stmnt->execute([$studentExamId]);

            return $stmnt->fetchColumn();
        }
        catch(PDOException $e){
            echo "<div class='alert alert-danger' role='alert'>
                        Sorry, there was an error. " . $e->getMessage()."
                    </div>";
        }

    }

    private function findStudentExamQuestions($studentExamId){
        
        $examId = $this->getExamId($studentExamId);

        try{

            $sql = "SELECT qtc.id, qtc.name AS 'question', qtc.max_points AS 'max_points', SUM(atc.points) AS 'earned_points'
                    FROM QuestionTypeConnect qtc
                    JOIN AnswerTypeConnect atc ON qtc.id = atc.question_type_fk
                    WHERE exam_fk = ?
                    AND atc.student_exam_fk = ?
                    GROUP BY qtc.id";

            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmnt = $this->conn->prepare($sql);
            $stmnt->execute([$examId, $_SESSION["student_exam_id"]]);

            return $stmnt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch(PDOException $e){
            echo "<div class='alert alert-danger' role='alert'>
                        Sorry, there was an error. " . $e->getMessage()."
                    </div>";
        }
    }
    
    private function getStudentExamQuestionAnswers($question_fk){

        try{

            $sql = "SELECT lo.connected_to, otc.answer
                    FROM OptionTypeConnect otc
                    JOIN LeftOption lo ON otc.id = lo.connected_to
                    JOIN AnswerTypeConnect atc ON lo.answer_type_fk = atc.id
                    WHERE otc.question_type_fk = ?
                    AND otc.is_left = 0
                    AND atc.student_exam_fk = ?
                    ORDER BY lo.option_type_fk";

            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmnt = $this->conn->prepare($sql);
            $stmnt->execute([$question_fk, $_SESSION["student_exam_id"]]);

            return $stmnt->fetchAll(PDO::FETCH_ASSOC);
        
        }
        catch(PDOException $e){
            echo "<div class='alert alert-danger' role='alert'>
                        Sorry, there was an error. " . $e->getMessage()."
                    </div>";
        }
    }

    public function getStudentExamAnswers($studentExamId){
        
        $questions = $this->findStudentExamQuestions($studentExamId);

        // questions with options (left side) and answers (right side)
        $data = [];

        foreach($questions as $question){

            $data[$question["question"]]["id"] = $question["id"];
            $data[$question["question"]]["max_points"] = $question["max_points"];
            $data[$question["question"]]["earned_points"] = $question["earned_points"];
            $data[$question["question"]]["options"] = $this->getQuestionOptions($question["id"]);
            $data[$question["question"]]["answers"] = $this->getStudentExamQuestionAnswers($question["id"]);
        }

        return $data;
    }
}

?>