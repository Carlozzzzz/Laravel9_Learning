
class Question {

    constructor(prevId, nextId, questionObj, quizDetaildId, buttonsURL) {
        this.prevId = prevId;
        this.nextId = nextId;
        this.questionObj = questionObj;
        this.quizDetaildId = quizDetaildId;
        this.buttonsURL = buttonsURL;
    }
    
    createOutputQuestionnaire() {
        let output = '';
        const questionCategory = this.questionObj.category;

        const questionId = this.questionObj.id;
        const question = this.questionObj.question;
        const category = this.questionObj.category;
        const sortOrder = this.questionObj.student_question_sort_order.question_order;

        let answerContent = '';

        if(questionCategory == QuestionCategories.MULTIPLE_CHOICE){
            answerContent = this.createChoicesRadio();
        } else if(questionCategory == QuestionCategories.CHECKLIST){
            answerContent = this.createChoicesChecklist();
        } else {
            console.log("Other category");
        }
        
        output = this.createQuestionInput(questionId, question, answerContent, category, sortOrder);

        return output;
    }

    createQuestionInput(id, question, answerContent, category, sortOrder) {
        const choices = '';

        let outputHTML = `
            <form id="answerForm">
                <input type="hidden" name="category" value="${category}">
                <input type="hidden" name="question_id" value="${id}">
                <div class="border rounded mb-4">
                    <div class="question-container mb-1 bg-green-1 text-light p-3">
                        <p class="mb-0"><span class="fw-bold">Question ${sortOrder}: </span> ${question}?</p>
                    </div>
                    <div class="choices-container p-3">
                        <p>Your answer:</p>

                        ${answerContent}

                    </div>
                </div>
                
            </form>

            ${this.createButtons(this.prevId, this.nextId, this.buttonsURL)}
        `;

        // console.log(outputHTML);

        return outputHTML;
    }

    // Multiple choice and (True or false) category
    createChoicesRadio() {
        const choices = this.questionObj.choices;
        const userAnswer = (this.questionObj.student_quiz_answers ?? {}).choice_id ?? false;

        let choiceHTML = '';

        choiceHTML = choices.map((choice, choiceIndex) => {
            const indexCharacter = indexToAlpha(choiceIndex);
            let isChecked = "";
            if(userAnswer && (userAnswer == choice.id)) {
                isChecked = "checked";
            }
            
            return `
                <label class="form-check-label  border rounded w-100 mb-2 p-2" for="${indexCharacter}">
                    <input class="form-check-input" 
                        type="radio"
                        name="choice_id"
                        id="${indexCharacter}" 
                        value="${choice.id}"
                        ${isChecked}>
                    <span>
                        ${indexCharacter}. ${choice.choice}
                    </span>
                </label>`;
                
        }).join('');

        return choiceHTML;
    }

    // Checklist
    createChoicesChecklist() {
        // todo

        console.log(this.questionObj);
        let checkListHTML = `
            <div class="checklist-key d-flex align-items-center form-check mt-2">
                <input class="form-check-input txtAnswerKey me-2" type="checkbox" name="" value="txtChoice" id="sample">
                <label for="sample" class="border w-100 rounded py-2 ">
                    <div class="mx-2">Test</div>
                </label>
            </div>
        `;

        return checkListHTML;
    }

    // Enumeration
    createAnswerEnumeration() {
        // todo
    }
    

    createButtons(prevId, nextId, buttonsURL) {
        // console.log(buttonsURL);
        let buttonsHTML = '';

        if(prevId) {
            buttonsHTML += `<button type="button" onclick="submitQuestion('${buttonsURL.prevURL}')" class="btn btn-primary me-auto"><< Prev</button>`;
        }

        if(nextId) {
            buttonsHTML += `<button type="button" onclick="submitQuestion('${buttonsURL.nextURL}', false)" class="btn btn-primary ms-auto">Next >></button>`;
        } else {
            buttonsHTML += `<button type="button" onclick="submitQuestion('${buttonsURL.resultsURL}', true)" class="btn btn-primary ms-auto">Finished</button>`;
        }
        
        console.log(prevId, nextId);

        let html = `
                <div class="questionnaire-navigation d-flex justify-content-between">
                    ${buttonsHTML}
                </div>
            `;

        return html;
    }
}