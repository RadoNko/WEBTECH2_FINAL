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
        [id^="answersConnect"] > div{
            display: flex;
            justify-content: space-between;
        }
        [id^="connectOptions"]{
            width: 45%;
        }
        /*[id^="connectAnswers"]>li:before{*/
        /*    display: block;*/
        /*    content: "-->";*/
        /*    width: 33%;*/
        /*}*/
        [id^="connectAnswers"] {
            width: 45%;
            background: purple;
        }
        li {
            list-style: none;
            font-size: 20px;
        }
        [id^="connectOptions"] li{
            position: relative;

        }
        [id^="connectOptions"] li:after{
            position: absolute;
            right: 0;
            content:url("../img/iconmonstr-arrow-right-thin.svg");
            transform: translate(150%, 0%);
            width: 10%;
        }
        /*[id^="connectAnswers"]{*/
        /*    display: block;*/
        /*    width: 33%;*/
        /*    list-style: square;*/
        /*}*/

    </style>

</head>
<body class="grid grid-cols-12 bg-gray-200 min-h-screen">
    <?php include "partials/navbar.html"?>
    <main class="col-span-10 flex justify-center pt-10">
        <div class="w-4/5 h-full bg-gray-100 text-xl shadow-2xl pb-96">
            <div id="examContainer">
            </div>
            <button type="button" class="btn btn-primary" id="submitQuestionConnect" onclick="submitExamAnswers()">Submit test</button>
        </div>
    </main>

    <script src="../mathquill-0.10.1/mathquill.js"></script>
    <script src="../drawingboard.js/drawingboard.min.js"></script>

    <script src="../js/renderQuestionsForStudent.js"></script>
    <script src="../js/submitExamAnswers.js"></script>
    <script src="../js/initializeMathFields.js"></script>
</body>
</html>