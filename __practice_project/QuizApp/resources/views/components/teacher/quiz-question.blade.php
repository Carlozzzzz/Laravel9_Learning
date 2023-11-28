<style>
    .questioner-header .quiz-categories {
        width: 250px;
    }

    body {
        margin-right: 300px;
    }

    .sidebar {
        right: 0;
    }

    .banner-toggler {
        display: none;
    }
</style>


{{-- for questionSettings --}}
<div class="container bg-white p-4">
    <div class="row g-4">
        <div class="col-12 col-lg-8 col-xl-7 mx-auto">
            <form action="{{ route('questionnaire.store', $data->id) }}" method="post">
                @csrf

                <div class="questionnaire-container" id="questionnaire-container">
                    {{-- Append new question here --}}
                </div>

                <div class="cursor-pointer shadow-sm w-100 mb-3" id="create-questionnaire">
                    <div class="bg-gray-1 p-3">
                        <p class="mb-0 text-center fw-bold"><i class="bi bi-plus-lg"></i> Create New</p>
                    </div>
                </div>
            
                <div class="questionnaire-buttons text-end">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-secondary">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>