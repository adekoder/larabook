<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\User;
class loginController extends Controller
{
    public function Login(Request $request)
    {
    	$this->validate($request , [
    		'email' => 'required',
    		'password' => 'required',
    	]);
    	$email = $request->email;
    	$password = $request->password;
    	//dd($password);
    	if( Auth::attempt(['email' => $email , 'password'=> $password ,'active' => 0], $request->remember) )
    	{
    		$this->user_status(Auth::user()->id, 1);
    		return redirect()->intended('dashboard');
    	}
    	else
    	{
    		return redirect()->back()->with([
    			'error_message' => 'invalid credentials try Again with correct input'
    		]);
    	}
    }

    public function Logout()
    {
            $this->user_status(Auth::user()->id, 0);
    	   Auth::logout();


    	return redirect()->route('index');
    }
    protected function user_status($log_user_id, $value)
    {
             $user = User::find($log_user_id);
            $user->active = $value;
            $user->save();   
    }
}
