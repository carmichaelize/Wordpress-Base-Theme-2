<?php

	if( !defined( 'WP_UNINSTALL_PLUGIN' ) ){
		exit();
	}

	//Tidy Database Options
	$option_name = 'sc_mockingbird_options';
	delete_option( $option_name );

	//Tidy Database Meta
	$meta_titles = 'sc_mockingbird_title';
	$meta_data = 'sc_mockingbird';
	global $wpdb;
	$query = "DELETE FROM $wpdb->postmeta WHERE meta_key = %s OR meta_key = %s";
	$wpdb->query( $wpdb->prepare( $query, array( $meta_titles, $meta_data ) ) );

?>