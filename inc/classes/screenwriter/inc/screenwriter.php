<?php

class Screenwriter {

	public $unique_key = "sc_screenwriter";

	public $post_id;

	public $options = array(
			'post_types' => array('page', 'post'),
			'title'		 => 'Page Content',
			'context'	 => 'normal', //normal, advanced, side
			'priority'	 => 'default', //default, core, high, low
			'show_on'    => true,
			'sections' 	 => array(
								array(
									'key' => 'page_content',
									'label' => ''
								)
							),
			'config'     => array(
								'plugins'   => "link, image, media, code",
	    						'toolbar'   => "bold italic underline alignleft aligncenter alignright alignjustify blockquote bullist numlist link, unlink image media code",
	    						'resize'    => false,
	    						'width'     => "100%",
	    						'height'    => 300,
	    						'statusbar' => true,
	    						'menubar'   => false
							),
			'before'       => '<section>',
			'after'  	   => '</section>',
			'before_title' => '<h1>',
			'after_title'  => '</h1>'
		);

	public function get_sections($post_id = false){

		$this->post_id = $post_id ? $post_id : $this->post_id;
		if( !$this->post_id || !$this->unique_key ) return false;

		$values = get_post_meta( $this->post_id, $this->unique_key, true );
		if( is_array($values) ){
			foreach($values as $key => $value){
				$values[$key] = (object)$value;
			}
			return (object)$values;
		}
		return false;

	}

	public function print_sections(){

		$content = "";
		if( $sections = $this->get_sections() ){
			foreach( $sections as $section ){
				$content .= $this->options->before;
					$content .= $section->title ? $this->options->before_title : "" ;
						$content .= $section->title;
					$content .= $section->title ? $this->options->after_title : "" ;
					$content .= $section->text;
				$content .= $this->options->after;
			}
		}
		return $content;

	}

	public function build_options($params = array()){
        //Merge Final Arrays
        return $this->options = (object)array_merge($this->options, $params);
	}

	public function __construct($post_id = false, $key = '', $params = array()){

		//Set ID, Key and Build Options
		$this->post_id = $post_id ? $post_id : get_the_id();
		$this->unique_key = $key ? $key : $this->unique_key;
		$this->build_options( $params );

	}

}

//Print Sections Wrapper Function
function screenwriter( $id = false, $params = array(), $key = '' ){
	$sections = new Screenwriter( $id, $key, $params );
	echo $sections->print_sections();
	return false;
}


//Get Sections Wrapper Function
function get_screenwriter( $id = false, $key = '' ){

	$sections = new Screenwriter( $id, $key );
	return $sections->get_sections();

}

//Content Filter
function sc_screenwriter_post_filter( $content ){

	$content = screenwriter(get_the_id());
	return $content;

}

//Add Content Filter
add_filter( 'the_content', 'sc_screenwriter_post_filter' );