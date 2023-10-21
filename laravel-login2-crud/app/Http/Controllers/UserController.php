<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\View;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index() {
        if(View::exists('user.index')) {

            $data['data_datatablefile'] = User::orderBy('created_at', 'asc')
                    ->get();

            return view('user.index', $data);
        } return abort(404);
    }

    public function create() {
        if(View::exists('user.create')) {
            return view('user.create');
        } return abort(404);
    }

    public function store(Request $request) {
        try {
            $validated = $request->validate([
                'name' => ['required', 'string', 'min:3'],
                'email' => 'required|email:rfc,dns|unique:users,email',
                'age' => 'required',
                'job' => 'required',
                'password' => 'required|min:8',
                'password_confirmation' => 'required|same:password'
            ]);
    
            $validated['password'] = bcrypt($validated['password']);
            
            if($request->hasFile('user_image')) {
                $request->validate([
                    "user_image" => 'mimes:jpeg,png,bmp,tiff||max:4096'
                ]);
    
                $fileExtension = $request->file('user_image');
    
                $filename = pathinfo($fileExtension, PATHINFO_FILENAME);
    
                $extension = $request->file("user_image")->getClientOriginalExtension();
    
                $fileNameToStore = $filename . '_' . time() . '.' . $extension;
    
                $request->file('user_image')->storeAs('public/user/image', $fileNameToStore);
    
                $validated['user_image'] = $fileNameToStore;
            }
    
            $data = User::create($validated);

            return redirect('/users')->with('message', 'Data has been saved.');
        } catch (\Throwable $th) {
            throw $th;
        }
    }


}
