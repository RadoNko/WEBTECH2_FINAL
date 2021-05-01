$(document).ready(function(){

    let examId = 1;

    $.ajax({
        method: "GET",
        url: "https://wt82.fei.stuba.sk/Forward_the_Foundation/router/exam/"+examId,
        dataType: "json",
        success: function(data){
          
            //console.log(data);

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

    console.log(answers.length);
}

function renderQuestionTypeConnect(question, answers){

    console.log(answers.length);

}

/*DRAG n DROP*/

function drag(ev) {
    ev.dataTransfer.setData("text", ev.target.id);
}

function allowDrop(ev) {
    ev.preventDefault();
    ev.dataTransfer.dropEffect = "move"
}

function drop(ev) {
    ev.preventDefault();
    var data = ev.dataTransfer.getData("text");
    ev.target.appendChild(document.getElementById(data));
}