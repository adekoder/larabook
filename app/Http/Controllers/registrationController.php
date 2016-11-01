<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\RegistrationRequest;
use App\User;
use Illuminate\Support\Facades\Auth;
class registrationController extends Controller
{
    
    public function Register(RegistrationRequest $request)
    {
    		$request->password = bcrypt($request->password);
    		
    	$user = User::create([
    		'firstname'=> $request->firstname,
    		'lastname'=> $request->lastname,
    		'email'=> $request->email,
    		'password'=> $request->password,
    		'date_of_birth' => $request->date_of_birth,
    		'gender' => $request->gender
    		]);
    	//dd($user);
    	 	Auth::login($user);
    		
    		$user->active = 1 ;
    		$user->save();
    	return redirect()->route('dashboard');
    } 
}
