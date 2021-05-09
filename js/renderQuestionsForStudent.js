$(document).ready(function () {
    let examId = 1;
    let origin = $(location).attr("origin");

    $.ajax({
        method: "GET",
        url: origin + "/Final/router/exam/" + examId,
        dataType: "json",
        success: function (data) {
            console.log("data: ",data)

            $.each(data, function (questionType, questions) {
                $.each(questions, function (question, answers) {
                    // call render function for question type

                    window["render" + questionType](question, answers);
                });
            });
        },
    });
});

let boards = new Map()

function renderQuestionTypeDrawing(question, answers){

    const exam = document.getElementById("examContainer");
    const questionType = "questionTypeDrawing";

    // this is the ID from db; it will be extracted upon test submit
    let questionTypeNumber = answers["id"];
    exam.insertAdjacentHTML('beforeend', `<form class='question' id='` + questionType + questionTypeNumber +`'>
                                    <div class="form-group">
                                        <p class="font-semibold">` + question + `</p>
                                        <span class="max-points">`+ answers["points"] +`</span>
                                    </div>
                                    <div id="answersDrawing`+ questionTypeNumber +`" class="form-group">
                                        
                                    </div>
                                </form>
                                `);
    const answersContainer = document.getElementById("answersDrawing" + questionTypeNumber);
    answersContainer.insertAdjacentHTML('beforeend', `<div class="form-check">
                                                                    <div class="w-full h-96" id='drawingDiv`+ questionType + questionTypeNumber +`'></div>
                                                                    <input type="hidden" name='image' value="">
                                                                    <input type="hidden" name="imageId" value="">
                                                                 </div>
            
    
                                             `)

    const myBoard = new DrawingBoard.Board('drawingDiv'+ questionType + questionTypeNumber);
    boards.set(''+questionType + questionTypeNumber, myBoard);
}

function renderQuestionTypeMultiple(question, answers){

    let exam = document.getElementById("examContainer");

    let questionType = "questionTypeMultiple";

    // this is the ID from db; it will be extracted upon test submit
    let questionTypeNumber = answers["id"];

    exam.insertAdjacentHTML('beforeend', `<form class='question' id='` + questionType + questionTypeNumber +`' >
                                    <div class="form-group">
                                        <p><b>` + question + `</b></p>
                                        <span class="max-points">`+ answers["points"] +`</span>
                                    </div>
                                    <div id="answersMultiple`+ questionTypeNumber +`" class="form-group">
                                        
                                    </div>
                                </form>
                                `);

    let answersContainer = document.getElementById("answersMultiple" + questionTypeNumber);

    $.each(answers["answers"], function(key, answer){


        answersContainer.insertAdjacentHTML('beforeend', `<div class="form-check">
                                                                <input type="checkbox" name="answer" value='`+ answer.id +`' class="form-check-input">
                                                                <label class="form-check-label">` + answer.answer + `</label>
                                                             </div>
                                             `)
    })
}

function renderQuestionTypeMath(question, answers){
    const exam = document.getElementById("examContainer");
    const questionType = "questionTypeMath";

    // this is the ID from db; it will be extracted upon test submit
    let questionTypeNumber = answers["id"];
    exam.insertAdjacentHTML('beforeend', `<form class='question' id='` + questionType + questionTypeNumber +`' >
                                    <div class="form-group">
                                        <p><span class="math-expression">` + question + `</span></p>
                                        <span class="max-points">`+ answers["points"] +`</span>
                                    </div>
                                    <div id="answersMath`+ questionTypeNumber +`" class="form-group">
                                        
                                    </div>
                                </form>
                                `);
    const answersContainer = document.getElementById("answersMath" + questionTypeNumber);
    answersContainer.insertAdjacentHTML('beforeend', `<div class="form-check">
                                                                    <span class="math-answer" id="answer-2"></span> <!--span as input for rendering math expressions-->
                                                                    <input type="hidden" name="answer" value='' class="form-check-input"> <!--have to be last child of thid div element-->
                                                                 </div>
            
    
                                             `)
    const MQ = MathQuill.getInterface(2);

    //render static math fields //TODO bad preformance due to looping through already rendered fields
    const mathExpressions = document.getElementsByClassName('math-expression')
    for (const expression of mathExpressions){
        MQ.StaticMath(expression)
    }

    //init answer math field
    const answerSpans = answersContainer.getElementsByClassName('math-answer')
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
}

function renderQuestionTypeConnect(question, data){

    let exam = document.getElementById("examContainer");

    let questionType = "questionTypeConnect";

    // this is the ID from db; it will be extracted upon test submit
    let questionTypeNumber = data["id"];

    exam.insertAdjacentHTML('beforeend', `<form class='question' id='` + questionType + questionTypeNumber +`' >
                                            <div class='form-group'>
                                                <p><b>` + question + `</b></p>
                                                <span class="max-points">`+ data["points"] +`</span>
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
                                                            <input type="hidden" name='connectOption' value='`+ option.id +`'>   
                                                          </li>
                                                `)
    });

    $.each(data["answers"], function(key, answer){

        answersContainer.insertAdjacentHTML('beforeend', `<li draggable="true" ondragstart="drag(event)"
                                                            ondrop="drop(event)" ondragover="allowDrop(event)" class="list-group-item border text-center">
                                                                ` + answer.answer + `
                                                                <input type="hidden" name="connectAnswer" value='`+ answer.id +`'>
                                                          </li>
                                            `);
    });

    // randomly rearrange answers (right side); before shuffle they are 1:1 with options (left side) and therefore correctly placed
    $("#connectAnswers" + questionTypeNumber +" li").shuffle(questionTypeNumber);
}

function renderQuestionTypeText(question, answers){

    let exam = document.getElementById("examContainer");

    let questionType = "questionTypeText";

    let questionTypeNumber = answers["id"];

    exam.insertAdjacentHTML('beforeend', `
                                    <form class='question' id='` + questionType + questionTypeNumber +`' >
                                    <div class="form-group">
                                        <p><b>` + question + `</b></p>
                                        <span class="max-points"> `+ answers["points"] +`</span>
                                    </div>
                                    
                                    <div class='answer' id='` + "answerTypeText" + questionTypeNumber +`' >
                                     <input type="text" name="questionAnswer` +questionTypeNumber +`">
                               
                                </form>
                                        <br>
                                `);
}