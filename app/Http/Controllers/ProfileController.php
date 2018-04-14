<?php

namespace App\Http\Controllers;

use App\User;
use App\Volunteer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show($username)
    {
        $user = User::where('username', $username)->first();
        $data = [];
        if (!is_null($user)) {
            $data['user'] = $user;
            $data['volunteer'] = $user->volunteer;
            if (Auth()->user())
                if (Auth::user()->id == $user->id)
                    $data['view_mode'] = "self";
                else
                    $data['view_mode'] = "other";
            else
                $data['view_mode'] = "guest";

            return view("profile.volunteer")->with($data);
        } else
            return redirect("home");
    }

    public function edit($username)
    {
        $user = User::has("volunteer")->where('username', $username)->first();
        $volunteer = $user->volunteer;
        return view("profile.edit")->with([
            "volunteer" => $volunteer,
            "user"      => $user,
        ]);
    }
}
