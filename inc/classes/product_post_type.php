<?php

class sc_product_post_type {

	public function post_type_options() {
		return array(
			'labels' => array(
				'name' => __( 'Products' ),
				'singular_name' => __( 'Product' ),
				'add_new' => __( 'Add New' ),
				'add_new_item' => __( 'Add New Product' ),
				'edit_item' => __( 'Edit Product' ),
				'new_item' => __( 'New Product' ),
				'all_items' => __( 'All Products' ),
				'view_item' => __( 'View Product' ),
				'search_items'  => __( 'Search Products' ),
				'not_found' => __( 'No products found' ),
				'not_found_in_trash' => __( 'No products found in the Trash' ),
				'parent_item_colon' => '',
				'menu_name' => 'Products'
			),
			'description' => 'Holds our products and product specific data',
			'public' => true,
			'menu_position' => 20,
			'supports' => array( 'title', 'editor', 'thumbnail' ), // title, editor, thumbnail, excerpt, comments, page-attributes
			'has_archive'   => true,
			'rewrite' => array( 'slug' => 'products', 'with_front' => true ),
			//'hierarchical' => true,
			'menu_icon' => 'dashicons-admin-tools' //http://melchoyce.github.io/dashicons/
		);
	}

	//http://melchoyce.github.io/dashicons/
	//Post 'dashicons-admin-post'
	//Page 'dashicons-admin-page'
	//Speech 'dashicons-admin-comments'
	//Media  'dashicons-admin-media'
	//Users 'dashicons-admin-users'
	//Tools 'dashicons-admin-tools'
	//Settings 'dashicons-admin-generic'

	// public function post_taxonomy_options(){
	// 	return array(
	// 		'hierarchical' => false, // Hierarchical taxonomy (like categories)
	// 		// This array of options controls the labels displayed in the WordPress Admin UI
	// 		'labels' => array(
	// 			'name' => __( 'Locations' ),
	// 			'singular_name' => __( 'Location' ),
	// 			'search_items' =>  __( 'Search Locations' ),
	// 			'all_items' => __( 'All Locations' ),
	// 			'parent_item' => __( 'Parent Location' ),
	// 			'parent_item_colon' => __( 'Parent Location:' ),
	// 			'edit_item' => __( 'Edit Location' ),
	// 			'update_item' => __( 'Update Location' ),
	// 			'add_new_item' => __( 'Add New Location' ),
	// 			'new_item_name' => __( 'New Location Name' ),
	// 			'menu_name' => __( 'Locations' ),
	// 		),
	// 		'rewrite' => array( // Control the slugs used for this taxonomy
	// 			'slug' => 'locations', // This controls the base slug that will display before each term
	// 			'with_front' => false, // Don't display the category base before "/locations/"
	// 			'hierarchical' => true // This will allow URL's like "/locations/boston/cambridge/"
	// 		)
	// 	);
	// }

	public function post_type_setup() {
		register_post_type( 'products', $this->post_type_options() );
	}

	// public function post_taxonomy_setup(){
	// 	register_taxonomy( 'location', 'products', $this->post_taxonomy_options() );
	// }

	public function __construct(){

		//Add Post Custom Type
		add_action( 'init', array(&$this, 'post_type_setup') );

		//Add Taxonomy to Custom Post type
		//add_action( 'init', array(&$this, 'post_taxonomy_setup'), 0 );

	}

}

?>