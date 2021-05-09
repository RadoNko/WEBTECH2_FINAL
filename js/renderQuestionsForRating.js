$(document).ready(function () {
    let studentExamId = 1;
    let origin = $(location).attr("origin");
    $.ajax({
        method: "GET",
        url: origin + "/Final/router/rateExam/" + studentExamId,
        dataType: "json",
        success: function (data) {
            console.log("data: ",data)
            data["AnswerTypeMath"].forEach(answer => {
                renderQuestionTypeMath(answer)

                //init static math expressions
                const MQ = MathQuill.getInterface(2);
                const mathExpressions = document.getElementsByClassName('math-expression')
                for (const expression of mathExpressions){
                    MQ.StaticMath(expression)
                }
            })
            data["AnswerTypeDrawing"].forEach(answer => {
                renderQuestionTypeDrawing(answer)
            })
        },
    });
});

function renderQuestionTypeDrawing(answer){
    const exam = document.getElementById("examContainer");
    const questionType = "questionTypeDrawing";

    // this is the ID from db; it will be extracted upon test submit
    let questionTypeNumber = answer["id"];
    exam.insertAdjacentHTML('beforeend', `<form class='question' id='` + questionType + questionTypeNumber +`'>
                                    <div class="form-group">
                                        <p class="font-semibold">` + answer["name"] + `</p>
                                        <span class="max-points">`+ answer["max_points"] +`</span>
                                    </div>
                                    <div id="answersDrawing`+ questionTypeNumber +`" class="form-group">
                                        
                                    </div>
                                </form>
                                `);
    const answersContainer = document.getElementById("answersDrawing" + questionTypeNumber);
    answersContainer.insertAdjacentHTML('beforeend', `<div class="form-check">
                                                                    <img class="w-full h-96" id='drawingDiv`+ questionType + questionTypeNumber +`' src="/Final/drawings/`+ answer["student_exam_fk"] +`-`+answer["question_type_fk"] +`.png " alt="Image Not Found">
                                                                    <label for="points">Rate Question</label>
                                                                    <input type="number" name="`+answer["id"]+`" points+ value="`+answer["points"]+`" class="form-check-input" min="0" max="`+answer["max_points"]+`" required>
                                                                 </div>
                                             `)

}

function renderQuestionTypeMultiple(question, answers){

}

function renderQuestionTypeMath(answer){
    const exam = document.getElementById("examContainer");
    const questionType = "questionTypeMath";
    const question = answer["name"];

    // this is the ID from db; it will be extracted upon test submit
    let questionTypeNumber = answer["id"];
    exam.insertAdjacentHTML('beforeend', `<form class='question' id='` + questionType + questionTypeNumber +`' >
                                    <div class="form-group">
                                        <p><span class="math-expression">` + question + `</span></p>
                                        <span class="max-points">`+ answer["max_points"] +`</span>
                                    </div>
                                    <div id="answersMath`+ questionTypeNumber +`" class="form-group">

                                    </div>
                                </form>
                                `);
    const answersContainer = document.getElementById("answersMath" + questionTypeNumber);
    answersContainer.insertAdjacentHTML('beforeend', `<div class="form-check">
                                                                    <span class="math-expression" id="answer-2">`+ answer["answer"] +`</span> <!--span as input for rendering math expressions-->
                                                                    <label for="points">Rate Question</label>
                                                                    <input type="number" name="`+answer["id"]+`" value="`+answer["points"]+`" class="form-check-input" min="0" max="`+answer["max_points"]+`" required>
                                                                 </div>
                                             `)


}

function renderQuestionTypeConnect(question, data){

}

function renderQuestionTypeText(question, answers){

}