<html lang="sk">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skuska</title>
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="tailwind.css">
</head>

<body class="relative h-full bg-green-500">
    <main class="absolute bg-black w-12 h-12 top-1/2 left-1/2">

    </main>

    <!--    --><?php
                session_start();
                if ($_SESSION["student"] == true) {
                    echo "student: " . $_SESSION["logged_id"];
                    echo "<button class='btn btn-danger' onclick='logOut()'>Log out</button><br>";
                    echo "Tu sa zobrazi test";
                } elseif ($_SESSION["teacher"] == true) {
                    echo "teacher: " . $_SESSION["logged_id"];
                    echo "<button class='btn btn-danger' onclick='logOut()'>Log out</button>";
                    echo '<div id="teacherSide">
                        <button type="button" class="btn btn-primary" id="addQuestionMultiple" onclick="addQuestionText()">Add question</button>
                        <h1 style="margin-left: 40%">Question type text</h1><br>
                        <div id="mainQuestionDiv" style="margin-left: 40%">
                        </div>';
                } else {
                    echo "login menu";
                    echo "    <div id='loginButtons'>
                        <input type='button' class='btn btn-primary'  onclick='location.href=\"login/student\"' value='Som študent' />
                        <input type='button' class='btn btn-primary'  onclick='location.href=\"login/teacher\"' value='Som učiteľ' />
                    </div>";
                }
                //    
                ?>

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