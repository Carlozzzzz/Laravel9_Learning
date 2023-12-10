const QuestionCategories = {
    MULTIPLE_CHOICE: 'multiple_choice',
    TRUE_OR_FALSE: 'true_or_false',
    CHECKLIST: 'checklist',
    ENUMERATION: 'enumeration',
    IDENTIFICATION: 'identification',
};

let questionnaireArr = [], checkListItemArr = [];

$(document).ready(function() {

     // Populate Question Category Dropdown
    Object.keys(QuestionCategories).forEach(key => {
        const value = QuestionCategories[key];
        const option = `<option value="${value}">${key}</option>`;
        $('#quiz-settings-categories').append(option);
    });
    
    $('#create-questionnaire').click(function() {
        let selectedCategory = $('#quiz-settings-categories').val();

        if (!selectedCategory) {
            alert("Please select an category");
            return;
        }

        // display an input here
        const questionnaireHTML = generateQuestionnaireInput(selectedCategory);
        $('#questionnaire-container').append(questionnaireHTML);
        
        contentScrollFocus('.questionnaire-buttons');

        const myForm = document.querySelector('#questionnaire-input');

        console.log(myForm.classList.contains("save"));

        if(true) {
            $('#questionnaire-input').submit(function(e) {
                e.preventDefault();
                let formData = $(this).serializeArray();
                // let formData = new FormData($("#questionnaire-input")[0]);
                $(".invalid-feedback").children("strong").text("");
                $("#questionnaire-input input").removeClass("is-invalid");
    
                let url = "{{ route('questionnaire.store', '$data_datarecordfile->id') }}";
                console.log(formData);
                $.ajax({
                    type:'POST',
                    url: url,
                    headers: {
                        Accept: "application/json"
                    },
                    data: formData,
                    success: (response) => {
                        alert(response.message)
                    },
                    error: (response) => {
                        if(response.status === 422) {
                            let errors = response.responseJSON.errors;

                            Object.keys(errors).forEach(function (key) {
                                console.log(key);

                                // Split the key using dot as separator
                                let parts = key.split('.');
                                let secondPart = parts[1];

                                $("."+key).addClass("is-invalid");

                                if (secondPart) {
                                    $("#" + secondPart + "Input").addClass("is-invalid");
                                    $("#" + secondPart + "Error").children("strong").text(errors[key][0]);
                                } else {
                                    $("#" + key + "Input").addClass("is-invalid");
                                    $("#" + key + "Error").children("strong").text(errors[key][0]);
                                }
                            });
                        } else {
                            // window.location.reload();
                        }

                    }
                });
    
            });
        } else if(form.classlist.contains("update")) {

        }
    });

});

// Process to Database

// Front End functions
function generateQuestionnaireInput(questionCategory, isAllowedNewQuestionnaire = true) {
    // const questionIndex = questionnaireArr.length + 1;
    const questionIndex = questionnaireArr.length;
    
    let questionnaireInputHTML;
    let isEnabled = false;

    if(!isAllowedNewQuestionnaire){
        return '';
    } 

    toggleCreateQuestionnaireCursor(isEnabled);

    questionnaireInputHTML = createInputHTML(questionCategory, questionIndex);

    if(!questionnaireInputHTML) {
        isEnabled = true;
        toggleCreateQuestionnaireCursor(isEnabled);
    }

    return questionnaireInputHTML;
}

function createInputHTML(questionCategory, questionIndex) {

    // Default for all Question category
    let choicesHTML = '';
    let questionCount = questionIndex + 1;

    switch (questionCategory) {
        case QuestionCategories.MULTIPLE_CHOICE:
            choicesHTML = generateChoicesInputHTML(questionCategory, questionIndex, 4);
            break;
        case QuestionCategories.TRUE_OR_FALSE:
            choicesHTML = generateChoicesInputHTML(questionCategory, questionIndex, 1);
            break;
        case QuestionCategories.CHECKLIST:
        case QuestionCategories.ENUMERATION:
            // creating add item button, instead of populating choices
            choicesHTML = `
                    <div class="cursor-pointer w-100 my-3" id="create-checklist-item">
                        <div class="text-white bg-green-1 rounded p-2">
                            <p class="mb-0 text-center fw-bold"><i class="bi bi-plus-lg"></i> Add new item</p>
                        </div>
                    </div>
                `;
            break;
        default:
            // choicesHTML = getDefaultHTML();
            alert("Question Category was not found.");
            break;
    }


    let questionnaireHTML = `
        <form data-category="${questionCategory}" class="questionnaire-input ${questionCategory}-input save position-relative shadow mb-3 p-4" id="questionnaire-input" novalidate>
            <button type="button" class="remove-question position-absolute top-0 end-0 bg-transparent border-0 fw-bold fs-3 sub-text-color mx-3 my-1 p-0" id="remove-question"><i class="bi bi-x"></i></button>

            <input type="hidden" class="form-check-input" name="category" value="${questionCategory}">

            <div class="${questionCategory}">

                <div class="question mb-3">
                    <label for="questionInput" class="form-label">Question --${questionCount}--</label>
                    <input type="text" class="form-control questionInput" id="questionInput" name="question" placeholder="Enter your question here..." required>
                    <div class="invalid-feedback" id="questionError">
                        <strong>Please provide a Question.</strong>
                    </div>
                </div>

                <div class="choices-container">
                    <p class="form-label">Choices :</p>
                    
                    ${choicesHTML}

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary" id="save-questionnaire">Save Question</button>
                        <button type="cancel" class="btn btn-secondary">Cancel</button>
                    </div>
                    
                </div>
                

            </div>
        </form>
    `;

    return questionnaireHTML;
}

function generateChoicesInputHTML(selectedCategory, questionIndex, count = 1) {

    let inputChoiceHTML = '';

    for (let index = 0; index < count; index++) {
        inputChoiceHTML += createChoiceInputHTML(selectedCategory, questionIndex, index);
    }

    return inputChoiceHTML || '';
}

function createChoiceInputHTML(selectedCategory, questionIndex, choiceNumber = null) {
    let choiceInputHTML = '';
    let choiceCount = choiceNumber + 1;
    switch (selectedCategory) {
        case QuestionCategories.MULTIPLE_CHOICE:
            choiceInputHTML = `
                <div class="choice-${choiceNumber} d-flex align-items-center mb-2">
                    <div class="form-check">
                        <input data-id="txtChoice${choiceNumber}" type="radio" class="form-check-input answer_key" id="answer_key${choiceNumber}Radio" name="answer_key" value="txtChoice${choiceNumber}" required>
                    </div>
                    <div class="form-input flex-grow-1 ps-2">
                        <input type="text" class="form-control" id="txtChoice${choiceNumber}Input" name="choice[txtChoice${choiceNumber}]" placeholder="Choice ${choiceCount}..." required>
                        <div class="invalid-feedback" id="txtChoice${choiceNumber}Error">
                            <strong></strong>
                        </div>
                    </div>
                </div>
            `;
            break;

        case QuestionCategories.TRUE_OR_FALSE:
            choiceInputHTML = `
                <div class="choice-1 form-check">
                    <input data-id="txtChoice1" class="form-check-input" type="radio" name="answerKey" id="txtChoice1" value="true" required>
                    <label class="form-check-label" for="txtChoice1">True</label>
                </div>
                <div class="choice-2 form-check">
                    <input data-id="txtChoice2" class="form-check-input" type="radio" name="answerKey" id="txtChoice2" value="false" required>
                    <label class="form-check-label" for="txtChoice2">False</label>
                    <div class="invalid-feedback">
                        Please provide a Answer key.
                    </div>
                </div>
            `;
            break;

        case QuestionCategories.CHECKLIST:
        case QuestionCategories.ENUMERATION:
            // proceding with default add new item buttons
            break;
            
        default:
            break;

    }

    return choiceInputHTML;

}

function getChoices(form) {
    const choicesContainer = $(form).find('.choices-container');
    const choices = {};
    choicesContainer.find('.form-check-input').each(function (index) {
        const choiceKey = $(this).attr('data-id');
        const choiceValue = choicesContainer.find(`#txtChoice${index + 1}`).val();
        choices[choiceKey] = choiceValue;
    });
    return choices;
}

function getAnswerKey(form) {
    const answerKeyInput = $(form).find('input[name="answerKey"]:checked');
    return answerKeyInput.attr('data-id');
}


/**
 * Helper  
 */
function toggleCreateQuestionnaireCursor(isEnabled) {
    const createQuestionnaireButton = $('#create-questionnaire');

    if (isEnabled) {
        createQuestionnaireButton.addClass('cursor-pointer');
        createQuestionnaireButton.removeClass('cursor-not-allowed');
    } else {
        createQuestionnaireButton.removeClass('cursor-pointer');
        createQuestionnaireButton.addClass('cursor-not-allowed');
    }
}