<?php
/*
	Plugin Name: Mockingbird
	Plugin URI: http://www.carmichaelize.co.uk/projects/mockingbird/
	Description: Post type relator plugin.
	Author: Scott Carmichael
	Version: 1.0
	Author URI: http://www.scarmichael.co.uk
	Licence: Envato Regular & Extended
	Licence URI: http://themeforest.net/licenses

	Copyright 2013 Scott Carmichael
*/

define("MOCKINGBIRD_URL", TEMPLATE_PATH."/inc/classes/mockingbird");

//Include Files
if ( !class_exists('Sc_Str') ) {
	include('inc/helpers.php');
}

include('inc/mockingbird.php');

if( is_admin() ){

	//Load Admin Classes
	include('inc/mockingbird_admin.php');

	//Build Post Type Widget
	new Mockingbird_admin( 'sc_related_pages', array( 'display_on' => array('post', 'page'), 'types_to_display'=>array('post', 'page')) );

}

?>