$(document).ready(function () {
    let studentExamId = 1;
    let origin = $(location).attr("origin");
    console.log("render answers")
    $.ajax({
        method: "GET",
        url: origin + "/Final/router/rateExam/" + studentExamId,
        dataType: "json",
        success: function (data) {
            data["AnswerTypeMath"].forEach(answer => {
                renderQuestionTypeMath(answer)

                //init static math expressions
                const MQ = MathQuill.getInterface(2);
                const mathExpressions = document.getElementsByClassName('math-expression')
                for (const expression of mathExpressions){
                    MQ.StaticMath(expression)
                }
            })
        },
    });
});

function renderQuestionTypeDrawing(question, answers){

}

function renderQuestionTypeMultiple(question, answers){

}

function renderQuestionTypeMath(answer){
    console.log(answer)
    const exam = document.getElementById("examContainer");
    const questionType = "questionTypeMath";
    const question = answer["name"];

    // this is the ID from db; it will be extracted upon test submit
    let questionTypeNumber = answer["id"];
    exam.insertAdjacentHTML('beforeend', `<form class='question' id='` + questionType + questionTypeNumber +`' >
                                    <div class="form-group">
                                        <p><span class="math-expression">` + question + `</span></p>
                                        <span class="max-points">`+ answer["points"] +`</span>
                                    </div>
                                    <div id="answersMath`+ questionTypeNumber +`" class="form-group">

                                    </div>
                                </form>
                                `);
    const answersContainer = document.getElementById("answersMath" + questionTypeNumber);
    answersContainer.insertAdjacentHTML('beforeend', `<div class="form-check">
                                                                    <span class="math-expression" id="answer-2">`+ answer["answer"] +`</span> <!--span as input for rendering math expressions-->
                                                                    <label for="points">Rate Question</label>
                                                                    <input type="number" name="points" value='' class="form-check-input" min="0" required>
                                                                 </div>
                                             `)


}

function renderQuestionTypeConnect(question, data){

}

function renderQuestionTypeText(question, answers){

}