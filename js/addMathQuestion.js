function addMathQuestion(){

    let questionType = "questionTypeMath";

    let questions = document.getElementById("questionContainer");

    let questionTypeNumber = getQuestionNumber(questionType);

    // add new question to question container
    questions.insertAdjacentHTML('beforeend', `<form id='` + questionType + questionTypeNumber +`' >
                                    <div class="form-group">
                                        <h3>Math Question</h3>
                                        <label for="questionText">Question</label>
                                        <span class="math-answer" id="answer-2"></span> <!--span as input for rendering math expressions-->
                                        

                                        <label>Points</label>
                                        <input type="number" name="questionPoints" min="1" step="1">
                                    
                                        <button type="button" class="btn btn-danger" value='` + questionType + questionTypeNumber +`' onclick='deleteQuestion(this.value)'>Delete</button>
                                        <input id="questionText" name="questionText" type="hidden">  <!--have to stay as lastElementCHild due to init-->
                                    </div>
                                </form>
                                `);


    const answerSpans = questions.getElementsByClassName('math-answer')
    let MQ = MathQuill.getInterface(2);
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