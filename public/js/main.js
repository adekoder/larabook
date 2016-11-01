$(document).ready(function()
{

	window.onLoad = get_all_post();
	

	$("#post-form").on('submit' , sendPost);
	
	function toggle_get_comments(e)
	{

		e.preventDefault();
		//alert("clicked");
		var section = $(this).parentsUntil(".post_list").children('.comments-section');
		section.slideToggle();
	}


	// function sending post request to save post 

	function sendPost(e)
	{
		e.preventDefault();
		var url = "post/create";

		var formData = new FormData(this);
		console.log(formData);
		$.ajax({
			'type': "POST",
			url: url,
			data: formData,
			contentType: false,       // The content type used when sending data to the server.
			cache: false,             // To unable request pages to be cached
			processData:false,
			Datatype: "json",
			beforSend: function ()
			{

			},
			success: function(response)
			{

				if(user_image.length == 0)
				{
					user_image = "assets/images/users/user1.png";
				}
				var html;
				
					html = create_post_html(user_image , user_name , response.updated_at, response.post_text, response.post_image);

				// getting the frist div in the list of post.....
				var target_content_length = $("#target").html().length;
				if(target_content_length < 1 )
				{
					$("#target").html(html);
				}else
				{
					$("#target").children("div.post-list:first").before(html);
				} 
				
				$("#info-area").toggleClass("text-success").text("new post created ").fadeIn(1000).fadeOut(5000);
				$("#post-input").val("");
				$('#input-file').val("");

			},
			error: function (response)
			{
				console.log(response.responseText);
				$.each( JSON.parse(response.responseText) , function (index, value)
				{
					
					$('#info-area').removeClass("text-success").addClass('text-danger').text(value).fadeIn(1000).fadeOut(5000);
					
				});
			}

		}) ;
	}

function get_all_post ()
{
	$.get("posts/show" , function (response)
	{	
		
		var target = $("#target");
		var html  ="";
		console.log(response);
		/*for(i = 0 ; i < response.length ; i++)
		{
			console.log(response[i].firstname);
			var value = response[i];
			html += create_post_html( value.profile_image_link , value.firstname , value.created_at , value.post_text , value.post_image);
		}*/
		$.each(response , function(index ,value)
		{	
			//console.log(value);

			var user_name = value.firstname + " " + value.lastname ;
			html += create_post_html( value.profile_image_link , user_name , value.created_at , value.post_text , value.post_image);
		})
		//console.log(html);
		target.html(html);
		$(".comments-action").on('click' , toggle_get_comments);
	});
	
}
//console.log(create_post_html());
function create_post_html(user_image , post_user , post_time , post_text , post_image ){
	var html;
		html=	"<div class='card post-list'>";
		html+=					"<div class='details'>"
		html+=					'<img src="http://larabook.io/storage/' + user_image +'"  class="medium-sm-img img-thumbnail left"\>'
		html+=						"<h4><a href='' class='text-blue-800  text-bold upper user-name' >" +post_user +" </a><br> <small class='time'>" + post_time +"</small></h4>"

		html+=					"</div>";
		if(post_text !== null)
		{
			html+=					"<div class='post-text'><p>"+ post_text +"</p></div>";
		}
		
		if(post_image !== null)
		{
			html+=					"<div class='post-image'><img src=http://larabook.io/storage/" + post_image +"\></div>";
		}
		
		html+=					'<hr>';
		html+=					'<div class="stat">';
		html+=						'<span class="text-bold left like-count"" ><span class="badge bg-blue-800"><i class="fa fa-thumbs-up"></i></span>8</span>';
		html+=						'<span class="text-bold text-blue-800 right"> <span class="comments-count">12</span>comments</span>';
		html+=					'</div>';
		html+=					'<hr>';
		html+=					'<div class="action-section">';
		html+=						'<ul>';
		html+=							"<li><a href=''><i class='fa fa-thumbs-up'></i> like</a></li>";
		html+=							'<li><a href="" class="comments-action" ><i class="fa fa-comments"></i> comments</a></li>';
		html+=							'<li><a href=""><i class="fa fa-share"></i> share</a></li>';
		html+=						'</ul>';
		html+=					'</div>';
		html+=					'<hr>';
		html+=					"<div class='comments-section'></div>";
		html+=				"</div>";
	
	return html;


}
	

						



	
});