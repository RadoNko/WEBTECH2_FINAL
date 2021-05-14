$(document).ready(function () {
    let studentExamId = 1;
    let origin = $(location).attr("origin");
    $.ajax({
        method: "GET",
        url: origin + "/Final/router/rateExam/" + studentExamId,
        dataType: "json",
        success: function (data) {

            $.each(data, function (questionType, questions) {
                $.each(questions, function (question, answers) {

                    // call render function for question type
                    window["render" + questionType](question, answers);
                });
            });
            //init static math expressions
            const MQ = MathQuill.getInterface(2);
            const mathExpressions = document.getElementsByClassName('math-expression')
            for (const expression of mathExpressions) {
                MQ.StaticMath(expression)
            }
        },
    });
});

function renderAnswerTypeDrawing(question, answer) {
    const exam = document.getElementById("examContainer");
    const questionType = "questionTypeDrawing";

    // this is the ID from db; it will be extracted upon test submit
    let questionTypeNumber = answer["id"];
    exam.insertAdjacentHTML('beforeend', `<form class='question' id='` + questionType + questionTypeNumber + `'>
                                    <div class="form-group">
                                        <p class="font-semibold">` + answer["name"] + `</p>
                                        <span class="max-points">`+ answer["max_points"] + `</span>
                                    </div>
                                    <div id="answersDrawing`+ questionTypeNumber + `" class="form-group">
                                        
                                    </div>
                                </form>
                                `);
    const answersContainer = document.getElementById("answersDrawing" + questionTypeNumber);
    answersContainer.insertAdjacentHTML('beforeend', `<div class="form-check">
                                                                    <img class="w-full h-auto" id='drawingDiv`+ questionType + questionTypeNumber + `' src="/Final/drawings/` + answer["student_exam_fk"] + `-` + answer["question_type_fk"] + `.png " alt="Image Not Found - Student didnt answer to this question">
                                                                    <label class="block pdf" for="points">Rate Answer</label>
                                                                    <input type="number" name="`+ answer["id"] + `" points+ value="` + answer["points"] + `" class="form-check-input pdf" min="0" max="` + answer["max_points"] + `" required>

                                                                 </div>
                                             `)

}

function renderQuestionTypeMultiple(question, answers) {
    let exam = document.getElementById("examContainer");

    let questionType = "questionTypeMultiple";

    // this is the ID from db; it will be extracted upon test submit
    let questionTypeNumber = answers["id"];

    exam.insertAdjacentHTML('beforeend', `<form class='question' id='` + questionType + questionTypeNumber + `' >
                                    <div class="form-group">
                                        <p><b>` + question + `</b></p>
                                        <span>`+ parseFloat(answers["earned_points"]).toFixed(2) + ` / ` + answers["max_points"] + `</span>
                                    </div>
                                    <div id="answersMultiple`+ questionTypeNumber + `" class="form-group">
                                    </div>
                                </form>
                                `);

    let answersContainer = document.getElementById("answersMultiple" + questionTypeNumber);

    $.each(answers["answers"], function (key, answer) {

        //                                                                                                                                                               choice-y -> student selected that answer
        answersContainer.insertAdjacentHTML('beforeend', `<div class="form-check">
                                                                <input `+ ((answer.choice === "y") ? 'checked' : '') + ` type="checkbox" disabled="disabled" name="answer" value='` + answer.id + `'  >
                                                                <label class="form-check-label">` + answer.answer + `</label>
                                                             </div>
                                             `)
    })
}

function renderAnswerTypeMath(question, answer) {
    const exam = document.getElementById("examContainer");
    const questionType = "questionTypeMath";

    // this is the ID from db; it will be extracted upon test submit
    let questionTypeNumber = answer["id"];
    exam.insertAdjacentHTML('beforeend', `<form class='question' id='` + questionType + questionTypeNumber + `' >
                                    <div class="form-group">
                                        <p><span class="math-expression">` + answer["name"] + `</span></p>
                                        <span class="max-points">`+ answer["max_points"] + `</span>
                                    </div>
                                    <div id="answersMath`+ questionTypeNumber + `" class="form-group">
                                    </div>
                                </form>
                                `);
    const answersContainer = document.getElementById("answersMath" + questionTypeNumber);
    answersContainer.insertAdjacentHTML('beforeend', `<div class="form-check">
                                                                    <span class="math-expression" id="answer-2">`+ answer["answer"] + `</span> <!--span as input for rendering math expressions-->
                                                                    <label class="block pdf" for="points">Rate Answer</label>
                                                                    <input type="number" name="`+ answer["id"] + `" value="` + answer["points"] + `" class="form-check-input pdf" min="0" max="` + answer["max_points"] + `" required>
                                                                 </div>
                                             `)
}

function renderQuestionTypeConnect(question, data) {
    let exam = document.getElementById("examContainer");

    let questionType = "questionTypeConnect";

    // this is the ID from db; it will be extracted upon test submit
    let questionTypeNumber = data["id"];

    exam.insertAdjacentHTML('beforeend', `<form class='question' id='` + questionType + questionTypeNumber + `' >
                                            <div class='form-group'>
                                                <p><b>` + question + `</b></p>
                                                <span>`+ parseFloat(data["earned_points"]).toFixed(2) + ` / ` + data["max_points"] + `</span>
                                            </div>
                                            <div id='answersConnect`+ questionTypeNumber + `' class='form-group'>
                                                <div class='row'>
                                                    <ul id='connectOptions`+ questionTypeNumber + `' class='col d-flex flex-column list-group'>
                                                    </ul>
                                                    <ul id='connectAnswers`+ questionTypeNumber + `' class='col d-flex flex-column'>
                                                    </ul>
                                                </div>
                                            </div>
                                        </form>
                                `);

    let optionsContainer = document.getElementById("connectOptions" + questionTypeNumber);
    let answersContainer = document.getElementById("connectAnswers" + questionTypeNumber);

    $.each(data["options"], function (key, option) {

        optionsContainer.insertAdjacentHTML('beforeend', `<li class="list-group-item border text-center">
                                                                ` + option.option + `  
                                                          </li>
                                                `)
    });

    $.each(data["answers"], function (key, answer) {

        answersContainer.insertAdjacentHTML('beforeend', `<li class="list-group-item border text-center">
                                                                ` + answer.answer + `
                                                          </li>
                                            `);
    });

}

function renderAnswerTypeText(question, answer) {

    let exam = document.getElementById("examContainer");

    let questionType = "questionTypeText";

    question = answer["name"];

    let questionTypeNumber = answer["id"];

    exam.insertAdjacentHTML('beforeend', `
                                    <form class='question' id='` + questionType + questionTypeNumber + `' >
                                    <div class="form-group">
                                        <p><b>` + question + `</b></p>
                                        <span class="max-points">`+ answer["max_points"] + `</span>
                                    </div>
                                    
                                    <div id="answersText`+ questionTypeNumber + `" class="form-group">
                                    </div>
                                </form>
                                `);
    const answersContainer = document.getElementById("answersText" + questionTypeNumber);
    answersContainer.insertAdjacentHTML('beforeend', `
            <div class="form-group">
                <span  id="answer-2">`+ answer["answer"] + `</span> 
                <label class="block pdf" for="points">Rate Answer</label>
                <input type="number" name="`+ answer["id"] + `" value="` + answer["points"] + `" class="form-check-input pdf" min="0" max="` + answer["max_points"] + `" required>

             </div>
                                             `)

}