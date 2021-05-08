$(document).ready(function () {
    let studentExamId = 1;
    let origin = $(location).attr("origin");

    $.ajax({
        method: "GET",
        url: origin + "" + studentExamId,
        dataType: "json",
        success: function (data) {

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

}

function renderQuestionTypeMath(question, answers){

}

function renderQuestionTypeConnect(question, data){

}

function renderQuestionTypeText(question, answers){

}