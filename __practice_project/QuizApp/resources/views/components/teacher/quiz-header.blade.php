@props(['data' => []])
@props(['activepage' => []])



<div class="quiz-nav shadow-sm flex-grow-1 d-flex align-items-end h-100 px-2 px-lg-4" id="quizNav">
    <ul class="nav">
        <li class="quiz-nav-item {{ isset($activepage) && $activepage == 'teacher_quiz' ? 'active' : '' }} px-3 py-2 px-md-4" data-target="generalContent">
            <a href="{{ isset($data->id) ? route('quiz.edit', $data->id) : '' }}" class="text-decoration-none {{ isset($activepage) && $activepage == 'teacher_quiz' ? '' : '' }}">
                <span class="d-none d-md-block">General</span>
                <i class="d-block d-md-none bi bi-info-square"></i>
            </a>
        </li>
        <li class="quiz-nav-item {{ isset($activepage) && $activepage == 'teacher_quiz_question' ? 'active text-white' : '' }} px-3 py-2 px-md-4" data-target="questionContent">
            <a href="{{ isset($data->id) ? route('questionnaire.index', $data->id) : '' }}" class="text-decoration-none {{ isset($data->id) ? '' : 'pe-none' }}" id="quiz-question">
                <span class="d-none d-md-block">Questions</span>
                <i class="d-block d-md-none bi bi-book-fill"></i>
            </a>
        </li>
        {{-- TODO - FIX link, status --}}
        <li class="quiz-nav-item px-3 py-2 px-md-4" data-target="statusContent">
            <a href="{{ isset($data->id) ? route('questionnaire.index', $data->id) : '' }}" class="text-decoration-none {{ isset($data->id) ? '' : 'pe-none' }}" id="quiz-status">
                    <span class="d-none d-md-block" id="quiz-status">Status</span>
                    <i class="d-block d-md-none bi bi-view-list"></i>
            </a>
        </li>
    </ul>
</div>