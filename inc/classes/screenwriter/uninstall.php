<?php

	if( !defined( 'WP_UNINSTALL_PLUGIN' ) ){
		exit();
	}

	//Tidy Database Meta
	$meta_titles = 'sc_screenwriter';
	global $wpdb;
	$query = "DELETE FROM $wpdb->postmeta WHERE meta_key = %s";
	$wpdb->query( $wpdb->prepare( $query, array( $meta_titles ) ) );

?>