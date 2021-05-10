$(document).ready(function () {

    let studentExamId = 3;
    let origin = $(location).attr("origin");

    $.ajax({
        method: "GET",
        url: origin + "/Final/router/studentExam/"+studentExamId+"/answers",
        dataType: "json",
        success: function (data) {

            console.log(data);
            
            $.each(data, function (questionType, questions) {
                $.each(questions, function (question, answers) {
                    // call render function for question type
                    window["render" + questionType](question, answers);
                });
            });
        },
    });
});

function renderQuestionTypeDrawing(question, answers){

}

function renderQuestionTypeMultiple(question, answers){

    let exam = document.getElementById("examContainer");

    let questionType = "questionTypeMultiple";

    // this is the ID from db; it will be extracted upon test submit
    let questionTypeNumber = answers["id"];

    exam.insertAdjacentHTML('beforeend', `<form class='question' id='` + questionType + questionTypeNumber +`' >
                                    <div class="form-group">
                                        <p><b>` + question + `</b></p>
                                        <span>`+ answers["earned_points"] +` / `+ answers["max_points"] +`</span>
                                    </div>
                                    <div id="answersMultiple`+ questionTypeNumber +`" class="form-group">
                                        
                                    </div>
                                </form>
                                `);

    let answersContainer = document.getElementById("answersMultiple" + questionTypeNumber);

    $.each(answers["answers"], function(key, answer){

        //                                                                                                                                                               choice-y -> student selected that answer
        answersContainer.insertAdjacentHTML('beforeend', `<div class="form-check">
                                                                <input type="checkbox" disabled="disabled" name="answer" value='`+ answer.id +`' class="form-check-input choice-`+ answer.choice +`">
                                                                <label class="form-check-label">` + answer.answer + `</label>
                                                             </div>
                                             `)
    })

}

function renderQuestionTypeMath(question, answers){

}

function renderQuestionTypeConnect(question, data){

    let exam = document.getElementById("examContainer");

    let questionType = "questionTypeConnect";

    // this is the ID from db; it will be extracted upon test submit
    let questionTypeNumber = data["id"];

    exam.insertAdjacentHTML('beforeend', `<form class='question' id='` + questionType + questionTypeNumber +`' >
                                            <div class='form-group'>
                                                <p><b>` + question + `</b></p>
                                                <span>`+ data["earned_points"] +` / `+ data["max_points"] +`</span>
                                            </div>
                                            <div id='answersConnect`+ questionTypeNumber +`' class='form-group'>
                                                <div class='row'>
                                                    <ul id='connectOptions`+ questionTypeNumber +`' class='col d-flex flex-column list-group'>
                                                        
                                                    </ul>

                                                    <ul id='connectAnswers`+ questionTypeNumber +`' class='col d-flex flex-column'>
                                                    </ul>
                                                </div>
                                            </div>
                                        </form>
                                `);

    let optionsContainer = document.getElementById("connectOptions" + questionTypeNumber);
    let answersContainer = document.getElementById("connectAnswers" + questionTypeNumber);

    $.each(data["options"], function(key, option){

        optionsContainer.insertAdjacentHTML('beforeend', `<li class="list-group-item border text-center">
                                                                ` + option.option + `  
                                                          </li>
                                                `)
    });

    $.each(data["answers"], function(key, answer){

        answersContainer.insertAdjacentHTML('beforeend', `<li class="list-group-item border text-center">
                                                                ` + answer.answer + `
                                                          </li>
                                            `);
    });
}

function renderQuestionTypeText(question, answers){

}