@extends('layouts.master')

@section('style')

	<link rel="stylesheet" type="text/css" href="{{ asset('css/custom.css')}}">
	
@endsection

@section('navbar')
	@include('partials.dashboardNav')
@endsection
@section('content')
	<div class="row">
		<div class="card card-big">
			<div class="page-header ">
				@if(count($errors) > 0)
					@foreach($errors->all() as $error)
						<div class="alert alert-danger">
							<span>{{ $error }}</span>
						</div>
						
					@endforeach
				@endif
				<h2 class="text-info upper">Edit Profile: {{ " ". Auth::user()->firstname}} </h2>
			</div>
			<span id="info-area"></span>
			<form class="form form-horizontal" id="update_info" method="POST" action="{{ route('profile.update') }}">
				{{ csrf_field() }}
				<div class="container">
					<div class="form-group">
						<label for="firstname">Firstname</label>
						<input type="text" name="firstname" class="form-control" id="firstname" value="{{ $user->firstname}}">
					</div>
					<div class="form-group">
						<label for="firstname">Lastname</label>
						<input type="text" name="lastname" class="form-control" id="lastname" value="{{ $user->lastname}}">
					</div>
					<div class="form-group">
						<label for="firstname">email</label>
						<input type="email" name="email" class="form-control" id="email" value="{{ $user->email }}">
					</div>
					<div class="form-group">
						<label for="firstname">Nationality</label>
						<input type="text" name="nationality" class="form-control" id="nationality" value="{{ isset($user->nationality)? $user->nationality: "" }}">
					</div>
					<button type="submit" class="btn btn-success "> Update Profile </button>
				</div>
			</form>
		</div>
		

	</div>
@endsection
@section('script')
	<script>
		$('#update_info').on('submit' , update_info);
		function update_info(e)
		{
			e.preventDefault();
				
			var url = "{{ route('profile.update')}}";
			var formData = $(this).serialize();
			console.log(formData);
			$.ajax({
				type: 'POST',
				url: url,
				data: formData,
				dataType: 'json',
				beforeSend: function()
				{
					$("#info-area").html("<i class='fa fa-spin fa-spinner'></i> Updating record please wait");
				},
				success: function(response)
				{
					if(response)
					{
						console.log('1');
						$('#info-area').removeClass('text-danger').addClass('text-success').text("Profile successfully Updated").fadeIn(1000).fadeOut(5000);
						$('#login_user').text($('#firstname').val());
					}
					else
					{
						console.log("0");
						$('#info-area').addClass('text-danger').text("Erorr Updating your profile try again").fadeIn(1000).fadeOut(5000);
					}
					

					
				},
				error: function(response)
				{
					console.log( JSON.parse(response.responseText) );
					$.each( JSON.parse(response.responseText) , function (index, value)
					{
						$('#'+index).addClass('error-border');
						$('#info-area').addClass('text-danger').text('All input must be filled ');
						$('#'+index).on('keyup' ,function ()
						{
							$(this).removeClass('error-border');
						});
					});
				}


			});
		}		

	</script>
@endsection