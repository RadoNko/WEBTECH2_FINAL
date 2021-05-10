<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("../controllers/QuestionText.php");
require_once("../controllers/Teacher.php");
require_once("../controllers/Student.php");
require_once("../controllers/Exam.php");




use Pecee\SimpleRouter\SimpleRouter as Router;

Router::post("skuska/WEBTECH2_FINAL/router/question/addNewQuestionText", function(){
    session_start();
    $input = input()->all();
    $questionText=new QuestionText();
    $questionText->addQuestion($input);
});

Router::post("skuska/WEBTECH2_FINAL/router/logins/verifyTestCode", function() {
    $input = input()->all();
    $student=new Student();
    return json_encode($student->isTestCode($input));
});

Router::post("skuska/WEBTECH2_FINAL/router/logins/sendStudentNameSurname", function() {
    session_start();
    $input = input()->all();
    $student=new Student();
    $result=$student->insertStudentData($input);
    if($result=="verified" || $result=="inserted")
        return json_encode($student->insertStudentExam($input));
    else
        return json_encode("wrongData");

});

Router::post("skuska/WEBTECH2_FINAL/router/logins/destroySession", function() {
    session_start();
    $_SESSION["student"]=false;
    $_SESSION["teacher"]=false;
    $_SESSION["logged_id"]=-1;
    $_SESSION["student_exam_id"]=-1;
    header("location:http://147.175.98.72/skuska/WEBTECH2_FINAL/");
//    return json_encode($_SESSION["student"]);
});

Router::post("skuska/WEBTECH2_FINAL/router/logins/registerNewTeacher", function() {
    session_start();
    $input = input()->all();
    $teacher=new Teacher();
    $result=$teacher->registerTeacher($input);
    return json_encode($result);
});


Router::post("skuska/WEBTECH2_FINAL/router/logins/verifyTeacherLogin", function() {
    session_start();
    $input = input()->all();
    $teacher=new Teacher();
    $result=$teacher->verifyTeacherLogin($input);
    return json_encode($result);
});

Router::get("skuska/WEBTECH2_FINAL/router/exam/{id}", "Exam@getExam");

Router::post("skuska/WEBTECH2_FINAL/router/exam/insertTextAnswer", function() {
    $input = input()->all();
    $question=new QuestionText();
    return json_encode($question->insertAnswers($input));
//    return json_encode($input);
});

Router::post("Final/router/rateExam/{id}", "Exam@getRateExam");
//Router::get("skuska/WEBTECH2_FINAL/router/rateExam/{id}", "Exam@getRateExam");

Router::post("Final/router/exam/rateAnswersText", function () {
//Router::post("skuska/WEBTECH2_FINAL/router/exam/rateAnswersText", function () {
    $answerDrawingController = new QuestionText();
    $input = input()->all();
    $answerDrawingController->setScore($input["points"], $input["answerId"]);
});


//Router::post("Final/router/exam/rateAnswersText", function () {
Router::post("skuska/WEBTECH2_FINAL/router/printPDF", function () {

});
?>