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

    <div class="quiz-view h-100">
        @php
            $xroute = 'quiz.store';
            if(isset($data_datarecordfile) && $data_datarecordfile != "") {
                $xroute = 'quiz.update';
            }
        @endphp

        <div class="quiz-instruction bg-white rounded m-1 m-lg-0 p-3 h-100">
            <h4 class="mb-5">{{ $data_datarecordfile->title }}</h4>
            <h6>Instruction: </h6>
            <p> {{ $data_datarecordfile->instruction}} </p>
            <div class="quiz-buttons">
                @if(!$data_isMaxAttemptReach && $data_hasResults && !$data_isOngoing && $data_studentQuizScore != null)  
                {{-- FIX ME --}}
                    <a href="{{ route('student.quiz.reattemptQuiz', $data_datarecordfile->id) }}" class="btn btn-primary"><i class="bi bi-arrow-clockwise"></i> Re-attempt</a>
                @endif
                @if(!$data_isMaxAttemptReach && $data_hasResults && $data_isOngoing) 
                    <a href="{{ route('student.quiz.resumeQuiz', $data_datarecordfile->id) }}" class="btn btn-primary"><i class="bi bi-play-circle-fill"></i> Resume Quiz</a>
                @endif
                @if($data_hasResults)
                    <a href="{{ route('student.quizresult.result', $data_datarecordfile->latest_student_quiz_details->id) }}" class="btn btn-primary"><i class="bi bi-info-circle-fill"></i> View Results</a>
                @else
                    <a href="{{ route('student.quiz.startQuiz', $data_datarecordfile->id) }}" class="btn btn-primary">Start Quiz 1</a>
                @endif
            </div>
        </div>

    </div>
@endsection

@section('custom-script')
    <script>
       
    </script>

@endsection