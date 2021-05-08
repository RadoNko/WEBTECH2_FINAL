<?php

    require_once("../controllers/QuestionMultipleController.php");
    require_once("../controllers/QuestionConnectController.php");

    require_once("../controllers/AnswerMultipleController.php");
    require_once("../controllers/AnswerConnectController.php");
    
    require_once("../controllers/ExamController.php");
   
    use Pecee\SimpleRouter\SimpleRouter as Router;

    Router::post("Final/router/question/multiple", function(){

        $questionMultipleController = new QuestionMultipleController();
        $input = input()->all();

        $questionMultipleController->insertQuestionAndAnswers($input);
    });

    Router::post("Final/router/question/connect", function(){

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

    //                             /id has to be here cuz Router is domyleny bez toho
    Router::get("Final/router/exam/id/{id}", "ExamController@getExam");
?>