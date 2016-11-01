@extends('layouts.master')
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/custom.css') }}">
@endsection
@section('navbar')
    @include('partials.indexNav')
@endsection

@section('content')

    <div class='row'>
        <div class="container-fluid">
            <div class='col-sm-6'>
                <div class="catch-phrase">
                    
                    <h1 class="text-center">Welcome To laraBook</h1>
                </div>

            </div>

            <div class='col-sm-6'>
                <div class="sign-up-div">
                    @if(count($errors) > 0)
                        @foreach($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    @endif
                    <h1 class="text-center">Join To laraBook Today</h1>
                    <hr>
                    <span class='text-blue'>New to Larabook Signup here</span>
                    <div class="signup-form">
                        <form class="form-horizontal" autocomplete="on" method="Post" action="{{ route('register') }}">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input type="text" name="firstname" class="form-control input-lg" placeholder="Firstname"   value="{{ old('firstname')}}" required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input type="text" name="lastname" class="form-control input-lg"  placeholder="Lastname"    value="{{ old('lastname')}}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="email" name="email" placeholder="Example@example.com" class="form-control input-lg" 
                                value="{{ old('email')}}" required>
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" placeholder="New Password" class="form-control input-lg" 
                                value="{{ old('email')}}" required>
                            </div>
                            <div class="form-group">
                                <label  for="date">Date of Birth</label>
                                <input type="date" name="date_of_birth"  class="form-control input-lg" value="{{ old('date_of_birth')}}" required>
                            </div>
                            <div class="form-group">
                                <label  for="gender">Gender: </label>
                                 <label > <input type="radio" name="gender"  value="male"  required>    Male</label>
                                 <label> <input type="radio" name="gender"  value="female" required>    Female</label>
                            </div>
                            <div class="form-group">
                                <button type= 'submint' class="btn btn-success btn-lg"> Sign Up</button>
                            </div>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        </form>
                    </div>
                </div>

            </div>


        </div>
    </div>
@endsection

@section('script')
    <script >
         $('#error_info').delay(3000).fadeOut(1000);   

    </script>
@endsection