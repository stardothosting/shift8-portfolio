<?php

// Load Front end CSS and JS
function shift8_portfolio_scripts() {
	// Bootstrap 
	wp_enqueue_style( 'shift8bootstrap', plugin_dir_url(dirname(__FILE__)) . 'bootstrap/css/bootstrap.min.css');
	// Featherlight
        wp_enqueue_style( 'shift8flcss', plugin_dir_url(dirname(__FILE__)) . 'css/featherlight.min.css');
        wp_enqueue_style( 'shift8flgallerycss', plugin_dir_url(dirname(__FILE__)) . 'css/featherlight.gallery.min.css');
        wp_enqueue_script( 'shift8fljs', plugin_dir_url(dirname(__FILE__)) . 'js/featherlight.min.js','','',true);
        wp_enqueue_script( 'shift8flgalleryjs', plugin_dir_url(dirname(__FILE__)) . 'js/featherlight.gallery.min.js','','',true);
	// Main CSS
        wp_enqueue_style( 'shift8portfolio', plugin_dir_url(dirname(__FILE__)) . 'css/shift8_portfolio.css');
}
add_action( 'wp_enqueue_scripts', 'shift8_portfolio_scripts', 12,1 );

// Register admin scripts for custom fields
function load_shift8_portfolio_wp_admin_style() {
        wp_enqueue_media();
	wp_enqueue_script('jquery-ui-datepicker');
        wp_enqueue_script('media-upload');
        wp_enqueue_script('thickbox');
        wp_enqueue_style('thickbox');
        // admin always last
        wp_enqueue_style( 'shift8_portfolio_admin_css', plugin_dir_url(dirname(__FILE__)) . 'css/shift8_portfolio_admin.css' );
        wp_enqueue_script( 'shift8_portfolio_admin_script', plugin_dir_url(dirname(__FILE__)) . 'js/shift8_portfolio_admin.js' );
}
add_action( 'admin_enqueue_scripts', 'load_shift8_portfolio_wp_admin_style' );
