<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileImageCoverRequest;
use App\Http\Requests\ProfileImageRequest;
use App\Models\Country;
use App\Models\User;
use App\Services\ImageLinkService;
use App\Services\StoreImageService;
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

    public function update(ProfileImageRequest $request, User $user)
    {
        // try {
            $validated = "";

            if($request->has('user_image')) {

                $validated = $request->validated();
    
                $requestFile = $request->file('user_image');

                $validated['user_image'] = StoreImageService::saveImageTo($requestFile, 'user/image', true);

                $user->update($validated);

                return redirect('/user/profile')->with("message", "Profile has been updated.");

            }

            if($validated == "") {
                return redirect('/user/profile')->with("message", "No changes made.");
            }

        // } catch (ValidationException $e) {
        //     dd($e->validator->errors()->toArray());
        // }
    }

    public function update_1(ProfileImageCoverRequest $request, User $user)
    {
        $validated = "";

        if ($request->has('user_cover_image')) {

            $validated = $request->validated();

            $requestFile = $request->file('user_cover_image');

            $validated['user_cover_image'] = StoreImageService::saveImageTo($requestFile, 'user/image/cover', true);

            $user->update($validated);

            return redirect('/user/profile')->with("message", "Profile has been updated.");
        }

        if($validated == "") {
            return redirect('/user/profile')->with("message", "No changes made.");
        }
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