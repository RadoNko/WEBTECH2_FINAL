<?php

require_once("../controllers/QuestionMultipleController.php");
require_once("../controllers/QuestionConnectController.php");

require_once("../controllers/AnswerMultipleController.php");
require_once("../controllers/AnswerConnectController.php");

require_once("../controllers/ExamController.php");

require_once("../controllers/TeacherController.php");

use Pecee\SimpleRouter\SimpleRouter as Router;

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

Router::get("Final/router/exam/{id}", "ExamController@getExam");

Router::get("Final/router/exam", "ExamController@getAll");

Router::put("Final/router/exam/toggle/{id}", "ExamController@toggle");

Router::get("Final/router/teacher", "TeacherController@getAll");

    // set session based on ip and gps permission
    //Router::post("Forward_the_Foundation/question/multiple", "QuestionMultipleController@insertQuestionAndAnswers");
