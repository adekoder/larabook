<nav class="navbar  navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <a class="navbar-brand white-text" href="{{ route('index') }}">
        Larabook
      </a>
    </div>
    <form class="navbar-form navbar-right" role="login" method="POST" action="{{ route('login') }}">
    	<p class="navbar-text white-text">Login here</p>

	  <div class="form-group">
	    <input type="email" name="email" class="form-control" placeholder="Email"  value="{{ old('email')}}" required="required">
	    	@if( $errors->has('email'))
	    		<span class="text-danger">{{ $errors->first('email')}}</span>
	    	@endif
	  </div>
	  <div class="form-group">
	    <input type="password" name="password" class="form-control" placeholder="password" value="{{ old('password')}}"
	    required="required">
	    @if( $errors->has('password'))
	    		<span class="text-danger">{{ $errors->first('password')}}</span>
	    	@endif
	  </div>
	  <div class="form-group">
        
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="remember"> Remember Me
                </label>
            </div>
   	 </div>

	  <button type="submit" class="btn btn-default">Submit</button>
	  <br>
	  @if(Session::has('error_message'))
    		<span class="text-warning " id="error_info"> {{ Session::get('error_message')}}</span>
    	@endif
	  <input type="hidden" name="_token" value="{{ csrf_token() }}">
	</form>

  </div>
</nav>
	


