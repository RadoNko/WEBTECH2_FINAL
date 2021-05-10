<html lang="sk">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skuska</title>
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="tailwind.css">
    <style>
        main{
            transform: translate(-50%, -50%);
            padding-top: 5vw;
        }
        .login-icon{
            width: 62%;
        }
        .login-icon-container{
            width: 10vw;
            height: 10vw;
            transform: translate(33%, -100%);
        }
        #login-buttons{
            color: red;
            background: red;
        }
    </style>
</head>

<body class="relative h-full logoColourBackground">
    <main class="absolute bg-gray-600 w-1/6 h-1/4 top-1/2 left-1/2 rounded-md">
        <div class="login-icon-container absolute rounded-full opacity-90 bg-gray-700 flex items-center justify-center">
            <img class="login-icon opacity-100" src="/Final/img/person1.svg" alt="Prson Icon">
        </div>
        <h1 class="text-center block text-5xl px-2 py-1 mt-1 text-white font-semibold pb-4">Login</h1>


        <?php
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
            echo "    <div id='loginButtons' class='w-full text-center'>
                        <button class='btn-primary text-2xl break-normal w-5/12' onclick=location.href='/Final/login/student'>I'm Studen</button>
                        <button class='btn-primary text-2xl break-normal w-5/12' onclick=location.href='/Final/login/teacher'>I'm Teacher</button>
                    </div>";
        }
        ?>
    </main>
    <script src="js/addTextQuestion.js"></script>
    <script src="js/login.js"></script>
</body>

</html>