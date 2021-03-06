$("#close-modal").click(function () {
    $("#open-modal").css('visibility', 'hidden');
})

// checks for question types in test and sends each question to its submit function
function submitRateTest() {
    $("#open-modal").css('visibility', 'visible');
    let questionTypeTextIds = $("[id^='questionTypeText']"); //kanda
    let questionTypeMathIds = $("[id^='questionTypeMath']"); //fullajtar
    let questionTypeDrawingIds = $("[id^='questionTypeDrawing']"); //fullajtar

    if (questionTypeTextIds.length > 0) { //kanda
        questionTypeTextIds.each(function () {
            submitQuestionText(this.id);
        })
    }

    if (questionTypeMathIds.length > 0) { //fullajtar
        questionTypeMathIds.each(function () {
            submitQuestionMath(this.id);
        })
    }

    if (questionTypeDrawingIds.length > 0) { //fullajtar
        questionTypeDrawingIds.each(function () {
            submitQuestionDrawing(this.id);
        })
    }

    //resetArea();
}

function submitQuestionText(id) {
    let form = $("#" + id).serializeArray();

    let data = {};
    data["answerId"] = form[0].name;
    data["points"] = form[0].value;
    let origin = $(location).attr('origin');

    $.ajax({
        method: "POST",
        url: origin + "/Final/router/exam/rateAnswersText",
        data: data,
        dataType: "text",
        success: function (data) {
        }
    });

}

function submitQuestionMath(id) {
    let form = $("#" + id).serializeArray();

    let data = {};
    data["answerId"] = form[0].name;
    data["points"] = form[0].value;

    let origin = $(location).attr('origin');

    $.ajax({
        method: "POST",
        url: origin + "/Final/router/exam/rateAnswersMath",
        data: data,
        dataType: "text",
        success: function (data) {
        }
    });
}

function submitQuestionDrawing(id) {
    let form = $("#" + id).serializeArray();

    let data = {};
    data["answerId"] = form[0].name;
    data["points"] = form[0].value;

    let origin = $(location).attr('origin');

    $.ajax({
        method: "POST",
        url: origin + "/Final/router/exam/rateAnswersDrawing",
        data: data,
        dataType: "text",
        success: function (data) {
        }
    });
}

/*  checks for question types in test and sends each question to its submit function

    !!!!!!:  update table Student_Exam
*/
