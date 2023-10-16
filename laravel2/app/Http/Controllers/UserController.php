<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index() {
        return 'Hello from UserController';
    }

    public function login() {
        if(View::exists('user.login')) {
            return view('user.login');
        } else {
            return abort(404);
            // return response()->view('errors.sampleError');
        }
    }

    public function process(Request $request) {
        $validated = $request->validate([
            "email" => ['required', 'email'],
            "password" => 'required'
        ]);

        if(auth()->attempt($validated)) {
            $request->session()->regenerate();

            return redirect('/')->with('message', 'Welcome back!');
        }

        return back()->withErrors(['email' => "Login failed."])->onlyInput('email');

    }

    public function register() {
        if(View::exists('user.register')) {
            return view('user.register');
        } else {
            return abort(404);
        }
    }

    public function logout(Request $request) {
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('message', 'Logout successfull');
    }

    public function store(Request $request) {
        // @dd($request);
        $validated = $request->validate([
            "name" => ['required', 'min:4'],
            "email" => ['required', 'email', Rule::unique('users', 'enail')],
            "password" => 'required|confirmed|min:6',
            "password_confirmation" => 'required'
        ]);

        // $validated['password'] = Hash::make($validated['password']);
        $validated['password'] = bcrypt($validated['password']);

        $user = User::create($validated);

        auth()->login($user);
        // return redirect('/');

    }

    public function show($id) {

        $data = array(
            "id" => $id,
            "name" => "PinayCode",
            "age" => 23,
            "email" => "echibot1@gmail.com"
        );

        // return view('user', ['data' => $data]);

        return view('user', $data);
    }

    public function show2($id) {

        $data = ['sampleData' => 'data from db'];
        return view('user')
                    ->with('data', $data)
                    ->with('name', 'Carlos Agasi')
                    ->with('age', 22)
                    ->with('email', 'echibot1@gmail.com')
                    ->with('id', $id);
    }
}


