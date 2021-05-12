<?php
if (session_status() != 2){
    session_start();
}
?>

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
    <link rel="stylesheet" href="../tailwind.css">
    <link rel="stylesheet" href="../mathquill-0.10.1/mathquill.css"/>
</head>
<body class="grid grid-cols-12 bg-gray-200 min-h-screen">
<?php include "partials/teacherNavigation.php" ?>
<main class="col-span-10 flex justify-center pt-10">
    <div class="w-4/5 h-full bg-gray-100 text-xl shadow-2xl pb-96">
        <div class="sticky top-0 p-4 z-10 bg-gray-100 border border-gray-200">
            <h1 class="text-3xl text-center font-semibold pb-1"><?php echo $testName; ?></h1>
            <button type="button" class="green-button text-lg" id="addQuestionMultiple" onclick="addQuestionMultiple()">Add question with multiple choices</button>
            <button type="button" class="green-button text-lg" id="addQuestionConnect"  onclick="addQuestionConnect()">Add question with pairs</button>
            <button type="button" class="green-button text-lg" id="addQuestionDrawing"  onclick="addDrawingQuestion()">Add drawing Question</button>
            <button type="button" class="green-button text-lg" id="addQuestionMath"  onclick="addMathQuestion()">Add math Question</button>
            <button type="button" class="green-button text-lg" id="addQuestionText"  onclick="addQuestionText()">Add text Question</button>

            <button type="button" class="purple-button block mt-1" id="submitQuestionConnect" onclick="submitExamQuestions()">Submit test</button>
        </div>
        <div id="questionContainer">
        </div>
    </div>
</main>
    <script src="../js/addQuestions.js"></script>
    <script src="../js/addDrawingQuestion.js"></script>
    <script src="../mathquill-0.10.1/mathquill.js"></script>
    <script src="../js/addMathQuestion.js"></script>
    <script src="../js/addTextQuestion.js"></script>
    <script src="../js/submitExamQuestions.js" ></script>
</body>
</html>