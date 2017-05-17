<?php
/**
 * Plugin Name: Shift8 Portfolio
 * Plugin URI: https://github.com/stardothosting/shift8-portfolio
 * Description: This is a Wordpress plugin that allows you to easily manage and showcase a grid of your portfolio items. If an item has a "Writeup" or additional information, then clicking the image will go to the single portfolio item page. If not, then it will expand to a larger image.
 * Version: 1.6
 * Author: Shift8 Web 
 * Author URI: https://www.shift8web.ca
 * License: GPLv3
 */

require_once(plugin_dir_path(__FILE__).'components/enqueuing.php' );
require_once(plugin_dir_path(__FILE__).'components/custompost.php' );
require_once(plugin_dir_path(__FILE__).'components/metabox.php' );

// Get image ID from URL
function shift8_portfolio_get_image_id($image_url) {
    global $wpdb;
    $attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url ));
        return $attachment[0];
}

// Shortcode for multiple portfolio system
function shift8_portfolio_shortcode($atts){
	extract(shortcode_atts(array(
		'numposts' => '-1',
		'numperrow' => '6',
	), $atts));

	$args = array(
		'numberposts' => -1,
		'posts_per_page' => -1,
		'post_type' => 'shift8_portfolio',
		'post_status' => 'publish',
		'orderby' => 'date',
		'order' => 'DESC',
	);

	// check if number per row is divisible by 12.
	if ($numperrow %12 != 0) {
		$numperrow = 12 / $numperrow;
	} else {
		$numperrow = 6;
	}

	
	global $post;
	$out = '';
	$posts = new WP_Query($args);
	if ($posts->have_posts()) {
		$out .= '<div id="shift8-peffect" class="shift8-portfolio-container effects clearfix row" >';
		while ($posts->have_posts()) {
			$posts->the_post();
			// get event image
			$work_image_url = esc_url(get_post_meta(get_the_ID(),'shift8_portfolio_image',true));
			$work_image = wp_get_attachment_image_src(shift8_portfolio_get_image_id($work_image_url), 'large');

			$work_image_display = null;
			// get link to work page
			$work_link = get_post_permalink($posts->ID);
			// get gallery ids
			$work_gallery = explode(',', get_post_meta(get_the_ID(),'shift8_portfolio_image',true));

			if (!empty($work_image)) {
				$work_image_display = '<div class="shift8-portfolio-image-cropped" style="background-image: url(\'' . $work_image[0] . '\');"><div class="shift8-portfolio-image-layer"><h2>' . get_the_title() . '</h2></div></div>';
			}
			// get project name
			$out .= '<div class="col-lg-' . $numperrow . ' col-md-' . $numperrow . ' col-xs-12 shift8-portfolio-thumb" id="shift8-portfolio-' . get_the_ID() . '">
			'. $work_image_display .'
			<div class="shift8-portfolio-overlay">
			<a href="' . $work_link . '" class="shift8-portfolio-expand">+</a>
			</div>
			</div>
			<script>
				jQuery("#shift8-portfolio-' . get_the_ID() . '").click(function() {
				window.location = jQuery(this).find("a").attr("href");
				return false;
				});
			</script>
			';
		}
	} else {
		return;
	}
	$out .= '</div></div>';
	wp_reset_query();
	return html_entity_decode($out);
}
add_shortcode('shift8_portfolio', 'shift8_portfolio_shortcode');
