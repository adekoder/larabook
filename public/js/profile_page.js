$(document).ready(function (){
	
			$('#update_bio').on('submit' , update_bio);
			$("#upload_profile").on('submit' , upload_profile);
			$("#upload_cover").on('submit' , upload_cover);
		function update_bio(e)
		{
					e.preventDefault();
					var url = "profile/bio/edit";
					var formData = $(this).serialize();
					var updateBtn = $('#update-bio-btn');
					updateBtn.text("updating Bio ....");
					$.ajax({
						type: 'POST',
						url: url,
						data: formData,
						dataType: 'json',
						beforeSend: function ()
						{

						},
						success: function (response)
						{
							console.log(response);
							$.each(JSON.parse(response) , function (index, value)
							{
								//console.log(value.bio);
								$("#bio-section").text(value.bio).parent().toggleClass("fade-notify");
								$(".info-area").text("Bio updated").fadeIn(1000).fadeOut(5000);
								updateBtn.text("update");
								//$.each(value, function (index, value))
							});
							
						},
						error: function(response)
						{
							console.log(JSON.parse(response.responseText))
							$.each( JSON.parse(response.responseText) , function (index, value)
							{
								$('#'+index).addClass('error-border');
								$('.info-area').toggleClass("text-success").addClass('text-danger').text(value);
								$('#'+index).on('keyup' ,function ()
								{
									$(this).removeClass('error-border');
								});
							});
						}
					});
		}


		function upload_profile(e)
		{
			e.preventDefault();
			
			var formData = new FormData(this);
			
			for(var file of formData.entries())
			{
				console.log(file[0] + file[1]);
			}
			
			//formData.append("profile_image" , file);
			//console.log(formData);

			var url = "profile/image/upload";

			$.ajax({
				type: "POST",
				url: url,
				data: formData,
				contentType: false,       // The content type used when sending data to the server.
				cache: false,             // To unable request pages to be cached
				processData:false,
				success: function(response)
				{
					$(".info-area").removeClass("text-danger").text("profile image uploaded").fadeIn(1000).fadeOut(5000);
					$("#profile_image").val("");
					$(".user_image").attr("src", response);
					
				},
				error: function(response)
				{
					console.log(response.responseText);

							$.each( JSON.parse(response.responseText) , function (index, value)
							{
								$('#'+index).addClass('error-border');
								$('.info-area').removeClass("text-success").addClass('text-danger').text(value);
								
							});
				}

			});
		}

		function upload_cover(e)
		{
			e.preventDefault();
			
			var formData = new FormData(this);
			for(var file of formData.entries())
			{
				console.log(file[0] + file[1]);
			}
			
			//formData.append("profile_image" , file);
			//console.log(formData);

			var url = "profile/cover/upload";

			$.ajax({
				type: "POST",
				url: url,
				data: formData,
				contentType: false,       // The content type used when sending data to the server.
				cache: false,             // To unable request pages to be cached
				processData:false,
				success: function(response)
				{
					$(".info-area").removeClass("text-danger").text("profile image uploaded").fadeIn(1000).fadeOut(5000);
					$("#cover_image").val("");
					$("#cover-photo").css("background-image", "url("+ response +")");
					
				},
				error: function(response)
				{
					console.log(response.responseText);

							$.each( JSON.parse(response.responseText) , function (index, value)
							{
								$('#'+index).addClass('error-border');
								$('.info-area').removeClass("text-success").addClass('text-danger').text(value);
								
							});
				}

			});
		}

		// function for image view ....
			$("#user_image").on('click' , function ()
			{
				$("#view-image").attr("src" , $(this).attr("src"));
			});
		// function for image view .... ends ...

});
