<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Q</title>
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
</head>
<body>

    <h1 style="margin-left: 40%">Question text</h1><br>
    <div id="mainQuestionForm" style="margin-left: 40%">
        <button type="button" class="btn btn-primary" id="addQuestionText" onclick="addQuestionText()">Pridaj otázku</button>
        <button style="display: none" type="button" class="btn btn-primary" id="addTextAnswer" onclick="addTextAnswer()">Pridaj odpoveď</button><br>
    </div>

    <button style="margin-left: 45%; top:80%; position: absolute" type="button" class="btn btn-success" onclick="saveTest()">Ulož test</button>

<script src="js/custom.js"></script>
</body>
</html>

