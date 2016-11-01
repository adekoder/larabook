@extends('layouts.master')

@section('style')

	<link rel="stylesheet" type="text/css" href="{{ asset('css/custom.css')}}">
	<style>
		.jumbotron{
			background-image: url("{{ isset($user->profileImage->cover_image_link) ? asset(Storage::url($user->profileImage->cover_image_link)) : ' ' }}");
			background-color: #ccc;
			 background-repeat: no-repeat;
			 background-size: cover; 
			 border-radius:0px;
		}

	</style>
@endsection

@section('navbar')
	@include('partials.dashboardNav')
@endsection
@section('content')
<div class="container-fluid custom">
	<div class="jumbotron " id="cover-photo" >
		@if($user->id == Auth::user()->id)
			<span class=" right" data-toggle="modal" data-target="#uploadCoverModal"><i class="fa fa-camera fa-2x"></i></span>
		@endif
		<div class="profile-image">
			
		
			<img src="{{ isset($user->profileImage->profile_image_link)? asset(Storage::url( $user->profileImage->profile_image_link ) ) : asset('assets/images/users/user1.png')  }}" id="user_image" class="img-thumbnail img-responsive user_image" data-toggle="modal" data-target="#viewImageModal" />
		
			
		</div>	  

	</div>	
	<div class="tab-section">

		<div class="position-tab-center">
			<ul class="custom-tabs">
			<li><span class="text-danger upper"> {{ $user->firstname ." ".  $user->lastname}}</span></li>
			  <li class="active"><a href="#timeline-tab" data-toggle="tab">Timeline</a></li>
			  <li><a href="#about-tab" data-toggle="tab">About</a></li>
			  <li><a href="#friend-tab" data-toggle="tab">Friends</a></li>
			  @if( Auth::user()->id == $user->id )
				<li><a href="#message-tab" data-toggle="tab">Messages</a></li>
			 	 <li><a href="{{ route('profile.edit')}}">Edit</a></li>
			 	 <li><button class="btn btn-default" id="upload-btn" data-toggle="modal" data-target="#uploadModal">uplaod image</button></li>
			@endif
			  @if( Auth::user()->id !== $user->id )
				<li><button class="btn btn-default ">Add Friend</button></li>
			@endif
			  
			</ul>
			
		</div>

	</div>
	<div class="row">
		<div class="container-fluid">
			<div class="col-sm-3">
				<div class="info-box card card-bg">
					<h3 class="page-header text-amber-800">Basic Info</h3>
					<div class="bio-section ">
						<h4 class="text-info">Bio:</h4>
						<p clas="text-center" id="bio-section">
							{{ isset($user->bio)? $user->bio : 'No bio available'}}
							
						</p>
						 @if( Auth::user()->id == $user->id )
							<a href="" class="text-info" data-toggle="modal" data-target="#bioModal">edit bio</a>
							@endif
					</div>
					<ul class="style-none bio-list">
						<li>Name: <span class="text-right text-blue">{{ $user->firstname . " " . $user->lastname   }}</span></li>
						<li>Email:		<span class="text-right text-blue">{{ $user->email}}</span></li>
						<li>Date of Birth:	
								<span class="text-right text-blue">
									<?php 
										$date = Carbon\Carbon::parse($user->date_of_birth);
										$date = Carbon\Carbon::create($date->year, $date->month, $date->day);
										echo $date->toFormattedDateString();
									?>
						 		</span>
						 </li>
						 <li>Gender: <span class="text-rght text-blue">{{ $user->gender }}</span></li>
						<li>Nationality		
							<span class="text-right text-blue">
							
								@if(!isset($user->nationality))
								
									{{ "not avaliable" }}

								@else

									{{ $user->nationality}}

								@endif

							
								
						 	</span>
						 </li>
					</ul>
					
				</div>
			</div>
			<div class="col-sm-6">
				<div class="tab-content card card-bg">
					<div class="tab-pane active" id="timeline-tab">
						Basic tabs example using <code>.nav-tabs</code> class. Also requires base <code>.nav</code> class.
					</div>

					<div class="tab-pane" id="about-tab">
						Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim.
					</div>

					<div class="tab-pane" id="friend-tab">
						Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus.
					</div>

					<div class="tab-pane" id="message-tab">
						Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet.
					</div>
				</div>
			</div>	
			<div class="col-sm-3">
				
	
			</div>
		</div>
	</div>
	<!-- Trigger the modal with a button -->


<!-- edit Bio Modal -->
<div id="bioModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Bio</h4>
      </div>
      <div class="modal-body">
      	<span  class="text-success info-area"></span>
        <form id="update_bio" method="POST" action="{{ route('update.Bio')}}">
        	{{ csrf_field() }}
        	<textarea name='bio' class="form-control" id="bio" placeholder="Enter your bio here" >{{ trim($user->bio)}}
        	</textarea>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit"  form="update_bio" id="update-bio-btn" class="btn btn-success">Update</button>
      </div>
    </div>

  </div>
</div>
<!--upload profile Modal -->
<div id="uploadModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">upload profile image</h4>
      </div>
      <div class="modal-body">
      	<span  class="text-success info-area"></span>
        <form id="upload_profile" method="POST" action=" {{ route('profile.image.upload')}}" enctype="multipart/form-data">
        	{{ csrf_field() }}
        	<input type="file" name='profile_image' id="profile_image" class="form-control" >
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit"  form="upload_profile"  class="btn btn-success">Upload</button>
      </div>
    </div>

  </div>
</div>

<!--upload profile Modal -->
<div id="uploadCoverModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">change cover photo</h4>
      </div>
      <div class="modal-body">
      	<span  class="text-success info-area"></span>
        <form id="upload_cover" method="POST" action=" {{ route('profile.cover.upload')}}" enctype="multipart/form-data">
        	{{ csrf_field() }}
        	<input type="file" name="cover_image" id="cover_image" class="form-control" >
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit"  form="upload_cover"  class="btn btn-success">Upload</button>
      </div>
    </div>

  </div>
</div>
</div>
@include("partials.viewImage")
@endsection
@section('script')
	<script type="text/javascript" src=" {{ asset('js/profile_page.js') }}"></script>
@endsection