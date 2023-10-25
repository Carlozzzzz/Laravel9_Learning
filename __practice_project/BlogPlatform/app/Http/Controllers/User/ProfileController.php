<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\ValidationException;
use Intervention\Image\Facades\Image;

class ProfileController extends Controller
{
    public function __construct() {
        $this->middleware("auth");
    }

    public function show()
    {
        if(View::exists("user.profile")) {

            $user = User::find(Auth::id());

            $data['data_datarecordfile'] = $user;

            $storageSrc = "storage/user/image/";
            $storageCoverSrc = "storage/user/image/cover/";

            $user_image = $data['data_datarecordfile']->user_image;
            $user_cover_image = $data['data_datarecordfile']->user_cover_image;

            $data['data_datarecordfile']->user_image = $this->imageLink($user_image, $storageSrc);
            $data['data_datarecordfile']->user_cover_image = $this->imageLink($user_cover_image, $storageCoverSrc);

            return view("user.profile", $data);

        } return abort(404);
    }

    public function update(Request $request, User $user)
    {
        // try {
            $validated = "";

            if($request->has('user_image')) {
                $validated = $request->validate([
                    "user_image" => "required|mimes:jpeg,jpg,png,bmp,tiff||max:4096"
                ]);
    
                $fileExtension = $request->file('user_image');
    
                $filename = pathinfo($fileExtension, PATHINFO_FILENAME);
    
                $extension = $request->file('user_image')->getClientOriginalExtension();
    
                $fileNameToStore = $filename  . '_' . time() . '.' . $extension;
    
                $request->file('user_image')->storeAs('public/user/image', $fileNameToStore);
                
                $request->file('user_image')->storeAs('public/user/thumbnail/image', $fileNameToStore);
    
                $thumbnail = "storage/user/thumbnail/image/" . $fileNameToStore;
    
                $this->createThumbnail($thumbnail, 150, 93);
    
                $validated['user_image'] = $fileNameToStore;

            }
            else if ($request->has('user_cover_image')) {
                $validated = $request->validate([
                    "user_cover_image" => "required|mimes:jpeg,jpg,png,bmp,tiff||max:4096"
                ]);
    
                $fileExtension = $request->file('user_cover_image');
    
                $filename = pathinfo($fileExtension, PATHINFO_FILENAME);
    
                $extension = $request->file('user_cover_image')->getClientOriginalExtension();
    
                $fileNameToStore = $filename  . '_' . time() . '.' . $extension;
    
                $request->file('user_cover_image')->storeAs('public/user/image/cover/', $fileNameToStore);
                
                $validated['user_cover_image'] = $fileNameToStore;

            } else{
            
            }

            if($validated == "") {
                return redirect('/user/profile')->with("message", "No changes made.");
            }

            $user->update($validated);

            return redirect('/user/profile')->with("message", "Profile has been updated.");
        // } catch (ValidationException $e) {
        //     dd($e->validator->errors()->toArray());
        // }
    }

    public function update_2(Request $request, User $user)
    {

        // dd($request);

        $validated = $request->validate([
            'email' => 'required|unique:users,email,'.$user->id,
            'contact_number' => 'required|min:10'
        ]);

        $user->update($validated);

        return redirect('/user/profile')->with('message', 'Profile has been updated.');
        
    }

    public function createThumbnail($path, $width, $height) 
    {
        $img = Image::make($path)->resize($width, $height, function($constraint) {
            $constraint->aspectRatio();
        });
        $img->save($path);
    }

    public function imageLink($userProfileImage = "", $folder_name = "storage/user/image/")
    {
        $userProfileImage =  $userProfileImage == NULL || $userProfileImage == "" ? "https://api.dicebear.com/avatar.svg" : $userProfileImage;
        $userProfileImage = str_contains($userProfileImage, "https") ? $userProfileImage : asset($folder_name . $userProfileImage);

        return $userProfileImage;
    }
}
