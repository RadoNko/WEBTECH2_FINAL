$(document).ready(function(){

    // hide all submit buttons
    $("[id^='submit']").hide();
})

function addQuestionMultiple(questionType){

    let question = document.getElementById("questionContainer");
    question.innerHTML = "";

    // add question form
    question.innerHTML = `<form id='` + questionType + `' >
                            <div class="form-group">
                                <label for="questionText">Question</label>
                                <textarea id="questionText" name="questionText" placeholder="Your question"></textarea>

                                <label for="questionPoints">Points</label>
                                <input type="number" id="questionPoints" name="questionPoints" min="1" step="1">
                            </div>
                            <h4>Answers</h4>
                            <div id="answers" class="form-group">

                                <label>Is this answer correct ?</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="answerRadio1" id="yesRadio" value="1">
                                    <label class="form-check-label" for="yesRadio">Yes</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="answerRadio1" id="noRadio" value="0">
                                    <label class="form-check-label" for="noRadio">No</label>
                                </div>
                                <input type="text" name="answerText1" class="form-control" placeholder="Answer is...">
                                
                            </div>
                           </form>`;

    
    question.innerHTML += `<button type="button" id="addAnswerMultiple" class="btn btn-info" onclick="addAnswerQuestionMultiple()">Add another answer</button>`;

    $("#submitQuestionMultiple").show();

    $(":button").not("#addAnswerMultiple, #submitQuestionMultiple").hide();
}

function addAnswerQuestionMultiple(){

    let answers = document.getElementById("answers");

    // number of answers so far + 1
    let answerNumber = $("#answers > input").length+1;

    // add another answer
    answers.insertAdjacentHTML('beforeend',`<label>Is this answer correct ?</label>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="answerRadio`+answerNumber+`" id="yesRadio" value="1">
                                                <label class="form-check-label" for="yesRadio">Yes</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="answerRadio`+answerNumber+`" id="noRadio" value="0">
                                                <label class="form-check-label" for="noRadio">No</label>
                                            </div>
                                            <input type="text" name="answerText`+answerNumber+`" class="form-control" placeholder="Answer is...">
                               `);
}

function submitQuestionMultiple(){

    let form = $("#QuestionTypeMultiple").serializeArray();

    let data = {};
    data["question"] = form[0].value;
    data["points"] = form[1].value;

    let answers = [];
    let answer = {};

    // 0, 1 are question text and points (don't want those here)
    for(i = 2; i<form.length; i++){

        if(i%2==0){
            
            answer.correct = form[i].value;
        }
        else{
            answer.name = form[i].value;
            answers.push(answer);
            answer = {};
        }
    }

    data["answers"] = answers;

    $.ajax({
        method: "POST",
        url: "https://wt82.fei.stuba.sk/Forward_the_Foundation/router/question/multiple",
        data: data,
        dataType: "text",
        success: function(data){
 
            console.log(data);
        }
    });

    resetArea();
}

function addQuestionConnect(questionType){

    let question = document.getElementById("questionContainer");
    question.innerHTML = "";

    // add question form
    question.innerHTML = `<form id='` + questionType + `' >
                            <div class="form-group">
                                <label for="questionText">Question</label>
                                <textarea id="questionText" name="questionText" placeholder="Your question"></textarea>

                            </div>
                            <h4>Make pairs</h4>
                            <div id="answers" class="form-group">

                                <div class="form-row">
                                    <div class="col">
                                        <label>Question</label>
                                        <input type="text" name="questionTextPair1" class="form-control" placeholder="Question">
                                    </div>
                                    <div class="col">
                                        <label>Answer</label>
                                        <input type="text" name="answerTextPair1" class="form-control" placeholder="Answer">
                                    </div>
                                </div>
                                
                            </div>
                           </form>`;

    question.innerHTML += `<button type="button" id="addAnswerConnect" class="btn btn-info" onclick="addQuestionConnectPair()">Add another pair</button>`;

    $("#submitQuestionConnect").show();

    $(":button").not("#addAnswerConnect, #submitQuestionConnect").hide();
}

function addQuestionConnectPair(){

    let answers = document.getElementById("answers");

    // number of answers so far + 1
    let answerNumber = $("#answers > input").length+1;

    // add another answer
    answers.insertAdjacentHTML('beforeend',`<div class="form-row">
                                                <div class="col">
                                                    <label>Question</label>
                                                    <input type="text" name="questionTextPair`+answerNumber+`" class="form-control" placeholder="Question">
                                                </div>
                                                <div class="col">
                                                    <label>Answer</label>
                                                    <input type="text" name="answerTextPair`+answerNumber+`" class="form-control" placeholder="Answer">
                                                </div>
                                            </div>
                              `);
}

function submitQuestionConnect(){

    let form = $("#QuestionTypeConnect").serializeArray();

    console.log(form);

    let data = {};
    data["question"] = form[0].value;
    //data["points"] = form[1].value;

    let pairs = [];
    let pair = {};

    // 0 is question text (don't want this here)
    for(i = 1; i<form.length; i++){

        if(i%2 !==0){
            
            pair.question = form[i].value;
        }
        else{
            pair.answer = form[i].value;
            pairs.push(pair);
            pair = {};
        }
    }

    data["pairs"] = pairs;

    console.log(data);
    $.ajax({
        method: "POST",
        url: "https://wt82.fei.stuba.sk/Forward_the_Foundation/router/question/connect",
        data: data,
        dataType: "text",
        success: function(data){
          
            console.log(data);
        }
    });

    resetArea();
}

function resetArea(){

    // show all available question buttons
    $("button[id^='add']").show();

    // hide all submit buttons
    $("button[id^='submit']").hide();

    // clear question container
    $("#questionContainer").html("");
}