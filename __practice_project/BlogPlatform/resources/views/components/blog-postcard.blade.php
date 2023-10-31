@props(['data'])
@props(['lastid'])

<style>

</style>
<div class="container overflow-hidden">
    <div class="row g-3" id="dataContainer">
        @foreach ($data as $row)
            <div class="col-md-6 col-lg-12 d-flex align-items-stretch">
                <div class="card flex-lg-row position-relative w-100">
                    <img src="{{ $row->post_image }}" class="blog-image object-fit-cover " alt="...">
                    <div class="blog-body flex-fill d-flex flex-column justify-content-between  p-2">
                        <div class="story mt-1">
                            <h5 class="fw-bold fs-4 ">{{ $row->title }}</h5>
                            <p class="">{{ $row->content }}</p>
                        </div>
                        <a href="/post/{{ $row->id }}" class="text-decoration-none">
                            <div class="cust-footer d-flex flex-column ">
                                <div class="details">
                                    <div class="blog-creator d-flex align-items-center">
                                        <img src="{{ $row->user->user_image }}" class="rounded-circle border border-2 border-secondary border-opacity-25" alt="" width="25px" height="25px">
                                        <h5 class="fs-6 fw-bold text-muted mb-0 ms-1"> {{ $row->user->name}}</h5>
                                    </div>
                                </div>
                                <div class="mt-1">
                                    <span class="text-muted"><i class='bx bx-calendar'></i> {{ $row->date_joined }}</span>
                                    <span class="text-muted ms-2"><i class='bx bx-message-rounded'></i></span> 09 Comments</span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach

    </div>
    <div class="row">
        <div class="col-md-12 text-center" id="loadButtonCol">
            <div class="btn btn-primary m-4 w-50" data-id="{{ $lastid }}" id="load_more_button">See More</div>
        </div>
    </div>
</div>
@php
    $test = 'testURL';

@endphp

@section('script')
    <script>
        $(function() {
            let dataContainer = $('#dataContainer');

            function loadMoreData(id = 0) {
                axios.post('{{ route('load-data') }}', {
                        id: id
                    })
                    .then(res => {
                        $('#load_more_button').remove();
                        // $('#load_more_button').html('<b>See More</b>');
                        $('#loadButtonCol').append(res.data.loadButton);
                        $('#dataContainer').append(res.data.output);

                        window.scrollTo(0, document.body.scrollHeight);
                    })
            }

            $('body').on('click', '#load_more_button', function() {
                var id = $(this).data('id');
                $('#load_more_button').html('<b>Loading...</b>');

                console.log(id);

                loadMoreData(id);

            });
        });
    </script>
@endsection