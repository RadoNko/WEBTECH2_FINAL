<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student</title>
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/Final/tailwind.css">
</head>
<body>
<main class="absolute bg-gray-600 w-1/6 h-1/4 top-1/2 left-1/2 rounded-md">
    <div class="login-icon-container absolute rounded-full opacity-90 bg-gray-700 flex items-center justify-center">
        <img class="login-icon opacity-100" src="/Final/img/person1.svg" alt="Prson Icon">
    </div>
    <h1 class="text-center block text-5xl px-2 py-1 mt-1 text-white font-semibold pb-4">Login</h1>
    <?php
    session_start();
    if(!isset($_SESSION["teacher"]) ||$_SESSION["teacher"]==false){
        echo'  <div id="teacherLogin" class="form-group">
            <h4>Prihláste sa</h4>
            <input id="teacherNickname" name="teacherNickname" placeholder="Váš login...">
            <input id="teacherPassword" name="teacherPassword" type="password" placeholder="Heslo...">
            <button type="button" class="btn btn-success" onclick="verifyTeacherLogin()">Prihlásiť</button>
            <button id="registerButton" type="button" class="btn btn-primary" onclick="imNotRegistered()">Ešte nie som zaregistrovaný</button>
            </div>

        
            <div style="display:none;" id="teacherRegistration" class="form-group">
                <h4>Login</h4>
                <input id="teacherRegistrationNickname" name="teacherRegistrationNickname" type="text" required>
                <h4>Heslo</h4>
                <input id="teacherRegistrationPassword" type="password" name="teacherRegistrationPassword" required>
                <h4>Heslo znova</h4>
                <input id="teacherRegistrationPasswordAgain" type="password" name="teacherRegistrationPasswordAgain" required><br><br>
                <button type="button" class="btn btn-success" onclick="registerNewTeacher()">Zaregistrovať sa</button>
            </div>';
    }
    else{
        echo "už si prihlaseny";
    }
    ?>
</main>


<script src="../../js/login.js"></script>
</body>
</html>