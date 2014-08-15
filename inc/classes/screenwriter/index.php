<?php
/*
	Plugin Name: Screenwriter
	Plugin URI: http://www.carmichaelize.co.uk/projects/screenwriter
	Description: Split page content into into sections.
	Author: Scott Carmichael
	Version: 1.1
	Author URI: http://www.scarmichael.co.uk
	Licence: Dual Licensed under GPL & MIT
	Licence URI: GPL(http://www.gnu.org/licenses/gpl.html) / MIT (http://www.opensource.org/licenses/mit-license.php)
	Thirdparty Resources: TinyMCE (http://www.tinymce.com/)

	Copyright 2014 Scott Carmichael
*/

define("SCREENWRITER_URL", TEMPLATE_PATH."/inc/classes/screenwriter" );
define("SCREENWRITER_SERVER_PATH", dirname( __FILE__ ) );

//var_dump(dirname( __FILE__ ));

//Load Classes
include_once('inc/screenwriter.php');
include_once('inc/screenwriter_admin.php');

/*==================================================
	Create Screenwriter Instance(s) (Examples)
==================================================*/

	//Default Usage
	//new Screenwriter_admin();


	//Custom Usage
	// $args = array(
	// 	'post_types' => array('page', 'post'),
	// 	'sections'   => array(
	// 			array(
	// 				'key'   => 'top_section',
	// 				'label' => 'Top Section'
	// 			),
	// 			array(
	// 				'key'   => 'bottom_section',
	// 				'label' => 'Bottom Section'
	// 			)
	// 		)
	// 	);

	// new Screenwriter_admin( $args, 'custom_page_content' );

/*================================================*/

// $args = array(
// 		'post_types' => array('page', 'post'),
// 		'sections'   => array(
// 				array(
// 					'key'   => 'top_section',
// 					'label' => 'Top Section'
// 				),
// 				array(
// 					'key'   => 'bottom_section',
// 					'label' => 'Bottom Section'
// 				)
// 			)
// 		);
// new Screenwriter_admin( $args, 'custom_page_content' );

?>