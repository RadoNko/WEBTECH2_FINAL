<?php

//require_once("../php/QuestionMultipleController.php");
//require_once("../php/QuestionConnectController.php");
require_once("../php/QuestionText.php");


use Pecee\SimpleRouter\SimpleRouter as Router;

Router::post("skuska/WEBTECH2_FINAL/router/question/addNew", function(){
//    $input = input()->all();
//    return json_encode($input);
    $cicky=new Foo();
    return $cicky->getCicky();

});


// set session based on ip and gps permission
//Router::post("Forward_the_Foundation/question/multiple", "QuestionMultipleController@insertQuestionAndAnswers");
?>