@props(['data'])

<div class="col-md-6 col-lg-4 col-xl-3 d-flex align-items-stretch">
    <div class="card border-0 bg-light-1 w-100  p-3"> 
        <a href="{{ route('quiz.edit', $data->id) }}" class="text-decoration-none main-text-color">
            <div class="card-header border-0 ">
                <img src="{{ asset('image/quiz-1.svg') }}" class="card-img object-fit-cover h-100 w-100" alt="...">
            </div>
            <div class="card-body">
                <div class="blog-body flex-fill d-flex flex-column justify-content-between  p-2">
                    <div class="story mt-1">
                        <h5 class="fw-bold fs-4 ">{{ $data->title }}</h5>
                        <p class="">{{ $data->instruction }}</p>
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                    <p class="mb-0">test</p>
                    <p class="mb-0">test</p>
                </div>
            </div>
        </a>
    </div>
</div>