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
                    <a class="btn btn-secondary " href="{{ route('student.quiz.view', $quiz_id) }}">Back</a>
                </div>
                <div class="col-12 col-lg-8 col-xl-6 mx-auto">

                    <div class="questionnaire-container" id="questionnaire-container">
                        @if(count($data_datarecordfile) > 0)
                            <form action="">
                                <input type="hidden" name="category" value="{{ $quiz_id }}">

                                @foreach($data_datarecordfile as $questionnaire)
                                    @php
                                        $questionnaireIndex = $loop->index + 1;
                                    @endphp
                                    <div class="{{ $questionnaire->category }} border rounded mb-4">
                                        <div class="question-container mb-1 bg-green-1 text-light p-3">
                                            <p class="mb-0"><span class="fw-bold">Question {{ $questionnaireIndex }}: </span> {{ $questionnaire->question }}?</p>
                                        </div>
                
                                        <div class="choices-container p-3">
                                            <p>Your answer: </p>
                                            @foreach($questionnaire->choices as $choiceKey => $choiceValue)
                                            
                                                <div class="hover-bg-gray-3 rounded mb-3">
                                                    @if($questionnaire->category == "multiple_choice" || $questionnaire->category == "true_or_false" || $questionnaire->category == "checklist")
                                                        <label class="form-check-label  border rounded p-2 w-100" for="{{ $questionnaireIndex }}{{chr(64+ $loop->iteration)}}">
                                                            <input class="form-check-input" 
                                                                type="{{ $questionnaire->category == 'checklist' ? 'checkbox' : 'radio'}}"
                                                                name="answer[{{$questionnaireIndex}}]"
                                                                id="{{ $questionnaireIndex }}{{chr(64+ $loop->iteration)}}" 
                                                                value="{{ $choiceValue->id }}">
                                                            <span>
                                                                @if($questionnaire->category == "multiple_choice" || $questionnaire->category == "true_or_false")
                                                                    {{ chr(64+ $loop->iteration).'. '.$choiceValue->choice }}
                                                                @elseif($questionnaire->category == "checklist")
                                                                    {{ $choiceValue->choice }}
                                                                @endif
                                                            </span>
                                                        </label>
                                                    @elseif($questionnaire->category == "enumeration")
                                                        <input type="hidden" name="" value="">
                                                        <input class="form-control" 
                                                            type="input" 
                                                            name="answer[{{$questionnaireIndex}}]"
                                                            id="{{ $questionnaireIndex }}{{chr(64+ $loop->iteration)}}" 
                                                            placeholder="Please enter your answer here...">
                                                    @else
                                                        {{ "No available question.." }}
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                        {{-- <div class="questionnaire-navigation d-flex justify-content-between">
                                            <button class="btn btn-primary"><< Prev</button>
                                            <button class="btn btn-primary">Next >></button>
                                        </div> --}}
                                    </div>
                                @endforeach

                            </form>
                        @else 
                            <div class="shadow-sm mb-3 text-center mx-auto p-4">
                                <p class="fw-bold mb-0">No record found.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
    </div>
@endsection

@section('custom-script')
<script>
    $(document).ready(function() {

    });

    function getQuestionnaire() {
        const datarecordfileId = "{{ isset($data_datarecordfile) ? optional($data_datarecordfile)->id : '' }}";

        if (!datarecordfileId) {
            return;
        }
        const url = `{{ route('questionnaire.getQuestionnaire', ':id') }}`.replace(':id', datarecordfileId);

        $.ajax({
            type: "GET",
            url: url,
            headers: {
                Accept: "application/json"
            },
            success: (response) => {

            }
        })
    }
</script>
@endsection