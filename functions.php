<?php

//Globals
define( 'TEMPLATE_PATH', get_bloginfo('stylesheet_directory') );
define( 'TEMPLATE_ROOT', parse_url(TEMPLATE_PATH, PHP_URL_PATH) );
define( 'IMAGE_PATH', TEMPLATE_PATH. "/images" );
// WP_CONTENT_URL, WP_CONTENT_DIR

//Get Global Theme Options
$global_options = (object)get_option('sc_theme_options');

//Helper Functions
if ( !class_exists('Str') ) {
	include_once('inc/helpers.php');
}
include_once('inc/wp_helpers.php');

//Custom Classes
include_once('inc/classes/settings_page.php');
include_once('inc/classes/page_meta.php');
include_once('inc/classes/mockingbird/index.php');
//include_once('inc/classes/screenwriter/index.php');
//include_once('inc/classes/page_images/index.php');
//include_once('inc/classes/page_icons.php');

// include_once('inc/classes/product_post_type.php');
// include_once('inc/classes/testimonial_post_type.php');
// include_once('inc/classes/staff_post_type.php');
// new sc_testimonial_post_type();
// new sc_staff_post_type();
// new sc_product_post_type();

//Page Template Select page-{template_name}.php && // (T)emplate Name: My Custom Page //
//get_page_template() is_page_template()

new sc_theme_settings_page();
new sc_page_meta(array('post_types'=>array('post', 'page')));

// Related Pages
// if( is_admin() ){
// 	$args = array(
// 		'types_to_display' => array('page'),
// 		'display_on' => array('page'),
// 		'title' => 'Related Pages'
// 		);
// 	new Mockingbird_admin( 'sc_related_pages', $args );
// }

//Theme Specific Functions
include_once('inc/functions.php');

//Custom Shortcodes
include_once('inc/shortcodes.php');

// Enable post thumbnails
//add_theme_support('post-thumbnails');
//set_post_thumbnail_size(520, 250, true);
//add_image_size( 'sc_gallery', 200, 200, true );

//Admin Titdy
include_once('inc/admin_tidy.php');

//Flush Rewrite Rules (Development Only)
//add_action('init', function(){
	//flush_rewrite_rules(false);
//});

/** Turn Off Revisions (Paste in wp-config.php) */
//define('WP_POST_REVISIONS', false );

//Redirect Page (Use before header.php)
// if( $redirect_link = get_post_meta( get_the_id(), 'sc_redirect_link', true ) ){
// 	wp_redirect( $redirect_link );
// 	exit;
// }

?>