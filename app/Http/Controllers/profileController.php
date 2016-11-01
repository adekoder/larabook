<?php

namespace App\Http\Controllers;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\User;
use App\Http\Requests\updateProfileRequest;
use DB;
use App\profileImage;
use Illuminate\Support\Facades\Storage;
class profileController extends Controller
{

    
    public function  Show($user_id = null)
    {
        if( is_null($user_id) )
        {
            $user = User::findOrFail(Auth::user()->id);
        }else
        {
            $user = User::findOrFail($user_id);   
        }
    	

    	return view('profile', ['user'=> $user]);
    }
    public function editProfile()
    {	
    	
    	//dd(Auth::user()->id);
    	$user = User::find(Auth::user()->id);
    	return view('edit_profile', ['user' => $user]);
    }
    public function updateProfile(updateProfileRequest $request)
    {
    	$user = User::where('id' , Auth::user()->id)
    				->update([
    					'firstname' => $request->firstname,
    					'lastname' => $request->lastname,
    					'email' => $request->email,
    					'nationality' => $request->nationality
    					]);
    	if($user)
    	{
    		return response()->json($user, 200);
    	}else
    	{
    		return response()->json($user, 404);
    	}
    	
    }
    public function updateBio(Request $request)
    {
    	$this->validate($request ,
    	 [
    	 	'bio' => 'max:200'
    	]);

    	$user = User::where('id' , Auth::user()->id)
    				->update([
    					'bio' => trim($request->bio)
    				]);

    	$user_bio = $this->getBio();
    	if($user)
    	{
    		return response()->json( $user_bio->toJson(), 200);
    		//return dd($user_bio->bio);
    	}else
    	{
    		return response()->json($user, 404);
    	}

    }
    protected function getBio()
    {
    	
    	$bio = DB::table('users')->select('bio')->where('id', Auth::user()->id)->get();

    	return $bio;
    }

    public function profileImageUpload(Request $request)
    {
        
    	// validation logic....
        //dd($request->file("profile_image"));
        $errorMessages = array(
            'profile_image.required' => 'You can\'t upload An Empty file',
            'profile_image.mimes' => 'the file uplaod must be an image and in either png or jpeg format'
        );

    	$file = array("profile_image" => $request->file("profile_image"));

    	 $validate = Validator::make($file , [

    	 	"profile_image" => "required|mimes:jpeg,png|max:2048"

    	 ] , $errorMessages)->validate();
         // validation logic ends....

         $extension = $request->file("profile_image")->extension();

         $file_name = "profile_image_user_".Auth::user()->id ."_".rand(0000,  9999)."." . $extension; 

         $current_files = Storage::files("public/profile_images");
         //dd($current_files);
         $pattern = '/profile_image_user_'.Auth::user()->id . '/';
         //dd($pattern);
         foreach ($current_files as $file)
         {
            //dd($file);
            if(preg_match($pattern , $file))
            {
               
                 Storage::delete($file);
                 //dd("match");
            }
           
         }
         //dd($current_file);
    	$path =  $request->file("profile_image")->storeAs("profile_images", $file_name,'public');
        $stored = $this->storeImage($path , "profile_image_link");
        if($stored)
        {
            return response()->json(asset(Storage::url($path)) , 200);
        }
    	
    }
   
    public function coverImageUpload(Request $request)
    {
        // validation logic....
        //dd($request->file("profile_image"));
        $errorMessages = array(
            'cover_image.required' => 'You can\'t upload An Empty file',
            'cover_image.mimes' => 'the file uplaod must be an image and in either png or jpeg format'
        );

        $file = array("cover_image" => $request->file("cover_image"));

         $validate = Validator::make($file , [

            "cover_image" => "required|mimes:jpeg,png|max:2048"

         ] , $errorMessages)->validate();
         // validation logic ends....

         $extension = $request->file("cover_image")->extension();

         $file_name = "cover_image_user_".Auth::user()->id ."_".rand(0000,  9999)."." . $extension; 

         $current_files = Storage::files("public/cover_images");
         //dd($current_files);
         $pattern = '/cover_image_user_'.Auth::user()->id . '/';
         //dd($pattern);
         foreach ($current_files as $file)
         {
            //dd($file);
            if(preg_match($pattern , $file))
            {
               
                 Storage::delete($file);
                 //dd("match");
            }
           
         }
         //dd($current_file);
        $path =  $request->file("cover_image")->storeAs("cover_images", $file_name,'public');
        $stored = $this->storeImage($path , "cover_image_link");
        if($stored)
        {
            return response()->json(asset(Storage::url($path)) , 200);
        }
    }

    protected function storeImage($path , $field)
    {
        $record_exist = profileImage::where("user_id" , Auth::user()->id )->get();

        //dd($record_exist);
        if(count($record_exist) > 0)
        {
            $new_record = profileImage::where('user_id' , Auth::user()->id)
                                        ->update([
                                            $field => $path
                                        ]);
        }
        else
        {
            $new_record = new profileImage();
            $new_record->user_id = Auth::user()->id;
            $new_record->$field = $path;
            $new_record->save();
        }

        return true;
    }

}
