<style>
    .questioner-header .quiz-categories {
        width: 250px;
    }

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

<div class="container bg-white p-4">
    <div class="row g-4">
        <div class="col-12">
            <div class="questioner-header d-flex justify-content-end" id="questionerHeader">
                <button class="btn btn-primary ms-2" id="createQuestionnare">
                    Create
                </button>
            </div>
        </div>
        <div class="col-12 col-lg-8 col-xl-7 mx-auto">
            <form action=" {{route('question.store')}} " method="post">
                @csrf
                <fieldset class="shadow mb-3 p-3">
                    <legend>Question 1</legend>
                    <div class="mb-3">
                        <label for="questioner1" class="form-label"><span class="test">Question:</span></label>
                        <input type="text" class="form-control" id="questioner1" name="questions[1][question_text]" value="Choose your favorite language.">
                    </div>
            
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="JavaScript" name="questions[1][choices][]" value="JavaScript" checked>
                        <label class="form-check-label" for="JavaScript">JavaScript</label>
                    </div>
            
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="Python" name="questions[1][choices][]" value="Python">
                        <label class="form-check-label" for="Python">Python</label>
                    </div>
            
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="Java" name="questions[1][choices][]" value="Java">
                        <label class="form-check-label" for="Java">Java</label>
                    </div>
                </fieldset>
            
                <fieldset class="shadow mb-3 p-3">
                    <legend>Question 2</legend>
                    <div class="mb-3">
                        <label for="questioner2" class="form-label">Question:</label>
                        <input type="text" class="form-control" id="questioner2" name="questions[2][question_text]" value="Choose your favorite anime.">
                    </div>
            
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="Naruto" name="questions[2][choices][]" value="Naruto" checked>
                        <label class="form-check-label" for="Naruto">Naruto</label>
                    </div>
            
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="Pokemon" name="questions[2][choices][]" value="Pokemon">
                        <label class="form-check-label" for="Pokemon">Pokemon</label>
                    </div>
            
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="Momoland" name="questions[2][choices][]" value="Momoland">
                        <label class="form-check-label" for="Momoland">Momoland</label>
                    </div>
                </fieldset>

                {{-- <fieldset class="shadow mb-3 p-3">
                    <div class="multiple-choice ">
                        <div class="mb-3">
                            <label for="questioner1" class="form-label">Question #1</label>
                            <input type="text" class="form-control question_${questionCount}" id="question_${questionCount}" name="questionnaire[${questionCount}][question]" placeholder="Enter your question here...">
                        </div>
                        <div class="choices">
                            <label for="questioner1" class="form-label">Choices :</label>
                            <div class="form-input d-flex">
                                <label class="form-check-label d-flex align-items-center ms-2" for="question_${questionCount}_choice_${choiceCount}">Choice 1</label>
                                <input type="text" class="form-control choice_${choiceCount} ms-2" id="question_${questionCount}_choice_${choiceCount}" name="questionnaire[${questionCount}][choice][]" placeholder="Answer 1...">
                            </div>
                        </div>
                    </div>
                </fieldset> --}}

                {{-- <div class="question-content position-relative shadow mb-3 p-4">
                    <button type="button" class="position-absolute top-0 end-0 bg-transparent border-0 fw-bold fs-3 sub-text-color mx-3 my-1 p-0" id="removeQuestion"><i class="bi bi-x"></i></button>
                    <div class="multiple-choice ">
                        <div class="mb-3">
                            <label for="questioner1" class="form-label">Question --1--</label>
                            <input type="text" class="form-control sampleQuestion" id="sampleQuestion" name="questionnaire" placeholder="Enter your question here...">
                        </div>

                        <div class="question-container">
                            <label for="questioner1" class="form-label">Choices :</label>

                            <div class="question-1 d-flex align-items-center mb-2">
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" id="answerKey1" name="answer_key">
                                </div>
                                <div class="form-input flex-grow-1 ps-2">
                                    <input type="text" class="form-control sampleChoice1" id="sampleChoice1" name="choice1" placeholder="Choice 1...">
                                </div>
                            </div>

                            <div class="question-2 d-flex align-items-center mb-2">
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" id="answerKey2" name="answer_key">
                                </div>
                                <div class="form-input flex-grow-1 ps-2">
                                    <input type="text" class="form-control sampleChoice2" id="sampleChoice2" name="choice3" placeholder="Choice 2...">
                                </div>
                            </div>

                            <div class="question-3 d-flex align-items-center mb-2">
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" id="answerKey3" name="answer_key">
                                </div>
                                <div class="form-input flex-grow-1 ps-2">
                                    <input type="text" class="form-control sampleChoice3" id="sampleChoice3" name="choice3" placeholder="Choice 3...">
                                </div>
                            </div>

                            <div class="question-4 d-flex align-items-center mb-2">
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" id="answerKey4" name="answer_key">
                                </div>
                                <div class="form-input flex-grow-1 ps-2">
                                    <input type="text" class="form-control sampleChoice4" id="sampleChoice4" name="choice4" placeholder="Choice 4...">
                                </div>
                            </div>
                           
                             <div class="text-center">
                                <button type="button" class="btn btn-primary">Save Question</button>
                                <button type="cancel" class="btn btn-secondary">Cancel</button>
                            </div>
                            
                        </div>
                    </div>
                </div> --}}

               
                <div class="question-container" id="questionContainer">

                </div>
            
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="cancel" class="btn btn-secondary">Cancel</button>
                </div>
            </form>

        </div>
    </div>
</div>