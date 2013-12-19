<?php

class Mockingbird_admin extends Mockingbird {

	public function custom_meta_add() {

		//Show Only On Specific Pages
		if( !$this->options->show_on || in_array(get_the_id(), $this->options->show_on ) ){
			foreach( $this->options->display_on as $post_type ){
				add_meta_box(
					$this->unique_key, // Unique Key
					$this->options->title ? esc_html__( $this->options->title ) : 'Related Content', //Title
					array(&$this, 'custom_meta_render' ), // Callback (builds html)
					$post_type, // Post type
					$this->options->context, // Context
					$this->options->priority, // Priority
					$callback_args = null
				);
			}
		}

	}

	public function custom_meta_render($object, $box){

		wp_nonce_field( basename( __FILE__ ), $this->unique_key.'_nonce' );

		//Get Preset Data
		$list = is_array( $list = get_post_meta($object->ID, $this->unique_key, true) ) ? $list : array() ;
		$titles = get_post_meta( $object->ID, $this->unique_key."_title", true );

		//Set Posttype Filter
		$this->options->types_to_display = count($this->options->types_to_display) > 0 ? $this->options->types_to_display : $this->get_post_types();

		//Get All Available Posts
		$args = array(
			'post_type' 	 => $this->options->types_to_display,
			'order' 		 => 'ASC',
			'orderby'		 => 'title',
			'posts_per_page' => -1
			);
		$post_query = new WP_Query( $args );
		$posts = $post_query->posts;

	?>

		<!-- Filter Buttons -->
		<?php if($posts) : ?>

			<!-- Description Text -->
			<?php if( $this->options->description ) : ?>
				<p><em><?php echo esc_html__( $this->options->description ); ?></em></p>
			<?php endif; ?>

			<ul class="sc-mockingbird-filter-btns">

				<li data-type="<?php echo implode(',', $this->options->types_to_display); ?>," class="active">All</li>

				<?php foreach( $this->options->types_to_display as $post_type ) : ?>

					<?php $post_type_labels = get_post_type_object( $post_type ); ?>

					<li data-type="<?php echo $post_type; ?>">
						<?php echo ucfirst( $post_type_labels->labels->name ); ?>
					</li>

				<?php endforeach; ?>

			</ul>

			<div class="sc-mockingbird-filter-select">

				<div>
					<!-- Loading Indicator -->
					<span class="sc-loading-image"></span>

					<select class="widefat sc-mockingbird-selectbox">
						<option value="">- - Select All - -</option>
						<?php foreach( $posts as $post ): ?>
							<option <?php echo in_array( $post->ID, $list ) ? 'disabled="disabled"' : '' ; ?> value="<?php echo $post->ID ?>">
								<?php echo esc_html__( $post->post_title ); ?>
							</option>
						<?php endforeach; ?>
					</select>

				</div>

			</div>

		<?php else : ?>

			<p><em>No Posts Available.</em></p>

		<?php endif; wp_reset_postdata(); ?>

		<?php

			//Reset Post Array
			$posts = false;

			//Get Saved Posts
			if($list){

				$args = array(
					'post_type' 	 => $this->options->types_to_display,
					'post__in'		 => $list,
					'order' 		 => 'ASC',
					'orderby'		 => 'post__in',
					'posts_per_page' => '-1',
					);
				$post_query = new WP_Query( $args );
				$posts = $post_query->posts;
			}

		?>

		<ul class="sc-mockingbird-container <?php echo $this->options->allow_relabel ? 'sc-relabel' : '' ; ?>">

			<script class="sc-mockingbird-template" type="text/template">
				<li class="button" style="display:none;">
					<span class="sc-mockingbird-label"></span>
					<input type="hidden" class="sc-id-input" name="<?php echo $this->unique_key ?>[]" value="" />
					<input type="hidden" class="sc-original-input" value="" />
					<input type="hidden" class="sc-title-input" name="<?php echo $this->unique_key; ?>_title[]" value="" />
					<span class="remove"></span>
				</li>
			</script>

			<?php if( $list && $posts ) : $count = 0; ?>

				<?php foreach( $posts as $post ): ?>

					<li class="button">
						<span class="sc-mockingbird-label">
							<?php echo $this->options->context == 'side' ? esc_html__( Sc_Str::limit( $titles[$count] ? $titles[$count] : $post->post_title, 27 ) ) : esc_html__( $titles[$count] ? $titles[$count] : $post->post_title ) ; ?>
						</span>
						<input type="hidden" class="sc-id-input" name="<?php echo $this->unique_key; ?>[]" value="<?php echo $post->ID; ?>" />
						<input type="hidden" class="sc-original-input" value="<?php echo esc_html__( $post->post_title ); ?>" />
						<input type="hidden" class="sc-title-input" name="<?php echo $this->unique_key; ?>_title[]" value="<?php echo esc_html__( $titles[$count] ? $titles[$count] : $post->post_title ) ; ?>" />
						<span class="remove"></span>
					</li>

				<?php $count++; endforeach; ?>

			<?php endif; wp_reset_postdata(); ?>

		</ul>

		<em class="sc-nojs-message">Please enable JavaScript to continue using this plugin.</em>

	<?php }

	public function custom_meta_save( $post_id, $post = false ){

		//Show Only On Specific Pages
		if( $this->options->show_on && !in_array( get_the_id(), $this->options->show_on ) ){
			return false;
		}

		//Verify the nonce before proceeding.
		if ( !isset( $_POST[$this->unique_key.'_nonce'] ) || !wp_verify_nonce( $_POST[$this->unique_key.'_nonce'], basename( __FILE__ ) ) ){
			return false;
		}

		//Meta Keys to Save
		$keys = array( $this->unique_key, $this->unique_key."_title" );

		foreach( $keys as $key ){

			//Get the posted data and sanitize it for use as an HTML class.
			if( $key == $this->unique_key ){
				$new_meta_value = ( isset( $_POST[$key] ) ? sanitize_html_class( $_POST[$key] ) : '' );
			} else {
				$new_meta_value = isset( $_POST[$key] ) ? $_POST[$key] : '' ;
			}

			//Get the meta value of the custom field key.
			$meta_value = get_post_meta( $post_id, $key, true );

			//If a new meta value was added and there was no previous value, add it.
			if ( $new_meta_value && '' == $meta_value ){
				add_post_meta( $post_id, $key, $new_meta_value, true );
			}

			//If the new meta value does not match the old value, update it.
			elseif ( $new_meta_value && $new_meta_value != $meta_value ){
				update_post_meta( $post_id, $key, $new_meta_value );
			}

			//If there is no new meta value but an old value exists, delete it.
			elseif ( '' == $new_meta_value && $meta_value ){
				delete_post_meta( $post_id, $key, $meta_value );
			}

		}

	}

	public function custom_meta_setup() {

		//Add Box
		add_action( 'add_meta_boxes', array( &$this, 'custom_meta_add' ) );
		//Save Box
		add_action( 'save_post', array( &$this, 'custom_meta_save' ) );

	}

    public function load_assets(){

    	global $pagenow, $typenow, $wp_version;

    	if( in_array($typenow, $this->options->display_on) && ($pagenow == "post.php" || $pagenow == "post-new.php") ){
    		//Load Javascript
        	wp_register_script( 'sc_mockingbird_script', MOCKINGBIRD_URL.'/js/mockingbird.js', false, null, true );
       		wp_enqueue_script( 'sc_mockingbird_script');

       		$js_vars = array(
	       			'ajax_url' => admin_url( 'admin-ajax.php' ),
	       			'unique_key' => $this->unique_key,
	       			'options' => $this->options
       			);
       		wp_localize_script( 'sc_mockingbird_script', 'wp_js_object', $js_vars );

        	//Load CSS
       		if( (float)$wp_version >= 3.8 ){
				wp_enqueue_style( 'sc_mockingbird_admin_style', MOCKINGBIRD_URL.'/css/mockingbird_admin.css' );
			} else {
				wp_enqueue_style( 'sc_mockingbird_admin_style', MOCKINGBIRD_URL.'/css/mockingbird_admin_old.css' );
			}
    	}

    }

    public function sc_mockingbird_ajax_search(){

    	$post_types = explode(',', $_POST['posttype']);

	    $args = array(
	        'post_type'=> $post_types,
	        'order' 		 => 'ASC',
			'orderby'		 => 'title',
			'posts_per_page' => '-1'
	        );
		$post_query = new WP_Query( $args );

	    echo json_encode($post_query->posts);

		die();

    }

	public function __construct( $unique_key = '', $params = array() ){

		//Set Unique Key
		$this->unique_key = $unique_key ? $unique_key : $this->unique_key;

		//Build Options
        $this->build_options($params);

        //Create Metabox
		add_action( 'init', array( &$this, 'custom_meta_setup' ) );

		//Ajax Endpoint
		add_action('wp_ajax_sc_mockingbird_search', array( &$this, 'sc_mockingbird_ajax_search') );

		//Load CSS & JS
        add_action( 'admin_enqueue_scripts', array( &$this,'load_assets' ) );

	}

}

?>