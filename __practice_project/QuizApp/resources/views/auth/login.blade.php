@extends('layouts.auth-master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-8 col-lg-6 mx-auto mt-5">
                <div class="card login-div">
                    <div class="card-body">
                        <h5 class="fs-2 text-muted text-center py-4">Login to Your Account</h5>
                        <form action="{{ route('login.perform') }}" method="POST">
                            @method("POST")
                            @csrf
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" id="floatingInput" name="email" placeholder="name@example.com" value=" {{ old('email') }}">
                                <label class="text-muted" for="floatingInput">Email address</label>
                                @error('email')
                                    <p class="fs-6 text-danger p-2"> {{ $message }} </p>
                                @enderror
                            </div>
                            <div class="form-floating">
                                <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Password">
                                <label class="text-muted" for="floatingPassword">Password</label>
                                @error('password')
                                    <p class="fs-6 text-danger p-2"> {{ $message }} </p>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary w-100 mt-3 p-3">Login</button>
                            <div class="d-flex justify-content-evenly py-2">
                                <div class="forgot-password-div">
                                    <a href="" class="forgot-password text-decoration-none ">Forgot password</a>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="rememberme" name="remember_me">
                                    <label for="rememberMe" class="text-muted">Remember Me</label>
                                </div>
                            </div>
                            <p class="text-center mt-2 mb-0"><a href=" {{ route('register.show') }}" class="text-decoration-none">Register account?</a></p>
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