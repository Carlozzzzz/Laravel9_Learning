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
                {{-- <button class="btn btn-primary ms-2" id="createQuestionnare">
                    Create
                </button> --}}
            </div>
        </div>
        <div class="col-12 col-lg-8 col-xl-7 mx-auto">
            <form action=" {{route('question.store')}} " method="post">
                @csrf
                {{-- <fieldset class="shadow mb-3 p-3">
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
                        <input type="text" class="form-control" id="questioner2" name="questions[0][question_text]" value="Choose your favorite anime.">
                    </div>
            
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="Naruto" name="questions[0][choices][]" value="Naruto" checked>
                        <label class="form-check-label" for="Naruto">Naruto</label>
                    </div>
            
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="Pokemon" name="questions[0][choices][]" value="Pokemon">
                        <label class="form-check-label" for="Pokemon">Pokemon</label>
                    </div>
            
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="Momoland" name="questions[0][choices][]" value="Momoland">
                        <label class="form-check-label" for="Momoland">Momoland</label>
                    </div>
                </fieldset> --}}

                {{-- <div class="question-container" id="questionContainer">
                    <div data-id="0" class="questionnare new-question question_0 position-relative shadow mb-3 p-4" id="question_0">
                        <button type="button" class="removeQuestion position-absolute top-0 end-0 bg-transparent border-0 fw-bold fs-3 sub-text-color mx-3 my-1 p-0" id="removeQuestion0"><i class="bi bi-x"></i></button>
                        <div class="multiple-choice ">
                            <div class="mb-3">
                                <label for="questioner1" class="form-label">Question --1--</label>
                                <input type="text" class="form-control category-question0" id="categoryQuestion_0" name="questionnare[0][question]" placeholder="Enter your question here..." value="Porro ipsum saepe r" readonly>
                            </div>
        
                            <div class="choices-container">
                                <label for="questioner0" class="form-label">Choices :</label>
                                
                                <div class="choice-1 d-flex align-items-center mb-2">
                                    <div class="form-check">
                                    <input type="radio" class="form-check-input" name="questionnare[0][answer_key]" id="isAnswerKey_0A" value="txtChoice1" readonly>
                                    </div>
                                    <div class="form-input flex-grow-1 ps-2">
                                    <input type="text" class="form-control txtChoice1" id="txtChoice1_0" name="questionnare[0][choices][]" placeholder="Choice..." value="Earum nihil officia " readonly>
                                    </div>
                                </div>
                                <div class="choice-1 d-flex align-items-center mb-2">
                                    <div class="form-check">
                                    <input type="radio" class="form-check-input" name="questionnare[0][answer_key]" id="isAnswerKey_0B" value="txtChoice2" readonly>
                                    </div>
                                    <div class="form-input flex-grow-1 ps-2">
                                    <input type="text" class="form-control txtChoice2" id="txtChoice2_0" name="questionnare[0][choices][]" placeholder="Choice..." value="Sit dolor distincti" readonly>
                                    </div>
                                </div>
                                <div class="choice-1 d-flex align-items-center mb-2">
                                    <div class="form-check">
                                    <input type="radio" class="form-check-input" name="questionnare[0][answer_key]" id="isAnswerKey_0C" value="txtChoice3" checked readonly>
                                    </div>
                                    <div class="form-input flex-grow-1 ps-2">
                                    <input type="text" class="form-control txtChoice3" id="txtChoice3_0" name="questionnare[0][choices][]" placeholder="Choice..." value="Mollit ipsum soluta" readonly>
                                    </div>
                                </div>
                                <div class="choice-1 d-flex align-items-center mb-2">
                                    <div class="form-check">
                                    <input type="radio" class="form-check-input" name="questionnare[0][answer_key]" id="isAnswerKey_0D" value="txtChoice4" readonly>
                                    </div>
                                    <div class="form-input flex-grow-1 ps-2">
                                    <input type="text" class="form-control txtChoice4" id="txtChoice4_0" name="questionnare[0][choices][]" placeholder="Choice..." value="Id tempora praesenti" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}

               
                <div class="question-container" id="questionContainer">
                    {{-- Append new question here --}}
                </div>

                <div class="cursor-pointer shadow-sm w-100 mb-3" id="createQuestionnare">
                    <div class="bg-gray-1 p-3">
                        <p class="mb-0 text-center fw-bold"><i class="bi bi-plus-lg"></i> Create New</p>
                    </div>
                </div>
            
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="cancel" class="btn btn-secondary">Cancel</button>
                </div>
            </form>

        </div>

       
    </div>
</div>