@extends('layouts.app-master')

@section('content')

    <style>
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
    <div class="question-content h-100">
        <div class="container bg-white p-4 min-height-100">
            <div class="row g-4">
                <div class="col col-12">
                    {{-- <a class="btn btn-secondary " href="{{ route('student.quiz.view', $quiz_id) }}">Back</a> --}}
                </div>
                <div class="col-12 col-lg-8 col-xl-6 mx-auto">

                    <div class="questionnaire-container" id="questionnaire-container">
                        {{-- Append Questionnaire here --}}
                    </div>
                </div>
            </div>
        </div>
        
    </div>
@endsection

@section('custom-script')
<script src="{{ asset('/js/Timey.js') }}"></script>

<script>
    const QuestionCategories = {
        MULTIPLE_CHOICE: 'multiple_choice',
        TRUE_OR_FALSE: 'true_or_false',
        CHECKLIST: 'checklist',
        ENUMERATION: 'enumeration',
        IDENTIFICATION: 'identification'
    };

    let questionnaireArr = [];
    
    $(document).ready(function() {
        getQuestionnaire() 

        console.log("{{ $data_quiz->student_quiz_details->hours}}");
        const data_hour = parseInt("{{ isset($data_quiz->student_quiz_details->hours) ? $data_quiz->student_quiz_details->hours : 0 }}");
        const data_mins = parseInt("{{ isset($data_quiz->student_quiz_details->minutes) ? $data_quiz->student_quiz_details->minutes : 0 }}");
        const data_secs = parseInt("{{ isset($data_quiz->student_quiz_details->seconds) ? $data_quiz->student_quiz_details->seconds : 0  }}");

        // let now = new Date().getTime();
        // const timey = new Timey(data_hour, data_mins, data_secs);
        const timey = new Timey(data_hour, data_mins, data_secs);
        let quizDetaildId = "{{ $data_quiz->student_quiz_details->id }}";

        timey.startTimey(function(x) {

            console.log("Ajax tester", x);

            const url = `{{ route('student.quizdetail.updateTimer', ':id') }}`.replace(':id', quizDetaildId);
            $.ajax({
                type: "POST",
                url: url,
                data : x,
                headers: {
                    Accept: "application/json"
                },
                success: (response) => {
                    console.log("Response", response);
                },
                error : (response) => {
                    if(response.status === 422) {
                        console.log(response);
                    } else {
                        console.log("Outside error", response);
                    }
                }
            });
        });


    });

    function getQuestionnaire() {
        console.log("Running getquestionnaire..");


        const questionId = "{{ isset($data_currentquestion) ? optional($data_currentquestion)->id : '' }}";



        if (!questionId) {
            return;
        }

        const url = `{{ route('student.quiz.getQuestionnaire', ':id') }}`.replace(':id', questionId);


        $.ajax({
            type: "POST",
            url: url,
            headers: {
                Accept: "application/json"
            },
            success: (response) => {

                questionnaireArr.push(response.data);

                console.log(questionnaireArr);

                const questionnaire = createOutputHTML(response.data);

                $('#questionnaire-container').append(questionnaire);
            },
            error: (response) => {
                if(response.status === 422) {
                    console.log(response);
                }
            }
        })
    }

    function createOutputHTML(questionObj){
        console.log("Current Question", questionObj.current_questionnaire)

        function prevAfterHTML(questionObj) {
            
            let buttons = '';
            
            if(questionObj.prev_questionnaire !== null && questionObj.prev_questionnaire.id !== null) {
                let prevQuestionnaireUrl = '{{ route("student.quiz.getQuestionnaire", ":id") }}';
                const prevQuestionId = questionObj.prev_questionnaire.id;
                prevQuestionnaireUrl = prevQuestionnaireUrl.replace(':id', questionObj.prev_questionnaire.id);

                buttons += `<a href="${prevQuestionnaireUrl}" class="btn btn-primary me-auto"><< Prev</a>`;
                // buttons += `<button data-id="${prevQuestionId}" class="btn btn-primary me-auto" onclick="prevOrNextQuestionnaire(this)"><< Prev</button>`;
            }
            
            if(questionObj.next_questionnaire !== null && questionObj.next_questionnaire.id !== null) {
                let nextQuestionnaireUrl = '{{ route("student.quiz.getQuestionnaire", ":id") }}';
                const nextQuestionId = questionObj.next_questionnaire.id;
                nextQuestionnaireUrl = nextQuestionnaireUrl.replace(':id', nextQuestionId);

                buttons += `<a href="${nextQuestionnaireUrl}" class="btn btn-primary ms-auto">Next >></a>`;
                // buttons += `<button data-id="${nextQuestionId}" class="btn btn-primary ms-auto" onclick="prevOrNextQuestionnaire(this)">Next >></button>`;
            }

            let html = `
                <div class="questionnaire-navigation d-flex justify-content-between">
                    ${buttons}
                </div>
            `;
            return html;
        }

        const questionCategory = questionObj.current_questionnaire.category;
        const questionIndex = questionnaireArr.length;

        let choiceHTML = '';


        if(questionCategory == QuestionCategories.MULTIPLE_CHOICE || questionCategory == QuestionCategories.TRUE_OR_FALSE) {
            const choices = questionObj.current_questionnaire.choices;
            choiceHTML = choices.map((choice, choiceIndex) => {
                const indexCharacter = indexToAlpha(choiceIndex);
                
                return `
                    <label class="form-check-label  border rounded w-100 mb-2 p-2" for="${questionIndex}${indexCharacter}">
                        <input class="form-check-input" 
                            type="radio"
                            name="answer[]"
                            id="${questionIndex}${indexCharacter}" 
                            value="${choice.id}">
                        <span>
                            ${indexCharacter}. ${choice.choice}
                        </span>
                    </label>`;
                    
            }).join('');
        }

        console.log("questionObj.currentOrder", questionObj.question_order);
        
        let outputHTML = `
            <form>
                <input type="hidden" name="category" value="${questionObj.current_questionnaire.id}">
                <div class="border rounded mb-4">
                    <div class="question-container mb-1 bg-green-1 text-light p-3">
                        <p class="mb-0"><span class="fw-bold">Question ${questionObj.question_order}: </span> ${questionObj.current_questionnaire.question}?</p>
                    </div>
                    <div class="choices-container p-3">
                        <p>Your answer:</p>

                        ${choiceHTML}
                    </div>
                </div>
                
            </form>

            ${prevAfterHTML(questionObj)}
            
        `;
        return outputHTML;
    }

    const indexToAlpha = (num = 1) => {
        // ASCII value of first character
        const A = 'A'.charCodeAt(0);
        let numberToCharacter = number => {
            return String.fromCharCode(A + number);
        };
        return numberToCharacter(num);
    };
</script>
@endsection