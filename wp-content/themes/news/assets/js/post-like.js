(function($)
{
	"use strict";
	$(document).ready(function() {
		$('body').on('click','.sv-post-like',function(event){
			event.preventDefault();
			var heart = $(this);
			var post_id = heart.data("post_id");
			heart.html("<i id='icon-like' class='icon-like'></i><i id='icon-gear' class='icon-gear'></i>");
			$.ajax({
				type: "post",
				url: ajax_var.url,
				data: "action=sv-post-like&nonce="+ajax_var.nonce+"&sv_post_like=&post_id="+post_id,
				success: function(count){
					if( count.indexOf( "already" ) !== -1 )
					{
						var lecount = count.replace("already","");
						if (lecount === "0")
						{
							lecount = "Like";
						}
						heart.prop('title', 'Like');
						heart.removeClass("liked");
						heart.html("<i id='icon-unlike' class='icon-unlike'></i>&nbsp;"+lecount);
					}
					else
					{
						heart.prop('title', 'Unlike');
						heart.addClass("liked");
						heart.html("<i id='icon-like' class='icon-like'></i>&nbsp;"+count);
					}
				}
			});
		});
	});
})(jQuery)
