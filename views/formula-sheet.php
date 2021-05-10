<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Math Demo</title>
    <link rel="stylesheet" href="../mathquill-0.10.1/mathquill.css"/>
    <link rel="stylesheet" href="../tailwind.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="../mathquill-0.10.1/mathquill.js"></script>
</head>
<body class="grid grid-cols-12 bg-gray-200 min-h-screen">
    <?php
    session_start();
    if ($_SESSION["teacher"]){
        include "partials/teacherNavigation.php";
    }
    else if ($_SESSION["student"]){
        include "partials/studentNavigation.php";
    }
    else{
        header("Location: /Final/loginKanda.php");
        exit();
    }



    ?>
    <main class="col-span-10 flex justify-center pt-10">
        <div>
            <p class="text-center text-2xl 2xl:font-semibold sticky top-0 p-2.5 bg-gray-200">Test your math expression: <span class="math-answer" id="answer-2"></span></p>
            <img src="../img/LaTeX%20math%20cheatsheet.png" alt="LaTeX cheatsheet">
        </div>

    </main>


<script>
    let MQ = MathQuill.getInterface(2);
    const answerSpans = document.getElementsByClassName('math-answer')
    for (const span of answerSpans){
        const answerMathField = MQ.MathField(span,{
            handlers: {
                edit: function() {
                    let enteredMath = answerMathField.latex(); // Get entered math in LaTeX format
                    const questionInput = span.parentElement.lastElementChild;
                    questionInput.value = enteredMath;
                }
            }
        })
    }
</script>
</body>
</html>