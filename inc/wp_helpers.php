<?php

/*
|--------------------------------------------------------------------------
| Metadata (SEO)
|--------------------------------------------------------------------------
*/

class page_meta {

	public static function title($id){

		$site_title = get_bloginfo('name')." | " .get_bloginfo('description');
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

	if( !$query ){

		global $wp_query;

		if( $wp_query->max_num_pages > 1 ){

			//Get current page and query type.
			$current_page = max( 1, get_query_var('paged') );
			$query_type = isset( $_GET['s'] ) ? '&' : '?';

			$args = array(
				'base'     => esc_url(get_pagenum_link())."{$query_type}paged=%#%",
				'format'   => "{$query_type}paged=%#%",
				'total'    => $wp_query->max_num_pages,
				'current'  => max( 1, get_query_var('paged') ),
				'show_all' => true,
				//'end_size'     => 1,
				//'mid_size'     => 2,
				//'prev_next'    => True,
				//'prev_text'    => __('« Previous'),
				//'next_text'    => __('Next »'),
				'type'         => 'list',
				//'add_args'     => False,
				//'add_fragment' => ''
			);

			$string = paginate_links($args);

		}

	} else {

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

	}

	return $string;

}

/*
|--------------------------------------------------------------------------
| Breadcrumbs
|--------------------------------------------------------------------------
*/

// function sc_breadcrumbs( $post_id = false, $home_id = false, $seperator = '&raquo;', $post_type = 'page' ){

// 	$breadcrumbs = get_post_ancestors( $post_id );
// 	$breadcrumbs = !$breadcrumbs ? array($home_id) : $breadcrumbs;
// 	$breadcrumbs = array_merge( $breadcrumbs, array( $post_id ) );

// 	$args = array(
// 		'post_type' => $post_type,
// 		'post__in' => $breadcrumbs,
// 		'orderby' => 'post__in',
// 		'post_status' => 'publish'
// 	);

// 	$breadcrumbs = new Wp_Query($args);
// 	wp_reset_query();
// 	$breadcrumbs = $breadcrumbs->posts;

// 	if( is_array( $breadcrumbs ) ){
// 		$return_breadcrumbs = "";
// 		$count = 0;
// 		foreach( $breadcrumbs as $breadcrumb ){
// 			$count++;
// 			$return_breadcrumbs .= "<a href='".get_permalink($breadcrumb->ID)."'>{$breadcrumb->post_title}</a>";
// 			$return_breadcrumbs .= $count == count($breadcrumbs) ? "" : " {$seperator} ";
// 		}
// 		return $return_breadcrumbs;
// 	}

// 	return false;

// }

function sc_breadcrumbs( $post_id = false, $home_id = false, $seperator = '&raquo;', $before = 'You are here:' ){

	if( is_search() ) return false;

	//Get Global Options
	global $global_options;
	$page_options = (array)$global_options;

    $breadcrumbs = array_merge( array((int)$home_id), array() );

	if( is_home() || ( is_single() && get_post_type() == 'post' ) ){
		//Blog Archive Page
		$breadcrumbs = array_merge( $breadcrumbs, array( (int)get_option('page_for_posts') ) );
	} elseif( is_archive() || (get_post_type() != 'post' || get_post_type() != 'page') ){
    	//Get Custom Post Type Archive

    	$post_type_id = $page_options[ get_post_type().'_page'];
    	$breadcrumbs = array_merge( $breadcrumbs, array( $post_type_id ) );
    }

    //Parent Pages
    $breadcrumbs = array_merge( $breadcrumbs, array_reverse( get_post_ancestors( $post_id ) ) );

    //Get Current Page
    if( !is_home() && !is_archive() ){

	    $breadcrumbs = array_merge( $breadcrumbs, array( $post_id ) );
	}

    $args = array(
                    'post_type'      => 'any',
                    'post__in'       => $breadcrumbs,
                    'orderby'        => 'post__in',
                    'post_status'    => 'publish',
                    'posts_per_page' => -1
    );

    $breadcrumbs = new Wp_Query($args);
    wp_reset_query();
    $breadcrumbs = $breadcrumbs->posts;

    if( is_array( $breadcrumbs ) ){
        $return_breadcrumbs = "{$before} ";
        $return_breadcrumbs = "";
        $count = 0;
        foreach( $breadcrumbs as $breadcrumb ){
            $count++;
            $classes = "level-".$count;
            $classes = $count == count($breadcrumbs) ? " current" : "" ;
            $return_breadcrumbs .= "<a class='".$classes."' href='".get_permalink($breadcrumb->ID)."'>{$breadcrumb->post_title}</a>";
            $return_breadcrumbs .= $count == count($breadcrumbs) ? "" : " {$seperator} ";
        }
        return $return_breadcrumbs;
    }

    return false;

}






/*
|--------------------------------------------------------------------------
| Parent / Child Menu
|--------------------------------------------------------------------------
*/


function sc_menu(){

	global $post;

	$menu_array = array();

	//Query Args
	$args = array(
			'post_type' => array('page'),
			'post_status' => 'publish',
			'post_parent' => $post->ID,
			'orderby' => 'menu_order',
			'order' => 'ASC',
			'posts_per_page' => -1
		);

	//Top Level
	if( $post->post_parent == 0 ){

		$menu = new Wp_Query($args);
		wp_reset_query();

		$menu_array[] = $post->ID;
		foreach( $menu->posts as $item ){
			$menu_array[] = $item->ID;
		}

	//Child Level
	} elseif( $post->post_parent > 0 ) {

		$args['post_parent'] = $post->post_parent;
		$menu = new Wp_Query($args);
		wp_reset_query();

		$menu_array[] = $post->post_parent;
		foreach( $menu->posts as $item ){
			$menu_array[] = $item->ID;
		}
	}

	return count($menu_array) > 1 ? $menu_array : false ;

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