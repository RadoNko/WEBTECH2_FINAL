<?php
session_start();

include "../controllers/Database.php";
if (isset($_SESSION["student_id"])){
    $studentID = $_SESSION["student_id"];
    $conn = (new Database())->getConnection();
    $stm = $conn->prepare("UPDATE Student_Exam SET left_website='1' WHERE student_fk = '$studentID'");
    $stm->execute();
    echo  "Success!";
}else echo "Student ID not set";


//SELECT id from Exam WHERE is_active = '1';
//SELECT * FROM Student_Exam WHERE exam_fk = '1' AND is_finished = '0'