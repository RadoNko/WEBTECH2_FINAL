<?php
if (session_status() != 2){
    session_start();
}
$_SESSION["student_exam_id"]=$_GET["studentExamFK"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Q</title>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <link rel="stylesheet" href="../tailwind.css">
    <link rel="stylesheet" href="../mathquill-0.10.1/mathquill.css"/>
    <link rel="stylesheet" href="../drawingboard.js/drawingboard.min.css">
    <style type="text/css">

    </style>
</head>
<body class="grid grid-cols-12 bg-gray-200 min-h-screen">

<?php include "partials/teacherNavigation.php" ?>
<main class="col-span-10 flex justify-center pt-10 pb-96">
    <div class="w-4/5 h-full bg-gray-100 text-xl shadow-2xl">
        <div id="examContainer">
        </div>
        <button type="button" class="green-button mb-4 w-full" id="submitQuestionConnect" onclick="submitRateTest()">Rate test</button>
        <button type="button" class="green-button mb-4 w-full" onclick="SaveAsPdf()">Export to PDF</button>
    </div>
</main>

<script src="../mathquill-0.10.1/mathquill.js"></script>
<script src="../drawingboard.js/drawingboard.min.js"></script>

<script src="../js/renderQuestionsForRating.js"></script>
<script src="../js/submitExamRating.js"></script>
<script src="../js/printPDF.js"></script>

</body>
</html>