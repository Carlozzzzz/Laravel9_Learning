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
        <div class="col-12 col-lg-8 p-0">
            <div class="px-2">
                <h3 class="mt-4">My Blogs</h3>
                <hr class="px-2">
            </div>
            
            {{-- Posts component --}}
            <x-postcard :data="$data_datatablefile"/>
           
        </div>
    </div>
</section>
@endsection


