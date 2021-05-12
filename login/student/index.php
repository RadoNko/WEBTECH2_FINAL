<?php
if (session_status() != 2){
    session_start();
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student</title>
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/Final/tailwind.css">
</head>
<body class="logoColourBackground">
<main class="login-main absolute bg-gray-600 w-1/6 h-1/3 top-1/2 left-1/2 rounded-md">
    <div class="login-icon-container absolute rounded-full opacity-90 bg-gray-700 flex items-center justify-center">
        <img class="login-icon opacity-100" src="/Final/img/person1.svg" alt="Prson Icon">
    </div>
    <h1 class="text-center block text-5xl px-2 py-1 mt-1 text-white font-semibold pb-4">Login</h1>
    <?php
    if(!isset($_SESSION["student"]) || $_SESSION["student"]==false){
        echo'  <div id="studentLogin" class="form-group text-center">
        <h4 class="text-center block text-xl px-2 py-1 mt-1 text-white font-semibold">Zadajte kód testu</h4>
        <input class="text-2xl text-center" id="testCode" name="testCode" placeholder="Code is...">
        <button type="button" class="purple-button text-2xl" onclick="verifyTestCode()">Overiť kód</button>
        </div>
    
        <div style="display:none;" id="studentDetails" class="form-group text-center bg-gray-600 pb-4 rounded-md">
            <h4>Ais ID</h4>
            <input class="text-2xl text-center" id="aisID" type="number" name="aisID" required>
            <h4>Meno</h4>
            <input class="text-2xl text-center" id="studentName" type="text" name="studentName" required>
            <h4>Priezvisko</h4>
            <input class="text-2xl text-center" id="studentSurname" type="text" name="studentSurname" required><br><br>
            <button type="button" class="purple-button text-2xl" onclick="sendStudentName()">Prihlásiť sa do testu</button>
        </div>';
    }
    else{
        header("Location: /Final/views/fillTest.php");
    }
    ?>
</main>


<script src="../../js/login.js"></script>
</body>
</html>
