@extends('layouts.auth-master')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12 col-md-8 col-lg-6 mx-auto mt-5">
            <div class="card login-div">
                <div class="card-body">
                    <h5 class="fs-2 text-muted text-center py-4">Register an Account</h5>
                    <form action="{{ route('register.perform') }}" method="POST">
                        @method("POST")
                        @csrf
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="floatingFname" name="first_name"
                                placeholder="First Name">
                            <label for="floatingFname" class="text-muted">First Name</label>
                            @error('first_name')
                            <p class="fs-6 text-danger p-2"> {{ $message }} </p>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="floatingLname" name="last_name"
                                placeholder="Last Name">
                            <label for="floatingLname" class="text-muted">Last Name</label>
                            @error('last_name')
                            <p class="fs-6 text-danger p-2"> {{ $message }} </p>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <select class="form-select" id="floatingSelect" name="gender"
                                aria-label="Select gender">
                                <option selected><span class="text-muted">Select Gender</span></option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                            <label for="floatingSelect">Gender</label>
                            @error('gender')
                            <p class="fs-6 text-danger p-2"> {{ $message }} </p>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="floatingInput" name="email"
                                placeholder="name@example.com" value=" {{ old('email') }}" autocomplete="false">
                            <label class="text-muted" for="floatingInput">Email address</label>
                            @error('email')
                            <p class="fs-6 text-danger p-2"> {{ $message }} </p>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="floatingPassword" name="password"
                                placeholder="Password">
                            <label class="text-muted" for="floatingPassword">Password</label>
                            @error('password')
                            <p class="fs-6 text-danger p-2"> {{ $message }} </p>
                            @enderror
                        </div>
                        <div class="form-floating">
                            <input type="password" class="form-control" id="floatingConfirmPassword"
                                name="password_confirmation" placeholder="Confirm Password">
                            <label class="text-muted" for="floatingConfirmPassword">Confirm Password</label>
                            @error('password_confirmation')
                            <p class="fs-6 text-danger p-2"> {{ $message }} </p>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary w-100 mt-3 p-3">Register</button>
                        <p class="text-center mt-2 mb-0"><a href=" {{ route('login') }}"
                                class="text-decoration-none">Login</a></p>
                    </form>
                </div>
            </div>
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