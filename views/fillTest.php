<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Q</title>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="../tailwind.css">
    <link rel="stylesheet" href="../mathquill-0.10.1/mathquill.css"/>

</head>
<body class="grid grid-cols-12 bg-gray-200 min-h-screen">
    <?php include "partials/navbar.html"?>
    <main class="col-span-10 flex justify-center pt-10">
        <div class="w-4/5 h-full bg-gray-100 text-xl shadow-2xl pb-96">
            <div id="examContainer">
            </div>
            <button type="button" class="btn btn-primary" id="submitQuestionConnect" onclick="submitTest()">Submit test</button>
        </div>
    </main>




    <script src="../mathquill-0.10.1/mathquill.js"></script>
    <script src="../js/exam.js"></script>
    <script src="../js/initializeMathFields.js"></script>
</body>
</html>