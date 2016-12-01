<?php


// Use custom page template for post type
add_filter('single_template', 'shift8_portfolio_template');

function shift8_portfolio_template($single) {
        global $wp_query, $post;

        /* Checks for single template by post type */
        if ($post->post_type == "shift8_portfolio"){
                if(file_exists(PLUGIN_PATH . '/template/shift8_portfolio_template.php')) {
                        return PLUGIN_PATH . '/template/shift8_portfolio_template.php';
                }
        }
        return $single;
}

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
