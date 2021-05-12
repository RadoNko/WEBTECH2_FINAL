<?php
if (session_status() != 2){
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test</title>
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
</head>
<body>

<!--    --><?php
            if($_SESSION["student"]==true){
                echo "student: ".$_SESSION["logged_id"];
                echo "<button class='btn btn-success' onclick='logOut()'>Submit test</button><br>";
                echo"Tu sa zobrazi test";
            }elseif($_SESSION["teacher"]==true){
                echo "teacher: ".$_SESSION["logged_id"];
                echo "<button class='btn btn-danger' onclick='logOut()'>Log out</button>";
                echo '<div id="teacherSide">
                        <button type="button" class="btn btn-primary" id="addQuestionMultiple" onclick="addQuestionText()">Add question</button>
                        <h1 style="margin-left: 40%">Question type text</h1><br>
                        <div id="mainQuestionDiv" style="margin-left: 40%">
                        </div>
                        <button type="button" class="btn btn-success" onclick="submitExamQuestions()">Ulož test</button>';
            }else{
                echo "    <div id='loginButtons'>
                        <input type='button' class='btn btn-primary'  onclick='location.href=\"login/student\"' value='Som študent' />
                        <input type='button' class='btn btn-primary'  onclick='location.href=\"login/teacher\"' value='Som učiteľ' />
                    </div>";
            }
//    ?>

<!--    <div id="teacherSide">-->
<!--        <h1 style="margin-left: 40%">Question type text</h1><br>-->
<!--        <div id="mainQuestionDiv" style="margin-left: 40%">-->
<!--        </div>-->
<!---->
<!--        <button type="button" class="btn btn-primary" id="addQuestionMultiple" onclick="addQuestionText()">Add question</button>-->
<!--        <button type="button" class="btn btn-primary" id="submitTest" onclick="submitTest()">Submit test</button>-->
<!--    </div>-->

<!--    <div id="loginButtons">-->
<!--        <input type='button' class='btn btn-primary'  onclick='location.href="login/student"' value='Som študent' />-->
<!--        <input type='button' class='btn btn-primary'  onclick='location.href="login/teacher"' value='Som učiteľ' />-->
<!--    </div>-->

<script src="js/addTextQuestion.js"></script>
<script src="js/login.js"></script>
</body>
</html>

