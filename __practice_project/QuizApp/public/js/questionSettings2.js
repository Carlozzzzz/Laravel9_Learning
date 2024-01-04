const QuestionCategories = {
    MULTIPLE_CHOICE: 'multiple_choice',
    TRUE_OR_FALSE: 'true_or_false',
    CHECKLIST: 'checklist',
    ENUMERATION: 'enumeration',
    IDENTIFICATION: 'identification',
};


let questionnaireArr = [], checkListItemArr = [];

$(document).ready(function() {

    // Quiz-General
    $('.quiz-nav-item').click(function() {

        let quizNavBtns = $('.quiz-nav-item');
        let quizContent = $('.quiz-content');
        
        const $this = $(this);
        
        toggleActiveContent(quizNavBtns, $this);
        toggleActiveDisplay(quizContent, $this);
    });

    // Startup pupulate data
    Object.keys(QuestionCategories).forEach(key => {
        const value = QuestionCategories[key];
        const option = `<option value="${value}">${key}</option>`;
        $('#quiz-settings-categories').append(option);
    });

    // Events
    $('#create-questionnaire').click(function() {
        let selectedCategory = $('#quiz-settings-categories').val();

        if (!selectedCategory) {
            alert("Please select an category");
            return;
        }

        // display an input here
        const inputHTML = populateInputHTML(selectedCategory);

        $('#questionnaire-container').append(inputHTML);

        const buttonsContainer = document.querySelector('.questionnaire-buttons');
        if (buttonsContainer) {
            buttonsContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }

        const forms = document.querySelectorAll('.needs-validation');
        let ispassvalidation = false;

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
                    saveQuestionnaireHTML(form);
                    if (buttonsContainer) {
                        buttonsContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }
                }
            }, false);
            form.addEventListener('reset', (event) => {
                form.classList.remove('was-validated');
            }, false);
        });

        
    });

    $('#quiz-settings-categories').on("change", function() {
        const selectedCategory = $(this).val();
        const hasQuestionnareInput = $('#questionnaire-container').find('#questionnaire-input').length > 0 ? true : false;

        let inputHTML;

        if(hasQuestionnareInput) {
            console.log("Input html found");
            $('#questionnaire-input').remove();
            inputHTML = populateInputHTML(selectedCategory);
            $('#questionnaire-container').append(inputHTML);

        } else {
            console.log("Not found");
        }

    });


    // Child Events
    $('#questionnaire-container').on('click', '.remove-question', function() {
        console.log($(this));

        toggleCreateQuestionnaireCursor(true);

        if(this.parentNode.classList.contains('questionnaire')) {
            console.log("questionnaire found");
            const nodeID = this.parentNode.getAttribute('data-id');
            
            // removing the selected node from the array
            questionnaireArr = questionnaireArr.filter(element => element.id !== parseInt(nodeID));

            // resetting the id on each object
            questionnaireArr = questionnaireArr.map((data, index) => {
                data.id = index + 1;
                return data;

            });

            $('#questionnaire-container .questionnaire').remove();
            $('#question-list p').remove();
            
            // repopulate the list with new set of id
            questionnaireArr.forEach((data) => {
                let mainQuestionnaire = createQuestionOutputHTML(data);
                let bannerQuestionnaire = createBannerQuestionOutputHTML(data);

                $('#questionnaire-container').append(mainQuestionnaire);
                $('#question-list').append(bannerQuestionnaire);
            });

            let questionIndex = questionnaireArr.length + 1;
            $("#questionnaire-input .question label").text("Question --"+questionIndex+"--");

        } else {
            console.log(this.parentNode);
            this.parentNode.remove();
        }
    });

    $('#questionnaire-container').on('click', '#create-checklist-item', function() {

        console.log("Adding Item.");

        let selectedCategory = $('#quiz-settings-categories').val();
        let newChecklistHTML;

        newChecklistHTML = createDynamicChoicesInputHTML(selectedCategory);
        
        // $('#questionnaire-container .choices-container').append(newItemHTML);
        if(this.parentNode.classList.contains("answer-item")) {
            $(this).prev().prepend(newChecklistHTML);
        } else {
            $(this).before(newChecklistHTML);
        }
        
    });
   
    $('#questionnaire-container').on('click', '#questionnaire-input .remove-checklist-item', function() {

        console.log("Removing Item.");

        $(this).parent().parent().remove()

        $('#questionnaire-input .choices-container input:text').each(function(index,data) {
            let checklistItemIndex = index + 1;
            let id = "txtChoice" + checklistItemIndex;
            $(this).attr("placeholder", "Answer " + checklistItemIndex + "...");
            $(this).attr("id", id);
            $(this).attr("name", id);

            $(this).removeClass(function(index, className) {
                return (className.match(/(^|\s)txtChoice\S+/g) || []).join(' ');
            }).addClass(id);

            let questionCategory = $("#questionnaire-input").attr("data-category");

            if(questionCategory == QuestionCategories.CHECKLIST){
                $(this).closest('.answer-item').find('.checklist-key input[name="answerKey"]').attr('data-id', id);
            }
        });

    });
    

    // Input
    function populateInputHTML(questionCategory, isAllowedNewQuestionnaire = true) {
        const questionCount = questionnaireArr.length + 1;
        
        let questionnaireInputHTML;
        let isEnabled = false;

        if(!isAllowedNewQuestionnaire){
            return '';
        } 

        toggleCreateQuestionnaireCursor(isEnabled);

        questionnaireInputHTML = getInputHTML(questionCategory, questionCount);

        if(!questionnaireInputHTML) {
            isEnabled = true;
            toggleCreateQuestionnaireCursor(isEnabled);
        }

        return questionnaireInputHTML;
    }

    function getInputHTML(questionCategory, questionIndex) {
        const questionInputHTML = createQuestionInputHTML(questionIndex);
        const questionCreateButton = createSaveCancelButtons();

        let choicesHTML = '';

        switch (questionCategory) {
            case QuestionCategories.MULTIPLE_CHOICE:
                choicesHTML = populateChoicesInputHTML(questionCategory, 4);
                break;
            case QuestionCategories.TRUE_OR_FALSE:
                choicesHTML = populateChoicesInputHTML(questionCategory, 1);
                break;

            case QuestionCategories.CHECKLIST:
                choicesHTML = populateChoicesInputHTML(questionCategory);
                break;

            case QuestionCategories.ENUMERATION:
                choicesHTML = populateChoicesInputHTML(questionCategory);
                break;

            default:
                choicesHTML = getDefaultHTML();
                break;
        }


        return `
            <form data-category="${questionCategory}" class="questionnaire-input ${questionCategory}-input position-relative shadow mb-3 p-4 needs-validation" id="questionnaire-input" novalidate>
                <button type="button" class="remove-question position-absolute top-0 end-0 bg-transparent border-0 fw-bold fs-3 sub-text-color mx-3 my-1 p-0" id="remove-question"><i class="bi bi-x"></i></button>
                <div class="${questionCategory}">

                    ${questionInputHTML}

                    <div class="choices-container">
                        <p class="form-label">Choices :</p>
                        
                        ${choicesHTML}
                        ${questionCreateButton}
                        
                    </div>
                    

                </div>
            </form>
        `;
    }

    function populateChoicesInputHTML(selectedCategory, count = 1) {

        let inputChoiceHTML = '';

        for (let index = 1; index <= count; index++) {
            inputChoiceHTML += createChoiceInputHTML(selectedCategory, index);
        }

        return inputChoiceHTML || '';
    }

    function createChoiceInputHTML(selectedCategory, choiceNumber = null) {
        let choiceInputHTML = '';

        switch (selectedCategory) {
            case QuestionCategories.MULTIPLE_CHOICE:
                choiceInputHTML = `
                    <div class="choice-${choiceNumber} d-flex align-items-center mb-2">
                        <div class="form-check">
                            <input data-id="txtChoice${choiceNumber}" type="radio" class="form-check-input" name="answerKey" required>
                        </div>
                        <div class="form-input flex-grow-1 ps-2">
                            <input type="text" class="form-control" id="txtChoice${choiceNumber}" placeholder="Choice ${choiceNumber}..." required>
                            <div class="invalid-feedback">
                                Please provide a Choice Answer.
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
                choiceInputHTML = `
                    <div class="cursor-pointer w-100 my-3" id="create-checklist-item">
                        <div class="text-white bg-green-2 rounded p-2">
                            <p class="mb-0 text-center fw-bold"><i class="bi bi-plus-lg"></i> Add new item</p>
                        </div>
                    </div>
                `;
                break;
                
            default:
                break;

        }

        return choiceInputHTML;
        
    }

    function createDynamicChoicesInputHTML(questionCategory) {

        let keyContainer = '';
        let itemCount = 0;

        let questionDataCategory = $("#questionnaire-input").data("category");

        if(questionDataCategory == QuestionCategories.CHECKLIST || questionDataCategory == QuestionCategories.ENUMERATION) {
            itemCount = $("#questionnaire-input .choices-container input[type='text']").length + 1;
        }

        switch (questionCategory) {
            case QuestionCategories.CHECKLIST:
                keyContainer = `
                    <div class="checklist-key form-check mt-2">
                        <input data-id ="txtChoice${itemCount}" class="form-check-input txtChoice${itemCount}" type="checkbox" name="answerKey">
                    </div>
                `;
                break;
            case QuestionCategories.ENUMERATION:
            default:
                keyContainer = '';
                break;
        }   

        return `
            <div class="answer-item d-flex mb-2">

                ${keyContainer}

                <div class="form-input flex-grow-1 ps-2">
                    <input type="text" class="form-control" name="txtChoice${itemCount}" id="txtChoice${itemCount}" placeholder="Answer ${itemCount}..." required>
                    <div class="invalid-feedback">
                        Please provide a Answer.
                    </div>
                </div>
                <div class="ms-1">
                    <button type="button" class="remove-checklist-item btn btn-danger"><i class="bi bi-trash"></i></button>
                </div>
            </div>
        `;

    }

    function createQuestionInputHTML(questionIndex) {
        return `
            <div class="question mb-3">
                <label for="category-question" class="form-label">Question --${questionIndex}--</label>
                <input type="text" class="form-control category-question" id="category-question" name="category_question" placeholder="Enter your question here..." required>
                <div class="invalid-feedback">
                    Please provide a Question.
                </div>
            </div>
        `;
    }

    // Save

    function saveQuestionnaireHTML(form){
        let questionObj= {};
        let dataId = questionnaireArr.length + 1;

        if (form.classList.contains(QuestionCategories.MULTIPLE_CHOICE + "-input")) {

            // answerKey = $("#questionnaire-input input[name='answerKey']:radio:checked").attr('data-id');

            // questionObj = {
            //     id          : dataId,
            //     category    : QuestionCategories.MULTIPLE_CHOICE,
            //     question    : $('#category-question').val(),
            //     answerKey   : getAnswerKey(form),
            //     choices     : getChoices(form)
            // };

            questionObj = createCategoryObj(form, QuestionCategories.MULTIPLE_CHOICE);
           
        } else if(form.classList.contains(QuestionCategories.TRUE_OR_FALSE + "-input")) {

            // questionObj = {
            //     id          : dataId,
            //     category    : QuestionCategories.TRUE_OR_FALSE,
            //     question    : $('#category-question').val(),
            //     answerKey   : getAnswerKey(form),
            //     choices     : getChoices(form)
            // };

            questionObj = createCategoryObj(form, QuestionCategories.MULTIPLE_CHOICE);


        } else if(form.classList.contains(QuestionCategories.CHECKLIST + "-input")) {

            let checkListInputs = [];

            $("#questionnaire-input input:text").each(function () {
            
                let isSelected = $(this).closest('.answer-item').find('input[name="answerKey"]').prop('checked')
            
                checkListInputs.push({
                    name: $(this).attr("name"),
                    value: $(this).val(),
                    isSelected: isSelected,
                });
    
                
            });

            let answerKey = checkListInputs.filter((element) => element.isSelected).map((element) => element.name);

            checkListInputs.shift() // removing question to the array

            questionObj = {
                id          : dataId,
                category    : QuestionCategories.CHECKLIST,
                question    : $('#category-question').val(),
                answerKey   : answerKey,
                choices     : checkListInputs
            };

        } else if(form.classList.contains(QuestionCategories.ENUMERATION + "-input")) {

            let checkListInputs = [];
            
            $("#questionnaire-input input:text").each(function () {
            
                let isSelected = $(this).closest('.answer-item').find('input[name="answerKey"]').prop('checked')
            
                checkListInputs.push({
                    name: $(this).attr("name"),
                    value: $(this).val(),
                    isSelected: isSelected,
                });
    
                
            });

            checkListInputs.shift() // removing question to the array

            questionObj = {
                id          : dataId,
                category    : QuestionCategories.ENUMERATION,
                question    : $('#category-question').val(),
                answerKey   : checkListInputs,
            };
        }
       
        questionnaireArr.push(questionObj);

        // GENERIC 
        $('#questionnaire-input').remove();

        let questionHTML = createBannerQuestionOutputHTML(questionObj)

        $('#question-list').append(questionHTML);

        let questionnareOutputHTML = createQuestionOutputHTML(questionObj);

        // append | save the form
        $('#questionnaire-container').append(questionnareOutputHTML);

        toggleCreateQuestionnaireCursor(true);
 
    }

    // Output 
    function createQuestionOutputHTML(questionData) {

        const choicesHTML  = populateChoicesOutputHTML(questionData);
    
        const str = `
            <div data-id="${questionData.id}" class="questionnaire question_${questionData.id} position-relative shadow mb-3 p-4" id="question_${questionData.id}">
                <button type="button" class="remove-question position-absolute top-0 end-0 bg-transparent border-0 fw-bold fs-3 sub-text-color mx-3 my-1 p-0" id="remove-question${questionData.id}"><i class="bi bi-x"></i></button>
    
                <input type="hidden" class="form-check-input" name="questionnaire[${questionData.id}][category]" value="${questionData.category}">
    
                <div class="questionnaire-choices">
                    <div class="mb-3">
                        <label for="category-question_${questionData.id}" class="form-label">Question --${questionData.id}--</label>
                        <input type="text" class="form-control category-question${questionData.id}" id="category-question_${questionData.id}" name="questionnaire[${questionData.id}][question]" placeholder="Enter your question here..." value="${questionData.question}" readonly>
                    </div>
    
                    ${choicesHTML}
    
                </div>
            </div>
        `;
    
        return str;
    }

    function populateChoicesOutputHTML(questionData) {
        let choices = "";
    
        if(!Array.isArray(questionData.answerKey)) {
    
            choices = Object.entries(questionData.choices).map(([choiceKey, choiceValue], choiceIndex) => {
                const isChecked = questionData.answerKey === choiceKey;
        
                return `
                    <div class="choice-1 d-flex align-items-center mb-2">
                        <div class="form-check">
                            <input type="radio" id="radioKey${questionData.id}${choiceIndex}" class="form-check-input" ${isChecked ? 'checked' : ''} disabled>
                        </div>
                        <div class="form-input flex-grow-1 ps-2">
                            <input type="text" class="form-control ${choiceKey}" id="${choiceKey}_${questionData.id}" name="questionnaire[${questionData.id}][choices][${choiceKey}]" placeholder="Choice..." value="${choiceValue}" readonly>
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
                                <input type="checkbox" id="checkKey${questionData.id}${choiceIndex}" class="form-check-input" ${isChecked ? 'checked' : ''} disabled>
                            </div>
                            <div class="form-input flex-grow-1 ps-2">
                                <input type="text" class="form-control ${choiceKey}" id="${choiceKey}_${questionData.id}" name="questionnaire[${questionData.id}][choices][${choiceKey}]" placeholder="Choice..." value="${choiceValue}" readonly>
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
                                <input type="text" class="form-control ${choiceKey}" id="${choiceKey}_${questionData.id}" name="questionnaire[${questionData.id}][choices][${choiceKey}]" placeholder="Choice..." value="${choiceValue}" readonly>
                            </div>
                        </div>`;
                });
            }
        }
    
        let choiceHTML = `
            <div class="choices-container">

                <input type="hidden" class="form-check-input" name="questionnaire[${questionData.id}][answer_key]" value="${questionData.answerKey}">

                <p class="form-label">Choices :</p>
                ${choices.join('')}
            </div>
        `;
        return choiceHTML;
    }
    
    function createBannerQuestionOutputHTML(questionObj) {
        return  `
            <p>Question ${questionObj.id} : <a>${questionObj.question}</a></p>
        `; 
    }


    // Helper
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

    function createSaveCancelButtons() {
        return `
            <div class="text-center">
                <button type="submit" class="btn btn-primary" id="save-questionnaire">Save Question</button>
                <button type="cancel" class="btn btn-secondary">Cancel</button>
            </div>
        `;
    }

    function getDefaultHTML() {
        return `
            <div class="questionnaire-input shadow mb-3 p-4" id="questionnaire-input">
                <p class="fw-bold mb-0">Category not found.</p>
            </div>
        `;
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

    function createCategoryObj(form, category) {
        let questionObj = {};
        let dataId = questionnaireArr.length + 1;
        let question = $('#category-question').val();

        questionObj = {
            id          : dataId,
            category    : category,
            question    :  question,
        };

        switch (category) {
            case QuestionCategories.MULTIPLE_CHOICE:
            case QuestionCategories.TRUE_OR_FALSE:
                questionObj.choices = getChoices(form);
                questionObj.answerKey = getAnswerKey(form);
                break;
            case QuestionCategories.TRUE_OR_FALSE:
                
            default:
                break;
        }

        return questionObj;
    }
    
});