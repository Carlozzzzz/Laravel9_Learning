@extends('layouts.app-master')

@section('content')
    <div>
        <div class="content-header">
            <h4>Quizzes</h4>
        </div>
        <div class="content-body">
            <div class="row g-3" id="dataContainer">
                @for ($i = 0; $i < 6; $i++)
                    <x-quiz.quiz-view />  
                @endfor
        
            </div>
        </div>
    </div>
@endsection


@section('custom-script')
<script>
    $(document).ready(function() {
        // script...
        let togglerBtn = document.querySelectorAll('.toggle-sidebar-btn');
    });
</script>
@endsection