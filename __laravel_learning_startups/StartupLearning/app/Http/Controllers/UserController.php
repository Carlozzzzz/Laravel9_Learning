<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index() {
        return 'Hello from user controller.';
    }

    public function login() {
        if(View::exists('user.login')) {
            return view('user.login');
        } else {
            return abort(404);
            // return response()->view('errors.404');
        }
    }

    public function process(Request $request) {
        $validated = $request->validate([
            "email" => ['required', 'email'],
            "password" => 'required'
        ]);

        
        if(auth()->attempt($validated)) {
            $request->session()->regenerate();

            // Redirect to homepage
            return redirect('/')->with('message', 'Welcome back!')->with('color', 'green');
        }

        return back()->withErrors(['email' => 'Login Failed'])->onlyInput('email');

    
    }

    public function register() {
        return view('user.register');
    }

    public function logout(Request $request) {
        auth()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        // Flash session
        return redirect('/login')->with('message', 'Logout successful')->with('color', 'green');
    }

    public function store(Request $request) {
        $validated = $request->validate([
            "name" => ['required', 'min:4'],
            "email" => ['required', 'email', Rule::unique('users', 'email')],
            "password" => 'required|confirmed|min:6',
            "password_confirmation" => 'required'
        ]);

        $validated['password'] = bcrypt($validated['password']);

        $user = User::create($validated);

        auth()->login($user);

        return redirect('/')->with('message', 'Welcome!')->with('color', 'green'); 
    }

    public function show($id) {

        $data = array(
            "id" => $id,
            "name" => 'CarlosDev1',
            "age" => 23,
            "email" => "echibot1@gmail.com"
        );

        // return view('user', $data);
        return view('user')
            ->with('data', $data)
            ->with('name', 'CarlosDev')
            ->with('age', 22)
            ->with('email', 'carlos@gmail.com');
    }
}
