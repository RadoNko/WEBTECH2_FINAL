<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Q</title>

    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <!--<link rel="stylesheet" href="css/index.css">-->
</head>
<body>

    <div id="questionContainer">
    </div>

    <button type="button" class="btn btn-primary" id="addQuestionMultiple" onclick="addQuestionMultiple()">Add question with multiple choices</button>
    <button type="button" class="btn btn-primary" id="addQuestionConnect"  onclick="addQuestionConnect()">Add question with pairs</button>

    <button type="button" class="btn btn-primary" id="submitQuestionConnect" onclick="submitTest()">Submit test</button>

    <div id="drag" draggable="true" ondragstart="drag(event)" style="width: 100px; height: 100px; background-color: blue"></div>
    <div ondrop="drop(event)" ondragover="allowDrop(event)" style="width: 100px; height: 100px; border: 1px dashed red; margin-top: 50px;"></div>

    <script src="js/script.js"></script>
</body>
</html>