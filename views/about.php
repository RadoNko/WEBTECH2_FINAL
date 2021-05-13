<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About us</title>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

</head>
<body>
    <div class="container mt5">
        <table class="table table-sm">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Dominik Fullajtár</th>
                    <th>Martin Kršek</th>
                    <th>Martin Kováčik</th>
                    <th>Matúš Kanda</th>
                    <th>Daniel Jankech</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>Login / Signup</th>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>X</td>
                    <td></td>
                </tr>
                <tr>
                    <th>Question type multiple answers</th>
                    <td></td>
                    <td></td>
                    <td>X</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <th>Question type short text</th>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>X</td>
                    <td></td>
                </tr>
                <tr>
                    <th>Question type pairs</th>
                    <td></td>
                    <td></td>
                    <td>X</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <th>Question type drawing</th>
                    <td>X</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <th>Question type math</th>
                    <td>X</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <th>End exam</th>
                    <td></td>
                    <td>X</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <th>Define multiple exams, activ/deactiv</th>
                    <td></td>
                    <td>X</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <th>Info about exam for teacher</th>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>X</td>
                </tr>
                <tr>
                    <th>PDF export</th>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>X</td>
                    <td></td>
                </tr>
                <tr>
                    <th>CSV export</th>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>X</td>
                </tr>
                <tr>
                    <th>Docker</th>
                    <td></td>
                    <td>X</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <th>Graphic design, layout</th>
                    <td>X</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <th>Database</th>
                    <td></td>
                    <td>X</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="w-50 mx-auto">
        <h4>Creating exam</h4>
        <p>Teacher can create a new exam with a "+" sign after signup (on page "Exam overview"), where he inserts the exam name and time limit.
        After clicking "Create" button, the teacher can choose from 5 different question types to add to the exam. 
        Question of the same type can be added multiple times, and not all types of questions are needed to create a exam.
        After submitting the exam, the teacher will be redirected back to page "Exam overview", where he will see the newly added exam.
        The exam is created with status "inactive". Exams are ordered in ascending way: last inserted exam is at the bottom.
        </p>
    
        <h4>Adding questions</h4>
        <p>Each type of question has an add button. Teacher must fill all the inputs, otherwise on submit a modal window will notify the teacher to fill all the values.
           Teacher can delete added question(s) only before submitting them. All questions are submitted "at once": one submit button for all of them.
        </p>

        <h4>Activation / deactivation of exam</h4>
        <p>Each exam has an activation button, which lets the teacher to active the exam. From that moment on, the exam code is valid
        and students can log in using that exam code. Teacher can also deactivate an active exam.
        </p>

        <h4>Exam notifications</h4>
        <p>
        </p>

        <h4>Grading exam</h4>
        <p>
        </p>

        <h4>Exports to pdf / csv</h4>
        <p>
        </p>
    </div>
    
</body>
</html>