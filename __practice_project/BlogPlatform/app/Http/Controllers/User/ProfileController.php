<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\User;
use App\Services\ImageLinkService;
use App\Services\ThumbnailService;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\ValidationException;

class ProfileController extends Controller
{
    public function __construct() {
        $this->middleware("auth");
    }

    public function show(ImageLinkService $imageLinkService)
    {
        if(View::exists("user.profile")) {

            $id = Auth::user()->id;

            $user = User::find($id);

            $data['data_datarecordfile'] = $user;

            ## Profile images ##
            $user_image = $user->user_image;

            $user_cover_image = $user->user_cover_image;
            
            $data['data_datarecordfile']->user_image = $imageLinkService->imageStorageLocation($user_image, "profile");

            $data['data_datarecordfile']->user_cover_image = $imageLinkService->imageStorageLocation($user_cover_image, "cover");

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
    
                $filenameToStore = $filename  . '_' . time() . '.' . $extension;
    
                $request->file('user_image')->storeAs('public/user/image', $filenameToStore);
                
                $request->file('user_image')->storeAs('public/user/image/thumbnail', $filenameToStore);
    
                $thumbnail = "storage/user/image/thumbnail/" . $filenameToStore;
    
                ThumbnailService::createThumbnail($thumbnail, 150, 93);
    
                $validated['user_image'] = $filenameToStore;

            }
            else if ($request->has('user_cover_image')) {
                $validated = $request->validate([
                    "user_cover_image" => "required|mimes:jpeg,jpg,png,bmp,tiff||max:4096"
                ]);
    
                $fileExtension = $request->file('user_cover_image');
    
                $filename = pathinfo($fileExtension, PATHINFO_FILENAME);
    
                $extension = $request->file('user_cover_image')->getClientOriginalExtension();
    
                $filenameToStore = $filename  . '_' . time() . '.' . $extension;
    
                $request->file('user_cover_image')->storeAs('public/user/image/cover/', $filenameToStore);
                
                $validated['user_cover_image'] = $filenameToStore;

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
}