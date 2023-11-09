@extends('layouts.app-master')

<style>
   
</style>


@section('header')
    <x-teacher.quiz-header />
@endsection

@section('content')

<style>
    .quiz-content {
        opacity: 0;
        display:none;
        transition: opacity 0.3s ease; /* Add transition property */
    }

    .quiz-content.active {
        opacity: 1;
        display:block;
    }
</style>

<h4>General Details</h4>

<div class="general-details d-none">
    <form>
        <div class="quiz-form row bg-white rounded m-1 m-lg-0 p-3">
            <!-- Left Column -->
            <div class="col-md-6">
                <!-- Quiz Title -->
                <div class="mb-3">
                    <label for="quizTitle" class="form-label fw-bold" data-tooltip="Click me for more info">Quiz Title</label>
                    <input type="text" class="form-control" id="quizTitle" placeholder="Enter quiz title">
                </div>
    
                <!-- Instructions -->
                <div class="mb-3">
                    <label for="instructions" class="form-label fw-bold">Instructions</label>
                    <textarea class="form-control" id="instructions" rows="3" placeholder="Enter instructions"></textarea>
                </div>
    
                <!-- Pointing System -->
                <div class="mb-3">
                    <label for="points" class="form-label fw-bold">Points per item?</label> <input type="checkbox" class="form-check-input ms-1" id="checkPointsPerItem">
                    <input type="text" class="form-control" id="points" placeholder="Points per question." disabled>
                </div>
    
                <!-- Attempts -->
                <div class="mb-3">
                    <label for="maxAttempts" class="form-label fw-bold">Maximum Attempts</label>
                    <input type="number" class="form-control" id="maxAttempts" placeholder="Enter maximum attempts">
                </div>
    
                <!-- Time Limits -->
                <div class="mb-3">
                    <label for="overallTimeLimit" class="form-label fw-bold">Overall Time Limit (in minutes)</label>
                    <input type="number" class="form-control" id="overallTimeLimit" placeholder="Enter overall time limit">
                </div>
    
              
            </div>
    
            <!-- Right Column -->
            <div class="col-md-6">
                 <!-- Start Date -->
                 <div class="mb-3">
                    <label for="startDate" class="form-label fw-bold">Start Date</label>
                    <input type="datetime-local" class="form-control" id="startDate">
                </div>
    
                 <!-- End Date -->
                 <div class="mb-3">
                    <label for="endDate" class="form-label fw-bold">End Date</label>
                    <input type="datetime-local" class="form-control" id="endDate">
                </div>
    
                 <!-- Review Options -->
                 <div class="mb-3">
                    <label for="feedbackTiming" class="form-label fw-bold">Feedback Timing</label>
                    <select class="form-select" id="feedbackTiming">
                    <option value="immediately">Immediately</option>
                    <option value="afterCompletion">After Quiz Completion</option>
                    </select>
                </div>
    
                <label for="randomizeQuestionOrder" class="fw-bold">Other Settings</label>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="reviewAnswers">
                    <label class="form-check-label" for="reviewAnswers">Allow Review of Answers</label>
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="resultsView">
                    <label class="form-check-label" for="resultsView">Show results after submission</label>
                </div>
                <!-- Randomization -->
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="randomizeAnswerChoices">
                    <label class="form-check-label" for="randomizeAnswerChoices">Randomize Answer Choices</label>
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="randomizeQuestionOrder">
                    <label class="form-check-label" for="randomizeQuestionOrder">Randomize Question Order</label>
                </div>
                
                <!-- Save and Publish Buttons -->
            </div>
            <div class="col-12">
                <div class="mb-3 text-end">
                    <button type="button" class="btn btn-primary">Save Draft</button>
                    <button type="button" class="btn btn-success">Publish Quiz</button>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="quiz-content generalContent active">
    generalContent
</div>

<div class="quiz-content questionContent">
    questionContent
</div>

<div class="quiz-content overviewContent">
    overviewContent
</div>
@endsection

@section('custom-script')
<script>
    $(document).ready(function() {
        // script...
        let quizNavBtns = $('.quiz-nav-item');
        let quizContent = $('.quiz-content');
        quizNavBtns.click(function(e) {

            const $this = $(this); // selecting the current class of clicked button
            
            toggleActiveContent(quizNavBtns, $this);
            toggleActiveDisplay(quizContent, $this);
        });

    });


    function toggleActiveContent(className, activeNav) {
        
        $(className).removeClass('active');

        activeNav.addClass('active');
    }

    function toggleActiveDisplay(className, obj){
        
        const target = obj.data('target');
        const activeContent = $('.' + target);
        
        $(className).hide();

        activeContent.show();

        toggleActiveContent(className, activeContent);
    }
</script>
@endsection