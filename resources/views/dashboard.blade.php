@extends('layouts.master')

@section('style')
	<link rel="stylesheet" type="text/css" href="{{ asset('css/custom.css')}}">
@endsection

@section('navbar')
	@include('partials.dashboardNav')
@endsection
@section('content')
	<div class="row">
		<div class="container" id="dash-con">
			<div class="col-sm-3">
				
				<!-- side bar left section -->
				<ul class="side-nav">
				<!-- asset(Storage::url($user->profileImage->profile_image_link))-->
					<li>
						<a href="{{ route('profile.show')}}">
							<img src="{{ isset($user->profileImage->profile_image_link)?asset(Storage::url($user->profileImage->profile_image_link )) : asset('assets/images/users/user1.png')}}" class="small-img">
							{{$user->firstname . " " . $user->lastname}}
						</a>
					</li>
					<li><a href=""><i class="fa fa-feed text-blue"></i> News Feeds</a></li>
					<li><a href=""><i class="fa fa-envelope text-purple"></i> Messages</a></li>
					<li><a href="{{ route('profile.edit')}}"><i class="fa fa-edit text-amber-800"></i> edit Profile</a></li>
				</ul>
			</div>
			<div class="col-sm-6">
				<!-- posts and  feeds  section -->
					<div class="feeds-contents">
						<div class=" card card-bg create-post-box">
							<h5 class=" upper text-bold"><i class="fa fa-edit text-blue-800"></i> Create new post</h5>
							<hr>
							<span id="info-area"></span>
							<form method="POST" action="{{ route('post.create')}}" enctype="multipart/form-data" id="post-form">
								{{ csrf_field()}}
								<div class="form-group">
									<textarea name="post_text"  id="post-input" rows="5" class="form-control unadjustable form-borderless"></textarea>
								</div>
								<hr>
								
								
								<label> 
									<span class="text-blue-800 text-bold group" >
										<i class="fa fa-upload text-default"></i>
										<input type="file" name="post_file" class="input-file" id="input-file">
										  Add photo
									 </span>
								 </label>

								<button type="submit" class="btn btn-blue btn-no-radius right">Post</button>
							</form>

						</div>

						<div id="target"></div>

						
						
											
					</div>
			</div>
			<div class="col-sm-3">
				<!-- side bar  right section -->
				fhfhfhfhf
			</div>
		</div>	

	</div>
@endsection
@section('script')
	<script >

		/*making this variable  aviablabe to main.js file*/
		var user_image = "{{$user->profileImage->profile_image_link or  ''}}";
		
		console.log(user_image);
		var target_content_length = $("#target").html().length;
		console.log(target_content_length);
		var user_name = "{{ Auth::user()->firstname .' ' .Auth::user()->lastname }}";
	</script>
	<script type="text/javascript" src="{{asset('js/main.js')}}"></script>
@endsection