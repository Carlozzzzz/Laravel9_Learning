let questionnare = [];
let isAllowedNewQuestionnare = true;
let questionDataId = 1;
let checkListItemCount = 0;


$(document).ready(function() {

    // Quiz-General
    $('.quiz-nav-item').click(function() {

        let quizNavBtns = $('.quiz-nav-item');
        let quizContent = $('.quiz-content');
        
        const $this = $(this);
        
        toggleActiveContent(quizNavBtns, $this);
        toggleActiveDisplay(quizContent, $this);
    });

    if ($('#checkPointsPerItem').is(":checked")) {
        $('#points').prop("disabled", false);
    } else {
        $('#points').prop("disabled", true);
    }

    $('#checkPointsPerItem').click(function() {
        $('#points').val("");

        if ($('#checkPointsPerItem').is(":checked")) {
            $('#points').prop("disabled", false);
        } else {
            $('#points').prop("disabled", true);
        }
    });

    // Quiz-Question
    
    // Repopulating inputHTML's
    $('#quizSettingsCategory').on("change", function() {
        let questionCategory = $(this).val();
        let hasQuestionnareInput = $('#questionContainer').find('#questionnareInput').length > 0;
    
    
        if (hasQuestionnareInput) {
            $('#questionnareInput').remove();
    
            console.log("Removed existing questionnareInput");
    
            // Add a new questionnareInput only if there was an existing one
            isAllowedNewQuestionnare = true;
            let questionnareInputHTML = populateInputHTML(questionCategory);
            $('#questionContainer').append(questionnareInputHTML);
        }
    
    });
    

    // create a code snippet that will contain display for each catefory
    $('#createQuestionnare').click(function() {

        let questionnareInputHTML;

        let questionCategory = $('#quizSettingsCategory').val();

        questionnareInputHTML = populateInputHTML(questionCategory);

        // appending the questionnare to the questionnare div
        $('#questionContainer').append(questionnareInputHTML);

        const forms = document.querySelectorAll('.needs-validation');
        var ispassvalidation = false;

        Array.prototype.slice.call(forms).forEach((form) => {
            form.addEventListener('submit', (event) => {
                if (!form.checkValidity()) {
                    ispassvalidation = false;
                } else {
                    ispassvalidation = true;
                }

                form.classList.add('was-validated');
                event.preventDefault();
                event.stopPropagation();

                if (ispassvalidation == true) {
                    let questionIndex = questionnare.length;
                    if (form.classList.contains("multiple-choice-input")) {
                        saveMultipleChoice(questionnare, questionIndex);
                    } else if(form.classList.contains("true-or-false-input")) {
                        saveTrueOrFalse(questionnare, questionIndex);
                    } else if(form.classList.contains("checklist-input")) {
                        saveChecklist(questionnare, questionIndex);
                    } else if(form.classList.contains("enumeration-input")) {
                        saveEnumeration(questionnare, questionIndex);
                    }

                    isAllowedNewQuestionnare = true;
                }
            }, false);
            form.addEventListener('reset', (event) => {
                form.classList.remove('was-validated');
            }, false);
        });

    });

    // removing questionnare
    $('#questionContainer').on('click', '.removeQuestion', function() {
        
        // Enabling Create New button
        $('#createQuestionnare').removeClass('cursor-not-allowed'); 
        $('#createQuestionnare').addClass('cursor-pointer');

        isAllowedNewQuestionnare = true;
        checkListItemCount = 0;

        // this.parentNode.remove();
        if(this.parentNode.classList.contains('questionnare')) {

            const nodeID = this.parentNode.getAttribute('data-id');
            let newQuestionList;
            
            // removing the selected node from the array
            questionnare = questionnare.filter(element => element.id !== parseInt(nodeID));
            
            // display to right banner

            newQuestionList = questionnare.map( (data, index) => {
                const questionCount = index + 1;
                const question = data.question;

                let arr = {
                    questionnareContentHTML : outputQuestionnareHTML(data, index),
                    questionHTML : outputBannerQuestionHtml(questionCount, question),
                }

                return arr;
            });
            
            this.parentNode.remove();

            $('#questionContainer').html("");
            $('#questionList').html("");

            newQuestionList.forEach(item => {
                $('#questionContainer').append(item.questionnareContentHTML);
                $('#questionList').append(item.questionHTML);
            });

            questionnare.forEach(element => {
                $('#' + element.answerKey).prop('checked', true);
            });

        } else {
            console.log(this.parentNode);
            this.parentNode.remove();
        }
            
        
    });

    // adding new checklist | enumeration item
    $('#questionContainer').on('click', '#createCheckItem', function() {

        checkListItemCount++;

        let newItemHTML;
        let questionCategory = $('#quizSettingsCategory').val();

        switch (questionCategory) {

            case "checklist":
                newItemHTML = inputChecklistItemHTML(checkListItemCount);
                break;

            case "enumeration":
                newItemHTML = inputEnumerationItemHTML(checkListItemCount);
                break;

            default:
                console.log("nothing happened.");
                break;
        }

        // $('#questionContainer .choices-container').append(newItemHTML);
        if(this.parentNode.classList.contains("answer-item")) {
            $(this).prev().prepend(newItemHTML);
        } else {
            $(this).before(newItemHTML);
        }

    });

    // remove checklist item
    $('#questionContainer').on('click', '.removeChecklistAnswer', function() {

        const choicesContainer = $(this).closest('.choices-container');

        checkListItemCount--;

        $(this).closest('.choices-container').find('.answer-item').remove();

        for (let index = 1; index <= checkListItemCount; index++) {
            let questionCategory = $('#quizSettingsCategory').val();
            let newItemHTML;

            switch (questionCategory) {

                case "checklist":
                    newItemHTML = inputChecklistItemHTML(index);
                    break;

                case "enumeration":
                    newItemHTML = inputEnumerationItemHTML(index);
                    break;

                default:
                    console.log("nothing happened.");
                    break;
            }
            choicesContainer.find('#createCheckItem').before(newItemHTML);
        }

    });

});

// Inputs HTML
function populateInputHTML(questionCategory, isAllowedNewQuestionnare = true) {
    let questionnareInputHTML;

    if (!isAllowedNewQuestionnare) {
        return; // Do nothing if the button is already clicked
    }

    isAllowedNewQuestionnare = false;
    
    $('#createQuestionnare').removeClass('cursor-pointer');
    $('#createQuestionnare').addClass('cursor-not-allowed'); 

    // Checking the value of dropdown category
    const questionCount = questionnare.length + 1;

    switch (questionCategory) {

        case "multiple choice":
            questionnareInputHTML = inputMultipleChoiceHTML(questionCount);
            break;

        case "true or false":
            questionnareInputHTML = inputTrueOrFalseHTML(questionCount);
            break;

        case "checklist":
            questionnareInputHTML = inputCheckListHTML(questionCount);
            break;

        case "enumeration":
            questionnareInputHTML = inputEnumerationHTML(questionCount);
            break;

        default:
            alert("Please select question category.");
            isAllowedNewQuestionnare = true;
            $('#createQuestionnare').addClass('cursor-pointer');
            $('#createQuestionnare').removeClass('cursor-not-allowed');
            break;
    }
    console.log(questionCategory);
    return questionnareInputHTML;
    // $('#questionContainer').append(questionnareInputHTML);

}


function inputMultipleChoiceHTML(questionIndex) {
    return `
            <form class="multiple-choice-input position-relative shadow mb-3 p-4 needs-validation" id="questionnareInput" novalidate>
                <button type="button" class="removeQuestion position-absolute top-0 end-0 bg-transparent border-0 fw-bold fs-3 sub-text-color mx-3 my-1 p-0" id="removeQuestion"><i class="bi bi-x"></i></button>
                <div class="multiple-choice ">
                    <div class="mb-3">
                        <label for="categoryQuestion" class="form-label">Question --${questionIndex}--</label>
                        <input type="text" class="form-control category-question" id="categoryQuestion" name="category_question" placeholder="Enter your question here..." required>
                        <div class="invalid-feedback">
                            Please provide a Question.
                        </div>
                    </div>

                    <div class="choices-container">
                        <label for="txtChoice1" class="form-label">Choices :</label>

                        <div class="choice-1 d-flex align-items-center mb-2">
                            <div class="form-check">
                                <input data-id ="txtChoice1" type="radio" class="form-check-input" name="answerKey" required>
                            </div>
                            <div class="form-input flex-grow-1 ps-2">
                                <input type="text" class="form-control txtChoice1" id="txtChoice1" placeholder="Choice 1..." required>
                                <div class="invalid-feedback">
                                    Please provide a Choice Answer.
                                </div>
                            </div>
                        </div>

                        <div class="choice-2 d-flex align-items-center mb-2">
                            <div class="form-check">
                                <input data-id ="txtChoice2" type="radio" class="form-check-input" name="answerKey" required>
                            </div>
                            <div class="form-input flex-grow-1 ps-2">
                                <input type="text" class="form-control txtChoice2" id="txtChoice2" placeholder="Choice 2..." required>
                                <div class="invalid-feedback">
                                    Please provide a Choice Answer.
                                </div>
                            </div>
                        </div>

                        <div class="choice-3 d-flex align-items-center mb-2">
                            <div class="form-check">
                                <input data-id ="txtChoice3" type="radio" class="form-check-input" name="answerKey" required>
                            </div>
                            <div class="form-input flex-grow-1 ps-2">
                                <input type="text" class="form-control txtChoice3" id="txtChoice3" placeholder="Choice 3..." required>
                                <div class="invalid-feedback">
                                    Please provide a Choice Answer.
                                </div>
                            </div>
                        </div>

                        <div class="choice-4 d-flex align-items-center mb-2">
                            <div class="form-check">
                                <input data-id ="txtChoice3" type="radio" class="form-check-input" name="answerKey" required>
                            </div>
                            <div class="form-input flex-grow-1 ps-2">
                                <input type="text" class="form-control txtChoice4" id="txtChoice4" placeholder="Choice 4..." required>
                                <div class="invalid-feedback">
                                    Please provide a Choice Answer.
                                </div>
                            </div>
                        </div>
                        
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary" id="saveQuestionnare">Save Question</button>
                            <button type="cancel" class="btn btn-secondary">Cancel</button>
                        </div>
                        
                    </div>
                </div>
            </form>
        `;
}

function inputTrueOrFalseHTML(questionIndex) {
    return `
            <form class="true-or-false-input position-relative shadow mb-3 p-4 needs-validation" id="questionnareInput" novalidate>
                <button type="button" class="removeQuestion position-absolute top-0 end-0 bg-transparent border-0 fw-bold fs-3 sub-text-color mx-3 my-1 p-0" id="removeQuestion"><i class="bi bi-x"></i></button>
                <div class="multiple-choice ">
                    <div class="mb-3">
                        <label for="categoryQuestion" class="form-label">Question --${questionIndex}--</label>
                        <input type="text" class="form-control category-question" id="categoryQuestion" name="category_question" placeholder="Enter your question here..." required>
                        <div class="invalid-feedback">
                            Please provide a Question.
                        </div>
                    </div>

                    <div class="choices-container">
                        <label for="txtChoice1" class="form-label">Choices :</label>

                            <div class="choice-1 form-check">
                                <input data-id="txtChoice1" class="form-check-input" type="radio" name="true_or_false" id="txtChoice1" value="true" required>
                                <label class="form-check-label" for="txtChoice1">True</label>
                            </div>
                            <div class="choice-2 form-check">
                                <input data-id="txtChoice2" class="form-check-input" type="radio" name="true_or_false" id="txtChoice2" value="false" required>
                                <label class="form-check-label" for="txtChoice2">False</label>
                                <div class="invalid-feedback">
                                    Please provide a Answer key.
                                </div>
                            </div>
                        
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary" id="saveQuestionnare">Save Question</button>
                        <button type="cancel" class="btn btn-secondary">Cancel</button>
                    </div>
                </div>
            </form>
        `;
}

function inputCheckListHTML(questionIndex) {
        return `
            <form class="checklist-input position-relative shadow mb-3 p-4 needs-validation" id="questionnareInput" novalidate>
                <button type="button" class="removeQuestion position-absolute top-0 end-0 bg-transparent border-0 fw-bold fs-3 sub-text-color mx-3 my-1 p-0" id="removeQuestion"><i class="bi bi-x"></i></button>
                <div class="checklist">
                    <div class="mb-3">
                        <label for="categoryQuestion" class="form-label">Question --${questionIndex}--</label>
                        <input type="text" class="form-control category-question" id="categoryQuestion" name="category_question" placeholder="Enter your question here..." required>
                        <div class="invalid-feedback">
                            Please provide a Question.
                        </div>
                    </div>

                    <div data-id="${questionDataId}" class="choices-container mb-3">
                        <p class="form-label">List of Choices :</p>
                        
                        <div class="cursor-pointer w-100 my-3" id="createCheckItem">
                            <div class="text-white bg-green-1 rounded p-2">
                                <p class="mb-0 text-center fw-bold"><i class="bi bi-plus-lg"></i> Add new item</p>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary" id="saveQuestionnare">Save Question</button>
                        <button type="cancel" class="btn btn-secondary">Cancel</button>
                    </div>
                </div>
            </form>
        `;
}

function inputChecklistItemHTML(count) {
    return `
        <div class="answer-item d-flex mb-2">
            <div class="form-check mt-2">
                <input data-id ="txtChoice${count}" class="form-check-input" type="checkbox" name="answerKey">
            </div>
            <div class="form-input flex-grow-1 ps-2">
                <input type="text" class="form-control txtChoice${count}" name="txtChoice${count}" id="txtChoice${count}" placeholder="Choice ${count}..." required>
                <div class="invalid-feedback">
                    Please provide a Choice Answer.
                </div>
            </div>
            <div class="ms-1">
                <button type="button" class="removeChecklistAnswer btn btn-danger"><i class="bi bi-trash"></i></button>
            </div>
        </div>
    `;
}

function inputEnumerationHTML(questionIndex) {
    return `
            <form class="enumeration-input position-relative shadow mb-3 p-4 needs-validation" id="questionnareInput" novalidate>
                <button type="button" class="removeQuestion position-absolute top-0 end-0 bg-transparent border-0 fw-bold fs-3 sub-text-color mx-3 my-1 p-0" id="removeQuestion"><i class="bi bi-x"></i></button>
                <div class="enumeration">
                    <div class="mb-3">
                        <label for="categoryQuestion" class="form-label">Question --${questionIndex}--</label>
                        <input type="text" class="form-control category-question" id="categoryQuestion" name="category_question" placeholder="Enter your question here..." required>
                        <div class="invalid-feedback">
                            Please provide a Question.
                        </div>
                    </div>

                    <div data-id="${questionDataId}" class="choices-container mb-3">
                        <p class="form-label">List of Answers :</p>
                        
                        <div class="cursor-pointer w-100 my-3" id="createCheckItem">
                            <div class="text-white bg-green-1 rounded p-2">
                                <p class="mb-0 text-center fw-bold"><i class="bi bi-plus-lg"></i> Add new item</p>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary" id="saveQuestionnare">Save Question</button>
                        <button type="cancel" class="btn btn-secondary">Cancel</button>
                    </div>
                </div>
            </form>
        `;
}

function inputEnumerationItemHTML(count) {
    return `
        <div class="answer-item d-flex mb-2">
            <div class="form-input flex-grow-1 ps-2">
                <input type="text" class="form-control txtChoice${count}" name="txtChoice${count}" id="txtChoice${count}" placeholder="Answer ${count}..." required>
                <div class="invalid-feedback">
                    Please provide an Answer.
                </div>
            </div>
            <div class="ms-1">
                <button type="button" class="removeChecklistAnswer btn btn-danger"><i class="bi bi-trash"></i></button>
            </div>
        </div>
    `;
}

// Save inputs process
/**
 * 
 * @param {*} questionArr questionnare = []
 * @param {*} questionIndex questionnare.length, actual questionnare length
 */
function saveMultipleChoice(questionArr, questionIndex) {

    let question = $('#categoryQuestion').val();

    let answerKey = $("#questionnareInput input[name='answerKey']:radio:checked").attr('data-id');

    let txtChoice1  = $('#txtChoice1').val();
    let txtChoice2  = $('#txtChoice2').val();
    let txtChoice3  = $('#txtChoice3').val();
    let txtChoice4  = $('#txtChoice4').val();

    let questionObj = {
        id          : questionDataId,
        question    : question,
        answerKey   : answerKey,
        choices     : {
                        'txtChoice1' : txtChoice1,
                        'txtChoice2' : txtChoice2,
                        'txtChoice3' : txtChoice3,
                        'txtChoice4' : txtChoice4,
                    }
    };

    questionArr.push(questionObj);
    questionDataId++;


    // appending the result to the question-category, removing the questinnare inputs
    $('#questionnareInput').remove();

    let questionHTML = outputBannerQuestionHtml(questionArr.length, question)

    // display to right banner
    $('#questionList').append(questionHTML);

    let htmlOutputMultipleChoiceQuestion = outputQuestionnareHTML(questionObj, questionIndex);

    // append | save the form
    $('#questionContainer').append(htmlOutputMultipleChoiceQuestion);

    $('#createQuestionnare').removeClass('cursor-not-allowed'); 
    $('#createQuestionnare').addClass('cursor-pointer');
}

function saveTrueOrFalse(questionArr, questionIndex) {

    let question = $('#categoryQuestion').val();

    let answerKey = $("#questionnareInput input[name='true_or_false']:radio:checked").attr('data-id');

    let txtChoice1  = $('#txtChoice1').val();
    let txtChoice2  = $('#txtChoice2').val();

    let questionObj = {
        id          : questionDataId,
        question    : question,
        answerKey   : answerKey,
        choices     : {
                        'txtChoice1' : txtChoice1,
                        'txtChoice2' : txtChoice2,
                    }
    };

    questionArr.push(questionObj);
    questionDataId++;

    // appending the result to the question-category, removing the questinnare inputs
    $('#questionnareInput').remove();

    let questionHTML = `
            <p>Question ${questionArr.length} : <a>${question}</a></p>
        `; 

    $('#questionList').append(questionHTML);

    let questionnareOutputHTML = outputQuestionnareHTML(questionObj, questionIndex);

    // append | save the form
    $('#questionContainer').append(questionnareOutputHTML);

    $('#createQuestionnare').removeClass('cursor-not-allowed'); 
    $('#createQuestionnare').addClass('cursor-pointer');
}

function saveChecklist(questionArr, questionIndex) {
    
    let checkListInputs = [];
    let answerKey;

    $("#questionnareInput input:text").each(function () {
        
        let isSelected = $(this).closest('.answer-item').find('input[name="answerKey"]').prop('checked')
    
        checkListInputs.push({
            name: $(this).attr("name"),
            value: $(this).val(),
            isSelected: isSelected,
        });

        
    });

    answerKey = checkListInputs.filter((element) => element.isSelected).map((element) => element.name);
    
    checkListInputs.shift()
    let question = $('#categoryQuestion').val();

    let questionObj = {
        id          : questionDataId,
        answerKey   : answerKey,
        question    : question,
        choices     : checkListInputs
    };

    console.log(questionObj);
    questionArr.push(questionObj);
    questionDataId++;
    checkListItemCount = 0;



    // appending the result to the question-category, removing the questinnare inputs
    $('#questionnareInput').remove();

    let questionHTML = outputBannerQuestionHtml(questionArr.length, question)

    // display to right banner
    $('#questionList').append(questionHTML);

    let questionnareOutputHTML = outputQuestionnareHTML(questionObj, questionIndex);

    // append | save the form
    $('#questionContainer').append(questionnareOutputHTML);

    $('#createQuestionnare').removeClass('cursor-not-allowed'); 
    $('#createQuestionnare').addClass('cursor-pointer');
}

function saveEnumeration(questionArr, questionIndex){
    let checkListInputs = [];

    $("#questionnareInput input:text").each(function () {
        
        let isSelected = $(this).closest('.answer-item').find('input[name="answerKey"]').prop('checked')
    
        checkListInputs.push({
            name: $(this).attr("name"),
            value: $(this).val(),
            isSelected: isSelected,
        });

        
    });

    checkListInputs.shift()

    let question = $('#categoryQuestion').val();

    let questionObj = {
        id          : questionDataId,
        answerKey   : checkListInputs,
        question    : question,
    };

    console.log(questionObj);
    questionArr.push(questionObj);
    questionDataId++;
    checkListItemCount = 0;

    // appending the result to the question-category, removing the questinnare inputs
    $('#questionnareInput').remove();

    let questionHTML = outputBannerQuestionHtml(questionArr.length, question)

    // display to right banner
    $('#questionList').append(questionHTML);

    let questionnareOutputHTML = outputQuestionnareHTML(questionObj, questionIndex);

    // append | save the form
    $('#questionContainer').append(questionnareOutputHTML);

    $('#createQuestionnare').removeClass('cursor-not-allowed'); 
    $('#createQuestionnare').addClass('cursor-pointer');
}

// Output HTML
function outputQuestionnareHTML(questionData, questionIndex) {

    const questionCount = questionIndex + 1;

    const choicesHTML  = outputPopulateChoicesHTML(questionData, questionIndex);

    const str =   `
        <div data-id="${questionData.id}" class="questionnare new-question question_${questionIndex} position-relative shadow mb-3 p-4" id="question_${questionIndex}">
            <button type="button" class="removeQuestion position-absolute top-0 end-0 bg-transparent border-0 fw-bold fs-3 sub-text-color mx-3 my-1 p-0" id="removeQuestion${questionIndex}"><i class="bi bi-x"></i></button>

            <input type="hidden" class="form-check-input" name="questionnare[${questionIndex}][answer_key]" value="${questionData.answerKey}">

            <div class="questionnare-choices">
                <div class="mb-3">
                    <label for="categoryQuestion_${questionIndex}" class="form-label">Question --${questionCount}--</label>
                    <input type="text" class="form-control category-question${questionIndex}" id="categoryQuestion_${questionIndex}" name="questionnare[${questionIndex}][question]" placeholder="Enter your question here..." value="${questionData.question}" readonly>
                </div>

                ${choicesHTML}

            </div>
        </div>
    `;

    return str;
}

function outputPopulateChoicesHTML(questionData, questionIndex) {
    let choices = "";

    if(!Array.isArray(questionData.answerKey)) {

        choices = Object.entries(questionData.choices).map(([choiceKey, choiceValue], choiceIndex) => {
            const isChecked = questionData.answerKey === choiceKey;
    
            return `
                <div class="choice-1 d-flex align-items-center mb-2">
                    <div class="form-check">
                        <input type="radio" id="radioKey${questionIndex}${choiceIndex}" class="form-check-input" ${isChecked ? 'checked' : ''} disabled>
                    </div>
                    <div class="form-input flex-grow-1 ps-2">
                        <input type="text" class="form-control ${choiceKey}" id="${choiceKey}_${questionIndex}" name="questionnare[${questionIndex}][choices][${choiceKey}]" placeholder="Choice..." value="${choiceValue}" readonly>
                    </div>
                </div>`;
        });
    } else {

        if(questionData.choices) {
            choices = questionData.choices.map((element, choiceIndex) => {
                const isChecked = element.isSelected;
                const choiceKey = element.name;
                const choiceValue = element.value;
    
                return `
                    <div class="choice-1 d-flex align-items-center mb-2">
                        <div class="form-check">
                            <input type="checkbox" id="checkKey${questionIndex}${choiceIndex}" class="form-check-input" ${isChecked ? 'checked' : ''} disabled>
                        </div>
                        <div class="form-input flex-grow-1 ps-2">
                            <input type="text" class="form-control ${choiceKey}" id="${choiceKey}_${questionIndex}" name="questionnare[${questionIndex}][choices][${choiceKey}]" placeholder="Choice..." value="${choiceValue}" readonly>
                        </div>
                    </div>`;
            });
        } else {
            choices = questionData.answerKey.map((element) => {
                const choiceKey = element.name;
                const choiceValue = element.value;
    
                return `
                    <div class="choice-1 d-flex align-items-center mb-2">
                        <div class="form-input flex-grow-1 ps-2">
                            <input type="text" class="form-control ${choiceKey}" id="${choiceKey}_${questionIndex}" name="questionnare[${questionIndex}][choices][${choiceKey}]" placeholder="Choice..." value="${choiceValue}" readonly>
                        </div>
                    </div>`;
            });
        }
    }

    let choiceHTML = `
        <div class="choices-container">
            <p class="form-label">Choices :</p>
            ${choices.join('')}
        </div>
    `;
    return choiceHTML;
}

function outputBannerQuestionHtml(questionIndex, question) {
    return  `
        <p>Question ${questionIndex} : <a>${question}</a></p>
    `; 
}


