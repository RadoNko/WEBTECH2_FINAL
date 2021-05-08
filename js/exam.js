$(document).ready(function(){

    let examId = 1;

    let origin = $(location).attr('origin');

    $.ajax({
        method: "GET",
        url: origin + "/Final/router/exam/id/" + examId,
        dataType: "json",
        success: function(data){

            $.each(data, function(questionType, questions){
                $.each(questions, function(question, answers){
                    
                    // call render function for question type
                    window["render" + questionType](question, answers);
                });
            });
        }
    });
})


function renderQuestionTypeMultiple(question, answers){
    
    let exam = document.getElementById("examContainer");

    let questionType = "questionTypeMultiple";

    // this is the ID from db; it will be extracted upon test submit
    let questionTypeNumber = answers["id"];

    exam.insertAdjacentHTML('beforeend', `<form class='question' id='` + questionType + questionTypeNumber +`' >
                                    <div class="form-group">
                                        <p><b>` + question + `</b></p>
                                        <span>`+ answers["points"] +`</span>
                                    </div>
                                    <div id="answersMultiple`+ questionTypeNumber +`" class="form-group">
                                        
                                    </div>
                                </form>
                                `);

    let answersContainer = document.getElementById("answersMultiple" + questionTypeNumber);

    $.each(answers["answers"], function(key, answer){

        
        answersContainer.insertAdjacentHTML('beforeend', `<div class="form-check">
                                                                <input type="checkbox" name="answer" value='`+ answer.id +`' class="form-check-input">
                                                                <label class="form-check-label">` + answer.answer + `</label>
                                                             </div>
                                             `)
    })
}

function renderQuestionTypeConnect(question, data){

    let exam = document.getElementById("examContainer");

    let questionType = "questionTypeConnect";

    // this is the ID from db; it will be extracted upon test submit
    let questionTypeNumber = data["id"];

    exam.insertAdjacentHTML('beforeend', `<form class='question' id='` + questionType + questionTypeNumber +`' >
                                            <div class='form-group'>
                                                <p><b>` + question + `</b></p>
                                                <span>`+ data["points"] +`</span>
                                            </div>
                                            <div id='answersConnect`+ questionTypeNumber +`' class='form-group'>
                                                <div class='row'>
                                                    <ul id='connectOptions`+ questionTypeNumber +`' class='col d-flex flex-column list-group'>
                                                        
                                                    </ul>

                                                    <ul id='connectAnswers`+ questionTypeNumber +`' class='col d-flex flex-column'>
                                                    </ul>
                                                </div>
                                            </div>
                                        </form>
                                `);

    let optionsContainer = document.getElementById("connectOptions" + questionTypeNumber);
    let answersContainer = document.getElementById("connectAnswers" + questionTypeNumber);

    $.each(data["options"], function(key, option){

        optionsContainer.insertAdjacentHTML('beforeend', `<li class="list-group-item border text-center">
                                                                ` + option.option + `
                                                            <input type="hidden" name='connectOption' value='`+ option.id +`'>   
                                                          </li>
                                                `)
    });

    $.each(data["answers"], function(key, answer){

        answersContainer.insertAdjacentHTML('beforeend', `<li draggable="true" ondragstart="drag(event)"
                                                            ondrop="drop(event)" ondragover="allowDrop(event)" class="list-group-item border text-center">
                                                                ` + answer.answer + `
                                                                <input type="hidden" name="connectAnswer" value='`+ answer.id +`'>
                                                          </li>
                                            `);
    });

    // randomly rearrange answers (right side); before shuffle they are 1:1 with options (left side) and therefore correctly placed
    $("#connectAnswers" + questionTypeNumber +" li").shuffle(questionTypeNumber);
}

function submitQuestionConnect(id){

    let form = $("#"+id).serializeArray();

    let questionId = id.split("questionTypeConnect").pop();

    let data = {};

    // CHANGE ! these are dummy values for testing
    data["examId"] = 1;
    data["studentId"] = 1;
    data["studentExamId"] = 3;

    data["questionId"] = questionId;

    let pairs = [];
    let pair = {};

    let nOfPairs = form.length/2;
    for(i = 0; i < nOfPairs; i++){
 
        pair.question = form[i].value;
        pair.answer = form[i+nOfPairs].value;

        pairs.push(pair);
        pair = {}; 
    }

    data["pairs"] = pairs;

    let origin = $(location).attr('origin');

    $.ajax({
        method: "POST",
        url: origin + "/Final/router/exam/answer/connect",
        data: data,
        dataType: "text",
        success: function(data){
 
            console.log(data);
        }
    });
}


function submitQuestionMultiple(id){

    let form = $("#"+id).serializeArray();

    let questionId = id.split("questionTypeMultiple").pop();

    let data = {};

    // CHANGE ! these are dummy values for testing
    data["examId"] = 1;
    data["studentId"] = 1;
    data["studentExamId"] = 3;

    data["questionId"] = questionId;

    let answers = [];
    let answer = {};

    
    for(i = 0; i < form.length; i++){
 
        answer.answer = form[i].value;
        answers.push(answer);
        answer = {};
    }

    data["answers"] = answers;

    let origin = $(location).attr('origin');

    $.ajax({
        method: "POST",
        url: origin + "/Final/router/exam/answer/multiple",
        data: data,
        dataType: "text",
        success: function(data){

            console.log(data);
        }
    });
}

/*  checks for question types in test and sends each question to its submit function
    
    !!!!!!:  update table Student_Exam
*/
function submitTest(){

    let questionTypeConnectIds = $("[id^='questionTypeConnect']");
    let questionTypeMultipleIds = $("[id^='questionTypeMultiple']");
    
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



/*
    Drag n Drop

    sauce: https://syntaxxx.com/rearranging-web-page-items-with-html5-drag-and-drop/
*/

var source;

function drag(event) {
    
    source = event.target;
    event.dataTransfer.setData("text/plain", event.target.innerHTML);
}

function allowDrop(event) {

    event.preventDefault();
}

function drop(event) {

    event.preventDefault();
    
    source.innerHTML = event.target.innerHTML;
    event.target.innerHTML = event.dataTransfer.getData("text/plain");
}

/*
    Shuffle answers

    sauce: https://css-tricks.com/snippets/jquery/shuffle-dom-elements/
    
    modifications by me
*/

(function($){
 
    $.fn.shuffle = function(questionTypeNumber) {
 
        var allElems = this.get(),
            getRandom = function(max) {
                return Math.floor(Math.random() * max);
            },
            shuffled = $.map(allElems, function(){
                var random = getRandom(allElems.length),
                    randEl = $(allElems[random]).clone(true)[0];
                allElems.splice(random, 1);
                return randEl;
           });
 
        this.each(function(i){
            $(this).replaceWith($(shuffled[i]));
        });

        $("#connectOptions"+ questionTypeNumber + " li input").each(function(i){

            let opposite = $("#connectAnswers"+questionTypeNumber +" li:nth-child("+(i+1)+") input");

            if(this.value - 1 == opposite[0].value){
                $("#connectAnswers" + questionTypeNumber +" li").shuffle(questionTypeNumber);
            }
        })
 
        return $(shuffled);
 
    };
 
})(jQuery);