<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="../tailwind.css">
    <link rel="stylesheet" href="../mathquill-0.10.1/mathquill.css" />
    <link rel="stylesheet" href="../drawingboard.js/drawingboard.min.css">
</head>

<body class="grid grid-cols-12 bg-gray-200 min-h-screen">
    <?php include "partials/navbar.html" ?>
    <main class="col-span-10 flex justify-center pt-10">
        <?php include "partials/debug.test.html" ?>
    </main>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="../mathquill-0.10.1/mathquill.js"></script>
    <script src="../drawingboard.js/drawingboard.min.js"></script>
    <script>
        let MQ = MathQuill.getInterface(2);
    </script>

    <script>
        //programmatically set value
        // let answerSpan2 = document.getElementById('answer-2');
        // let answerMathField2 = MQ.MathField(answerSpan2);
        // let str = String.raw`x=\frac{1}{2\sqrt{3}}`
        // answerMathField2.latex(str)
    </script>
    <script>
        //render all static math expressions
        const mathExpressions = document.getElementsByClassName('math-expression')
        for (const expression of mathExpressions) {
            MQ.StaticMath(expression)
        }
    </script>
    <script>
        //init all editable math expressions + onchange set input value to LaTeX format
        const answerSpans = document.getElementsByClassName('math-answer')
        for (const span of answerSpans) {
            const answerMathField = MQ.MathField(span, {
                handlers: {
                    edit: function() {
                        let enteredMath = answerMathField.latex(); // Get entered math in LaTeX format
                        const questionInput = span.parentElement.lastElementChild;
                        questionInput.value = enteredMath;
                        console.log(questionInput)
                    }
                }
            })
        }
    </script>
    <script>
        var myBoard = new DrawingBoard.Board('zbeubeu');
        $('.drawing-form').on('submit', function(e) {
            console.log("thid: ", this)
            //get drawingboard content
            var img = myBoard.getImg();

            //we keep drawingboard content only if it's not the 'blank canvas'
            var imgInput = (myBoard.blankCanvas == img) ? '' : img;

            //put the drawingboard content in the form field to send it to the server
            $(this).find('input[name=image11]').val(imgInput);
            $(this).find('input[name=imageId]').val("MOJEID");

            return false

            //we can also assume that everything goes well server-side
            //and directly clear webstorage here so that the drawing isn't shown again after form submission
            //but the best would be to do when the server answers that everything went well
            myBoard.clearWebStorage();

        });


        // var myBoard = new DrawingBoard.Board('zbeubeu');
        // $('.drawing-form').on('submit', function(e) {
        //     //get drawingboard content
        //     var img = myBoard.getImg();
        //
        //     //we keep drawingboard content only if it's not the 'blank canvas'
        //     var imgInput = (myBoard.blankCanvas == img) ? '' : img;
        //
        //     //put the drawingboard content in the form field to send it to the server
        //     $(this).find('input[name=image11]').val(imgInput);
        //     $(this).find('input[name=imageId]').val("MOJEID");
        //
        //     //we can also assume that everything goes well server-side
        //     //and directly clear webstorage here so that the drawing isn't shown again after form submission
        //     //but the best would be to do when the server answers that everything went well
        //     myBoard.clearWebStorage();
        //
        // });
    </script>