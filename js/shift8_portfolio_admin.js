jQuery(document).ready(function() {

/*    jQuery('#shift8_portfolio_upload_image_button').click(function() {

        formfield = jQuery('#shift8_portfolio_image').attr('name');
        tb_show( '', 'media-upload.php?type=image&amp;TB_iframe=true' );
        return false;
    });

    window.send_to_editor = function(html) {

        imgurl = jQuery('img',html).attr('src');
        jQuery('#shift8_portfolio_image').val(imgurl);
        tb_remove();
    }  */

	var meta_image_frame;
        // Runs when the image button is clicked.
        jQuery('#shift8_portfolio_image_button').click(function(e){
		console.log('clicked');

                // Prevents the default action from occuring.
                e.preventDefault();

                // If the frame already exists, re-open it.
                if ( meta_image_frame ) {
                        meta_image_frame.open();
                        return;
                }

                // Sets up the media library frame
                meta_image_frame = wp.media.frames.meta_image_frame = wp.media({
                        title: shift8_portfolio_image.title,
                        button: { text:  shift8_portfolio_image.button },
                        library: { type: 'image' }
                });

                // Runs when an image is selected.
                meta_image_frame.on('select', function(){

                        // Grabs the attachment selection and creates a JSON representation of the model.
                        var media_attachment = meta_image_frame.state().get('selection').first().toJSON();

                        // Sends the attachment URL to our custom image input field.
                        jQuery('#shift8_portfolio_image').val(media_attachment.url);
                });

                // Opens the media library frame.
                meta_image_frame.open();
        });


});
