function renderStaticMathFields(){
    let MQ = MathQuill.getInterface(2);
    const mathExpressions = document.getElementsByClassName('math-expression')
    for (const expression of mathExpressions){
        MQ.StaticMath(expression)
    }
}

function initializeMathInputs(){
    let MQ = MathQuill.getInterface(2);
    const answerSpans = document.getElementsByClassName('math-answer')
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
