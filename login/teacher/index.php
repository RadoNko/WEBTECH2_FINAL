<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student</title>
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
</head>
<body>
    <?php
    session_start();
    if($_SESSION["teacher"]==false){
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

<script src="../../js/login.js"></script>
</body>
</html>