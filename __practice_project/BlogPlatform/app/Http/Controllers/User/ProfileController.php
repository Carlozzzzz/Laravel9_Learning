<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class ProfileController extends Controller
{
    public function __construct() {
        $this->middleware("auth");
    }

    public function show()
    {
        if(View::exists("user.profile")) {

            $user = Auth::user();

            $data['data_datarecordfile'] = $user;

            return view("user.profile", $data);

        } return abort(404);
    }

    
}
