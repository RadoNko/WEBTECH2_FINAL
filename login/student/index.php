<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once "../../../Database.php";
$connection=(new Database())->getConnection();


//$sql="SELECT id FROM Exam WHERE code=?";
//$stm = $connection->prepare($sql);
//$stm->execute(["abc"]);
//$examID=$stm->fetch();
//echo $examID["id"];
//
//$sql = "INSERT INTO Student_Exam (student_fk, exam_fk,is_finished) VALUES (?,?,?)";
//$stm = $connection->prepare($sql);
//$stm->execute(["123",$examID["id"],0]);
?>

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
        if(!isset($_SESSION["student"]) || $_SESSION["student"]==false){
            echo'  <div id="studentLogin" class="form-group">
        <h4>Zadajte kód testu</h4>
        <input id="testCode" name="testCode" placeholder="Code is...">
        <button type="button" class="btn btn-primary" onclick="verifyTestCode()">Overiť kód</button>
        </div>
    
        <div style="display:none;" id="studentDetails" class="form-group">
            <h4>Ais ID</h4>
            <input id="aisID" type="number" name="aisID" required>
            <h4>Meno</h4>
            <input id="studentName" type="text" name="studentName" required>
            <h4>Priezvisko</h4>
            <input id="studentSurname" type="text" name="studentSurname" required><br><br>
            <button type="button" class="btn btn-success" onclick="sendStudentName()">Prihlásiť sa do testu</button>
        </div>';
        }
        else{
            echo "už si prihlaseny";
        }
    ?>
<!--    <div id="studentLogin" class="form-group">-->
<!--        <h4>Zadajte kód testu</h4>-->
<!--        <input id="testCode" name="testCode" placeholder="Code is...">-->
<!--        <button type="button" class="btn btn-primary" onclick="verifyTestCode()">Overiť kód</button>-->
<!--    </div>-->
<!---->
<!--    <div style="display:none;" id="studentDetails" class="form-group">-->
<!--        <h4>Ais ID</h4>-->
<!--        <input id="aisID" type="number" name="aisID" required>-->
<!--        <h4>Meno</h4>-->
<!--        <input id="studentName" type="text" name="studentName" required>-->
<!--        <h4>Priezvisko</h4>-->
<!--        <input id="studentSurname" type="text" name="studentSurname" required><br><br>-->
<!--        <button type="button" class="btn btn-success" onclick="sendStudentName()">Prihlásiť sa do testu</button>-->
<!--    </div>-->

<script src="../../js/login.js"></script>
</body>
</html>
