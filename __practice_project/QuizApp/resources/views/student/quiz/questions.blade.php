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
<script src="{{ asset('/js/Student/Question.js') }}"></script>

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

        const currentQuestionnaire = questionObj.current_questionnaire;
        const questionCategory = currentQuestionnaire.category;
        const questionIndex = questionnaireArr.length;

        const prevId = (questionObj.prev_questionnaire ?? {}).id ?? null;
        const nextId = (questionObj.next_questionnaire ?? {}).id ?? null;
        let buttonsURL = [];
        
        if(prevId) {
            let prevQuestionnaireUrl = '{{ route("student.quiz.getQuestionnaire", ":id") }}';
            prevQuestionnaireUrl = prevQuestionnaireUrl.replace(':id', prevId);
            buttonsURL.prevURL = prevQuestionnaireUrl;
        }
        
        if(nextId) {
            let nextQuestionnaireUrl = '{{ route("student.quiz.getQuestionnaire", ":id") }}';
            nextQuestionnaireUrl = nextQuestionnaireUrl.replace(':id', nextId);
            buttonsURL.nextURL = nextQuestionnaireUrl;
        }

        if(!questionObj.next_questionnaire) {
            let createResultURL = '{{ route("student.quizresult.result", ":id") }}';
            createResultURL = createResultURL.replace(':id', quizDetaildId);
            buttonsURL.resultsURL = createResultURL;
        }
        
        const studentQuestion = new Question(
            prevId, 
            nextId, 
            currentQuestionnaire, 
            quizDetaildId, 
            buttonsURL);

        return studentQuestion.createOutputQuestionnaire();

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