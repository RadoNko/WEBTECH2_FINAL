<?php
if (session_status() != 2){
    session_start();
}
require_once("Database.php");

class QuestionMultipleController{

    private $conn;

    public function __construct(){
        $this->conn = (new Database())->getConnection();
    }

    private function insertExam($exam){
        
        try{

            $sql = "INSERT INTO Exam(name)
                                VALUES(?)";

            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmnt = $this->conn->prepare($sql);
            $stmnt->execute([$exam]);

            return $this->conn->lastInsertId();

        }
        catch(PDOException $e){
            echo "<div class='alert alert-danger' role='alert'>
                        Sorry, there was an error. " . $e->getMessage()."
                    </div>";
        }

    }

    private function insertAnswer($answer, $correct, $question){

        try{

            $sql = "INSERT INTO OptionTypeMultiple(answer, is_correct, question_type_fk)
                                VALUES(?, ?, ?)";

            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmnt = $this->conn->prepare($sql);
            $stmnt->execute([$answer, $correct, $question]);

            //return $this->conn->lastInsertId();

        }
        catch(PDOException $e){
            echo "<div class='alert alert-danger' role='alert'>
                        Sorry, there was an error. " . $e->getMessage()."
                    </div>";
        }

    }

    private function insertQuestion($question, $exam, $points){

        try{

            $sql = "INSERT INTO QuestionTypeMultiple(name, exam_fk, max_points)
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

    public function insertQuestionAndAnswers($data){

        //$examId = $this->insertExam(1);
        
        foreach($data as $key => $value){

            if($key === "question"){

                $questionId = $this->insertQuestion($value, $_SESSION["exam_id"], $data["points"]);
            }

            if($key === "answers"){

                foreach($value as $ansKey => $answer){

                    $this->insertAnswer($answer["name"], $answer["correct"], $questionId);
                }
            }          
        }
    }

    private function findExamQuestions($examId){
        
        try{

            $sql = "SELECT id, name AS 'question', max_points AS 'points'
                    FROM QuestionTypeMultiple
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

    public function getExamQuestions($examId){
        
        $questions = $this->findExamQuestions($examId);

        // questions with answers
        $data = [];

        foreach($questions as $question){

            try{

                $sql = "SELECT id, answer
                        FROM OptionTypeMultiple
                        WHERE question_type_fk = ?";

                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $stmnt = $this->conn->prepare($sql);
                $stmnt->execute([$question["id"]]);

                $data[$question["question"]]["id"] = $question["id"];
                $data[$question["question"]]["points"] = $question["points"];
                $data[$question["question"]]["answers"] = $stmnt->fetchAll(PDO::FETCH_ASSOC);
            
            }
            catch(PDOException $e){
                echo "<div class='alert alert-danger' role='alert'>
                            Sorry, there was an error. " . $e->getMessage()."
                        </div>";
            }
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

            $sql = "SELECT qtm.id, qtm.name AS 'question', qtm.max_points, SUM(atm.points) AS 'earned_points'
                    FROM QuestionTypeMultiple qtm
                    JOIN AnswerTypeMultiple atm ON qtm.id = atm.question_type_fk
                    WHERE exam_fk = ?
                    AND atm.student_exam_fk = ?
                    GROUP BY qtm.id";

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

    public function getStudentExamAnswers($studentExamId){

        $questions = $this->findStudentExamQuestions($studentExamId);

        // questions with answers
        $data = [];

        foreach($questions as $question){

            try{

                $sql = "SELECT 
                        otm.id,
                        otm.answer,
                        CASE
                            WHEN omc.option_type_fk IS NULL THEN 'n'
                            ELSE 'y'
                        END AS 'choice'
                        FROM OptionTypeMultiple otm
                        LEFT JOIN OptionMarkedAsCorrect omc ON otm.id = omc.option_type_fk
                        JOIN AnswerTypeMultiple atm ON omc.answer_type_fk = atm.id
                        WHERE otm.question_type_fk = ?
                        AND atm.student_exam_fk = ?";

                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $stmnt = $this->conn->prepare($sql);
                $stmnt->execute([$question["id"], $_SESSION["student_exam_id"]]);

                $data[$question["question"]]["id"] = $question["id"];
                $data[$question["question"]]["max_points"] = $question["max_points"];
                $data[$question["question"]]["earned_points"] = $question["earned_points"];
                $data[$question["question"]]["answers"] = $stmnt->fetchAll(PDO::FETCH_ASSOC);
            
            }
            catch(PDOException $e){
                echo "<div class='alert alert-danger' role='alert'>
                            Sorry, there was an error. " . $e->getMessage()."
                        </div>";
            }
        }

        return $data;
    }
}

?>