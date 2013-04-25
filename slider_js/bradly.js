jQuery(document).ready(function () {

	

	window.restore_send_to_editor = window.send_to_editor;
	


	jQuery("#widget_upload_image_button").live('click', function (){
		
		tb_show('', 'media-upload.php?type=image&TB_iframe=true&flash=0&simple_slideshow=true');

		widget_content = jQuery(this).parent();
		
		window.send_to_editor = function(html) {
		
			imgurl = jQuery('img',html).attr('src');
			
			
			old_val = jQuery("[id^=widget-nivosliderwidget-]").val();
			if(old_val!=" ")
				jQuery("[id^=widget-nivosliderwidget-]").val(old_val+ ", " + imgurl);
			else
				jQuery("[id^=widget-nivosliderwidget-]").val(imgurl);
			
			jQuery("[id$=savewidget]").val("Save");
			
			tb_remove();
			return false;
		};

	});

});
