<?php
include "../controllers/Database.php";
if (session_status() != 2){
    session_start();
}
showErrors();

$conn = (new Database())->getConnection();
$exam_id = $_POST['exam_id'];
if (!isset($_SESSION["teacher"]) || $_SESSION["teacher"]==false){
    echo "<script>window.location.href = '/Final/index.php'; </script>";
}

$stm = $conn -> query( "SELECT id from Exam WHERE id = '$exam_id'");
$activeTests = $stm->fetchAll( PDO::FETCH_ASSOC );

$resultAll = array();

foreach ($activeTests as $item) {
//    $stm = $conn -> query( "SELECT student_fk,is_finished FROM Student_Exam WHERE exam_fk = '$exam_id'" );
    $stm = $conn -> query( "SELECT id,student_fk,is_finished FROM Student_Exam WHERE exam_fk = '$exam_id'" );
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
    if($stm->rowCount() > 0){
        if (sizeof($result) > 0){
            foreach ($result as $resultItem){
                $tmp = array();
                $student_exam_fk=$resultItem['id'];
                $studentFK = $resultItem['student_fk'];
                $isFinished = $resultItem['is_finished'];
                $stm = $conn -> query( "SELECT name,surname FROM Student WHERE ais_id = '$studentFK'" );
                $student = $stm->fetchAll(PDO::FETCH_ASSOC);
                if ($isFinished == 1){
                    $isFinished ="Finished";
                }else $isFinished = "Not finished";
//                if ($resultItem != null) array_push($resultAll,["Name" => $student[0]['name'], "Surname" => $student[0]['surname'],"State" => $isFinished]);
                  if ($resultItem != null) array_push($resultAll,["Name" => $student[0]['name'], "Surname" => $student[0]['surname'],"State" => $isFinished,"studentExamId"=>$student_exam_fk]);


            }
            printTable($resultAll,"1");
        }
    }
}
//var_dump($resultAll);
function showErrors(){
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

function printTable($rows,$id=""){

    echo "<table class='pure-table pure-table-bordered tables' id='$id' >";
    echo "<thead>";
    echo "<tr>";
    foreach ($rows[0] as $key => $value){
        // TODO treba spraviť klikateľné, po kliku to ukáže exam daného žiaka
        if($key!="studentExamId") {
            echo "<th>";
            echo $key;
            echo "</th>";
        }
    }
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";

    foreach ($rows as $index=> $row) {
        $studentExamFK=$row["studentExamId"];
//        array_pop($row);
        echo "<tr>";
        foreach ($row as $key => $column){
            if($key!="studentExamId"){
                if ($column == "Finished") {
                    echo "<td style='background-color:#00FF00'><a href='rateTest.php?studentExamFK=".$studentExamFK."'>".$column."</a></td>";
                }else if ($column == "Not finished") {
                    echo "<td style='background-color:#FF0000' >".$column."</td>";
                }else echo "<td>".$column."</td>";
            }
        }

        echo "</tr>";

    }
    echo "</tbody>";
    echo "</table>";

}
