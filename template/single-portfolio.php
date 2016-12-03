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
			foreach ($gallery_array as $gallery_item) {
				$gallery_display .= '<li><img id="shift8-portfolio-item-' . $gallery_item . '" src="' . wp_get_attachment_thumb_url($gallery_item) . '"></li>';
			}
			$gallery_display .= '</ul>';
		}


	} // End of the loop.
	?>

        <!-- Client page -->
        <div class="row shift8-portfolio-single-row1">
            <div class="col-md-12">
            <!--<p style="text-align: left;">
            <div class="shift8-portfolio-back">
            <svg version="1.1" id="Flash" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                 viewBox="0 0 20 20" enable-background="new 0 0 20 20" xml:space="preserve">
            <path d="M6.803,18.998c-0.194-0.127,3.153-7.16,3.038-7.469c-0.116-0.309-3.665-1.436-3.838-1.979
                c-0.174-0.543,7.007-8.707,7.196-8.549c0.188,0.158-3.129,7.238-3.039,7.469c0.091,0.23,3.728,1.404,3.838,1.979
                C14.109,11.024,6.996,19.125,6.803,18.998z"/>
            </svg>
            </div>
            <span class="shift8-portfolio-back-heading"><a href="<?php echo get_site_url(); ?>/our_work">Back to Our Work Page</a></span></p>-->
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

<?php
get_footer();
