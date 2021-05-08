function addQuestionText(){

    let questionType = "questionTypeText";

    let questions = document.getElementById("questionContainer");

    let questionTypeNumber = getQuestionNumber(questionType);
    console.log(questionType+questionTypeNumber);

    // add new question to question container
    questions.insertAdjacentHTML('beforeend', `<form id='` + questionType + questionTypeNumber +`' >
                                    <div class="form-group">                                        
                                        <h4>Question</h4>
                                        <textarea id="questionText" name="questionText" placeholder="Question is..."></textarea><br>
                                        <h4>Points</h4> 
                                        <input type="number" name="questionPoints" min="1" step="1">
                                        <button type="button" class="btn btn-danger" value='` + questionType + questionTypeNumber +`' onclick='deleteQuestion(this.value)'>Delete</button>

                                    </div>
                                    <h4>Correct answer</h4>
                                    <div id="answersMultiple`+ questionTypeNumber +`" class="form-group">
        
                                        <input type="text" name="answer`+ questionTypeNumber +`Text1" class="form-control" placeholder="Answer is...">
                                        
                                    </div>
                                </form>
                                `);

}




function submitQuestionText(id){

    let form = $("#"+id).serializeArray();

    let data = {};
    data["question"] = form[0].value;
    data["points"] = form[1].value;
    // console.log("question "+form[0].value);
    // console.log("points "+form[1].value);
    // console.log("answer "+form[2].value);


    let question={
        "question":form[0].value,
        "answer":form[2].value,
        "points":form[1].value,
        "exam":"QuestionTypeText"
    }
    const origin = $(location).attr("origin");
    $.ajax({
        method: "POST",
        url: origin+"/Final/router/question/addNewQuestionText",
        data: question,
        success: function(data){
            console.log("som spat"+data);
            resetArea();
        }
    });
}


// checks for question types in test and sends each question to its submit function
function submitTest(){

    let questionTypeTextIds = $("[id^='questionTypeText']");


    if(questionTypeTextIds.length > 0){

        questionTypeTextIds.each(function(){
            console.log("id: "+this.id);
            submitQuestionText(this.id);
        })
    }


    resetArea();
}

function getQuestionNumber(questionType){

    // get the id last questionType present in mainQuestionDiv
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
    $("#mainQuestionDiv").html("");
}