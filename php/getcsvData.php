<?php
include "../controllers/Database.php";
if (isset($_POST['test_code'])){
    $testCode = $_POST['test_code'];
    $conn = (new Database())->getConnection();

    $stm = $conn -> query("SELECT id from Exam WHERE code='$testCode'");
    $testID = $stm ->fetchAll(PDO::FETCH_ASSOC);
    //echo $testID[0]['id'];
    //echo $testCode;
    //var_dump($testID);
    $testID = $testID[0]['id'];
    $stm = $conn -> query( "SELECT student_fk from Student_Exam WHERE exam_fk = '$testID'");
    $allStudent_fk = $stm -> fetchAll( PDO::FETCH_ASSOC );

    $result = array();
    foreach($allStudent_fk as $student_fk){
        $fk = $student_fk['student_fk'];

        $stm = $conn -> query( "SELECT * from Student WHERE ais_id = '$fk'");
        $tmp = $stm -> fetchAll( PDO::FETCH_ASSOC );

        $stm = $conn -> query( "SELECT points_earned from Student_Exam WHERE student_fk = '$fk' AND exam_fk = '$testID'");
        array_push($tmp,$stm -> fetchAll( PDO::FETCH_ASSOC )[0]);

        array_push($result,["student" => $tmp ]);

    }

    echo json_encode($result);
}


if (isset($_POST['student_exam_fk'])){
    $student_exam_fk = $_POST['student_exam_fk'];
//$student_exam_fk = 3;

//$conn = (new Database())->createConnection("Projekt");
    $stm = $conn -> query( "SELECT points_earned FROM Student_Exam WHERE id='$student_exam_fk'");
    $stm = $stm ->fetchAll(PDO::FETCH_ASSOC);
    $points_earned = $stm[0]['points_earned'];

    $added_points = $_POST['points'];
//$added_points = 2;

    $points_earned += $added_points;
    $conn -> query("UPDATE Student_Exam SET points_earned='$points_earned' WHERE id ='$student_exam_fk'");
}

