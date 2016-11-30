<?php
/**
 * Plugin Name: Shift8 Full Width Portfolio
 * Plugin URI: https://github.com/stardothosting/shift8-full-width-portfolio
 * Description: This is a Wordpress plugin that allows you to easily manage and showcase a full width grid of your portfolio items. If an item has a "Writeup" or additional information, then clicking the image will go to the single portfolio item page. If not, then it will expand to a larger image.
 * Version: 1.0.0
 * Author: Shift8 Web 
 * Author URI: https://www.shift8web.ca
 * License: GPLv3
 */

// Load Front end CSS and JS
function shift8_portfolio_scripts() {
	wp_enqueue_style( 'shift8bootstrap', get_template_directory_uri() . '/bootstrap/css/bootstrap.css');
	wp_enqueue_style( 'shift8portfolio', get_template_directory_uri() . '/css/shift8_portfolio.css');
}
add_action( 'wp_enqueue_scripts', 'shift8_portfolio_scripts', 12,1 );

// Register admin scripts for custom fields
function load_shift8_portfolio_wp_admin_style() {
        wp_enqueue_media();
        wp_enqueue_script('media-upload');
        wp_enqueue_script('thickbox');
	wp_enqueue_style('thickbox');
        // admin always last
        wp_enqueue_style( 'shift8_portfolio_admin_css', plugin_dir_url( __FILE__ ) . 'css/shift8_portfolio_admin.css' );
        wp_enqueue_script( 'shift8_portfolio_admin_script', plugin_dir_url( __FILE__ ) . 'js/shift8_portfolio_admin.js' );
}
add_action( 'admin_enqueue_scripts', 'load_shift8_portfolio_wp_admin_style' );


// Register post type
add_action( 'init', 'register_cpt_shift8_portfolio' );

function register_cpt_shift8_portfolio() {

	$labels = array(
		'name' => __( 'Shift8 Portfolios', 'shift8_portfolio' ),
		'singular_name' => __( 'Shift8 Portfolio', 'shift8_portfolio' ),
		'add_new' => __( 'Add New', 'shift8_portfolio' ),
		'add_new_item' => __( 'Add New Shift8 Portfolio', 'shift8_portfolio' ),
		'edit_item' => __( 'Edit Shift8 Portfolio', 'shift8_portfolio' ),
		'new_item' => __( 'New Shift8 Portfolio', 'shift8_portfolio' ),
		'view_item' => __( 'View Shift8 Portfolio', 'shift8_portfolio' ),
		'search_items' => __( 'Search Shift8 Portfolios', 'shift8_portfolio' ),
		'not_found' => __( 'No shift8 portfolios found', 'shift8_portfolio' ),
		'not_found_in_trash' => __( 'No shift8 portfolios found in Trash', 'shift8_portfolio' ),
		'parent_item_colon' => __( 'Parent Shift8 Portfolio:', 'shift8_portfolio' ),
		'menu_name' => __( 'Shift8 Portfolios', 'shift8_portfolio' ),
	);

	$args = array(
		'labels' => $labels,
		'hierarchical' => false,
		'description' => 'Shift8 full width portfolio grid',
		'supports' => array( 'editor', 'title' ),
		'public' => false,
		'show_ui' => true,
		'show_in_menu' => true,
		'menu_position' => 5,
		'menu_icon' => 'dashicons-grid-view',
		'show_in_nav_menus' => false,
		'publicly_queryable' => false,
		'exclude_from_search' => true,
		'has_archive' => false,
		'query_var' => true,
		'can_export' => true,
		'rewrite' => true,
		'capability_type' => 'post'
	);

register_post_type( 'shift8_portfolio', $args );
}

// Add the Meta Box
function add_custom_meta_box() {
    add_meta_box(
        'custom_meta_box', // $id
        'Shift8 Portfolio Fields', // $title 
        'show_custom_meta_box', // $callback
        'shift8_portfolio', // $page
        'normal', // $context
        'high'); // $priority
}
add_action('add_meta_boxes', 'add_custom_meta_box');

// Field Array
$prefix = 'shift8_portfolio_';
$custom_meta_fields = array(
    array(
        'label'=> 'Main Image',
        'desc'  => 'This is the main image that is shown in the grid and at the top of the single item page.',
        'id'    => $prefix.'image',
        'type'  => 'media'
    ),
    array(
        'label'=> 'Gallery Images',
        'desc'  => 'This is the gallery images on the single item page.',
        'id'    => $prefix.'gallery',
        'type'  => 'gallery'
    ),
//    array(
//        'label'=> 'Single page or image expand',
//        'desc'  => 'Check if you want the user to arrive on the single portfolio page on click or to expand the image.',
//        'id'    => $prefix.'checkbox',
//        'type'  => 'checkbox'
//    ),
);

// Get image ID from URL
function shift8_portfolio_get_image_id($image_url) {
    global $wpdb;
    $attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url )); 
        return $attachment[0]; 
}

// The Callback
function show_custom_meta_box($object) {
	global $custom_meta_fields, $post;
	// Use nonce for verification
	echo '<input type="hidden" name="custom_meta_box_nonce" value="'.wp_create_nonce(basename(__FILE__)).'" />';

	// Begin the field table and loop
	echo '<table class="form-table">';
	foreach ($custom_meta_fields as $field) {
		// get value of this field if it exists for this post
		$meta = get_post_meta($post->ID, $field['id'], true);
		// begin a table row with
		echo '<tr>
		<th><label for="'.$field['id'].'">'.$field['label'].'</label></th>
		<td>';
		switch($field['type']) {
                        //case 'checkbox':
                        //echo '<input type="checkbox" name="'.$field['id'].'" id="'.$field['id'].'" ',$meta ? ' checked="checked"' : '','/>
                        //<label for="'.$field['id'].'">'.$field['desc'].'</label>';
                        //break;
			case 'media':
			$close_button = null;
			if ($meta) {
				$close_button = '<span class="shift8_portfolio_close"></span>';
			}
			echo '<input id="shift8_portfolio_image" type="hidden" name="shift8_portfolio_image" value="' . $meta . '" />
			<div class="shift8_portfolio_image_container">' . $close_button . '<img id="shift8_portfolio_image_src" src="' . wp_get_attachment_thumb_url(shift8_portfolio_get_image_id($meta)) . '"></div>
			<input id="shift8_portfolio_image_button" type="button" value="Add Image" />';
			break;
                        case 'gallery':
			$meta_html = null;
			if ($meta) {
				$meta_html .= '<ul class="shift8_portfolio_gallery_list">';
				$meta_array = explode(',', $meta);
				foreach ($meta_array as $meta_gall_item) {
					$meta_html .= '<li><div class="shift8_portfolio_gallery_container"><span class="shift8_portfolio_gallery_close"><img id="' . $meta_gall_item . '" src="' . wp_get_attachment_thumb_url($meta_gall_item) . '"></span></div></li>';
				}
				$meta_html .= '</ul>';
			} 
                        echo '<input id="shift8_portfolio_gallery" type="hidden" name="shift8_portfolio_gallery" value="' . $meta . '" />
			<span id="shift8_portfolio_gallery_src">' . $meta_html . '</span>
                        <div class="shift8_gallery_button_container"><input id="shift8_portfolio_gallery_button" type="button" value="Add Gallery" /></div>';
                        break;
		} //end switch
		echo '</td></tr>';
	} // end foreach
	echo '</table>'; // end table
}

// Save the Data
function save_custom_meta($post_id) {
	global $custom_meta_fields;
     
	// Verify nonce
	if (!wp_verify_nonce($_POST['custom_meta_box_nonce'], basename(__FILE__))) 
		return $post_id;
	// Check autosave
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
		return $post_id;
	// Check permissions
	if ('page' == $_POST['post_type']) {
		if (!current_user_can('edit_page', $post_id))
			return $post_id;
	} elseif (!current_user_can('edit_post', $post_id)) {
		return $post_id;
	}

	// Loop through meta fields
	foreach ($custom_meta_fields as $field) {
		$new_meta_value = $_POST[$field['id']];
		$meta_key = $field['id'];
		$meta_value = get_post_meta( $post_id, $meta_key, true );
		
		// If theres a new meta value and the existing meta value is empty
		if ( $new_meta_value && $meta_value == null ) {
			add_post_meta( $post_id, $meta_key, $new_meta_value, true );
		// If theres a new meta value and the existing meta value is different
		} elseif ( $new_meta_value && $new_meta_value != $meta_value ) {
			update_post_meta( $post_id, $meta_key, $new_meta_value );
		} elseif ( $new_meta_value == null && $meta_value ) {
			delete_post_meta( $post_id, $meta_key, $meta_value );
		}
	}
}

add_action('save_post', 'save_custom_meta');



// Shortcode for menu overlay system
function shift8_portfolio_shortcode($atts){
    extract(shortcode_atts(array(
        'numposts' => '-1',
    ), $atts));

    $args = array(
            'numberposts' => -1,
            'posts_per_page' => -1,
            'post_type' => 'our_work',
            'post_status' => 'publish',
            'orderby' => 'meta_value',
            'meta_key' => 'date_launched',
            //'meta_value' => date("Ymd"),
            //'meta_compare' => '>=',
            'order' => 'DESC',
        );

    global $post;
    $out = '';
    $posts = new WP_Query($args);
    if ($posts->have_posts()) {
        $out .= '<div id="effect-6" class="shift8-work-container effects clearfix row" >';
        while ($posts->have_posts()) {
            $posts->the_post();
            // get event image
            $work_image = get_field('main_image');
            $work_image_display = null;
            // get link to work page
            $work_link = get_post_permalink($posts->ID);

            if (!empty($work_image)) {
                $work_image_display = '<div class="shift8-work-image-cropped" style="background-image: url(\'' . $work_image['sizes']['large'] . '\');"><div class="shift8-work-image-layer"><h2>' . get_the_title() . '</h2></div></div>';
                //$work_image_display = '<div class="shift8-work-image-cropped"><img src="' . $work_image['sizes']['work-size'] . '"></div>';
            }
            // get project name
            $project_name = get_field('project_name');

            $out .= '<div class="col-lg-6 col-md-6 col-xs-12 shift8-thumb shift8-work-' . get_the_ID() . '">
                        '. $work_image_display .'
                        <div class="overlay">
                            <a href="' . $work_link . '" class="expand">+</a>
                            <a class="close-overlay hidden">x</a>
                        </div>.
                    </div>
                    <script>
                    jQuery(".shift8-work-' . get_the_ID() . '").click(function() {
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
