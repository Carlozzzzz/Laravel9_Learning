@props(['data'])

<div class="col-md-6 col-lg-4 col-xl-3 d-flex align-items-stretch">
    <a href="{{ route('student.quiz.view', $data->id) }}" class="card border-0 bg-light-1 w-100  p-3 text-decoration-none main-text-color h-100">
        <div class="card-header border-0 ">
            <img src="{{ asset('image/quiz-1.svg') }}" class="card-img object-fit-cover h-100 w-100" alt="...">
        </div>
        <div class="card-body  mt-2 mb-4 p-0">
            <div class="blog-body flex-fill d-flex flex-column justify-content-between">
                <div class="story mt-1">
                    <h5 class="fw-bold fs-4 ">{{ $data->title }}</h5>
                    <p class="mb-0">{{ $data->instruction }}</p>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-between mt-auto">
            <p class="text-muted mb-0"><span>Instructor : </span> {{ $data->user->first_name }} </p>
        </div>
    </a>
</div>