<div class="banner-content d-flex flex-column main-text-color p-3 h-100">
    <div class="question-settings">
        <div class="my-3">
            <h5>Question Details</h5>
        </div>

        <div class="form-group mb-3">
            <label for="quizSettingsCategory">Question Category <span class="bg-primary rounded text-white" data-toggle="tooltip" data-placement="top" title="Select a category to display questionnare"><i class="bi bi-info"></i></span></label>
            
            <select  class="form-select quiz-categories" id="quizSettingsCategory" name="quiz_category" >
                <option value="">--Select Category--</option>
                <option value="multiple choice">Multiple Choice</option>
                <option value="true or false">True or False</option>
                <option value="checklist">Checklist</option>
                <option value="enumeration">Enumeration</option>
            </select>
        </div>        

        <div class="question-list" id="questionList">
            {{-- append the questions here for easy view --}}
        </div>
    </div>

</div>

