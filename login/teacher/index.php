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
    <title>Student</title>
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/Final/tailwind.css">
    <style>

    </style>
</head>
<body class="logoColourBackground">
<main class="login-main absolute bg-gray-600 w-1/6 h-1/3 top-1/2 left-1/2 rounded-md">
    <div class="login-icon-container absolute rounded-full opacity-90 bg-gray-700 flex items-center justify-center">
        <img class="login-icon opacity-100" src="/Final/img/person1.svg" alt="Prson Icon">
    </div>
    <h1 class="text-center block text-5xl px-2 py-1 mt-1 text-white font-semibold pb-4">Login</h1>
    <?php
    if(!isset($_SESSION["teacher"]) ||$_SESSION["teacher"]==false){
        echo'  <div id="teacherLogin" class="form-group text-center">
            <input class="text-2xl text-center" id="teacherNickname" name="teacherNickname" placeholder="Váš login...">
            <h4 class="text-center block text-xl px-2 py-1 mt-1 text-white font-semibold">Password</h4>
            <input class="text-2xl text-center w-max" id="teacherPassword" name="teacherPassword" type="password" placeholder="Heslo...">
            <button type="button" class="purple-button text-2xl" onclick="verifyTeacherLogin()">Prihlásiť</button>
            <button id="registerButton" type="button" class="red-button-small" onclick="imNotRegistered()">Ešte nie som zaregistrovaný</button>
            </div>

        
            <div style="display:none;" id="teacherRegistration" class="form-group text-center bg-gray-600 pb-4 rounded-md">
                <h4 class="text-center block text-xl px-2 py-1 mt-1 text-white font-semibold">Login</h4>
                <input class="text-2xl text-center" id="teacherRegistrationNickname" name="teacherRegistrationNickname" type="text" required>
                <h4 class="text-center block text-xl px-2 py-1 mt-1 text-white font-semibold">Heslo</h4>
                <input class="text-2xl text-center" id="teacherRegistrationPassword" type="password" name="teacherRegistrationPassword" required>
                <h4 class="text-center block text-xl px-2 py-1 mt-1 text-white font-semibold">Heslo znova</h4>
                <input class="text-2xl text-center" id="teacherRegistrationPasswordAgain" type="password" name="teacherRegistrationPasswordAgain" required><br><br>
                <button type="button" class="purple-button text-2xl" onclick="registerNewTeacher()">Zaregistrovať sa</button>
            </div>';
    }
    else{
        echo "<script>window.location.href = '/Final/views/examOverview.php'; </script>";
    }
    ?>
</main>


<script src="../../js/login.js"></script>
</body>
</html>