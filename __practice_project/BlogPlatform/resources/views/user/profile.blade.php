@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-4 bg-dark text-light rounded">
            <div class="profile-content text-center pt-5 px-5 pb-2">
                <img src="https://api.dicebear.com/avatar.svg" alt="Profile Image" class="rounded-circle">
                <p class="mt-2"><a href="#" class="text-decoration-none fs-5">Change profile</a></p>

                <p class="fs-4 fw-bold">{{ $data_datarecordfile->name }}</p>
            </div>
            <div class="profile-additional bg-secondary p-5 mb-3 rounded">
                <div class="contact">
                    <h5 class="fw-bold">Contact me: </h5>
                    <p class="mb-0">{{ $data_datarecordfile->email}}</p>
                    <p class="mb-0">0913456789</p>
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
            <div class="content-cover bg-secondary position-relative" style="height:250px">
                <img src="" alt="">
                <p class="fs-5 text-white text-muted position-absolute bottom-0 start-0 ms-2 mb-2">Background Image</p>
                <button class="btn btn-primary position-absolute bottom-0 end-0 mb-2 me-2 ps-2"><i class='bx bxs-pencil'></i> Edit</button>
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
                <h5 class="fw-bold">About me</h5>
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
                            <td class="fw-bold"><p>Interests : </p></td>
                            <td><p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Consequuntur distinctio modi natus voluptate numquam quo similique voluptates nihil quas non.</p></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection