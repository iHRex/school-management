jQuery(document).ready(function($) {
	
	$('#upload_user_avatar_button').click(function() {
		
        tb_show('Upload image', 'media-upload.php?referer=teacher&type=image&TB_iframe=true&post_id=0', false);
        return false;
    });
	$('#upload_user_cover_button').click(function() {
		alert('hello');
       // tb_show('Upload image', 'media-upload.php?referer=teacher&type=image&TB_iframe=true&post_id=0', false);
        //return false;
    });
	
	window.send_to_editor = function(html) {
    var image_url = $('img',html).attr('src');
    $('#smgt_user_avatar_url').val(image_url);
    tb_remove();
	$('#upload_user_avatar_preview img').attr('src',image_url);
	}
	
	
	

});