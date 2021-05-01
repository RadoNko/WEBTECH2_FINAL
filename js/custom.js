
var questions=[];
var answers=[];
function addQuestionText(){
    var mainDiv=document.getElementById("mainQuestionForm");

    var deleteButton=document.createElement("button");
    deleteButton.textContent="X";
    mainDiv.append(deleteButton);

    var questionInput=document.createElement("input");
    questionInput.value="Zadaj otazku";
    questionInput.id="question_"+questions.length;
    questions.push(questionInput);

    mainDiv.append(questionInput);

    document.getElementById("addTextAnswer").style.display="block";
    document.getElementById("addQuestionText").style.display="none";
}




function addTextAnswer(){
    var mainDiv=document.getElementById("mainQuestionForm");

    var asnwerInput=document.createElement("input");
    asnwerInput.value="Zadaj odpoved";
    asnwerInput.id="answer_"+answers.length;
    answers.push(asnwerInput);

    mainDiv.append(asnwerInput);

    mainDiv.append(document.createElement("br"));

    document.getElementById("addQuestionText").style.display="block";
    document.getElementById("addTextAnswer").style.display="none";
}

function saveTest(){

    var myForm = $('#mainQuestionForm').serialize();
    //ajax post

}

// $.ajax({
//     type: "POST",
//     data: {hole: "cicky"},
//     dataType: "text",
//     url: "http://147.175.98.72/skuska/WEBTECH2_FINAL/router/question/addNew",
//     success(data){
//         console.log(data);
//     }
// });