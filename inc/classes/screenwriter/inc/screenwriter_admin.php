<?php

class Screenwriter_admin extends Screenwriter {

	public function custom_meta_add(){

		foreach($this->options->post_types as $post_type){
			add_meta_box(
				$this->unique_key, // Unique ID
				esc_html__( $this->options->title, 'example' ), //Title
				array(&$this, 'custom_meta_render' ), // Callback (builds html)
				$post_type, // Admin page (or post type)
				$this->options->context, // Context
				$this->options->priority, // Priority
				$callback_args = null
			);
		}

	}

	public function custom_meta_render($object, $box){

		wp_nonce_field( basename( __FILE__ ), $this->unique_key.'_nonce' );

		$count = 0;
		$this->post_id = $object->ID;
		$data = $this->get_sections();

	?>

		<?php foreach($this->options->sections as $section) : $count++; ?>

			<div class="sc-editor-container <?php echo $count == 1 ? 'first-editor' : '' ; ?>">

				<p>
					<?php if( $section['label'] ) : ?>
						<label for="<?php echo $section['key']; ?>_title"><?php echo $section['label']; ?></label>
						<br />
					<?php endif; ?>
					<input id="<?php echo $section['key']; ?>_title" type="text" class="regular-text" name="<?php echo $this->unique_key; ?>[<?php echo $section['key']; ?>][title]" value="<?php echo $data->{$section['key']}->title; ?>" />
				</p>

				<textarea class="sc_screenwriter" id="tinymce_<?php echo $this->unique_key; ?>_<?php echo $count; ?>" name="<?php echo $this->unique_key; ?>[<?php echo $section['key']; ?>][text]"><?php echo $data->{$section['key']}->text; ?></textarea>

			</div>

		<?php endforeach; ?>

		<br />

	<?php }

	public function custom_meta_save( $post_id, $post = false ){

		// Verify the nonce before proceeding.
		if ( !isset( $_POST[$this->unique_key.'_nonce'] ) || !wp_verify_nonce( $_POST[$this->unique_key.'_nonce'], basename( __FILE__ ) ) ){
			return $post_id;
		}

		// Get the post type object.
		$post_type = get_post_type_object( $post->post_type );

		// Get the posted data and sanitize it for use as an HTML class.
		$new_meta_value = ( isset( $_POST[$this->unique_key] ) ? $_POST[$this->unique_key] : '' );

		// Get the meta value of the custom field key. */
		$meta_value = get_post_meta( $post_id, $this->unique_key, true );

		// If a new meta value was added and there was no previous value, add it.
		if( $new_meta_value && '' == $meta_value ){
			add_post_meta( $post_id, $this->unique_key, $new_meta_value, true );
		}

		// If the new meta value does not match the old value, update it.
		elseif( $new_meta_value && $new_meta_value != $meta_value ){
			update_post_meta( $post_id, $this->unique_key, $new_meta_value );
		}

		// If there is no new meta value but an old value exists, delete it.
		elseif( '' == $new_meta_value && $meta_value ){
			delete_post_meta( $post_id, $this->unique_key, $meta_value );
		}

	}

	public function custom_meta_setup() {

		//Add Box
		add_action( 'add_meta_boxes', array(&$this, 'custom_meta_add' ));
		// Save Box
		add_action( 'save_post', array(&$this, 'custom_meta_save'));

	}

	public function load_assets(){

		global $pagenow, $typenow, $wp_version;

    	if( in_array( $typenow, $this->options->post_types ) && ( $pagenow == "post.php" || $pagenow == "post-new.php" ) ){

    		//Load CSS
			if( (float)$wp_version < 3.9 ){
				wp_register_style( 'sc_screenwriter_style', SCREENWRITER_URL.'/css/style_legacy.css' );
			} else {
				wp_register_style( 'sc_screenwriter_style', SCREENWRITER_URL.'/css/style.css' );
			}
			wp_enqueue_style( 'sc_screenwriter_style' );

			//Load New TinyMCE Plugin JS (http://www.tinymce.com/wiki.php/Configuration)
			wp_register_script( 'sc_tinymce', SCREENWRITER_URL.'/js/tinymce/tinymce.min.js', false, false, true );
			wp_enqueue_script('sc_tinymce');

			//Load JS
			wp_register_script( 'sc_screenwriter_script', SCREENWRITER_URL.'/js/script.js', false, false, true );
			wp_enqueue_script('sc_screenwriter_script');

			//Pass Dynamic Varaibles
			$js_vars = array(
				'wp_version' => (float)$wp_version,
				'selector' => 'sc_screenwriter',
				'directory' => SCREENWRITER_URL,
				'config' => $this->options->config
			);
			wp_localize_script( 'sc_screenwriter_script', 'screenwriter_js_object', $js_vars );

		}


	}

	public function reset_editor(){

		global $_wp_post_type_features;
	    $feature = "editor";
	    foreach( $this->options->post_types as $post_type ){
		    if( !isset($_wp_post_type_features[$post_type]) ){

		    } elseif ( isset($_wp_post_type_features[$post_type][$feature]) ){
		     	unset($_wp_post_type_features[$post_type][$feature]);
		    }
		}

	}

	public function __construct( $params = array(), $key = '' ){

		//Set Key & Build Options
		$this->unique_key = $key ? $key : $this->unique_key;
		$this->build_options( $params );

		add_action( 'init', array(&$this, 'custom_meta_setup') );

		//Load Assets
		add_action( 'admin_footer', array(&$this, 'load_assets'), 999 );

		//Reset Default Editor
		add_action( "init", array(&$this, 'reset_editor') );

	}

}