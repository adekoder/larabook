<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
	protected $fillable = [
		'post_id', 'user_id', 'post_text', 'post_image'
	]; 
    
    public function user()
    {
    	return $this->belongsTo("App\User");
    }
}
