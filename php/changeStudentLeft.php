<?php
session_start();

include "../controllers/Database.php";
$_SESSION["student_id"] = 123;
if (isset($_SESSION["student_id"])){
    $studentID = $_SESSION["student_id"];
    $conn = (new Database())->getConnection();
    $stm = $conn->prepare("UPDATE Student_Exam SET left_website='1' WHERE student_fk = '$studentID'");
    $stm->execute();
    echo  $_SESSION["student_id"];
}else echo null;

function appendAlert(){
    echo "<script>document.getElementById('myDIV').insertAdjacentHTML('afterend', `<div class='alert'>
    <span class='closebtn' onclick='this.parentElement.style.display=\'none\';'>&times;</span>Student
    <strong>Daniel Jankech</strong> left the test.
</div>`)</script>";
}

//SELECT id from Exam WHERE is_active = '1';
//SELECT * FROM Student_Exam WHERE exam_fk = '1' AND is_finished = '0'