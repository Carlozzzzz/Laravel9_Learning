@extends('layouts.app')

@section('content')
<section>
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/blogs">Home</a></li>
          <li class="breadcrumb-item"><a href="/user/posts">My Blogs</a></li>
          <li class="breadcrumb-item"><a>My Blogs</a></li>
        </ol>
    </nav>
    <div class="row justify-content-center py-5">
        <div class="col-md-6">
           <div class="d-flex ">
                @php
                    $dateCreated = \Carbon\Carbon::parse($data_datarecordfile->created_at)->format('F d, Y');
                @endphp
                <span class="badge text-bg-primary">Blog</span>
                <span class="mx-2"> {{ $dateCreated }}</span>
                <span class="mx-2"> {{ $data_datarecordfile->name }}</span>
                <span class="mx-2"> 10min Read</span>
           </div>
           <div>
                @php
                    $default_image = "https://api.dicebear.com/avatar.svg";   
                @endphp

                <h2 class="my-4 fw-bold"> {{ $data_datarecordfile->title}} </h2>
                <img 
                    src="{{ isset($data_datarecordfile->post_image) ? $data_datarecordfile->post_image : $default_image}}" 
                    alt="Post_Img"
                    class="w-100 rounded-3">
                <p class="fs-5 pt-5"> {{ $data_datarecordfile->content}} </p>
           </div>
        </div>
    </div>
</section>
@endsection
