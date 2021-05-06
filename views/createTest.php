<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>

<!--    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">-->
    <link rel="stylesheet" href="../tailwind.css">
    <link rel="stylesheet" href="../mathquill-0.10.1/mathquill.css"/>

    <style>
        /*.form-check-inline:before {*/
        /*    content: "\A";*/
        /*    white-space: pre;*/
        /*}*/

        .form-control{
            display: block;
        }

        .form-check-inline {
            display: inline;
        }

    </style>

</head>
<body class="grid grid-cols-12 bg-gray-200 min-h-screen">
<?php include "partials/navbar.html"?>
<main class="col-span-10 flex justify-center pt-10">
    <div class="w-4/5 h-full bg-gray-100 text-xl shadow-2xl pb-96">
        <div class="sticky top-0 p-4 z-10 bg-gray-100 border border-gray-200">
            <button type="button" class="green-button" id="addQuestionMultiple" onclick="addQuestionMultiple()">Add question with multiple choices</button>
            <button type="button" class="green-button" id="addQuestionConnect"  onclick="addQuestionConnect()">Add question with pairs</button>
            <button type="button" class="green-button" id="addQuestionConnect"  onclick="addDrawingQuestion()">Add drawing Question</button>
            <button type="button" class="green-button" id="addQuestionConnect"  onclick="addMathQuestion()">Add math Question</button>

            <button type="button" class="purple-button" id="submitQuestionConnect" onclick="submitTest()">Submit test</button>
        </div>


        <div id="questionContainer">
        </div>
    </div>


</main>




    <script src="../js/addQuestions.js"></script>
    <script src="../js/addDrawingQuestion.js"></script>
    <script src="../mathquill-0.10.1/mathquill.js"></script>
    <script src="../js/addMathQuestion.js"></script>
</body>
</html>