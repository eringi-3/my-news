<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Profile;
class ProfileController extends Controller
{
    
    public function index (){
        $profile = Profile::first();
    //   return view('profile/index', ['headline' => $headline, 'posts' => $posts]); 
       return view('profile/index', ['profile' => $profile]); 
    }
}
