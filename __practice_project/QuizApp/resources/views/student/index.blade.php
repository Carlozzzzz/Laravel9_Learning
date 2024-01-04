{{-- Refactor this --}}

@extends('layouts.app-master')

@section('header')
    <x-master.header />
@endsection

@section('content')
    <div>
        <div class="content-header">
            <h4>Student Quiz</h4>
        </div>
        <div class="content-body">
            <div class="row g-3" id="dataContainer">
                
                @foreach ($data_datarecordfile as $data)
                    <x-student.quiz-card :data="$data" />
                @endforeach
        
            </div>
        </div>
    </div>
@endsection


@section('custom-script')
<script>
    $(document).ready(function() {
        // script...
    });
</script>
@endsection