@extends('layouts.app-master')

@section('content')
    <div id="questionnaire-results">
        
    </div>
@endsection

@section('custom-script')
<script>
    $(document).ready(function(){
        console.log("Result Page");

        getResults()
    })

    function getResults() {
        const questionResult = $("#questionnaire-results");
        const results = @json($data_studentanswers);
        const details = @json($data_quizdetails);

        if(results && details) {
            const detailsHTML = createQuizResultOutput(details);
            questionResult.append(detailsHTML); 

            results.forEach(result => {
                const questionnaire = result.question;
                const choice = questionnaire.student_quiz_answers.choice;
                const answer = choice.choice;

                const resultData = {
                    quizId : details.quiz_id,
                    question : questionnaire.question,
                    answer : answer,
                    score : questionnaire.student_quiz_answers.point,
                    points_per_question : questionnaire.student_quiz_answers.points_per_question,
                    is_correct : questionnaire.student_quiz_answers.is_correct
                };

                console.log(resultData);

                const outputHTML = createQuestionnaireOutput(resultData);
                questionResult.append(outputHTML);
            });
        }
    }
    function createQuizResultOutput(detailsObj) {
        const quizId = detailsObj.quiz_id;
        let quizURL = "{{ route('student.quiz.view', ':id') }}";
        quizURL = quizURL.replace(':id', quizId);

        return  `
            <div class="result-details bg-light mb-3 p-3">
                <div class="result-score text-center">
                    <p class="fs-4">${detailsObj.score} / ${detailsObj.total_points}</p>
                    <p>Score</p>
                </div>
                <div class="result-buttons">
                    <a href="${quizURL}" class="btn btn-primary"><i class="bi bi-arrow-return-left"></i> Back to Overview</a>    
                </div>
            </div>
        `;
    }

    function createQuestionnaireOutput(resultObj) {

        const isCorrect = resultObj.is_correct;
        let logo = "";
        if(isCorrect) {
            logo = '<span class="text-success"><i class="bi bi-check-circle-fill"></i></span>';
        } else {
            logo = '<span class="text-danger"><i class="bi bi-x-circle-fill"></i></span>';
        }

        return  `
            <div class="bg-light mb-3 p-3">
                <p><span class="">Question</span> : <span>${resultObj.question}</span></p>
                <p class=""><span class="fw-bold">Response : </span><span>${resultObj.answer}</span></p>
                <p class="">Score : ${resultObj.score} / ${resultObj.points_per_question} ${logo}</p>  
            </div>
        `;
    }
</script>
@endsection
