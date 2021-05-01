<?php

//require_once("../php/QuestionMultipleController.php");
//require_once("../php/QuestionConnectController.php");
require_once("../php/QuestionText.php");


use Pecee\SimpleRouter\SimpleRouter as Router;

Router::post("skuska/WEBTECH2_FINAL/router/question/addNewQuestionText", function(){
    $input = input()->all();
    $questionText=new QuestionText();
    $questionText->addQuestion($input);

//    $cicky=new Foo();
//    return $cicky->getCicky();

});


// set session based on ip and gps permission
//Router::post("Forward_the_Foundation/question/multiple", "QuestionMultipleController@insertQuestionAndAnswers");
?>