@extends('layouts.app-master')

@section('header')
    <x-teacher.quiz-header />
@endsection

@section('content')

<style>
    .questioner-header .quiz-categories {
        width: 250px;
    }

    body {
        margin-right: 300px;
    }

    .sidebar {
        right: 0;
    }

    .banner-toggler {
        display: none;
    }
</style>

<h4>General Details</h4>

<div class="quiz-content generalContent d-none ">
    @php
        $xroute = 'quiz.store';
        if(isset($data_datarecordfile) && $data_datarecordfile != "") {
            $xroute = 'quiz.update';
        }
    @endphp
    <form action=" {{ isset($data_datarecordfile) && $data_datarecordfile != "" ? route('quiz.update', $data_datarecordfile->id) : route('quiz.store') }} " method="POST">
        @php $xmethod = isset($data_datarecordfile) && $data_datarecordfile != "" ? "patch" : "post"; @endphp
        @method($xmethod)
        @csrf
        <div class="quiz-form row bg-white rounded m-1 m-lg-0 p-3">
            <!-- Left Column -->
            <div class="col-md-6">
                <!-- Quiz Title -->
                <div class="mb-3">
                    <label for="quizTitle" class="form-label fw-bold" data-tooltip="Click me for more info">Quiz Title</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="quizTitle" name="title" placeholder="Enter quiz title" value=" {{ old('title', isset($data_datarecordfile->title) ? $data_datarecordfile->title : "") }}">
                    @error('title')
                        <p class="m-2 text-danger fs-6"> {{ $message }}</p>
                    @enderror
                </div>
    
                <!-- Instructions -->
                <div class="mb-3">
                    <label for="instructions" class="form-label fw-bold">Instructions</label>
                    <textarea class="form-control @error('instruction') is-invalid @enderror" id="instructions" rows="3" name="instruction" placeholder="Enter instructions">{{ old('instruction', isset($data_datarecordfile->instruction) ? $data_datarecordfile->instruction : "") }}</textarea>
                    @error('instruction')
                        <p class="m-2 text-danger fs-6"> {{ $message }}</p>
                    @enderror
                </div>
    
                <!-- Pointing System -->
                <div class="mb-3">
                    <label for="points" class="form-label fw-bold">Points per item?</label> <input type="checkbox" class="form-check-input ms-1" id="checkPointsPerItem" name="check_points_per_item" value="1" {{ old('check_points_per_item', isset($data_datarecordfile->title) ? $data_datarecordfile->check_points_per_item : "") ? "checked" : "" }}>
                    <input type="number" class="form-control @error('points') is-invalid @enderror" id="points" name="points" placeholder="Points per question." value="{{ old('points', isset($data_datarecordfile->points) ? $data_datarecordfile->points : "") }}" disabled>
                    @error('points')
                        <p class="m-2 text-danger fs-6"> {{ $message }}</p>
                    @enderror
                </div>
    
                <!-- Attempts -->
                <div class="mb-3">
                    <label for="maxAttempts" class="form-label fw-bold">Maximum Attempts</label>
                    <input type="number" class="form-control @error('attempts') is-invalid @enderror" id="maxAttempts" name="attempts" placeholder="Enter maximum attempts" value="{{ old('attempts', isset($data_datarecordfile->attempts) ? $data_datarecordfile->attempts : "") }}">
                    @error('attempts')
                        <p class="m-2 text-danger fs-6"> {{ $message }}</p>
                    @enderror
                </div>
    
                <!-- Time Limits -->
                <div class="mb-3">
                    <label for="timeLimitHr" class="form-label fw-bold">Overall Time Limit (in minutes)</label>
                    <div class="d-flex align-items-center">
                        <input type="number" class="form-control timer-input text-muted @error('time_limit_hr') is-invalid @enderror" id="timeLimitHr" name="time_limit_hr" placeholder="-hh-" value="{{old('time_limit_hr', isset($data_datarecordfile->time_limit_hr) ? $data_datarecordfile->time_limit_hr : "")}}"><span class="mx-2">:</span> 
                        <input type="number" class="form-control timer-input text-muted @error('time_limit_mm') is-invalid @enderror" id="timeLimitMins" name="time_limit_mm" placeholder="-mm-" value="{{old('time_limit_mm', isset($data_datarecordfile->time_limit_mm) ? $data_datarecordfile->time_limit_mm : "")}}"><span class="mx-2">:</span> 
                        <input type="number" class="form-control timer-input text-muted @error('time_limit_sec') is-invalid @enderror" id="timeLimitSec" name="time_limit_sec" placeholder="-ss-" value="{{old('time_limit_sec', isset($data_datarecordfile->time_limit_sec) ? $data_datarecordfile->time_limit_sec : "")}}">
                    </div>
                    @if($errors->has('time_limit_hr') || $errors->has('time_limit_mm') || $errors->has('time_limit_sec'))
                        <p class="m-2 text-danger fs-6">{{ $errors->first('time_limit_hr') ?: $errors->first('time_limit_mm') ?: $errors->first('time_limit_sec') }}</p>
                    @endif
                </div>
    
              
            </div>
    
            <!-- Right Column -->
            <div class="col-md-6">
                 <!-- Start Date -->
                 <div class="mb-3">
                    <label for="startDate" class="form-label fw-bold">Start Date</label>
                    <input type="datetime-local" class="form-control @error('start_date') is-invalid @enderror" id="startDate" name="start_date" value="{{ old('start_date', isset($data_datarecordfile->start_date) ? $data_datarecordfile->start_date : "") }}">
                    @error('start_date')
                        <p class="m-2 text-danger fs-6"> {{ $message }}</p>
                    @enderror
                </div>
    
                 <!-- End Date -->
                 <div class="mb-3">
                    <label for="endDate" class="form-label fw-bold">End Date</label>
                    <input type="datetime-local" class="form-control @error('end_date') is-invalid @enderror" id="endDate" name="end_date" value="{{ old('end_date', isset($data_datarecordfile->end_date) ? $data_datarecordfile->end_date : "") }}">
                    @error('end_date')
                        <p class="m-2 text-danger fs-6"> {{ $message }}</p>
                    @enderror
                </div>
    
                <!-- Review Options -show if answer is correct asap--> 
                <div class="mb-3">
                    <label for="feedbackTiming" class="form-label fw-bold">Feedback Timing</label>
                    <select class="form-select" id="feedbackTiming" name="feedback_timing">
                        <option value="immediately" {{ old('feedback_timing', isset($data_datarecordfile->feedback_timing) ? $data_datarecordfile->feedback_timing : "") == "immediately" ? "selected" : "" }}>Immediately</option>
                        <option value="afterCompletion" {{ old('feedback_timing', isset($data_datarecordfile->feedback_timing) ? $data_datarecordfile->feedback_timing : "") == "afterCompletion" ? "selected" : "" }}>After Quiz Completion</option>
                    </select>
                    @error('feedback_timing')
                        <p class="m-2 text-danger fs-6"> {{ $message }}</p>
                    @enderror
                </div>
    
                <label for="randomizeQuestionOrder" class="fw-bold">Other Settings</label>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="reviewAnswers" name="allow_answer_review" value="1" {{ old('allow_answer_review', isset($data_datarecordfile->allow_answer_review) ? $data_datarecordfile->allow_answer_review : "") ? "checked" : "" }}>
                    <label class="form-check-label" for="reviewAnswers">Allow Review of Answers</label>
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="resultsView" name="show_result_after_submission" value="1" {{ old('show_result_after_submission', isset($data_datarecordfile->show_result_after_submission) ? $data_datarecordfile->show_result_after_submission : "") ? "checked" : "" }}>
                    <label class="form-check-label" for="resultsView">Show results after submission</label>
                </div>
                <!-- Randomization -->
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="randomizeAnswerChoices" name="randomize_choices" value="1" {{ old('randomize_choices', isset($data_datarecordfile->randomize_choices) ? $data_datarecordfile->randomize_choices : "") ? "checked" : "" }}>
                    <label class="form-check-label" for="randomizeAnswerChoices">Randomize Answer Choices</label>
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="randomizeQuestionOrder" name="randomize_question" value="1" {{ old('randomize_question', isset($data_datarecordfile->randomize_question) ? $data_datarecordfile->randomize_question : "") ? "checked" : "" }}>
                    <label class="form-check-label" for="randomizeQuestionOrder">Randomize Question Order</label>
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="isPublished" name="is_published" value="1" {{ old('is_published', isset($data_datarecordfile->is_published) ? $data_datarecordfile->is_published : "") ? "checked" : "" }}>
                    <label class="form-check-label" for="randomizeQuestionOrder">Automalically published upon creation</label>
                </div>
                
                <!-- Save and Publish Buttons -->
            </div>
            <div class="col-12">
                <div class="mb-3 text-center">
                    <button type="submit" class="btn btn-primary">{{ isset($data_datarecordfile) && $data_datarecordfile != "" ? "Update" : "Save" }}</button>
                    <a href=" {{ route('home') }} " class="btn btn-secondary">Cancel</a>
                </div>
            </div>
        </div>
    </form>

</div>

<div class="quiz-content questionContent active">
    {{-- Quesitioner Component --}}
    {{-- <x-teacher.quiz-question :data="$data_datarecordfile" /> --}}

    <div class="container bg-white p-4">
        <div class="row g-4">
            <div class="col-12 col-lg-8 col-xl-7 mx-auto">
                <div class="questionnaire-container" id="questionnaire-container">
                    {{-- Append new question here --}}
                </div>

                <div class="cursor-pointer shadow-sm w-100 mb-3" id="create-questionnaire">
                    <div class="bg-gray-1 p-3">
                        <p class="mb-0 text-center fw-bold"><i class="bi bi-plus-lg"></i> Create New</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="quiz-content overviewContent d-none">
    overviewContent
</div>
@endsection

@section('custom-script')

{{-- <script src="{{ asset('/js/test.js?2') }}"></script> --}}
{{-- <script src="{{ asset('/js/questionSettings.js') }}"></script> --}}

<script>
    $(document).ready(function() {
        $('.quiz-nav-item').click(function() {

        let quizNavBtns = $('.quiz-nav-item');
        let quizContent = $('.quiz-content');

        const $this = $(this);

        toggleActiveContent(quizNavBtns, $this);
        toggleActiveDisplay(quizContent, $this);
        });
    });
</script>

<script>
    const QuestionCategories = {
        MULTIPLE_CHOICE: 'multiple_choice',
        TRUE_OR_FALSE: 'true_or_false',
        CHECKLIST: 'checklist',
        ENUMERATION: 'enumeration',
        IDENTIFICATION: 'identification'
    };

    const TRUE_OR_FALSE = {
        True : "true",
        False : "false"
    }

    let questionnaireArr = [], checkListItemArr = [];

    $(document).ready(function() {

        populateDropdownCategory();
        
        $('#create-questionnaire').click(function() {
            let selectedCategory = $('#quiz-settings-categories').val();
            $('#questionnaire-default').remove();

            if (!selectedCategory) {
                alert("Please select an category");
                return;
            }

            const questionIndex = questionnaireArr.length;

            // const questionSubmitType = "save";

            // display an input here
            const questionnaireHTML = createInputHTML(selectedCategory, questionIndex);

            if(!questionnaireHTML) {
                let defaultHTML = getDefaultHTML();
                allowCreateNewQuestionnaire(true);
                $('#questionnaire-container').append(defaultHTML);
                return;
            }

            allowCreateNewQuestionnaire(false);

            $('#questionnaire-container').append(questionnaireHTML);
            
            contentScrollFocus('.questionnaire-buttons');

           
        });

        $('#questionnaire-container').on('click', '.remove-questionnaire', function() {
            allowCreateNewQuestionnaire(true);

            if(this.parentNode.parentNode.classList.contains('questionnaire-output')) {
                console.log("questionnaire found");
                const nodeID = this.parentNode.parentNode.getAttribute('data-id');
                
                // removing the selected node from the array
                questionnaireArr = questionnaireArr.filter(element => element.id !== parseInt(nodeID));

                // resetting the id on each object
                questionnaireArr = questionnaireArr.map((data, index) => {
                    data.id = index;
                    return data;

                });

                $('#questionnaire-container .questionnaire-output').remove();
                $('#question-list p').remove();
                
                // repopulate the list with new set of id
                questionnaireArr.forEach((data) => {
                    console.log(data);
                    let questionnaire = createOutputHTML(data);

                    $('#questionnaire-container').append(questionnaire);
                    createBannerQuestionOutputHTML(data);
                });

                let questionIndex = questionnaireArr.length + 1;
                $("#questionnaire-input .question label").text("Question --"+questionIndex+"--");

            } else {
                this.parentNode.parentNode.remove();
            }
        });

        // working
        $('#questionnaire-container').on('click', '.edit-questionnaire', function() {

            const parentDataId = $(this).closest(".questionnaire-output").attr("data-id");

            const currentQuestionObj = questionnaireArr.filter(element => element.id == parentDataId)[0];

            const questionCategory = currentQuestionObj.category;

            const questionIndex = currentQuestionObj.id;

            const questionnaireHTML = createInputHTML(questionCategory, questionIndex);

            if(!questionnaireHTML) {
                allowCreateNewQuestionnaire(true);
                let defaultHTML = getDefaultHTML();
                $('#questionnaire-container').append(defaultHTML);
                return;
            }

            allowCreateNewQuestionnaire(false);

            $(this).closest('.questionnaire-output').remove()
            
            appendInOrder(parentDataId, questionnaireHTML);

            // create inputs for Checklist and enumeration choices
            const myForm = $('#questionnaire-form');

            if(myForm.hasClass(QuestionCategories.CHECKLIST) || myForm.hasClass(QuestionCategories.ENUMERATION)) {
                Object.keys(currentQuestionObj.choices).forEach(key => {
                    let newChecklistHTML;
        
                    newChecklistHTML = createDynamicChoicesInputHTML(questionCategory);
    
                    if(myForm.children('.answer-item').length > 0) {
                        $("#create-checklist-item").prev().prepend(newChecklistHTML);
                    } else {
                        $("#create-checklist-item").before(newChecklistHTML);
                    }
                });
            }

            $('#questionnaire-form').removeClass("save");

            $('#questionnaire-form').addClass("update");

            $("#submit-questionnaire").text("Update Question");

            populateQuestionnaireEditInputData(currentQuestionObj);

        });

        $('#questionnaire-container').on('click', '#cancel-questionnaire', function() {
            const myForm = document.querySelector('#questionnaire-form');

            questionnaireForm = $(this).closest("#questionnaire-form");

            if(myForm.classList.contains("save")) {
                // do nothing, will call quetionnaireForm at the end of ifelse condition
            } else if(myForm.classList.contains("update")) {
                // trying jquery things out
                const parentDataId = myForm.getAttribute("data-id");

                const currentQuestionObj = questionnaireArr.filter(element => element.id == parentDataId)[0];

                const questionnaireOutputHTML = createOutputHTML(currentQuestionObj);

                appendInOrder(parentDataId, questionnaireOutputHTML)

            }

            questionnaireForm.remove();


            allowCreateNewQuestionnaire(true);

        });

        $('#questionnaire-container').on('click', '#submit-questionnaire', function() {

            const myForm = document.querySelector('#questionnaire-form');

            $('#questionnaire-form').submit(function(e) {
                e.preventDefault();
                let formData = $('#questionnaire-form').serializeArray();
                $(".invalid-feedback").children("strong").text("");
                $("#questionnaire-form input").removeClass("is-invalid");

                if(myForm.classList.contains('save')) {

                    let url = "{{ route('questionnaire.store', "$data_datarecordfile->id") }}";
                    $.ajax({
                        type:'POST',
                        url: url,
                        headers: {
                            Accept: "application/json"
                        },
                        data: formData,
                        success: (response) => {
                            const questionObj = processQuestionnaireOutputData(myForm)

                            const questionnaireOutputHTML = createOutputHTML(questionObj);
                            
                            $('#questionnaire-container').append(questionnaireOutputHTML);
                            createBannerQuestionOutputHTML(questionObj);

                            Swal.fire({
                                icon: 'success',
                                title: 'Your work has been saved',
                                text: response.message,
                                allowOutsideClick: false
                            })

                            allowCreateNewQuestionnaire(true);
                        },
                        error: (response) => {
                            if(response.status === 422) {
                                let errors = response.responseJSON.errors;

                                Object.keys(errors).forEach(function (key) {
                                    let parts = key.split('.');
                                    let inputId = parts[1] || key;

                                    $(`.${key}, #${inputId}Input`).addClass("is-invalid");
                                    $(`#${inputId}Error strong`).text(errors[key][0]);
                                });
                            } else {
                                // window.location.reload();
                            }

                        }
                    });

                } else if(myForm.classList.contains("update")) {

                    let url = "{{ route('questionnaire.store', "$data_datarecordfile->id") }}";
                    $.ajax({
                        type:'POST',
                        url: url,
                        headers: {
                            Accept: "application/json"
                        },
                        data: formData,
                        success: (response) => {

                            const questionObj = processQuestionnaireOutputData(myForm)

                            console.log("update:",questionObj);

                            const questionnaireOutputHTML = createOutputHTML(questionObj);

                            const formDataId = questionObj.id;

                            appendInOrder(formDataId, questionnaireOutputHTML)

                            repopulateBannerQuestionOutputHTML();

                            Swal.fire({
                                icon: 'success',
                                title: 'Your work has been saved.',
                                text: response.message,
                                allowOutsideClick: false
                            })

                            allowCreateNewQuestionnaire(true);
                        },
                        error: (response) => {
                            if(response.status === 422) {
                                let errors = response.responseJSON.errors;

                                Object.keys(errors).forEach(function (key) {
                                    let parts = key.split('.');
                                    let inputId = parts[1] || key;

                                    $(`.${key}, #${inputId}Input`).addClass("is-invalid");
                                    $(`#${inputId}Error strong`).text(errors[key][0]);
                                });
                            } else {
                                // window.location.reload();
                            }

                        }
                    });
                }
            });

        });

        $('#questionnaire-container').on('click', '#create-checklist-item', function() {

            console.log("Adding Item.");

            let questionCategory = $('#questionnaire-form').attr('data-category');
            let newChecklistHTML;

            newChecklistHTML = createDynamicChoicesInputHTML(questionCategory);

            // $('#questionnaire-container .choices-container').append(newItemHTML);
            if(this.parentNode.classList.contains("answer-item")) {
                $(this).prev().prepend(newChecklistHTML);
            } else {
                $(this).before(newChecklistHTML);
            }

        });

        $('#questionnaire-container').on('click', '#questionnaire-form .remove-checklist-item', function() {

            console.log("Removing Item.");

            $(this).parent().parent().remove()

            $('#questionnaire-form .choices-container input:text').each(function(index, data) {
                let checklistItemCount = index + 1;
                let id = "txtChoice" + index;
                let inputId = id + "Input";
                $(this).attr("placeholder", "Answer " + checklistItemCount + "...");
                $(this).attr("id", inputId);
                $(this).attr("name", `choice[${id}]`);

                $(this).removeClass(function(index, className) {
                    return (className.match(/(^|\s)txtChoice\S+/g) || []).join(' ');
                }).addClass(id);

                let questionCategory = $("#questionnaire-form").attr("data-category");

                if(questionCategory == QuestionCategories.CHECKLIST){
                    let newAnswerkey = $(this).closest('.answer-item').find('.checklist-key input:checkbox').attr('data-id', id);
                    console.log(newAnswerkey);
                }
            });

        });

    });

    // Process to Database
  
    // Front End functions
    function processQuestionnaireOutputData(form) {
        // filtering formdata
        let questionObj = {};
        let answerKey = '';
        let choices = '';
        let dataId = 0;

        let questionCategory = $("#questionnaireCategory").val();
        let question = $("#questionInput").val();

        if(questionCategory == QuestionCategories.MULTIPLE_CHOICE || questionCategory == QuestionCategories.TRUE_OR_FALSE || questionCategory == QuestionCategories.CHECKLIST) {

            answerKey = getAnswerKey(form);
            choices = getChoices(form);

        } else if(questionCategory == QuestionCategories.ENUMERATION) {

            choices = getAnswerArr(form);

        }

        if(form.classList.contains("save")) {
            dataId = questionnaireArr.length;
        } else if(form.classList.contains("update")) {
            dataId = parseInt($(form).attr("data-id"));

            questionnaireArr = questionnaireArr.filter(element => element.id !== parseInt(dataId));

            console.log("processQuestionnaireOutputData: ", dataId);
        }

        questionObj = {
            id          : dataId,
            category    : questionCategory,
            question    : question,
            answerKey   : answerKey,
            choices     : choices
        };

        questionnaireArr.push(questionObj);

        $('#questionnaire-form').remove();


        return questionObj;
        
    }

    function populateQuestionnaireEditInputData(questionObj){
        let questionCategory = questionObj.category;
        let answerKey = questionObj.answerKey;
        let choices = questionObj.choices;

        $("#questionInput").val(questionObj.question);

        Object.entries(choices).forEach(([key, value]) => {
            $('#' + key + 'Input').val(value);
           
            let isAnswerKey = false;
            let checkbox = '';

            if(questionCategory != QuestionCategories.ENUMERATION) {

                if(questionCategory == QuestionCategories.CHECKLIST) {
                    isAswerKey = answerKey.includes(key);
                    checkbox = $('.choices-container').find(`.checklist-key input[data-id="${key}"]`);
                } else {
                    isAswerKey = (key == answerKey);
                    checkbox = $('.choices-container').find(`input[name="answer_key"][data-id="${key}"]`);
                }
                
                if(isAswerKey) {
                    checkbox.prop("checked", true);
                }
            }
        });
    }

    function createInputHTML(questionCategory, questionIndex) {

        // Default for all Question category
        let choicesHTML = '';
        let questionCount = questionIndex + 1;
        let isCategoryFound = true;
        let editDeleteQuestionnaireBtnsHTML = editDeleteQuestionnaireButtons("input");

        // let submitQuestionnaireBtnsHTML = submitQuestionnaireButtons(questionSubmitType);

        switch (questionCategory) {
            case QuestionCategories.MULTIPLE_CHOICE:
                choicesHTML = generateChoiceInputHTML(questionCategory, questionIndex, 4);
                break;
            case QuestionCategories.TRUE_OR_FALSE:
                choicesHTML = generateChoiceInputHTML(questionCategory, questionIndex, 1);
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
                isCategoryFound = false;
                break;
        }


        let questionnaireHTML = `
            <form data-category="${questionCategory}" data-id="${questionIndex}" class="questionnaire-form ${questionCategory} save position-relative shadow mb-3 p-4" id="questionnaire-form" novalidate>
              
                ${editDeleteQuestionnaireBtnsHTML}

                <input type="hidden" class="form-check-input" name="category" id="questionnaireCategory" value="${questionCategory}">

                <div class="${questionCategory}">

                    <div class="question-container mb-3">
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
                            <button type="submit" class="btn btn-primary" id="submit-questionnaire">Save Question</button>
                            <button type="button" class="btn btn-secondary" id="cancel-questionnaire">Cancel</button>
                        </div>
                        
                    </div>
                    

                </div>
            </form>
        `;

        return isCategoryFound ? questionnaireHTML : null;
    }

    function createOutputHTML(questionObj) {
        let questionCount = questionObj.id + 1;
        let question = questionObj.question;
        let questionCategory = questionObj.category;
        let answerKey = questionObj.answerKey;
        let choices = Object.entries(questionObj.choices);
        let editDeleteQuestionnaireBtnsHTML = editDeleteQuestionnaireButtons("output");

        let choiceHTML = '';

        if(questionCategory == QuestionCategories.MULTIPLE_CHOICE || questionCategory == QuestionCategories.TRUE_OR_FALSE) {
            choiceHTML = choices.map(([choiceKey, choiceValue], choiceIndex) => {
                const isChecked = (answerKey === choiceKey);
                
                return `
                    <div class="choice-${choiceIndex} d-flex align-items-center mb-2">
                        <div class="form-check">
                            <input type="radio" id="radioKey${questionObj.id}${choiceIndex}" class="form-check-input" ${isChecked ? 'checked' : ''} disabled>
                        </div>
                        <div class="form-input flex-grow-1 ps-2">
                            <input type="text" class="form-control ${choiceKey}" id="${choiceKey}_${questionObj.id}" name="questionnaire[${questionObj.id}][choices][${choiceKey}]" value="${choiceValue}" readonly>
                        </div>
                    </div>`;
            }).join('');
        } else if(questionCategory == QuestionCategories.CHECKLIST || questionCategory == QuestionCategories.ENUMERATION) {
            choiceHTML = choices.map(([choiceKey, choiceValue], choiceIndex) => {
                const itemCount = choiceIndex + 1;
                let checkListKeyInput = '';

                if(questionCategory == QuestionCategories.CHECKLIST) {
                    const isChecked = answerKey.includes(choiceKey);
                    checkListKeyInput = `
                        <div class="checklist-key form-check mt-2">
                            <input data-id ="txtChoice${questionObj.id}_${choiceIndex}" class="form-check-input txtChoice${questionObj.id}${itemCount}" type="checkbox" ${isChecked ? 'checked' : ''} disabled>
                        </div>`;
                }

                return `
                    <div class="answer-item d-flex mb-2">
    
                        ${checkListKeyInput}
                        
                        <div class="form-input flex-grow-1 ps-2">
                            <input type="text" class="form-control" name="txtChoice${choiceIndex}" id="txtChoice${questionObj.id}_${choiceIndex}" value="${choiceValue}" readonly>
                            <div class="invalid-feedback">
                                Please provide a Answer.
                            </div>
                        </div>
                    </div>
                `;
            }).join('');
        }

        let outputHTML = `
            <form data-id="${questionObj.id}" class="questionnaire-output ${questionCategory} update position-relative shadow mb-3 p-4" id="questionnaire-output">

                ${editDeleteQuestionnaireBtnsHTML}

                <div class="question-container mb-3">
                    <label for="categoryQuestion${questionObj.id}" class="form-label">Question --${questionCount}--</label>
                    <input type="text" class="form-control" id="categoryQuestion${questionObj.id}" name="question" placeholder="Enter your question here..." value="${question}" readonly>
                </div>
                <div class="choices-container">
                    <p class="form-label">Choices: </p>
                    ${choiceHTML}
                </div>
            </form>
        `;
        return outputHTML;
    }

    function createBannerQuestionOutputHTML(questionObj) {
        const question = questionObj.question;
        const questionCount = questionObj.id + 1;
        const bannerQuestionHTML =  `
            <p>Question ${questionCount} : <a>${question}</a></p>
        `; 

        $('#question-list').append(bannerQuestionHTML);
    }

    function repopulateBannerQuestionOutputHTML() {
        $('#question-list').html('');

        questionnaireArr.sort((a, b) => a.id - b.id);

        questionnaireArr.forEach((data) => {
            createBannerQuestionOutputHTML(data);
        });
    }

    function generateChoiceInputHTML(selectedCategory, questionIndex, count = 1) {

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
                choiceInputHTML = Object.entries(TRUE_OR_FALSE).map(([choiceKey, choiceValue], choiceIndex) => {
                    let capitalizedText = capitalize(choiceValue);

                    return `
                        <div class="choice-${choiceIndex} form-check">
                            <input data-id="txtChoice${choiceIndex}" type="radio" class="form-check-input answer_key" id="txtChoice${choiceIndex}Input" name="answer_key" value="${choiceValue}" required>
                            <label class="form-check-label" for="txtChoice${choiceIndex}Input">${capitalizedText}</label>
                            <div class="invalid-feedback">
                                Please provide a Answer key.
                            </div>
                        </div>`;
                }).join('');

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

    function createDynamicChoicesInputHTML(questionCategory) {

        let keyContainer = '';

        const inputIndex = $("#questionnaire-form .choices-container input:text").length;

        const itemCount = inputIndex + 1;

        if(questionCategory == QuestionCategories.CHECKLIST) {
            keyContainer = `
                <div class="checklist-key form-check mt-2">
                    <input data-id="txtChoice${inputIndex}" class="form-check-input txtAnswerKey${inputIndex}" type="checkbox" name="answer_key[txtAnswerKey${inputIndex}]"" value="txtChoice${inputIndex}">
                </div>
            `;
        }

        return `
            <div class="answer-item d-flex mb-2">

                ${keyContainer}

                <div class="form-input flex-grow-1 ps-2">
                    <input data-id="txtChoice${inputIndex}" type="text" class="form-control" name="choice[txtChoice${inputIndex}]" id="txtChoice${inputIndex}Input" placeholder="Answer ${itemCount}..." required>
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

    function getChoices(form) {
        const choicesContainer = $(form).find('.choices-container');
        const choices = {};

        choicesContainer.find('.form-check-input').each(function (index) {
            const choiceKey = $(this).attr('data-id');
            const choiceValue = choicesContainer.find(`#txtChoice${index}Input`).val();
            choices[choiceKey] = choiceValue;
        });

        return choices;
    }

    function getAnswerKey(form) {
        let answerKeyInput = "";
        if(form.classList.contains(QuestionCategories.MULTIPLE_CHOICE) || form.classList.contains(QuestionCategories.TRUE_OR_FALSE)) {
            answerKeyInput = $(form).find('input[name="answer_key"]:checked').attr('data-id');
        } else if(form.classList.contains(QuestionCategories.CHECKLIST)) {
            let checkListChoices = [];

            $("#questionnaire-form .choices-container input:text").each(function () {
            
                let checkBox = $(this).closest('.answer-item').find('input:checkbox')
            
                checkListChoices.push({
                    dataId: checkBox.attr("data-id"),
                    isSelected: checkBox.prop('checked'),
                });
    
                
            });

            answerKeyInput = checkListChoices.filter((element) => element.isSelected).map((element) => element.dataId);
        }
        return answerKeyInput;
    }

    function getAnswerArr(form) {
        const choicesContainer = $(form).find('.choices-container');
        let enumerationInputs = [];

        if(form.classList.contains(QuestionCategories.ENUMERATION)) {
            
            $("#questionnaire-form .choices-container input:text").each(function (index, data) {
                const answerKey = $(this).attr("data-id");
                const answer = $(this).val();

                enumerationInputs[answerKey] = answer;
            });
        }

        return enumerationInputs;
    }


    /**
     * Helper  
     */

    function populateDropdownCategory() {
        Object.keys(QuestionCategories).forEach(key => {
            const value = QuestionCategories[key];
            const option = `<option value="${value}">${key}</option>`;
            $('#quiz-settings-categories').append(option);
        });
    }

    function allowCreateNewQuestionnaire(isEnabled = true) {
        const createQuestionnaireButton = $('#create-questionnaire');
    
        if (isEnabled) {
            createQuestionnaireButton.addClass('cursor-pointer');
            createQuestionnaireButton.removeClass('cursor-not-allowed');
        } else {
            createQuestionnaireButton.removeClass('cursor-pointer');
            createQuestionnaireButton.addClass('cursor-not-allowed');
        }
    }

    function getDefaultHTML() {
        return `
            <div class="questionnaire-default shadow mb-3 p-4" id="questionnaire-default">
                <p class="fw-bold mb-0">Category not found.</p>
            </div>
        `;
    }

    function editDeleteQuestionnaireButtons(formType) {
        let buttons = '';

        if(formType == "output") {
            buttons += `<button type="button" class="btn btn-primary edit-questionnaire border-0 fw-bold fs-5 py-1 px-2" id="edit-questionnaire"><i class="bi bi-pencil-fill"></i></button>`;
            buttons += `<button type="button" class="btn btn-danger remove-questionnaire border-0 fw-bold fs-5 ms-1 py-1 px-2" id="remove-questionnaire"><i class="bi bi-trash"></i></button>`;
        }


        return `
            <div class="position-absolute top-0 end-0 d-flex m-2">
                ${buttons}
            </div>`;
    }

    // working-2
    function appendInOrder(formDataId, questionnaireHTML) {
        
        let questionnaireContainer = $('#questionnaire-container');
        let questionnaireForms = questionnaireContainer.find('.questionnaire-output');

        if(questionnaireForms.length > 0) {

            let prevElementDataId = formDataId - 1;
            let prevElement = questionnaireContainer.find(`.questionnaire-output[data-id="${prevElementDataId}"]`);

            if(formDataId == 0) {
                console.log("First Child:", questionnaireHTML);
                $('#questionnaire-container').prepend(questionnaireHTML);
            } else {
                console.log("There is another form-output:", prevElement);
                prevElement.after(questionnaireHTML);
            }


        } else {
            $('#questionnaire-container').append(questionnaireHTML);
        }
    }

    function capitalize(str) {
        return str[0].toUpperCase() + str.slice(1);
    }

</script>

@endsection