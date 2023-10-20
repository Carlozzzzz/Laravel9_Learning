<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function show() {
        return view("auth.index");
    }

    public function login(Request $request) 
    {
        $validate = $request->validate([
            "email" => "required|email",
            "password"=> "required"
        ]);

        // attempt to authenticate the user
        if(auth()->attempt($validate)) {
            return redirect('/dashboard')->with('message', 'Successfully Logged in.');
        }

        return redirect()->back()->withErrors(['email' => 'Failed to log in.']);
    }

    public function login2(LoginRequest $request) 
    {
        $validate = $request->validated();

        if(auth()->attempt($validate)) {
            return redirect('/dashboard')->with('message', 'Successfully Logged in.');
        }

        return redirect()->back()->withErrors(['email' => 'Failed to log in.']);
    }

    public function logout() 
    {
        auth()->logout();

        return redirect('/');
    }
}
