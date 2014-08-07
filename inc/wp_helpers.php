<?php

/*
|--------------------------------------------------------------------------
| Metadata (SEO)
|--------------------------------------------------------------------------
*/

class page_meta {

	public static function title($id){

		$site_title = get_bloginfo('name');
		$page_title = get_the_title();

		// Site Home
		if( is_home() || is_front_page() ){
			return $site_title;
		}

		// Single/Custom Posts & Pages
		if( is_single() || is_page() ){
			//Custom Meta Title (See meta_options.php)
			if( $meta_title = get_post_meta($id, 'sc_seo_meta_data', true ) ){
				if($meta_title['title'] != ''){
					return $meta_title['title'].' - '.$site_title;
				}
			}
			return $page_title.' - '.$site_title;
		}

		if( is_archive() ){

			// Custom Post Archive
			if( is_post_type_archive() ){
				return get_post_type().' - '.$site_title;
			}

			// Date Archive
			if( is_day() ) {
				return get_the_time('F jS, Y').' - '.$site_title;
			} elseif ( is_month() ) {
				return get_the_time('F, Y').' - '.$site_title;
			} elseif ( is_year() ) {
				return get_the_time('Y').' - '.$site_title;
			}

			// Author Page
			if( is_author() ) {
				return get_query_var('author_name').' - '.$site_title;
			}

			// Category/Tag/Taxonomy Page
			if ( is_category() || is_tag() || is_tax() ) {
				return single_cat_title('', false).' - '.$site_title;
			}

			return 'Archive - '.$site_title;
		}

		return $site_title;

	}

	public static function description($id){

		//Archive Page Description
		if( is_archive() ){

			//Author Bio
			if(is_author()){
				global $post;
				return Str::limit( get_the_author_meta('description', (int)$post->post_author), 160 );
			}

			if( category_description() ){
				return  Str::limit( category_description(), 160 );
			}

		}

		// Single/Custom Posts & Pages
		if( is_single() || is_page() ){

			//Custom Meta Description (See meta_options.php)
			if( $meta_title = get_post_meta($id, 'sc_seo_meta_data', true ) ){
				if($meta_title['description'] != ''){
					return $meta_title['description'];
				}
			}

			global $post;
			if( $post->post_content ){
				return Str::limit( $post->post_content, 160 );
			}

		}

		return Str::limit( get_bloginfo('description'), 160 );

	}

	public static function keywords($id){

		if( is_single() || is_page()){

			//Custom Meta Keywords (See meta_options.php)
			if( $meta_keywords = get_post_meta($id, 'sc_seo_meta_data', true ) ){
				if($meta_keywords['keywords'] != ''){
					return $meta_keywords['keywords'];
				}
			}

			$tags = get_the_tags();

			if($tags){
				foreach($tags as $tag){
					$sep = (empty($keywords)) ? '' : ', ';
					$keywords .= $sep . $tag->name;
				}
			}
			return $keywords;

		}

		return '';

	}

}

/*
|--------------------------------------------------------------------------
| Custom Is Page
|--------------------------------------------------------------------------
*/

function sc_is_page( $page_name ){
	global $global_options;
	$options = (array)$global_options;
	return (int)$options[$page_name] > 0 && is_page((int)$options[$page_name]);
}

/*
|--------------------------------------------------------------------------
| Pagination Function
|--------------------------------------------------------------------------
*/

function sc_pagination( $query ){

	$string = "";

	if( $query->max_num_pages > 1 ){

		$args = array(
			'base'     => @add_query_arg('pp', '%#%'),
			'format'   => "pp=%#%",
			'total'    => $query->max_num_pages,
			'current'  => max( 1, isset($_GET['pp']) ? $_GET['pp'] : 1 ),
			'show_all' => true,
			//'end_size'     => 1,
			//'mid_size'     => 2,
			//'prev_next'    => True,
			// 'prev_text'    => __('&larr;'),
			// 'next_text'    => __('&rarr;'),
			 'type'         => 'list',
			//'add_args'     => true,
			//'add_fragment' => ''
		);

		$string = paginate_links($args);

	}

	return $string;

}

/*
|--------------------------------------------------------------------------
| Breadcrumbs
|--------------------------------------------------------------------------
*/

function sc_breadcrumbs( $post_id = false, $home_id = false, $seperator = '&raquo;', $post_type = 'page' ){

	$breadcrumbs = get_post_ancestors( $post_id );
	$breadcrumbs = !$breadcrumbs ? array($home_id) : $breadcrumbs;
	$breadcrumbs = array_merge( $breadcrumbs, array( $post_id ) );

	$args = array(
		'post_type' => $post_type,
		'post__in' => $breadcrumbs,
		'orderby' => 'post__in',
		'post_status' => 'publish'
	);

	$breadcrumbs = new Wp_Query($args);
	wp_reset_query();
	$breadcrumbs = $breadcrumbs->posts;

	if( is_array( $breadcrumbs ) ){
		$return_breadcrumbs = "";
		$count = 0;
		foreach( $breadcrumbs as $breadcrumb ){
			$count++;
			$return_breadcrumbs .= "<a href='".get_permalink($breadcrumb->ID)."'>{$breadcrumb->post_title}</a>";
			$return_breadcrumbs .= $count == count($breadcrumbs) ? "" : " {$seperator} ";
		}
		return $return_breadcrumbs;
	}

	return false;

}

/*
|--------------------------------------------------------------------------
| Custom get_post_meta function
|--------------------------------------------------------------------------
*/

function sc_get_post_meta( $id, $key ){
	return (object)get_post_meta( $id, $key, true );
}

?>