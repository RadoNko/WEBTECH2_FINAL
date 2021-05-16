<?php
session_start();

if (session_status() != 2){
    session_start();
}

if (isset($_SESSION["student"])){
    $studentID = $_SESSION["student"];
    $conn = (new Database())->getConnection();
    $stm = $conn->prepare("UPDATE Student_Exam SET left_website='1' WHERE student_fk = '$studentID'");
    $stm->execute();
    echo  "Success!";
}else echo "Student ID not set";