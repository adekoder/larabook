<?php
namespace App\Http\viewComposer;

use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\View\View;

class viewComposer{

	protected $user;
	public function __construct()
	{
		$this->user = User::find(Auth::user()->id);
	}
	public function compose(View $view)
	{
		$view->with("user", $this->user);
	}
}



 ?>