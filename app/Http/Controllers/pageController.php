<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Posts;
use App\Http\Requests;

class pageController extends Controller
{
    
    // main page of the application
    public function Index()
    {

    	return view('indexPage');
    }    
    public function Dashboard()
    {
    	$posts = Posts::orderBy("created_at" ,"dsce")->get();
    	return view('dashboard' , ['posts'=> $posts] );
    }
}
