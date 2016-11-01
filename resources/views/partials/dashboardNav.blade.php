<nav class="navbar navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">
        <a class="navbar-brand white-text" href="{{ route('dashboard') }}">
        Larabook
      </a>
      </a>
    </div>
    <form class="navbar-form navbar-left" role="search">
    	<div class="row">
    			 <div class="input-group ">
				    <input type="text" class="form-control " id="width" placeholder="Search for people ">
				    <span class="input-group-btn">
				    	<button type="submit" class="btn btn-default  "> <i class="fa fa-search"></i></button>

				    </span>
				   	
				 </div>
				 
    	</div>
	 
	</form>
	<ul class=" nav navbar-nav navbar-right">
		<li>
			<!--asset(Storage::url($user->profileImage->profile_image_link)) or ''--> 
			<a href="{{ route('profile.show')}}" id="login_user">
			<img src=" {{ isset($user->profileImage->profile_image_link)?asset(Storage::url($user->profileImage->profile_image_link )) : asset('assets/images/users/user1.png')}}" class="medium-img user_image">
				{{ ucfirst(Auth::user()->firstname)}}
			</a>
		</li>
		<li><a href="{{ route('dashboard')}}" class="white-text">Home</a></li>
		<li><a href="" class="nav-icon"><i class="fa fa-user-plus fa-1x"></i></a></li>
		<li><a href="" class="nav-icon"><i class="fa fa-envelope fa-1x"></i></a></li>
		<li><a href="" class="nav-icon"><i class="fa fa-bell fa-1x"></i></a></li>
		<li>
			<a href="" class="dropdown-toggle nav-icon" data-toggle="dropdown"><i class="fa fa-lock fa-1x"></i><span class="caret"></span></a>
			<ul class="dropdown-menu">
				<li><a href="{{ route('logout')}}">logout</a></li>
			</ul>
		</li>
	</ul>
  </div>
</nav>