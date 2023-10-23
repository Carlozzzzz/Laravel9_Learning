@extends('layouts.app')

@section('content')
<style>
    .custom-img {
        width: 150px;
    }
</style>
<section>
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/blogs">Home</a></li>
          <li class="breadcrumb-item"><a>My Blogs</a></li>
        </ol>
    </nav>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h3 class="mt-4">My Blogs</h3>
            <hr>
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
                        <a href="/user/post/{{ $data->id }}" class="fs-5">View post</a>
                    </div>
                </div>
                
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
