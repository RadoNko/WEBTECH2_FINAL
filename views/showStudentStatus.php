<?php
include "../controllers/Database.php";
showErrors();
$conn = (new Database())->getConnection();
$stm = $conn -> query( "SELECT id from Exam WHERE is_active = '1'");
$activeTests = $stm -> fetchAll( PDO::FETCH_ASSOC );


$resultAll = array();

foreach ($activeTests as $item) {
    $examFK = $item['id'];
    $stm = $conn -> query( "SELECT student_fk,is_finished FROM Student_Exam WHERE exam_fk = '$examFK'" );
    //"SELECT student_fk,is_finished FROM Student_Exam WHERE exam_fk = '$examFK' AND is_finished = '0'"
    $result = $stm->fetchAll(PDO::FETCH_ASSOC);



    if (sizeof($result) > 1){
        foreach ($result as $resultItem){
            $tmp = array();
            $studentFK = $resultItem['student_fk'];
            $isFinished = $resultItem['is_finished'];
            $stm = $conn -> query( "SELECT name,surname FROM Student WHERE ais_id = '$studentFK'" );
            $student = $stm->fetchAll(PDO::FETCH_ASSOC);
            //array_push($tmp,["name" => $student[0]['name'], "surname" => $student[0]['surname'],"finished" => $isFinished]);
            if ($isFinished == 1){
                $isFinished ="Dokončený";
            }else $isFinished = "Nedokončený";
            if ($resultItem != null) array_push($resultAll,["Meno" => $student[0]['name'], "Priezvisko" => $student[0]['surname'],"Stav testu" => $isFinished]);
        }
    }
}
//var_dump($resultAll);
printTable($resultAll,"1");
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
        echo "<th>";
        echo $key;
        echo "</th>";
    }
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";

    foreach ($rows as $row) {
        echo "<tr>";
        foreach ($row as $key => $column){
            if ($column == "Dokončený") {
                echo "<td style='background-color:#00FF00' >".$column."</td>";
            }else if ($column == "Nedokončený") {
                echo "<td style='background-color:#FF0000' >".$column."</td>";
            }else echo "<td>".$column."</td>";
        }

        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";

}