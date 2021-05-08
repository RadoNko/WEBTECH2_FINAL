$(document).ready(function () {
  let examId = 1;

  console.log("AHOJoutside");
  let origin = $(location).attr("origin");

  $.ajax({
    method: "GET",
    url: origin + "/Final/router/exam/" + examId,
    dataType: "json",
    success: function (data) {
      console.log("AHOJsuccess: ", data);

      $.each(data, function (questionType, questions) {
        $.each(questions, function (question, answers) {
          // call render function for question type
          window["render" + questionType](question, answers);
        });
      });
    },
  });
});

let boards = new Map()

function renderQuestionTypeDrawing(question, answers){
  const exam = document.getElementById("examContainer");
  const questionType = "questionTypeDrawing";

  // this is the ID from db; it will be extracted upon test submit
  let questionTypeNumber = answers["id"];
  exam.insertAdjacentHTML('beforeend', `<form class='question' id='` + questionType + questionTypeNumber +`'>
                                    <div class="form-group">
                                        <p>` + question + `</p>
                                    </div>
                                    <div id="answersDrawing`+ questionTypeNumber +`" class="form-group">
                                        
                                    </div>
                                </form>
                                `);
  const answersContainer = document.getElementById("answersDrawing" + questionTypeNumber);
  answersContainer.insertAdjacentHTML('beforeend', `<div class="form-check">
                                                                    <div class="w-full h-96" id='drawingDiv`+ questionType + questionTypeNumber +`'></div>
                                                                    <input type="hidden" name='image' value="">
                                                                    <input type="hidden" name="imageId" value="">
                                                                 </div>
            
    
                                             `)

  // //init drawingBoard
  const myBoard = new DrawingBoard.Board('drawingDiv'+ questionType + questionTypeNumber);
  boards.set(''+questionType + questionTypeNumber, myBoard);
  //
  // $('.drawing-form').on('submit', function(e) {
  //   //get drawingboard content
  //   var img = myBoard.getImg();
  //
  //   //we keep drawingboard content only if it's not the 'blank canvas'
  //   var imgInput = (myBoard.blankCanvas == img) ? '' : img;
  //
  //   //put the drawingboard content in the form field to send it to the server
  //   $(this).find('input[name=image]').val(imgInput);
  //   $(this).find('input[name=imageId]').val(questionTypeNumber);
  //
  //   //we can also assume that everything goes well server-side
  //   //and directly clear webstorage here so that the drawing isn't shown again after form submission
  //   //but the best would be to do when the server answers that everything went well
  //   myBoard.clearWebStorage();
  //
  // });
}

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

function renderQuestionTypeMath(question, answers){
  const exam = document.getElementById("examContainer");
  const questionType = "questionTypeMath";

  // this is the ID from db; it will be extracted upon test submit
  let questionTypeNumber = answers["id"];
  exam.insertAdjacentHTML('beforeend', `<form class='question' id='` + questionType + questionTypeNumber +`' >
                                    <div class="form-group">
                                        <p><span class="math-expression">` + question + `</span></p>
                                    </div>
                                    <div id="answersMath`+ questionTypeNumber +`" class="form-group">
                                        
                                    </div>
                                </form>
                                `);
  const answersContainer = document.getElementById("answersMath" + questionTypeNumber);
  answersContainer.insertAdjacentHTML('beforeend', `<div class="form-check">
                                                                    <span class="math-answer" id="answer-2"></span> <!--span as input for rendering math expressions-->
                                                                    <input type="hidden" name="answer" value='' class="form-check-input"> <!--have to be last child of thid div element-->
                                                                 </div>
            
    
                                             `)
  const MQ = MathQuill.getInterface(2);

  //render static math fields //TODO bad preformance due to looping through already rendered fields
  const mathExpressions = document.getElementsByClassName('math-expression')
  for (const expression of mathExpressions){
    MQ.StaticMath(expression)
  }

  //init answer math field
  const answerSpans = answersContainer.getElementsByClassName('math-answer')
  for (const span of answerSpans){
    const answerMathField = MQ.MathField(span,{
      handlers: {
        edit: function() {
          let enteredMath = answerMathField.latex(); // Get entered math in LaTeX format
          const questionInput = span.parentElement.lastElementChild;
          questionInput.value = enteredMath;
        }
      }
    })
  }
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

function renderQuestionTypeText(question, answers){

  let exam = document.getElementById("examContainer");

  let questionType = "questionTypeText";

  let questionTypeNumber = answers["id"];

  exam.insertAdjacentHTML('beforeend', `
                                    <h4>Otázka</h4>    
                                    <form class='question' id='` + questionType + questionTypeNumber +`' >
                                    <div class="form-group">
                                        <p><b>` + question + `</b></p>
                                        <span>max. body `+ answers["points"] +`</span>
                                    </div>
                                    
                                    <div class='answer' id='` + "answerTypeText" + questionTypeNumber +`' >
                                     <input type="text" name="questionAnswer` +questionTypeNumber +`">
                               
                                </form>
                                        <br>
                                `);
}

function submitQuestionText(id){

  let form = $("#"+id).serializeArray();

  let questionId = id.split("questionTypeText").pop();

  let data = {};

  // CHANGE ! these are dummy values for testing
  data["examId"] = 1;
  data["studentId"] = 1;
  data["studentExamId"] = 1;

  data["questionId"] = questionId;

  let answers = [];
  let answer = {};


  for(i = 0; i < form.length; i++){

    answer.answer = form[i].value;
    answers.push(answer);
    answer = {};
  }

  data["answers"] = answers;

  const origin = $(location).attr("origin");


  $.ajax({
    method: "POST",
    url: origin + "/Final/router/exam/insertTextAnswer",
    data: data,
    dataType: "text",
    success: function(data){
      console.log(data);
    }
  });

}

function submitQuestionMath(id){
  let form = $("#"+id).serializeArray();
  let questionId = id.split("questionTypeMath").pop();
  let data = {};

  //TODO CHANGE ! these are dummy values for testing
  data["examId"] = 1;
  data["studentId"] = 1;
  data["studentExamId"] = 1;

  data["questionId"] = questionId;
  data["answer"] = form[0].value;
  console.log("data: ",data)

  let origin = $(location).attr('origin');

  $.ajax({
    method: "POST",
    url: origin + "/Final/router/exam/insertAnswersMath",
    data: data,
    dataType: "text",
    success: function(data){
      console.log(data)
    }
  });
}

function submitQuestionDrawing(id){

  let form = $("#"+id).serializeArray();

  const myBoard = boards.get(id)
  console.log("myBoard: ", myBoard)

    //get drawingboard content
    var img = myBoard.getImg();

    //we keep drawingboard content only if it's not the 'blank canvas'
    var imgInput = (myBoard.blankCanvas == img) ? '' : img;

    //put the drawingboard content in the form field to send it to the server
    const thisForm = document.getElementById(id)
    $(thisForm).find('input[name=image]').val(imgInput);
    $(thisForm).find('input[name=imageId]').val(id);

    //we can also assume that everything goes well server-side
    //and directly clear webstorage here so that the drawing isn't shown again after form submission
    //but the best would be to do when the server answers that everything went well






  let questionId = id.split("questionTypeDrawing").pop();
  let data = {};

  //TODO CHANGE ! these are dummy values for testing
  data["examId"] = 1;
  data["studentId"] = 1;
  data["studentExamId"] = 1;

  data["questionId"] = questionId;
  data["answer"] = id;
  data["img"] = imgInput;
  console.log("data: ",data)

  let origin = $(location).attr('origin');

  $.ajax({
    method: "POST",
    url: origin + "/Final/router/exam/insertAnswersDrawing",
    data: data,
    dataType: "text",
    success: function(data){
      console.log(data)
      myBoard.clearWebStorage();
    }
  });
}

function submitQuestionConnect(id) {
  let form = $("#" + id).serializeArray();

  let questionId = id.split("questionTypeConnect").pop();

  let data = {};

  // CHANGE ! these are dummy values for testing
  data["examId"] = 1;
  data["studentId"] = 1;
  data["studentExamId"] = 1;

  data["questionId"] = questionId;

  let pairs = [];
  let pair = {};

  let nOfPairs = form.length / 2;
  for (i = 0; i < nOfPairs; i++) {
    pair.question = form[i].value;
    pair.answer = form[i + nOfPairs].value;

    pairs.push(pair);
    pair = {};
  }

  data["pairs"] = pairs;

  let origin = $(location).attr("origin");

  $.ajax({
        method: "POST",
        url: origin + "/Final/router/exam/insertAnswersConnect",
        data: data,
        dataType: "text",
        success: function(data){
 
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
  data["studentExamId"] = 1;

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
function submitTest() {
  let questionTypeConnectIds = $("[id^='questionTypeConnect']");
  let questionTypeMultipleIds = $("[id^='questionTypeMultiple']");
  let questionTypeMathIds = $("[id^='questionTypeMath']"); //fullajtar
  let questionTypeDrawingIds = $("[id^='questionTypeDrawing']"); //fullajtar
  let questionTypeTextIds = $("[id^='questionTypeText']");

  if (questionTypeConnectIds.length > 0) {
    questionTypeConnectIds.each(function () {
      submitQuestionConnect(this.id);
    });
  }

  if (questionTypeMultipleIds.length > 0) {
    questionTypeMultipleIds.each(function () {
      submitQuestionMultiple(this.id);
    });
  }

  //fullajtar
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
