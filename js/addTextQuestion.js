function addQuestionText(){
    let questionType = "questionTypeText";
    let questions = document.getElementById("questionContainer");
    let questionTypeNumber = getQuestionNumber(questionType);

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