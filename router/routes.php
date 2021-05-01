<?php

    require_once("../controllers/QuestionMultipleController.php");
    require_once("../controllers/QuestionConnectController.php");
    require_once("../controllers/ExamController.php");
   
    use Pecee\SimpleRouter\SimpleRouter as Router;

    Router::post("Forward_the_Foundation/router/question/multiple", function(){

        $questionMultipleController = new QuestionMultipleController();
        $input = input()->all();

        $questionMultipleController->insertQuestionAndAnswers($input);
        //return  json_encode($input);
    });

    Router::post("Forward_the_Foundation/router/question/connect", function(){

        $questionConnectController = new QuestionConnectController();
        $input = input()->all();

        $questionConnectController->insertQuestionAndAnswers($input);
        //return  json_encode($input);
    });

    Router::get("Forward_the_Foundation/router/exam/{id}", "ExamController@getExam");

    // set session based on ip and gps permission
    //Router::post("Forward_the_Foundation/question/multiple", "QuestionMultipleController@insertQuestionAndAnswers");
?>