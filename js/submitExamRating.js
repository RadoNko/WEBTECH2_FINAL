function submitQuestionText(id){

    const origin = $(location).attr("origin");

    $.ajax({
        method: "POST",
        url: origin + "",
        data: data,
        dataType: "text",
        success: function(data){
        }
    });

}

function submitQuestionMath(id){

    let origin = $(location).attr('origin');

    $.ajax({
        method: "POST",
        url: origin + "",
        data: data,
        dataType: "text",
        success: function(data){
        }
    });
}

function submitQuestionDrawing(id){

    let origin = $(location).attr('origin');

    $.ajax({
        method: "POST",
        url: origin + "",
        data: data,
        dataType: "text",
        success: function(data){
            myBoard.clearWebStorage();
        }
    });
}

/*  checks for question types in test and sends each question to its submit function

    !!!!!!:  update table Student_Exam
*/
function submitExamAnswers() {
    let questionTypeMathIds = $("[id^='questionTypeMath']"); //fullajtar
    let questionTypeDrawingIds = $("[id^='questionTypeDrawing']"); //fullajtar
    let questionTypeTextIds = $("[id^='questionTypeText']");

    if(questionTypeMathIds.length > 0){

        questionTypeMathIds.each(function(){
            submitQuestionMath(this.id);
        })
    }

    if(questionTypeDrawingIds.length > 0){

        questionTypeDrawingIds.each(function(){
            submitQuestionDrawing(this.id);
        })
    }

    if(questionTypeTextIds.length > 0){

        questionTypeTextIds.each(function(){
            submitQuestionText(this.id);
        })
    }
}

function getQuestionNumber(questionType) {
    // get the id last questionType present in questionContainer
    let questionNumber = $("[id^='" + questionType + "']")
        .last()
        .attr("id");

    if (typeof questionNumber === "undefined") {
        questionNumber = 1;
    } else {
        // number in id of last question type incremented by 1
        questionNumber = questionNumber.split(questionType).pop();
        questionNumber++;
    }

    return questionNumber;
}