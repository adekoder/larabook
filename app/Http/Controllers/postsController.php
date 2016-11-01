<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Posts;
use App\User;
use DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class postsController extends Controller
{
	protected $post_id ;
	protected $user_id;
	protected $post_text;
	protected $post_image;
 	
 	public function getAllPosts()
 	{
 		// return all post related to the auth user ....
 		return response()->json($this->postRetriver(),  200);
 	}

 	/**
 	*function retriving post 
 	*
 	*@retrun posts 
 	*
 	*/
 	protected function postRetriver()
 	{
 		$posts = DB::table('posts')
 					->join('users' , 'posts.user_id' , '=' , 'users.id')
 					->join('profile_images' , 'posts.user_id' ,'=', 'profile_images.user_id')
 					->select('posts.*' , 'users.firstname' , 'users.lastname' , 'profile_images.profile_image_link')
 					->where('posts.user_id' , Auth::user()->id)
 					->orderBy('posts.created_at' , 'DSCE')
 					->get();
 		return $posts;
 	} 
 	public function storePost(Request $request)
 	{
 		

 		//converting object to array....
 		$data_array = array('post_file' => $request->file('post_file') , 'post_text' => $request->post_text);
 		$rules = [
 			'post_text' => 'required_without:post_file',
 			
 		];
 		$message = [
 			"required_without" => "you can't create empty post"
 		];
 		// create a custom validation....
 		$validator = Validator::make($data_array, $rules , $message)->validate();
 		
 		$this->user_id = Auth::user()->id;
 		$this->post_id = $this->generatePostId();
 		$this->post_text = $request->post_text;
 		$this->post_image = $request->file("post_file");

 		if( !isset($this->post_image) )
 		{
 			$post = $this->store($this->post_id ,$this->user_id , $this->post_text);
 		}
 		else
 		{
 			$image_link = $this->processImage($this->post_image ,	$this->post_id , $this->user_id);

 			$post = $this->store($this->post_id ,$this->user_id , $this->post_text , $image_link);
 			
 		}
 		
 		return response()->json($post , 200);

 	}  

 	protected function processImage($file , $post_id , $user_id)
 	{
 		$image = $file;
 		$file = array('post_file' => $file);

 		$rules = [
 			'post_file' => 'mimes:png,jpeg'
 		];

 		$validate = Validator::make($file , $rules , [

 				'post_file.mimes' => 'the file uplaod must be an image and in either png or jpeg format'

 		])->validate();

 		$extension = $image->extension();
 		$filename = "post_" . $post_id . "_" . $user_id. "_" . ".$extension" ;
 		$path = $image->storeAs("post_images" , $filename , 'public');
 		return $path;

 	}
 	protected function store($post_id , $user_id , $post_text = null, $image_link = null)
 	{

 		$post = Posts::create([
 				'user_id' => $this->user_id,
 				'post_id' => $this->post_id,
 				'post_text' => $this->post_text,
 				'post_image' => $image_link
 			]);
 		return $post;
 	}

 	protected function generatePostId()
 	{	$post_id = rand(1111, 9999);
 		return $post_id ;
 	}
}
