@extends('layouts.app')

@section('content')
<style>
    .custom-img {
        width: 150px;
    }
</style>
<section >
    <div class="row justify-content-center">
        <div class="col-md-8">
            @foreach ($data_datatablefile as $data)
            <div class="card mt-3">
                <div class="card-content  d-flex">
                    <div>
                        <img src="{{ $data->post_image }}" alt="Post_Img" class="custom-img">
                    </div>

                    <div class="d-flex flex-column m-4">
                        <h3 class="fw-bold">{{ $data->title }}</h3>
                        <div class="flex-grow-1">
                            <p class="mt-4">{{ $data->content }}</p>
                        </div>
                        <a href="/post/{{ $data->id }}" class="fs-5">Read More</a>
                    </div>
                </div>
                
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
