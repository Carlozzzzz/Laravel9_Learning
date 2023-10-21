<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\View;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
    public function index() 
    {
        if(View::exists('user.index')) {

            $data['data_datatablefile'] = User::orderBy('created_at', 'desc')
                    ->get();

            return view('user.index', $data);
        } return abort(404);
    }

    public function create() 
    {
        if(View::exists('user.create')) {
            return view('user.create');
        } return abort(404);
    }

    public function store(Request $request) 
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'min:3'],
            'email' => 'required|email:rfc,dns|unique:users,email',
            'age' => 'required|integer',
            'job' => 'required',
            'password' => 'required',
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

            // Original Image Store
            $request->file('user_image')->storeAs('public/user/image', $fileNameToStore);

            // Thumbnail storage
            $request->file('user_image')->storeAs('public/user/thumbnail/image', $fileNameToStore);

            // Create thumbnail
            $thumbnail = "storage/user/thumbnail/image/" . $fileNameToStore;

            $this->createThumbnail($thumbnail, 150, 93);

            $validated['user_image'] = $fileNameToStore;
        }

        $data = User::create($validated);

        return redirect('/users')->with('message', 'Data has been saved.');
    }

    public function edit($id)
    {
        if(View::exists('user.edit')) {
            $data['data_datarecordfile'] = User::find($id);

            return view('user.edit', $data);
        }
    }


    public function update(Request $request, User $user) {
        // try {
            $validated = $request->validate([
                'name' => ['required', 'string', 'min:3'],
                "email" => 'required|unique:users,email,'.$user->id,
                'age' => 'required|integer',
                'job' => 'required',
                'password' => 'required',
                'password_confirmation' => 'required|same:password'
            ]);

            if($request->hasFile('user_image')) {

                $request->validate([
                    'user_image' => 'mimes:jpeg,png,bmp,tiff||max:4096'
                ]);

                $fileExtension = $request->file('user_image');

                $filename = pathinfo($fileExtension, PATHINFO_FILENAME);

                $extension = $request->file('user_image')->getClientOriginalExtension();

                $fileNameToStore = $filename  . '_' . time() . '_' . $extension;

                $request->file('user_image')->storeAs('public/user/image', $fileNameToStore);
                
                $request->file('user_image')->storeAs('public/user/thumbnail/image', $fileNameToStore);

                $thumbnail = "storage/user/thumbnail/image/" . $fileNameToStore;

                $this->createThumbnail($thumbnail, 150, 93);

                $validated['user_image'] = $fileNameToStore;

            }

            $user->update($validated);

            return redirect('/users')->with('message', 'Data has been updated.');
        // } catch (ValidationException $e) {
        //     dd($e->validator->errors()->toArray());
        // }
    }

    public function destroy(User $user) {
        $user->delete();

        return redirect('/users')->with('message', 'Data has been deleted.');
    }
    public function createThumbnail($path, $width, $height) 
    {
        $img = Image::make($path)->resize($width, $height, function($constraint) {
            $constraint->aspectRatio();
        });
        $img->save($path);
    }


}
