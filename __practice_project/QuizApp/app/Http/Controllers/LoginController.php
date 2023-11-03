<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

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

            return redirect('/')->with('message', 'Welcome back!');
        }
        return back()->withErrors(['email' => "Login failed."])->onlyInput('email');
        //code...
    }
}
