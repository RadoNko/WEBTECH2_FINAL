<?php

    require_once("../controllers/QuestionMultipleController.php");

    use Pecee\SimpleRouter\SimpleRouter as Router;

    // list of cities ip
    Router::post("Forward_the_Foundation/router/question/multiple", function(){

        $questionMultipleController = new QuestionMultipleController();
        $input = input()->all();

        $questionMultipleController->insertQuestionAndAnswers($input);
        //return  json_encode($input);
    });

    // set session based on ip and gps permission
    //Router::post("Forward_the_Foundation/question/multiple", "QuestionMultipleController@insertQuestionAndAnswers");
?>