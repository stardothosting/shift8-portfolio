<?php

/**
 * The template for displaying all single portfolio items
 *
*/

get_header(); ?>

	<div id="shift8-portfolio-single-client" class="">
	<main id="main" class="site-main" role="main">
	<?php
	while ( have_posts() ) {
		the_post();

		// Get fields and assign to variables
		$client_name = get_the_title();
		$description = get_the_content();

		// Get images
		$main_image_display = null;
		$main_image_url = get_post_meta(get_the_ID(),'shift8_portfolio_image',true);
		$main_image = wp_get_attachment_image_src(shift8_portfolio_get_image_id($main_image_url), 'large');
		if ($main_image) {
			$main_image_display = '<div class="shift8-portfolio-single-client-feature"><img src="' . $main_image[0] . '"></div>';
		}

		// Get gallery
		$gallery_display = null;
		$gallery_array = explode(',', get_post_meta(get_the_ID(),'shift8_portfolio_gallery',true));
		if (is_array($gallery_array)) {
			$gallery_display .= '<ul class="shift8-portfolio-gallery">';
			$gallery_display .= '<section data-featherlight-gallery data-featherlight-filter="a">';
			foreach ($gallery_array as $gallery_item) {
				$gallery_display .= '<li><a href="' . wp_get_attachment_url($gallery_item) . '"><img id="shift8-portfolio-item-' . $gallery_item . '" src="' . wp_get_attachment_thumb_url($gallery_item) . '"></a></li>';
			}
			$gallery_display .= '</section></ul>';
		}


	} // End of the loop.
	?>

        <!-- Client page -->
        <div class="row shift8-portfolio-single-row1">
            <div class="col-md-12">
            <p style="text-align: center;"><h1 class="shift8-portfolio-heading"><?php echo $client_name; ?></span></h1></p>
            <div class="shift8-portfolio-title-border" style="text-align: center;"></div>
            </div>
        </div>
        <div class="row shift8-portfolio-single-row2">
            <div class="col-md-12">
            <center><div class="shift8-row2-container"><?php echo $short_description; ?></div></center>
            <?php echo $main_image_display; ?>
            </div>
        </div>
	<?php if ($gallery_display) { ?>
        <div class="row shift8-portfolio-single-row3">
            <div class="col-md-12">
            <?php echo $gallery_display; ?>
            </div>
        </div>
	<?php } ?>
        <div class="row shift8-portfolio-single-row4">
            <div class="col-md-12">
            <?php echo $description; ?>
            </div>
        </div>


        </main><!-- #main -->
    </div><!-- #primary -->

<script type='text/javascript'>
jQuery(document).ready(function(){
	jQuery('a.gallery').featherlightGallery({
		previousIcon: '«',
		nextIcon: '»',
		galleryFadeIn: 300,
		openSpeed: 300
	});
});
</script>
<?php
get_footer();
