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
    <style>
    </style>

</head>
<body class="grid grid-cols-12 bg-gray-200 min-h-screen">
    <?php include "partials/studentNavigation.php" ?>
    <main class="col-span-10 flex justify-center pt-10 pb-96">
        <div class="w-4/5 h-full bg-gray-100 text-xl shadow-2xl">
            <div id="examContainer">
            </div>
            <button type="button" class="green-button mb-4 w-full" id="submitQuestionConnect" onclick="submitExamAnswers()">Submit test</button>
        </div>
    </main>

    <script src="../mathquill-0.10.1/mathquill.js"></script>
    <script src="../drawingboard.js/drawingboard.min.js"></script>

    <script src="../js/renderQuestionsForStudent.js"></script>
    <script src="../js/submitExamAnswers.js"></script>
    <script src="../js/initializeMathFields.js"></script>
</body>
</html>