// checks for question types in test and sends each question to its submit function
function submitTest() {
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
            console.log("id: "+this.id);
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
            console.log("id: "+this.id);
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
    // console.log("question "+form[0].value);
    // console.log("points "+form[1].value);
    // console.log("answer "+form[2].value);


    // let answers = [];
    let question={
        "question":form[0].value,
        "points":form[1].value,
        "exam":"QuestionTypeMath"
    }
    console.log("data: ", data)
    console.log("question :", question)
    $.ajax({
        method: "POST",
        url: "/Final/router/question/math",
        data: question,
        success: function(data){
            console.log(data)
            resetArea();
        }
    });
}

//fullajtar
function submitQuestionDrawing(id){
    let form = $("#"+id).serializeArray();

    let data = {};
    data["question"] = form[0].value;
    data["points"] = form[1].value;
    // console.log("question "+form[0].value);
    // console.log("points "+form[1].value);
    // console.log("answer "+form[2].value);


    // let answers = [];
    let question={
        "question":form[0].value,
        "points":form[1].value,
        "exam":"QuestionTypeMath"
    }

    $.ajax({
        method: "POST",
        url: "",
        data: question,
        success: function(data){
            resetArea();
        }
    });
}

//kanda
function submitQuestionText(id){

    let form = $("#"+id).serializeArray();

    let data = {};
    data["question"] = form[0].value;
    data["points"] = form[1].value;
    // console.log("question "+form[0].value);
    // console.log("points "+form[1].value);
    // console.log("answer "+form[2].value);


    // let answers = [];
    let question={
        "question":form[0].value,
        "answer":form[2].value,
        "points":form[1].value,
        "exam":"QuestionTypeText"
    }

    $.ajax({
        method: "POST",
        url: "http://147.175.98.72/skuska/WEBTECH2_FINAL/router/question/addNewQuestionText",
        data: question,
        success: function(data){
            console.log("som spat"+data);
            resetArea();
        }
    });
}

//kovacik
function submitQuestionConnect(id) {
    let form = $("#" + id).serializeArray();

    let data = {};
    data["question"] = form[0].value;
    //data["points"] = form[1].value;

    let pairs = [];
    let pair = {};

    // 0 is question text (don't want this here)
    for (i = 1; i < form.length; i++) {
        if (i % 2 !== 0) {
            pair.question = form[i].value;
        } else {
            pair.answer = form[i].value;
            pairs.push(pair);
            pair = {};
        }
    }

    data["pairs"] = pairs;

    let origin = $(location).attr("origin");

    //console.log(data);

    $.ajax({
          method: "POST",
          url: origin + "/Final/router/question/connect",
          data: data,
          dataType: "text",
          success: function(data){

              console.log(data);
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
              console.log(data);
          }
      });
}


function resetArea(){

    // show all available question buttons
    $("button[id^='add']").show();

    // clear question container
    $("#mainQuestionDiv").html("");
}
