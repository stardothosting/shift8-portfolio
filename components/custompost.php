<?php

// Assign template to custom post type
add_filter( 'single_template', 'shift8_portfolio_custom_post_type_template' );
function shift8_portfolio_custom_post_type_template($single_template) {
     global $post;
     if ($post->post_type == 'shift8_portfolio' ) {
	if ( !file_exists(get_template_directory() . '/single-portfolio.php') ) {
		$single_template = plugin_dir_path(dirname(__FILE__)) . 'template/single-portfolio.php';
	} else {
		$single_template = get_template_directory() . '/single-portfolio.php';
	}
     }
     return $single_template;
     wp_reset_postdata();
}

// Register post type
add_action( 'init', 'shift8_portfolio_register_cpt' );

function shift8_portfolio_register_cpt() {

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
                'public' => true,
                'show_ui' => true,
                'show_in_menu' => true,
                'menu_position' => 5,
                'menu_icon' => 'dashicons-grid-view',
                'show_in_nav_menus' => false,
                'publicly_queryable' => true,
                'exclude_from_search' => true,
                'has_archive' => false,
                'query_var' => true,
                'can_export' => true,
		'rewrite' => array(
			'slug' => 'portfolio',
			'with_front' => true,
			'feeds' => true,
			'pages' => true
		),
                'capability_type' => 'post'
        );

register_post_type( 'shift8_portfolio', $args );
}
