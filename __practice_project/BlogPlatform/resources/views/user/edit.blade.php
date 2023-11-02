@extends('layouts.app')

@section('content')

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
           
           <div class="card">
                <form action="{{ url('user/post/update/'.$data_datarecordfile->id.'') }}" method="POST" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="card-header">
                        <h2 class="fw-bold mb-0">Edit Post</h2>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Title</label>
                            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Title here..." name="title" value="{{old('title', $data_datarecordfile->title)}}">
                            @error('title')
                                <p class="text-danger my-2"> {{ $message }} </p>
                            @enderror
                        </div>
                        <div class="form-group mb-2">
                            <label for="postImage" class="form-label">Image</label>
                            <input type="file" class="custom-file-input form-control" id="postImage" name="post_image" previewImage="currentUserImage">
                        </div>
                        <div class="form-group mb-2" id="currentUserImageDiv">
                            @php
                                $imageSrc = $data_datarecordfile->post_image ? $data_datarecordfile->post_image : asset("storage/default-img.png");
                            @endphp
                            <label class="form-label mb-0">Image Preview</label>
                            <img id="currentUserImage" src="{{ $imageSrc }}" class="object-fit-cover border my-2" width="100%" height="250px">
                            @error('post_image')
                                <p class="text-danger m-2"> {{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="content" class="form-label">Content</label>
                            <textarea class="form-control" id="content" class="content" rows="3" placeholder="Content here" name="content" >{{old('content', $data_datarecordfile->title)}}</textarea>
                            @error('content')
                                <p class="text-danger my-2"> {{ $message }} </p>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ url('user/posts') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
           </div>
        </div>
    </div>
</section>

<script>
    let postImage = document.getElementById("postImage");

    postImage.addEventListener('change', function() {
       previewUpload(this);

   });
</script>

@endsection
