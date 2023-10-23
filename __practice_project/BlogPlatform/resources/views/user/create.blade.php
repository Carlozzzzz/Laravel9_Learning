@extends('layouts.app')

@section('content')
<style>
    .post-image {
        height: 30vh;
        width: 100%;
    }
</style>
<section class="">
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/blogs">Home</a></li>
          <li class="breadcrumb-item"><a href="/user/posts">My Blogs</a></li>
          <li class="breadcrumb-item active" aria-current="page">Post</li>
        </ol>
    </nav>
    <div class="row justify-content-center">
        <div class="col-md-6">
            @php
                $default_image = "https://api.dicebear.com/avatar.svg";   
            @endphp
           <div class="card">
                <form action="/user/store" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-header">
                        <h2 class="fw-bold mb-0">Create Post</h2>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Title</label>
                            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Title here..." name="title" value="{{old('title')}}">
                            @error('title')
                                <p class="text-red my-2"> {{ $message }} </p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="postImage" class="form-label">Image</label>
                            <input class="form-control" type="file" id="postImage" class="post_image" name="post_image">
                            <img src="{{ $default_image }}" alt="Post_Img" class="post-image object-fit-cover border my-2">
                            @error('post_image')
                                <p class="text-red my-2"> {{ $message }} </p>
                            @enderror
                        </div>
                        {{-- ========================================================== --}}
                        <div class="form-group">
                            <label for="customFile">Session photo</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="sessionPhoto" name="sessionPhoto">
                                <label class="custom-file-label" for="customFile">Choose file</label>
                            </div>
                        </div>
                        <div class="form-group" id="currentPhotoDiv" style="display: none;">
                            <label for="customFile"><small>Current photo</small></label>
                            <br>
                            <img id="currentPhotoImg" src="" width="200px">
                        </div>
                        {{-- ========================================================== --}}
                        <div class="form-group mb-3">
                            <label for="content" class="form-label">Content</label>
                            <textarea class="form-control" id="content" class="content" rows="3" placeholder="Content here" name="content" >{{old('content')}}</textarea>
                            @error('content')
                                <p class="text-red my-2"> {{ $message }} </p>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Publish</button>
                        <button class="btn btn-secondary">Cancel</button>
                    </div>
                </form>
           </div>
        </div>
    </div>
</section>


@endsection
