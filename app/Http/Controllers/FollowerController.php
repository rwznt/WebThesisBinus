<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FollowerController extends Controller
{
    public function follow(User $user){
        $follower = auth()->user();

        $follower->following()->attach($user);

        return redirect()->route('', $user->id)->with('succes', "Followed Successfully");
    }

    public function unfollow(){

    }
}
