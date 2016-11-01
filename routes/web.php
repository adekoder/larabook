<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', [
	'uses' => 'pageController@Index',
	'as' => 'index'
])->middleware('sessionCheck');

Route::post('/register' , [
	'uses' => 'registrationController@Register',
	'as' => 'register'
]);
Route::post('/login' , [
	'uses' => 'loginController@Login',
	'as' => 'login'
]);

Route::group(['middleware' => 'auth'] , function()
{
	Route::get("/dashboard" , [
		'uses' => 'pageController@Dashboard',
		'as' => 'dashboard'
	]);

	Route::get("/logout" , [
		"uses" => 'loginController@Logout',
		'as' => 'logout'
	]);
	Route::get('/profile/edit' , [
		'uses' => 'profileController@editProfile',
		'as' => 'profile.edit'
	]);
	Route::post('/profile/edit' , [
		'uses' => 'profileController@updateProfile',
		'as' => 'profile.update'
	]);
	Route::get("/profile/{user_id?}" , [
		'uses' => 'profileController@Show',
		'as' => 'profile.show'
	]);
	Route::post("/profile/bio/edit", [
		'uses' => 'profileController@updateBio',
		'as' => 'update.Bio'
	]);

	Route::post("/profile/image/upload" , [
		"uses" => 'profileController@profileImageUpload',
		'as' => 'profile.image.upload'
	]);
	Route::post("/profile/cover/upload" , [
		"uses" => 'profileController@coverImageUpload',
		'as' => 'profile.cover.upload'
	]);
	Route::get("/posts/show" , [
		'uses' => "postsController@getAllPosts",
		'as' => 'post.show'
	]);
	Route::post("/post/create" , [
		'uses' => 'postsController@storePost',
		'as' => 'post.create'

	]);
	
});