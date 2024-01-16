@php
    $isStudent = auth()->user()->user_type == "student";
    $isStudentQuiz = isset($data_dataactivepage) && ($data_dataactivepage == "student_quiz_view" || $data_dataactivepage == 'student_quiz_question');
    $isStudentQuizView = isset($data_dataactivepage) && ($data_dataactivepage == "student_quiz_view");
    $isStudentQuizQuestion = isset($data_dataactivepage) && ($data_dataactivepage == "student_quiz_question");

    $isTeacher = auth()->user()->user_type == "teacher";
    $isTeacherQuiz = isset($data_dataactivepage) && ($data_dataactivepage == "teacher_quiz" || $data_dataactivepage == 'teacher_quiz_question');
    $isTeacherQuizEdit = isset($data_dataactivepage) && ($data_dataactivepage == "teacher_quiz");
    $isTeacherQuizQuestion = isset($data_dataactivepage) && ($data_dataactivepage == 'teacher_quiz_question');
@endphp
<div id="bannerNav" class="sidebar">
    <div class="banner-content d-flex flex-column main-text-color p-3 h-100">
        @if($isTeacher && $isTeacherQuiz)
            @if($isTeacherQuizEdit)
                <h5 class="mt-2 mb-4">Question Edit Page</h5>
            @elseif($isTeacherQuizQuestion)
                <div class="question-settings">
                    <h5 class="mt-2 mb-4">Question Details</h5>

                    <div class="form-group mb-3">
                        <label for="quiz-settings-categories">Question Category <span class="bg-primary rounded text-white" data-toggle="tooltip" data-placement="top" title="Select a category to display questionnare"><i class="bi bi-info"></i></span></label>
                        
                        <select  class="form-select quiz-settings-categories" id="quiz-settings-categories" name="quiz_category" >
                            <option value="">--Select Category--</option>
                        </select>
                    </div>        

                    <div class="question-list" id="question-list">
                    </div>
                </div>
            @endif
        @elseif($isStudent && $isStudentQuiz)
            @if($isStudentQuizView)
                <h5 class="mt-2 mb-4">Quiz Details</h5>
                <div class="assignmentContainer card mb-3">
                    <div class="card-body">
                        <h6>Assignment</h6>
                        <div class="assignmentContent">
                            <p class="mb-0"><span class="me-1">Type :</span> Quiz</p>
                        </div>
                        <div class="assignmentContent">
                            <p class="mb-0"><span class="me-1">Points :</span> {{$data_datarecordfile->points}} pts. each</p>
                        </div>
                        <div class="assignmentContent">
                            <p class="mb-0"><span class="me-1">Max score :</span> {{ $data_totalQuizPoints ?? null}}</p>
                        </div>
                        <div class="assignmentContent">
                            <p class="mb-0"><span class="me-1">Start :</span> {{$data_startDate}}</p>
                        </div>
                        <div class="assignmentContent">
                            <p class="mb-0"><span class="me-1">End : </span>{{ $data_endDate }}</p>
                        </div>
                        <div class="assignmentContent">
                            <p class="mb-0"><span class="me-1">Timer :</span> {{ $data_datarecordfile->time_limit_hr }}h {{ $data_datarecordfile->time_limit_mm }}m {{ $data_datarecordfile->time_limit_sec }}s</p>
                        </div>
                        <div class="assignmentContent">
                            @if ($data_isMaxAttemptReach && $data_isQuizOpen)
                                <p class="mb-0">No more submission allowed.</p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="scoreContainer card mb-3">
                    <div class="card-body">
                        <h6 class="">
                            Score
                        </h6>
                        <span class="fw-none">
                            @if(isset($data_studentQuizScore) && $data_studentQuizScore != null)
                                {{ $data_studentQuizScore }} / {{ $data_totalQuizPoints ?? "Null" }}
                            @else
                                Waiting for grade.
                            @endif
                        </span>
                    </div>
                </div>
    
                <div class="submissionContainer card mb-3">
                    <div class="card-body">
                        <h6>Submission</h6>
                        {{-- or past due --}}
                        @if ($data_hasResults)
                            <p class="mb-0">Submitted</p>
                        @else
                            <p class="mb-0">Not yet submitted</p>
                        @endif
                        <p class="mb-0"><span class="me-1">Attempts :</span> {{ $data_studentAttempts }}</p>
                        <p class="mb-0"><span class="me-1">Max Attempts :</span> {{ $data_datarecordfile->attempts}}</p>
                        <p class="mb-0"><span class="me-1">Allow late submission :</span> {{ $data_datarecordfile->allow_late ? "Yes" : "No" }} {{-- icon --}} </p>
                    </div>
                </div>
    
                <div class="commentContainer card ">
                    <div class="card-body">
                        <h6>Comment</h6>
                        <form action="">
                            <textarea class="form-control w-100" name="" rows="10" placeholder="Your comment here..."></textarea>
                        </form>
                    </div>
    
                </div>
            @elseif($isStudentQuizQuestion && isset($data_quiz) )
                <h5 class="mt-2 mb-4">Quiz Details</h5>
                <div class="timerContainer card mb-3">
                    <div class="card-header">
                        <h6>Timer</h6>
                    </div>
                    <div class="card-body">
                        <p class="mb-0"><span><i class="bi bi-stopwatch"></i> Remaining time : </span><span id="quiz-timer"></span></p>
                    </div>
                </div>
                <div class="questionnaireDetailsContainer card mb-3">
                    <div class="card-header">
                        <h6>Questions</h6>
                    </div>
                    <div class="card-body">
                        <div class="card-body p-0">
                            <div class="d-flex flex-column">
                                @foreach($data_questionsSortOrder as $sortOrder)
                                    <div class="question{{ $sortOrder->question->id }}">
                                        {{-- @php 
                                            echo "<br><br>Question : " .$question->id . " => " . $question->student_question_sort_order->question_order . "<br>";
                                        @endphp --}}
                                        <a href="" class="text-decoration-none text-secondary mb-0"><span class="{{isset($sortOrder->question->student_quiz_answers->is_answered) && $sortOrder->question->student_quiz_answers->is_answered !== null ? "text-success" : "text-secondary"}}"><i class="bi bi-check-square-fill"></i></span> Question {{ $sortOrder->question_order }}</a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="card mb-3">
                    <div class="card-body">
                        <p class="mb-0"><i class="bi bi-stopwatch"></i> Remaining Time: <span class="quiz-remaining-time">- - -</span></p>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        Questions
                    </div>
                    <div class="card-body">
                        <div class="card-body d-flex flex-column">
                            <a class="text-decoration-none fw-bold text-secondary"><span><i class="bi bi-check-square"></i></span> Question 1</a>
                            <a class="text-decoration-none fw-bold text-secondary"><span class="text-success"><i class="bi bi-check-square-fill"></i></i></span> Question 1</a>
                        </div>
                    </div>
                </div>
            @endif
        @else
            Profile View Default
        @endif
    </div>
</div>