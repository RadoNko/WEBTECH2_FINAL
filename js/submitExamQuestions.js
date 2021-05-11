// checks for question types in test and sends each question to its submit function
function submitExamQuestions() {
    let questionTypeConnectIds = $("[id^='questionTypeConnect']"); //kovacik
    let questionTypeMultipleIds = $("[id^='questionTypeMultiple']"); //kovacik
    let questionTypeTextIds = $("[id^='questionTypeText']"); //kanda
    let questionTypeMathIds = $("[id^='questionTypeMath']"); //fullajtar
    let questionTypeDrawingIds = $("[id^='questionTypeDrawing']"); //fullajtar

    if (questionTypeConnectIds.length > 0) { //kovacik
        questionTypeConnectIds.each(function () {
            submitQuestionConnect(this.id);
        });
    }

    if (questionTypeMultipleIds.length > 0) { //kovacik
        questionTypeMultipleIds.each(function () {
            submitQuestionMultiple(this.id);
        });
    }

    if(questionTypeTextIds.length > 0){ //kanda
        questionTypeTextIds.each(function(){
            submitQuestionText(this.id);
        })
    }

    if(questionTypeMathIds.length > 0){ //fullajtar
        questionTypeMathIds.each(function(){
            submitQuestionMath(this.id);
        })
    }

    if(questionTypeDrawingIds.length > 0){ //fullajtar
        questionTypeDrawingIds.each(function(){
            submitQuestionDrawing(this.id);
        })
    }

    resetArea();
}

//fullajtar
function submitQuestionMath(id){
    let form = $("#"+id).serializeArray();

    let data = {};
    data["points"] = form[0].value;
    data["question"] = form[1].value;

    const origin = $(location).attr("origin");

    $.ajax({
        method: "POST",
        url: origin + "/Final/router/question/math",
        data: data,
        dataType: "text",
        success: function(data){
        }
    });
}

//fullajtar
function submitQuestionDrawing(id){
    let form = $("#"+id).serializeArray();

    let data = {};
    data["question"] = form[0].value;
    data["points"] = form[1].value;

    const origin = $(location).attr("origin");

    $.ajax({
        method: "POST",
        url: origin + "/Final/router/question/drawing",
        data: data,
        dataType: "text",
        success: function(data){
        }
    });
}

//kanda
function submitQuestionText(id){

    let form = $("#"+id).serializeArray();

    let data = {};
    data["question"] = form[0].value;
    data["points"] = form[1].value;

    // let answers = [];
    let question={
        "question":form[0].value,
        "answer":form[2].value,
        "points":form[1].value,
        "exam":"QuestionTypeText"
    }
    const origin = $(location).attr("origin");

    $.ajax({
        method: "POST",
        url: origin + "/Final/router/question/addNewQuestionText",
        data: question,
        success: function(data){
            resetArea();
        }
    });
}

//kovacik
function submitQuestionConnect(id) {
    let form = $("#" + id).serializeArray();

    let data = {};
    data["question"] = form[0].value;
    data["points"] = form[1].value;

    let pairs = [];
    let pair = {};

    // 0 is question text (don't want this here)
    for (i = 2; i < form.length; i++) {
        if (i % 2 == 0) {
            pair.question = form[i].value;
        } else {
            pair.answer = form[i].value;
            pairs.push(pair);
            pair = {};
        }
    }

    data["pairs"] = pairs;

    let origin = $(location).attr("origin");

    console.log("data: ", data)
    console.log(form)

    $.ajax({
          method: "POST",
          url: origin + "/Final/router/question/connect",
          data: data,
          dataType: "text",
          success: function(data){
          }
      });
}

//kovacik
function submitQuestionMultiple(id) {
    let form = $("#" + id).serializeArray();

    let data = {};
    data["question"] = form[0].value;
    data["points"] = form[1].value;

    let answers = [];
    let answer = {};

    // 0, 1 are question text and points (don't want those here)
    for (i = 2; i < form.length; i++) {
        if (i % 2 == 0) {
            answer.correct = form[i].value;
        } else {
            answer.name = form[i].value;
            answers.push(answer);
            answer = {};
        }
    }

    data["answers"] = answers;

    let origin = $(location).attr("origin");

    $.ajax({
          method: "POST",
          url: origin + "/Final/router/question/multiple",
          data: data,
          dataType: "text",
          success: function(data){
          }
      });
}


function resetArea(){

    // show all available question buttons
    $("button[id^='add']").show();

    // clear question container
    $("#mainQuestionDiv").html("");
}
