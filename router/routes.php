<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("../controller/QuestionText.php");
require_once("../controller/Teacher.php");
require_once("../controller/Student.php");




use Pecee\SimpleRouter\SimpleRouter as Router;

Router::post("skuska/WEBTECH2_FINAL/router/question/addNewQuestionText", function(){
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
    $input = input()->all();
    $student=new Student();
    $result=$student->insertStudentData($input);
    if($result=="verified" || $result=="inserted")
        return json_encode($student->insertStudentExam($input));
    else
        return json_encode("wrongData");

});

Router::post("skuska/WEBTECH2_FINAL/router/logins/destroySession", function() {
//    $input = input()->all();
    session_start();
    $_SESSION["student"]=false;
    $_SESSION["teacher"]=false;
    header("location:http://147.175.98.72/skuska/WEBTECH2_FINAL/");
    return json_encode($_SESSION["student"]);


});

?>