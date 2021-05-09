$(document).ready(function () {
    let studentExamId = 1;
    let origin = $(location).attr("origin");
    $.ajax({
        method: "GET",
        // url: origin + "/Final/router/rateExam/" + studentExamId,
        url :"http://147.175.98.72/skuska/WEBTECH2_FINAL/router/rateExam/" + studentExamId,

        dataType: "json",
        success: function (data) {
            console.log("data: ",data)
            data["AnswerTypeText"].forEach(answer => {
                renderQuestionTypeText(answer)
            })
        },
    });
});


function renderQuestionTypeText(answer){

    let exam = document.getElementById("examContainer");

    let questionType = "questionTypeText";

    const question = answer["name"];

    let questionTypeNumber = answer["id"];

    exam.insertAdjacentHTML('beforeend', `
                                    <form class='question' id='` + questionType + questionTypeNumber +`' >
                                    <div class="form-group">
                                        <p><b>` + question + `</b></p>
                                        <span>max points `+ answer["max_points"] +`</span>
                                    </div>
                                    
                                    <div id="answersText`+ questionTypeNumber +`" class="form-group">
                                    </div>
                                </form>
                                `);
    const answersContainer = document.getElementById("answersText" + questionTypeNumber);
    answersContainer.insertAdjacentHTML('beforeend', `
            <div class="form-group">
                <span  id="answer-2">`+ answer["answer"] +`</span> 
                <label for="points">Rate Question</label>
                <input type="number" name="`+answer["id"]+`" value="`+answer["points"]+`" class="form-check-input" min="0" max="`+answer["max_points"]+`" required>
             </div>
                                             `)



}
