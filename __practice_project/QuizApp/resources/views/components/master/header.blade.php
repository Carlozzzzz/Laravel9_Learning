@extends('layouts.app-master')

@section('header')

<div class="d-flex align-items-center h-100 w-100 px-2 px-lg-4">
    <a href=" {{ route('home') }} " class="text-decoration-none"><h3 class="page-title main-text-color fs-4  mb-0" id="pageTitle">{{ isset($page) ? $page : "Page Title" }}</h3></a>

    <a href="{{ route('quiz.create') }}" class="btn btn-success ms-auto px-3 py-2">Create Quiz </a>
</div>

@endsection