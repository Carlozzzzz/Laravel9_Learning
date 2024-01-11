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

            console.log("Results", results);

            results.student_quiz_answer.forEach(result => {
                console.log(result);
                const outputHTML = createQuestionnaireOutput(result);
                questionResult.append(outputHTML);
            });
        }
    }
    function createQuizResultOutput(detailsObj) {
        const quizId = 101;
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
                    <button class="btn btn-success"><i class="bi bi-arrow-clockwise"></i> Re-attempt</a>    
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
                <p><span class="">Question</span> : <span>${resultObj.question.question}</span></p>
                <p class=""><span class="fw-bold">Response : </span><span>${resultObj.choice.choice}</span></p>
                <p class="">Score : ${resultObj.point} / ${resultObj.points_per_question} ${logo}</p>  
            </div>
        `;
    }
</script>
@endsection
