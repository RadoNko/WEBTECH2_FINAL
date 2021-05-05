function addDrawingQuestion(){

    let questionType = "questionTypeDrawing";

    let questions = document.getElementById("questionContainer");

    let questionTypeNumber = getQuestionNumber(questionType);

    // add new question to question container
    questions.insertAdjacentHTML('beforeend', `<form id='` + questionType + questionTypeNumber +`' >
                                    <div class="form-group">
                                        <hr>
                                        <h3>Drawing Question</h3>
                                        <label for="questionText">Question</label>
                                        <textarea id="questionText" name="questionText" placeholder="Your question"></textarea>

                                        <label>Points</label>
                                        <input type="number" name="questionPoints" min="1" step="1">
                                    
                                        <button type="button" class="btn btn-danger" value='` + questionType + questionTypeNumber +`' onclick='deleteQuestion(this.value)'>Delete</button>

                                    </div>
                                </form>
                                `);
}