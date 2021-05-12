<?php
if (session_status() != 2){
    session_start();
}
// TODO this is only testing code, remove if not needed
echo "loggedId: " . $_SESSION["logged_id"] . "<br>";
echo "examId: " . $_SESSION["exam_id"] . "<br>";
// END
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="examOverview.css">
    <title>Exam overview</title>
</head>

<body class="container">
    <button id="addNewExamButton">
        <svg width="40px" height="40px" aria-hidden="true" focusable="false" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
            <path fill="currentColor" d="M416 208H272V64c0-17.67-14.33-32-32-32h-32c-17.67 0-32 14.33-32 32v144H32c-17.67 0-32 14.33-32 32v32c0 17.67 14.33 32 32 32h144v144c0 17.67 14.33 32 32 32h32c17.67 0 32-14.33 32-32V304h144c17.67 0 32-14.33 32-32v-32c0-17.67-14.33-32-32-32z"></path>
        </svg>
    </button>
    <div id=listBody></div>
    <div class="modal" tabindex="-1" id="toggleExamModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="toggleExamTitle"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="toggleExamBody">Modal body text goes here.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="toggleExamButton">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" tabindex="-1" id="createExamModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create Exam</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nameInput">Exam name</label>
                        <input id="nameInput" type="text" class="form-control" placeholder="Exam title" aria-label="Exam title" aria-describedby="basic-addon2" required>
                        <small id="nameHelp" class="form-text text-muted">You can not choose this name. Exam with provided name already exists.</small>
                    </div>
                    <div class="form-group">
                        <label for="timeInput">Time to work</label>
                        <input id="timeInput" type="number" class="form-control" aria-label="Time to work" aria-describedby="basic-addon2" value="60" required>
                        <small id="timeHelp" class="form-text text-muted">Set time in minutes between 1 and 1660.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="createExamButton" disabled>Create</button>
                </div>
            </div>
        </div>
    </div>
    <script src="../js/examOverview.js"></script>
</body>

</html>