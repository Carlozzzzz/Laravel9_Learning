<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Country;
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

            $id = Auth::user()->id;

            $user = User::find($id);

            $data['data_datarecordfile'] = $user;

            ## Profile images ##
            $user_image = $data['data_datarecordfile']->user_image;

            $user_cover_image = $data['data_datarecordfile']->user_cover_image;
            
            $storageSrc = "storage/user/image/";

            $storageCoverSrc = "storage/user/image/cover/";

            $data['data_datarecordfile']->user_image = $this->imageLink($user_image, "profile", $storageSrc);

            $data['data_datarecordfile']->user_cover_image = $this->imageLink($user_cover_image, "cover", $storageCoverSrc);

            ## User Country ##
            $country = User::find($id)->country->name;

            $data['data_datarecordfile']['country'] = $country;

            ## Countries
            $data['data_datarecordfile']['countries'] = Country::all();

            ## Interests
            $data['interests'] = $user->interests;

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
        $validated = $request->validate([
            'email' => 'required|unique:users,email,'.$user->id,
            'contact_number' => 'required|min:10'
        ]);

        $user->update($validated);

        $message = [
            'message' => 'Profile has been updated.',
        ];

        return redirect('/user/profile')->with($message);
    }

    public function update_3(Request $request, User $user)
    {
        // try {
            $validated = $request->validate([
                'name'          => 'required|min:3',
                'gender'        => 'required',
                'industry'      => 'required|min:2',
                'occupation'    => 'required|min:2',
                'country_id'    => 'required',
            ]);

            $user->update($validated);

            $message = [
                'message' => 'Profile has been updated.',
            ];

            return redirect('/user/profile')->with($message);

        // } catch (ValidationException $e) {
        //     dd($e->validator->errors()->toArray());
        // }
    }

    public function createThumbnail($path, $width, $height) 
    {
        $img = Image::make($path)->resize($width, $height, function($constraint) {
            $constraint->aspectRatio();
        });
        $img->save($path);
    }

    public function imageLink($image_url = "", $imageFor = "profile", $folder_name = "storage/user/image/")
    {
        $imageFor = ($imageFor === "profile") ? "https://api.dicebear.com/avatar.svg" : asset("storage/default-img.png");
        $image_url =  ($image_url == NULL || $image_url == "") ? $imageFor : $image_url;
        $image_url = (str_contains($image_url, "https") || str_contains($image_url, "storage/default-img.png")) ? $image_url : asset($folder_name . $image_url);

        return $image_url;
    }
    
    
}
