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
        <div id="open-modal"  class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert" style="visibility:hidden">
  <strong class="font-bold">Success!</strong>
  <span class="block sm:inline">You successfully rated this exam.</span>
  <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
    <svg class="fill-current h-6 w-6 text-red-500" id="close-modal" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
  </span>
</div>
        <button type="button" class="green-button mt-8 w-full" id="submitQuestionConnect" onclick="submitRateTest()">Rate test</button>
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