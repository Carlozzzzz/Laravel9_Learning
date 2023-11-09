@extends('layouts.app-master')

@section('header')
    <x-teacher.quiz-header />
@endsection

@section('content')

<h4>General Details</h4>

<div class="quiz-content generalContent active">
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

<div class="quiz-content questionContent d-none">
    questionContent
</div>

<div class="quiz-content overviewContent d-none">
    overviewContent
</div>
@endsection

@section('custom-script')
<script>
    $(document).ready(function() {
        
        $('.quiz-nav-item').click(function() {

            let quizNavBtns = $('.quiz-nav-item');
            let quizContent = $('.quiz-content');
            
            const $this = $(this);
            
            toggleActiveContent(quizNavBtns, $this);
            toggleActiveDisplay(quizContent, $this);
        });

        if ($('#checkPointsPerItem').is(":checked")) {
            $('#points').prop("disabled", false);
        } else {
            $('#points').prop("disabled", true);
        }

        $('#checkPointsPerItem').click(function() {
            $('#points').val("");

            if ($('#checkPointsPerItem').is(":checked")) {
                $('#points').prop("disabled", false);
            } else {
                $('#points').prop("disabled", true);
            }
        });


    });

</script>
@endsection