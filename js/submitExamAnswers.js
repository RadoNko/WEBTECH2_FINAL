$(document).ready(function () {
  let origin = $(location).attr("origin");
  setInterval(getTimeout, 1000);

  // function to check if user should not end his test already
  function getTimeout() {
    $.ajax({
      method: "GET",
      url: origin + "/Final/router/exam/time/left",
      dataType: "text",
      success: function (data) {
        if (data < 0) {
          $("#countdown").text("End now !");
          // finish exam
          submitExamAnswers();
        } else {
          $("#countdown").text(new Date(data * 1000).toISOString().substr(11, 8));
        }
        var date = new Date(null);
        date.setSeconds(data); // specify value for SECONDS here
        var result = date.toISOString().substr(11, 8);
        $("#countdown").text(result);
      },
    });
  }
})

function submitQuestionText(id) {

  let form = $("#" + id).serializeArray();

  let questionId = id.split("questionTypeText").pop();

  let data = {};

  // CHANGE ! these are dummy values for testing
  data["examId"] = 1;
  data["studentId"] = 1;
  data["studentExamId"] = 1;

  data["questionId"] = questionId;

  let answers = [];
  let answer = {};


  for (i = 0; i < form.length; i++) {

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
    success: function (data) {
    }
  });

}

function submitQuestionMath(id) {
  let form = $("#" + id).serializeArray();
  let questionId = id.split("questionTypeMath").pop();
  let data = {};

  data["questionId"] = questionId;
  data["answer"] = form[0].value;

  let origin = $(location).attr('origin');

  $.ajax({
    method: "POST",
    url: origin + "/Final/router/exam/insertAnswersMath",
    data: data,
    dataType: "text",
    success: function (data) {
    }
  });
}

function submitQuestionDrawing(id) {
  const myBoard = boards.get(id)

  //get drawingboard content
  var img = myBoard.getImg();

  //we keep drawingboard content only if it's not the 'blank canvas'
  var imgInput = (myBoard.blankCanvas == img) ? '' : img;

  //put the drawingboard content in the form field to send it to the server
  const thisForm = document.getElementById(id)
  $(thisForm).find('input[name=image]').val(imgInput);
  $(thisForm).find('input[name=imageId]').val(id);

  let questionId = id.split("questionTypeDrawing").pop();
  let data = {};

  data["questionId"] = questionId;
  data["answer"] = id;
  data["img"] = imgInput;

  let origin = $(location).attr('origin');

  $.ajax({
    method: "POST",
    url: origin + "/Final/router/exam/insertAnswersDrawing",
    data: data,
    dataType: "text",
    success: function (data) {
      //after succesful submit, clear picture from web storage
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
    url: origin + "/Final/router/exam/answer/connect",
    data: data,
    dataType: "text",
    success: function (data) {

    }
  });
}

function submitQuestionMultiple(id) {

  let form = $("#" + id).serializeArray();

  let questionId = id.split("questionTypeMultiple").pop();

  let data = {};

  // CHANGE ! these are dummy values for testing
  data["examId"] = 1;
  data["studentId"] = 1;
  data["studentExamId"] = 1;

  data["questionId"] = questionId;

  let answers = [];
  let answer = {};


  for (i = 0; i < form.length; i++) {

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
    success: function (data) {
    }
  });
}

/*  checks for question types in test and sends each question to its submit function
    
    !!!!!!:  update table Student_Exam
*/
function submitExamAnswers() {
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
  if (questionTypeMathIds.length > 0) {

    questionTypeMathIds.each(function () {
      submitQuestionMath(this.id);
    })
  }

  if (questionTypeDrawingIds.length > 0) {

    questionTypeDrawingIds.each(function () {
      submitQuestionDrawing(this.id);
    })
  }

  if (questionTypeTextIds.length > 0) {

    questionTypeTextIds.each(function () {
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

(function ($) {

  $.fn.shuffle = function (questionTypeNumber) {

    var allElems = this.get(),
      getRandom = function (max) {
        return Math.floor(Math.random() * max);
      },
      shuffled = $.map(allElems, function () {
        var random = getRandom(allElems.length),
          randEl = $(allElems[random]).clone(true)[0];
        allElems.splice(random, 1);
        return randEl;
      });

    this.each(function (i) {
      $(this).replaceWith($(shuffled[i]));
    });

    $("#connectOptions" + questionTypeNumber + " li input").each(function (i) {

      let opposite = $("#connectAnswers" + questionTypeNumber + " li:nth-child(" + (i + 1) + ") input");

      if (this.value - 1 == opposite[0].value) {
        $("#connectAnswers" + questionTypeNumber + " li").shuffle(questionTypeNumber);
      }
    })

    return $(shuffled);

  };

})(jQuery);
