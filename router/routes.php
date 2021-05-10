<?php
require_once("../controllers/QuestionText.php");
require_once("../controllers/Student.php");

require_once("../controllers/AnswerMultipleController.php");
require_once("../controllers/AnswerConnectController.php");

require_once("../controllers/ExamController.php");

require_once("../controllers/TeacherController.php");

//fullajtar
require_once("../controllers/QuestionMathController.php");
require_once("../controllers/QuestionDrawingController.php");
require_once("../controllers/AnswerMathController.php");
require_once("../controllers/AnswerDrawingController.php");

use Pecee\SimpleRouter\SimpleRouter as Router;

Router::post("Final/router/question/addNewQuestionText", function() {
    $input = input()->all();
    $questionText=new QuestionText();
    $questionText->addQuestion($input);
});

    Router::post("Final/router/question/math", function () {
        $questionMathController = new QuestionMathController();
        $questionMathController->addQuestion(input()->all());
    });

    Router::post("Final/router/question/drawing", function () {
        $questionDrawingController = new QuestionDrawingController();
        $questionDrawingController->addQuestion(input()->all());
    });

    Router::post("Final/router/question/multiple", function () {

        $questionMultipleController = new QuestionMultipleController();
        $input = input()->all();

        $questionMultipleController->insertQuestionAndAnswers($input);
    });

    Router::post("Final/router/question/connect", function () {

        $questionConnectController = new QuestionConnectController();
        $input = input()->all();

        $questionConnectController->insertQuestionAndAnswers($input);
    });

Router::post("Final/router/exam/answer/multiple", function(){

    $answerMultipleController = new AnswerMultipleController();
    $input = input()->all();

    if(!empty($input["answers"])){

        $answerMultipleController->insertAnswers($input["questionId"], $input["studentExamId"], $input["answers"]);
    }
});

Router::post("Final/router/exam/answer/connect", function(){

    $answerConnectController = new AnswerConnectController();
    $input = input()->all();

    $answerConnectController->insertAnswers($input["questionId"], $input["studentExamId"], $input["pairs"]);
});

    Router::post("Final/router/exam/insertAnswersMath", function () {

        $answerMathController = new AnswerMathController();
        $input = input()->all();

        $answerMathController->insertAnswer($input["studentExamId"], $input["questionId"], $input["answer"]);
    });

    Router::post("Final/router/exam/insertAnswersDrawing", function () {

        $answerDrawingController = new AnswerDrawingController();
        $input = input()->all();
        $answerDrawingController->insertAnswer($input["studentExamId"], $input["questionId"], $input["img"]);
    });

    //setting exam score
Router::post("Final/router/exam/rateAnswersMath", function () {
    $answerMathController = new AnswerMathController();
    $input = input()->all();
    $answerMathController->setScore($input["points"], $input["answerId"]);
});

Router::post("Final/router/exam/rateAnswersDrawing", function () {
    $answerDrawingController = new AnswerDrawingController();
    $input = input()->all();
    $answerDrawingController->setScore($input["points"], $input["answerId"]);
});

Router::post("Final/router/exam/rateAnswersText", function () {
//Router::post("skuska/WEBTECH2_FINAL/router/exam/rateAnswersText", function () {
    $answerDrawingController = new QuestionText();
    $input = input()->all();
    $answerDrawingController->setScore($input["points"], $input["answerId"]);
});


    Router::get("Final/router/exam/{id}", "ExamController@getExam");

    Router::get("Final/router/exam", "ExamController@getAll");

    //get exam of student with filled answers
    Router::get("Final/router/rateExam/{id}", "ExamController@getRateExam");

    Router::put("Final/router/exam/toggle/{id}", "ExamController@toggle");

    Router::post("Final/router/exam", function () {

        $examController = new ExamController();
        $input = input()->all();

        $examController->create($input["name"], $input["time"], $input["code"]);
    });

    Router::get("Final/router/teacher", "TeacherController@getAll");

// set session based on ip and gps permission
//Router::post("Forward_the_Foundation/question/multiple", "QuestionMultipleController@insertQuestionAndAnswers");

    Router::post("Final/router/logins/verifyTestCode", function () {
        $input = input()->all();
        $student = new Student();
        return json_encode($student->isTestCode($input));
    });

    Router::post("Final/router/logins/sendStudentNameSurname", function () {
        if (session_status() != 2){
            session_start();
        }
        $input = input()->all();
        $student = new Student();
        $result = $student->insertStudentData($input);
        if ($result == "verified" || $result == "inserted")
            return json_encode($student->insertStudentExam($input));
        else
            return json_encode("wrongData");

    });

    Router::post("Final/router/logins/destroySession", function () {
        if (session_status() != 2){
            session_start();
        }
        $_SESSION["student"] = false;
        $_SESSION["teacher"] = false;
        $_SESSION["logged_id"] = -1;
        $_SESSION["student_exam_id"] = -1;
        if (isset($_SESSION["username"])){
            $_SESSION["username"] = -1;
        }
        header("Location: /Final/");
//    return json_encode($_SESSION["student"]);
    });

    Router::post("Final/router/logins/registerNewTeacher", function () {
        if (session_status() != 2){
            session_start();
        }
        $input = input()->all();
        $teacher = new TeacherController();

        $result = $teacher->registerTeacher($input);
        return json_encode($result);
    });


    Router::post("Final/router/logins/verifyTeacherLogin", function () {
        if (session_status() != 2){
            session_start();
        }
        $input = input()->all();
        $teacher = new TeacherController();
        $result = $teacher->verifyTeacherLogin($input);
        return json_encode($result);
    });

    Router::get("Final/router/exam/{id}", "Exam@getExam");

    Router::post("Final/router/exam/insertTextAnswer", function () {
        $input = input()->all();
        $question = new QuestionText();
        return json_encode($question->insertAnswers($input));
//    return json_encode($input);
    });

?>