<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("../controllers/QuestionText.php");
require_once("../controllers/Teacher.php");
require_once("../controllers/Student.php");

require_once("../controllers/QuestionMultipleController.php");
require_once("../controllers/QuestionConnectController.php");

require_once("../controllers/AnswerMultipleController.php");
require_once("../controllers/AnswerConnectController.php");

require_once("../controllers/ExamController.php");

require_once("../controllers/TeacherController.php");

//fullajtar
require_once("../controllers/QuestionMathController.php");
require_once("../controllers/QuestionDrawingController.php");
require_once ("../controllers/AnswerMathController.php");

use Pecee\SimpleRouter\SimpleRouter as Router;

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

Router::post("Final/router/exam/insertAnswersMultiple", function () {

    $answerMultipleController = new AnswerMultipleController();
    $input = input()->all();

    $answerMultipleController->insertAnswers($input["questionId"], $input["studentExamId"], $input["answers"]);
});

Router::post("Final/router/exam/insertAnswersConnect", function () {

    $answerConnectController = new AnswerConnectController();
    $input = input()->all();

    $answerConnectController->insertAnswers($input["studentExamId"], $input["questionId"], $input["pairs"]);
});

Router::post("Final/router/exam/insertAnswersMath", function () {

    $answerMathController = new AnswerMathController();
    $input = input()->all();

    $answerMathController->insertAnswer($input["studentExamId"], $input["questionId"], $input["answer"]);
});

Router::get("Final/router/exam/{id}", "ExamController@getExam");

Router::get("Final/router/exam", "ExamController@getAll");

Router::put("Final/router/exam/toggle/{id}", "ExamController@toggle");

Router::get("Final/router/teacher", "TeacherController@getAll");

// set session based on ip and gps permission
//Router::post("Forward_the_Foundation/question/multiple", "QuestionMultipleController@insertQuestionAndAnswers");

Router::post("skuska/WEBTECH2_FINAL/router/question/addNewQuestionText", function () {
    $input = input()->all();
    $questionText = new QuestionText();
    $questionText->addQuestion($input);
});

Router::post("skuska/WEBTECH2_FINAL/router/logins/verifyTestCode", function () {
    $input = input()->all();
    $student = new Student();
    return json_encode($student->isTestCode($input));
});

Router::post("skuska/WEBTECH2_FINAL/router/logins/sendStudentNameSurname", function () {
    $input = input()->all();
    $student = new Student();
    $result = $student->insertStudentData($input);
    if ($result == "verified" || $result == "inserted")
        return json_encode($student->insertStudentExam($input));
    else
        return json_encode("wrongData");
});

Router::post("skuska/WEBTECH2_FINAL/router/logins/destroySession", function () {
    session_start();
    $_SESSION["student"] = false;
    $_SESSION["teacher"] = false;
    header("location:http://147.175.98.72/skuska/WEBTECH2_FINAL/");
    //    return json_encode($_SESSION["student"]);
});

Router::post("skuska/WEBTECH2_FINAL/router/logins/registerNewTeacher", function () {
    $input = input()->all();
    $teacher = new Teacher();
    $result = $teacher->registerTeacher($input);
    return json_encode($result);
});


Router::post("skuska/WEBTECH2_FINAL/router/logins/verifyTeacherLogin", function () {
    $input = input()->all();
    $teacher = new Teacher();
    $result = $teacher->verifyTeacherLogin($input);
    return json_encode($result);
});
