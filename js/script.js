function addQuestionMultiple(questionType){

    let questions = document.getElementById("questionContainer");

    let questionTypeNumber = getQuestionNumber(questionType);

    // add new question to question container
    questions.insertAdjacentHTML('beforeend', `<form id='` + questionType + questionTypeNumber +`' >
                                    <div class="form-group">
                                        <label for="questionText">Question</label>
                                        <textarea id="questionText" name="questionText" placeholder="Your question"></textarea>

                                        <label>Points</label>
                                        <input type="number" name="questionPoints" min="1" step="1">
                                    
                                        <button type="button" class="btn btn-danger" value='` + questionType + questionTypeNumber +`' onclick='deleteQuestion(this.value)'>Delete</button>

                                    </div>
                                    <h4>Answers</h4>
                                    <div id="answersMultiple`+ questionTypeNumber +`" class="form-group">

                                        <label>Is this answer correct ?</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="answer`+ questionTypeNumber +`Radio1" value="1">
                                            <label class="form-check-label">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="answer`+ questionTypeNumber +`Radio1" id="noRadio" value="0">
                                            <label class="form-check-label" for="noRadio">No</label>
                                        </div>
                                        <input type="text" name="answer`+ questionTypeNumber +`Text1" class="form-control" placeholder="Answer is...">
                                        
                                    </div>
                                </form>
                                `);

    // get the newly added question
    let question = document.getElementById(questionType + questionTypeNumber);

    // add button to insert another answer to new question
    question.insertAdjacentHTML('beforeend',`<button type="button" class="addAnswerMultiple btn btn-info" onclick="addAnswerQuestionMultiple(`+ questionTypeNumber +`)">Add another answer</button>`);
}

function addAnswerQuestionMultiple(number){

    let answers = document.getElementById("answersMultiple"+number);

    // number of answers so far + 1
    let answerNumber = $("#answersMultiple" + number + " > input").length+1;

    // add another answer
    answers.insertAdjacentHTML('beforeend',`<label>Is this answer correct ?</label>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="answer`+number+`Radio`+answerNumber+`" value="1">
                                                <label class="form-check-label">Yes</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="answer`+number+`Radio`+answerNumber+`" value="0">
                                                <label class="form-check-label">No</label>
                                            </div>
                                            <input type="text" name="answer`+number+`Text`+answerNumber+`" class="form-control" placeholder="Answer is...">
                               `);
}

function submitQuestionMultiple(id){

    let form = $("#"+id).serializeArray();

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

    /*$.ajax({
        method: "POST",
        url: "https://wt82.fei.stuba.sk/Forward_the_Foundation/router/question/multiple",
        data: data,
        dataType: "text",
        success: function(data){
 
            console.log(data);
        }
    });*/
}

function addQuestionConnect(questionType){

    let questions = document.getElementById("questionContainer");

    let questionTypeNumber = getQuestionNumber(questionType);

    // add new question to question container
    questions.insertAdjacentHTML('beforeend', `<form id='` + questionType + questionTypeNumber +`' >
                                        <div class="form-group">
                                            <label for="questionText">Question</label>
                                            <textarea id="questionText" name="questionText" placeholder="Your question"></textarea>
                                            
                                            <label for="questionPoints">Points</label>
                                            <input type="number" id="questionPoints" name="questionPoints" min="1" step="1">

                                            <button type="button" class="btn btn-danger" value='` + questionType + questionTypeNumber +`' onclick='deleteQuestion(this.value)'>Delete</button>
                                        </div>
                                        <h4>Make pairs</h4>
                                        <div id="answersPairs`+ questionTypeNumber +`" class="form-group">

                                            <div class="form-row">
                                                <div class="col">
                                                    <label>Question</label>
                                                    <input type="text" name="questionTextPair" class="form-control" placeholder="Question">
                                                </div>
                                                <div class="col">
                                                    <label>Answer</label>
                                                    <input type="text" name="answerTextPair" class="form-control" placeholder="Answer">
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </form>
                                `);

    // get the newly added question
    let question = document.getElementById(questionType + questionTypeNumber);

    // add button to insert another answer to new question
    question.insertAdjacentHTML('beforeend', `<button type="button" class="addAnswerConnect btn btn-info" onclick="addQuestionConnectPair(`+ questionTypeNumber +`)">Add another pair</button>`);
}

function addQuestionConnectPair(number){

    let answers = document.getElementById("answersPairs"+number);

    // add another answer
    answers.insertAdjacentHTML('beforeend',`<div class="form-row">
                                                <div class="col">
                                                    <label>Question</label>
                                                    <input type="text" name="questionTextPair" class="form-control" placeholder="Question">
                                                </div>
                                                <div class="col">
                                                    <label>Answer</label>
                                                    <input type="text" name="answerTextPair" class="form-control" placeholder="Answer">
                                                </div>
                                            </div>
                              `);
}

function submitQuestionConnect(id){

    let form = $("#"+id).serializeArray();

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

    /*console.log(data);
    $.ajax({
        method: "POST",
        url: "https://wt82.fei.stuba.sk/Forward_the_Foundation/router/question/connect",
        data: data,
        dataType: "text",
        success: function(data){
          
            console.log(data);
        }
    });*/
}


// checks for question types in test and sends each question to its submit function
function submitTest(){

    let questionTypeConnectIds = $("[id^='QuestionTypeConnect']");
    let questionTypeMultipleIds = $("[id^='QuestionTypeMultiple']");
    
    if(questionTypeConnectIds.length > 0){

        questionTypeConnectIds.each(function(){
            submitQuestionConnect(this.id);
        })
    }

    if(questionTypeMultipleIds.length > 0){

        questionTypeMultipleIds.each(function(){
            submitQuestionMultiple(this.id);
        })
    }

    resetArea();
}

function getQuestionNumber(questionType){

    // get the id last questionType present in questionContainer
    let questionNumber = $("[id^='"+questionType+"']").last().attr("id");

    if(typeof(questionNumber) === "undefined"){
        questionNumber = 1;
    }
    else{

        // number in id of last question type incremented by 1
        questionNumber = questionNumber.split(questionType).pop();
        questionNumber++;
    }

    return questionNumber;
}

function deleteQuestion(id){

    $("#"+id).remove();
}

function resetArea(){

    // show all available question buttons
    $("button[id^='add']").show();

    // clear question container
    $("#questionContainer").html("");
}