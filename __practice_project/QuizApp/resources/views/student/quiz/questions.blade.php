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

    const quizDetaildId = "{{ $data_quiz->latest_student_quiz_details->id }}";

    let questionnaireArr = [];
    
    $(document).ready(function() {
        getQuestionnaire() 

        $('#questionnaire-container').on('submit', '#answerForm', function(e) {
            e.preventDefault();
            submitQuestion();
        });

        const data_hour = parseInt("{{ isset($data_quiz->latest_student_quiz_details->hours) ? $data_quiz->latest_student_quiz_details->hours : 0 }}");
        const data_mins = parseInt("{{ isset($data_quiz->latest_student_quiz_details->minutes) ? $data_quiz->latest_student_quiz_details->minutes : 0 }}");
        const data_secs = parseInt("{{ isset($data_quiz->latest_student_quiz_details->seconds) ? $data_quiz->latest_student_quiz_details->seconds : 0  }}");

        // let now = new Date().getTime();
        // const timey = new Timey(data_hour, data_mins, data_secs);
        const timey = new Timey(data_hour, data_mins, data_secs);

        timey.startTimey(function(data) {
            return;
            const url = `{{ route('student.quizdetail.updateTimer', ':id') }}`.replace(':id', quizDetaildId);
            
            $.ajax({
                type: "POST",
                url: url,
                data : data,
                headers: {
                    Accept: "application/json"
                },
                success: (response) => {
                    const quizTimerClass = document.querySelector("#quiz-timer");

                    if(response) {
                        allValueAreZero = true;
                        const keys = Object.keys(data);
                        keys.forEach((key) => {
                            const value = data[key];
                            if(value > 0) {
                                allValueAreZero = false;
                            }
                        });

                        quizTimerClass.innerHTML = data.hours + "h " + data.minutes + "m " + data.seconds + "s ";

                        if(allValueAreZero) {
                            quizTimerClass.innerHTML = "Time's up.";
                        }
                    } else {
                        quizTimerClass.innerHTML = "Something is wrong.";
                    }
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

        const questionId = "{{ isset($data_currentquestion->id) ? $data_currentquestion->id : '' }}";

        if (questionId) {
            const url = `{{ route('student.quiz.getQuestionnaire', ':id') }}`.replace(':id', questionId);
            
            $.ajax({
                type: "POST",
                url: url,
                headers: {
                    Accept: "application/json"
                },
                success: (response) => {

                    questionnaireArr.push(response.data);

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

    }

    // working
    function submitQuestion(redirectPage = "", isFinished = false) {
        
        function ajaxSubmitAnswer() {
            let storeQuizAnswerURL = `{{ route('student.quizAnswer.store', ":id") }}`;
            storeQuizAnswerURL = storeQuizAnswerURL.replace(':id', quizDetaildId);
            let formData = $('#questionnaire-container #answerForm').serialize();
            // formData += '&isFinished=' + isFinished;
            $.ajax({
                type: "POST",
                url: storeQuizAnswerURL,
                header: {
                    Accept: "application/json"
                },
                data: formData,
                success: (response) => {

                    if(isFinished) {
                        let timerInterval;
                        Swal.fire({
                            title: "Please wait",
                            html: "Generating the results ...",
                            timer: 1000,
                            timerProgressBar: true,
                            didOpen: () => {
                                Swal.showLoading();
                                ajaxCreateResult();
                            },
                            willClose: () => {
                                clearInterval(timerInterval);
                            }
                        }).then((result) => {
                            if (result.dismiss === Swal.DismissReason.timer) {
                                window.location.href = redirectPage;
                            }
                        });
                    } else {
                        let timerInterval;
                        Swal.fire({
                            title: "Please wait",
                            html: "Preparing question ...",
                            timer: 500,
                            timerProgressBar: true,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        }).then((result) => {
                            if (result.dismiss === Swal.DismissReason.timer) {
                                window.location.href = redirectPage;
                            }
                        });
                    }
                },
                error: (response) => {
                    if(response.status === 422) {
                        console.log("Error", response);
                    } else {
                        console.log("other error")
                    }
                }
            });
        }

        
        function ajaxCreateResult() {
            let createResultURL = '{{ route("student.quizdetail.createResult", ":id") }}';
            createResultURL = createResultURL.replace(':id', quizDetaildId);
            $.ajax({
                type: "POST",
                url: createResultURL,
                header: {
                    Accept: "application/json"
                },
                success: (response) => {

                    console.log("Result has been generated...");

                    if(isFinished) {
                        Swal.fire({
                            title: "Please wait",
                            html: response.message,
                            timer: 1000,
                            timerProgressBar: true,
                            didOpen: () => {
                                Swal.showLoading();
                                window.location.href = redirectPage;
                            },
                            willClose: () => {
                                clearInterval(timerInterval);
                            }
                        }).then((result) => {
                            if (result.dismiss === Swal.DismissReason.timer) {
                                console.log("I was closed by the timer");
                            }
                        });

                    } else {
                        console.log("Inside quiz questions...");
                    }
                },
                error: (response) => {
                    if(response.status === 422) {
                        console.log("Error", response);
                    } else {
                        console.log("other error")
                    }
                }
            });
        }

        if(isFinished) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You will be redirected to result page.",
                icon: 'warning',
                allowOutsideClick: false,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, submit!',
            }).then((result) => {
                if(result.value) {
                    ajaxSubmitAnswer();
                }
            });
        } else {
            // automatically submit when not finished on answering
            ajaxSubmitAnswer();
        }
    }

    function createOutputHTML(questionObj){

        function prevAfterHTML(questionObj) {
            
            let buttons = '';
            
            if(questionObj.prev_questionnaire && questionObj.prev_questionnaire.id !== null) {
                let prevQuestionnaireUrl = '{{ route("student.quiz.getQuestionnaire", ":id") }}';
                const prevQuestionId = questionObj.prev_questionnaire.id;
                prevQuestionnaireUrl = prevQuestionnaireUrl.replace(':id', questionObj.prev_questionnaire.id);
                

                // buttons += `<a href="${prevQuestionnaireUrl}" class="btn btn-primary me-auto"><< Prev</a>`;
                buttons += `<button type="button" onclick="submitQuestion('${prevQuestionnaireUrl}')" class="btn btn-primary me-auto"><< Prev</button>`;
            }
            
            if(questionObj.next_questionnaire && questionObj.next_questionnaire.id !== null) {
                let nextQuestionnaireUrl = '{{ route("student.quiz.getQuestionnaire", ":id") }}';
                const nextQuestionId = questionObj.next_questionnaire.id;
                nextQuestionnaireUrl = nextQuestionnaireUrl.replace(':id', nextQuestionId);

                // buttons += `<a href="${nextQuestionnaireUrl}" class="btn btn-primary ms-auto">Next >></a>`;
                buttons += `<button type="button" onclick="submitQuestion('${nextQuestionnaireUrl}', false)" class="btn btn-primary  ms-auto">Next >></button>`;
            }

            if(!questionObj.next_questionnaire) {
                let createResultURL = '{{ route("student.quizresult.result", ":id") }}';
                createResultURL = createResultURL.replace(':id', quizDetaildId);
                buttons += `<button type="button" onclick="submitQuestion('${createResultURL}', true)" class="btn btn-primary  ms-auto">Finished</button>`;
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

            const userAnswer = (questionObj.current_questionnaire.student_quiz_answers ?? {}).choice_id ?? false;

            choiceHTML = choices.map((choice, choiceIndex) => {
                const indexCharacter = indexToAlpha(choiceIndex);
                let isChecked = "";
                if(userAnswer && (userAnswer == choice.id)) {
                    isChecked = "checked";
                }
                
                return `
                    <label class="form-check-label  border rounded w-100 mb-2 p-2" for="${questionIndex}${indexCharacter}">
                        <input class="form-check-input" 
                            type="radio"
                            name="choice_id"
                            id="${questionIndex}${indexCharacter}" 
                            value="${choice.id}"
                            ${isChecked}>
                        <span>
                            ${indexCharacter}. ${choice.choice}
                        </span>
                    </label>`;
                    
            }).join('');
        }

        let outputHTML = `
            <form id="answerForm">
                <input type="hidden" name="category" value="${questionObj.current_questionnaire.category}">
                <input type="hidden" name="question_id" value="${questionObj.current_questionnaire.id}">
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