<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function like(NewsPost $newsPost) {
        $liker = auth()->user();

        $liker->$likes()->attach($newsPost);

        return redirect()->route('')->with('success',"Liked Successfully");
    }

    public function unlike(NewsPost $newsPost) {
        $liker = auth()->user();

        $liker->$likes()->detach($newsPost);

        return redirect()->route('')->with('success',"Unliked Successfully");
    }

}
