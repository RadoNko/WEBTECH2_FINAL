$(document).ready(function(){

    let examId = 1;

    let origin = $(location).attr('origin');

    $.ajax({
        method: "GET",
        url: origin + "/skuska/WEBTECH2_FINAL/router/exam/" + examId,
        // url: "http://147.175.98.72/skuska/WEBTECH2_FINAL/router/exam/"+examId,
        dataType: "json",
        success: function(data){

            console.log(data);


            $.each(data, function(questionType, questions){
                $.each(questions, function(question, answers){
                    window["render" + questionType](question, answers);
                });
            });
        }
    });
})


function renderQuestionTypeText(question, answers){

    let exam = document.getElementById("examContainer");

    let questionType = "questionTypeText";

    let questionTypeNumber = answers["id"];

    exam.insertAdjacentHTML('beforeend', `
                                    <h4>Otázka</h4>    
                                    <form class='question' id='` + questionType + questionTypeNumber +`' >
                                    <div class="form-group">
                                        <p><b>` + question + `</b></p>
                                        <span>max. body `+ answers["points"] +`</span>
                                    </div>
                                    
                                    <div class='answer' id='` + "answerTypeText" + questionTypeNumber +`' >
                                     <input type="text" name="questionAnswer` +questionTypeNumber +`">
                               
                                </form>
                                        <br>
                                `);
}




function submitQuestionText(id){

    let form = $("#"+id).serializeArray();

    let questionId = id.split("questionTypeText").pop();

    let data = {};

    // CHANGE ! these are dummy values for testing
    data["examId"] = 1;
    data["studentId"] = 1;
    data["studentExamId"] = 1;

    data["questionId"] = questionId;

    let answers = [];
    let answer = {};


    for(i = 0; i < form.length; i++){

        answer.answer = form[i].value;
        answers.push(answer);
        answer = {};
    }

    data["answers"] = answers;

    $.ajax({
        method: "POST",
        url: origin + "/skuska/WEBTECH2_FINAL/router/exam/insertTextAnswer",
        data: data,
        dataType: "text",
        success: function(data){
            console.log(data);
        }
    });

}

/*  checks for question types in test and sends each question to its submit function

*/
function submitTest(){

    let questionTypeTextIds = $("[id^='questionTypeText']");

    if(questionTypeTextIds.length > 0){

        questionTypeTextIds.each(function(){
            submitQuestionText(this.id);
        })
    }
}

