@extends('layouts.app-master')

@section('header')

@if (isset($data_activepage) == "student_quiz")
    <div class="quiz-nav shadow-sm flex-grow-1 bg-light d-flex align-items-end h-100 px-2 px-lg-4" id="quizNav">
        <ul class="nav">
            <li class="quiz-nav-item {{ isset($data_activepage) && $data_activepage == 'student_quiz' ? 'active' : '' }} px-3 py-2 px-md-4" data-target="overviewContent">
                <a href="{{ isset($data_datarecordfile->id) ? route('student.quiz.view', $data_datarecordfile->id) : '' }}" class="text-decoration-none">
                    <span class="d-none d-md-block">Overview</span>
                    <i class="d-block d-md-none bi bi-info-square"></i>
                </a>
            </li>
            <li class="quiz-nav-item {{ isset($data_activepage) && $data_activepage == 'student_quiz_question' ? 'active text-white' : '' }} px-3 py-2 px-md-4" data-target="questionContent">
                <a href="{{ isset($data_datarecordfile->id) ? route('questionnaire.index', $data_datarecordfile->id) : '' }}" class="text-decoration-none" id="quiz-question">
                    <span class="d-none d-md-block">Questions</span>
                    <i class="d-block d-md-none bi bi-book-fill"></i>
                </a>
            </li>
            {{-- TODO - FIX link, status --}}
            <li class="quiz-nav-item px-3 py-2 px-md-4" data-target="statusContent">
                <a href="{{ isset($data_datarecordfile->id) ? route('questionnaire.index', $data_datarecordfile->id) : '' }}" class="text-decoration-none" id="quiz-status">
                        <span class="d-none d-md-block" id="quiz-status">Result</span>
                        <i class="d-block d-md-none bi bi-view-list"></i>
                </a>
            </li>
        </ul>
    </div>
@else 
    <div class="bg-light d-flex align-items-center h-100 w-100 px-2 px-lg-4">
        <a href=" {{ route('home') }} " class="text-decoration-none"><h3 class="page-title main-text-color fs-4  mb-0" id="pageTitle">{{ isset($page) ? $page : "Page Title" }}</h3></a>
        <div class="ms-auto">
            <i class="bi bi-bell-fill"></i>

            @if(auth()->user()->user_type == "teacher")
                <a href="{{ route('quiz.create') }}" class="btn btn-success ms-auto px-3 py-2">Create Quiz </a>
            @elseif(auth()->user()->user_type == "student")
                {{-- script here --}}
                <p></p>
            @endif
        </div>
    </div>
@endif


@endsection