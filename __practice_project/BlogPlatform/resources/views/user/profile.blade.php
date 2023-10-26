@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-4 bg-dark text-light rounded">
            <div class="profile-content text-center pt-4 pb-3">
                <img src="{{ $data_datarecordfile->user_image }}" alt="Profile Image" class="rounded-circle object-fit-cover" width="150px;" height="150px;">
                {{-- Update profile modal --}}
                <x-user.update-profile-image :imagelink="$data_datarecordfile->user_image" :id="$data_datarecordfile->id"/>

                <p class="fs-4 fw-bold">{{ $data_datarecordfile->name }}</p>
            </div>
            <div class="profile-additional position-relative bg-secondary p-5 mb-3 rounded">
                {{-- User profile contact modal --}}
                <x-user.update-profile-contact :user="$data_datarecordfile" />
                <button class="btn btn-gray border border-gray border-0 text-white position-absolute top-0 end-0 m-2 ps-2" data-bs-toggle="modal" data-bs-target="#updateProfileContactModal"><i class='bx bxs-pencil'></i> Edit</button>
                <div class="contact">
                    <h5 class="fw-bold">Contact me: </h5>
                    <p class="mb-0">{{ $data_datarecordfile->email}}</p>
                    <p class="mb-0">{{ $data_datarecordfile->contact_number}}</p>
                </div>
                <hr>
                <div class="my-links">
                    <h5 class="fw-bold">Websites</h5>
                    <p class="mb-0"><i class='bx bx-world'></i> <a href="#" class="text-white">www.facebook.com</a></p>
                    <p><i class='bx bx-world'></i> <a href="#" class="text-white">www.youtube.com</a></p>
                </div>
                <hr>
                <div class="account-details">
                    @php
                        $dateJoined = \Carbon\Carbon::parse($data_datarecordfile->created_at)->format('F Y');
                    @endphp
                    <p>Joined since {{ $dateJoined }}</p>
                    <p>Account status</p>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="content-cover bg-secondary position-relative" >
                <img src=" {{ $data_datarecordfile->user_cover_image }}" alt="" class="object-fit-cover border border-gray border-opacity-50" width="100%" style="height:250px">
                {{-- <img src="http://127.0.0.1:8000/storage/image/default-img.png" alt="" class="object-fit-cover" width="100%" style="height:250px"> --}}
                <p class="fs-5 text-white text-muted position-absolute bottom-0 start-0 ms-2 mb-2">Background Image</p>
                <!-- Profile Cover Modal -->
                <button class="btn btn-primary position-absolute bottom-0 end-0 mb-2 me-2 ps-2" data-bs-toggle="modal" data-bs-target="#updateProfileCoverModal"><i class='bx bxs-pencil'></i> Edit</button>
                <x-user.update-profile-cover-image :imagelink="$data_datarecordfile->user_cover_image" :userid="$data_datarecordfile->id"/>
            </div>
            <hr class="mb-0">
            <div class="content-header ">
                <nav class="navbar navbar-expand-lg bg-body-tertiary p-0">
                    <a class="navbar-brand" href="#">Home</a>
                    
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="/user/posts">My Blogs</a>
                        </li>
                    </ul>
                </nav>
            </div>
            <hr class="mt-0">
            <div class="content-body mt-5">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">About me</h5>
                    
                    {{-- User profile contact modal --}}
                    <x-user.update-profile-about :user="$data_datarecordfile" />
                    <button class="btn btn-primary"  data-bs-toggle="modal" data-bs-target="#updateProfileAboutModal"><i class='bx bxs-pencil'></i> Edit</button>
                </div>
                <hr>
                <table>
                    <thead>
                        <tr>
                          <th scope="col" style="width: 120px;"></th>
                          <th scope="col"></th>
                          <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="fw-bold"><p>Gender : </p></td>
                            <td><p>{{ $data_datarecordfile->gender }}</p></td>
                        </tr>
                        <tr>
                            <td class="fw-bold"><p>Industry : </p></td>
                            <td><p>{{ $data_datarecordfile->industry }}</p></td>
                        </tr>
                        <tr>
                            <td class="fw-bold"><p>Occupation : </p></td>
                            <td><p>{{ $data_datarecordfile->occupation }}</p></td>
                        </tr>
                        <tr>
                            <td class="fw-bold"><p>Country : </p></td>
                            <td><p>{{ $data_datarecordfile->country }}</p></td>
                        </tr>
                        <tr>
                            <td class="fw-bold"><p class="mb-0">Interests : </p></td>
                            <td>
                                @foreach ($interests as $interest)
                                    <span class="badge text-bg-success">{{ $interest->name }} </span>
                                @endforeach
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection