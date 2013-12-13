<?php

class Mockingbird {

	public $unique_key = "sc_mockingbird";

	public $post_id = false;

	public $options = array(
					'options_page'		=> 'mockingbird-options',
					'display_on'		=> array('post'),
					'types_to_display'  => array('post'),
					'show_on'			=> array(),
					'title' 		    => 'Related Posts',
					'description'		=> '',
					'priority'			=> 'default',
					'context'			=> 'side',
					'container_class'   => 'mockingbird-container',
					'wrapper' 		    => '<ul>',
					'before' 		    => '<li>',
					'after' 		    => '</li>',
					'before_title'	    => '<h3>',
					'after_title' 	    => '</h3>',
					'include_excerpt'   => false,
					'include_thumbnail' => false,
					'excerpt_length'	=> 100,
					'excerpt_link_text' => 'Read More'
				);

	public function query_posts(){

		if( $this->related_posts() ){
			//Get Posts
	        $args = array(
	            'post_type' 	 => $this->unique_key == 'sc_mockingbird' ? $this->options->types_to_display : get_post_types(),
	            'order' 		 => 'ASC',
	            'orderby' 		 => 'post__in',
	            'posts_per_page' => '-1',
	            'post__in'		 => $this->related_posts()
	            );
	        $post_query = new WP_Query( $args );

	        //Add Custom Titles
	        if( $post_query->posts ){

	        	$related_titles = $this->related_titles();
	        	$count = 0;

	        	foreach( $post_query->posts as $post ){
	        		$post->custom_title = $related_titles[$count];
	        		$count++;
	        	}

			}

			wp_reset_postdata();

	        return $post_query;

		}

	}

	public function render_list(){

		$related_posts = $this->related_posts();
		$related_titles = $this->related_titles();

		$post_query = $this->query_posts();

		$string = "";

        if( $post_query->posts ){

			$string .= $this->options->title ? "<h2>{$this->options->title}</h2>" : "";

        	$string .= str_replace( ">", " class='{$this->options->container_class}'>", $this->options->wrapper );

        	foreach( $post_query->posts as $post ){

        		$post_query->the_post();

        		$string .= "{$this->options->before}";

        		//Post Title
        		$string .= "{$this->options->before_title}";
        		$string .= "<a href='".get_permalink( $post->ID )."'>";
        		$string .= esc_html__( $post->custom_title );
        		$string .= "</a>";
        		$string .= "{$this->options->after_title}";

        		//Post Thumbnail
        		if( $this->options->include_thumbnail ){
    				$string .= "<a href='".get_permalink( $post->ID )."'>";
    				$string .=  ($thumbnail = get_the_post_thumbnail( $post->ID, 'thumbnail')) ? $thumbnail : "";
    				$string .= "</a>";
    			}

    			//Post Excerpt
    			if( $this->options->include_excerpt && ($content = $post->post_excerpt ? $post->post_excerpt : $post->post_content) ){
    		    	$length = $this->options->excerpt_length ? (int)$this->options->excerpt_length : 100;
    		    	//Remove Mockingbird Shortcode Refrences
					$content = preg_replace( '/\[mockingbird?[^\]]+?\]/', '', $content );
    		   		$string .= "<p>";
    		   		$string .= Str::limit( $content, $length );
    		   		$string .= $this->options->excerpt_link_text ? "<a class='readmore' href='".get_permalink( $post->ID )."'>{$this->options->excerpt_link_text} &raquo;</a>" : "" ;
    		   		$string .= "</p>";
    			}

    			//Clearing Div
    			if( $this->options->include_thumbnail || $this->options->include_excerpt ){
    				$string .= "<div style='clear:both;'></div>";
    			}

        		$string .= "{$this->options->after}";

        	}

        	$string .= str_replace( "<", "</", $this->options->wrapper );

        }

        return $string;

	}

	public function related_posts(){
		return get_post_meta( $this->post_id, $this->unique_key, true );
	}

	public function related_titles(){
		return get_post_meta( $this->post_id, $this->unique_key.'_title', true );
	}

	public function build_options($params = array()){

		if( $settings = get_option($this->unique_key."_options") ){
            $this->options = array_merge($this->options, $settings);
        } else {
        	$this->options = $this->options;
        }

        $this->options = (object)array_merge($this->options, $params);

	}

	public function __construct( $post_id = false, $custom_styles = array(), $unique_key = '' ){

		//Build Options
		$this->build_options($custom_styles);

		//Set ID and Key
		$this->post_id = $post_id ? $post_id : get_the_id();
		$this->unique_key = $unique_key ? $unique_key : $this->unique_key;

		//Load CSS
        wp_enqueue_style( 'sc_mockingbird_style', MOCKINGBIRD_URL.'/css/style.css' );

	}

}

//Print Mockingbird Values
function mockingbird( $post_id = false, $custom_styles = array(), $key = '' ){

	//Styling Array Validation
	if( !is_array($custom_styles) ){
		return false;
	}

	$mockingbird = new Mockingbird( $post_id, $custom_styles, $key );

	//Render Post List
	echo $mockingbird->render_list();
	wp_reset_postdata();

	return false;

}

//Return Mockingbird Values
function get_mockingbird( $post_id = false, $return_posts = false, $key = '' ){

	$mockingbird = new Mockingbird( $post_id, array(), $key );

	//Return Post Ids
	if( !$return_posts ) {
	   return $mockingbird->related_posts();
	}

	//Return Post Query
	if( $return_posts ){
		$posts = $mockingbird->query_posts();
		wp_reset_postdata();
		return $posts->posts;
	}

	return false;

}

//Post Filter
function sc_mockingbird_post_filter( $content ){

	$setup = (object)get_option( 'sc_mockingbird_options' );
	if( isset( $setup->render ) && !has_filter( 'sc_mockingbird_post_filter' ) ){
		$mockingbird = new Mockingbird( get_the_id() );
		$content = $content." ".$mockingbird->render_list();
		wp_reset_postdata();
	}

	return $content;
}

//Add Content Filter
add_filter( 'the_content', 'sc_mockingbird_post_filter' );


//Shortcode Function
function mockingbird_shortcode_function( $atts ) {

	$defaults = array(
					'id' 				=> get_the_id(),
					'title'				=> 'Related Content',
					'include_excerpt'   => false,
					'include_thumbnail' => false,
					'excerpt_length'	=> 100,
					'excerpt_link_text' => 'Read More'
				);

	$params = shortcode_atts($defaults, $atts);

	$mockingbird = new Mockingbird( $params['id'], $params );
	$content = $mockingbird->render_list();
	wp_reset_postdata();

	return $content;

}

//Add Shortcode
add_shortcode( 'mockingbird', 'mockingbird_shortcode_function' );


?>