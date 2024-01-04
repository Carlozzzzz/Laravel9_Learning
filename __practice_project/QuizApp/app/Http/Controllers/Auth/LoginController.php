<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use RealRashid\SweetAlert\Facades\Alert;

class LoginController extends Controller
{
    public function show() {
        return view("auth.login");
    }

    public function login(LoginRequest $request)
    {
        
        $validated = $request->validated();

        if(auth()->attempt($validated)) {
            $request->session()->regenerate();

            $user = Auth::user();

            return redirect('/')->with('message', 'Welcome back!');
        }

        return back()->withErrors(['email' => "Login failed."])->onlyInput('email');
        //code...
    }

   
}
