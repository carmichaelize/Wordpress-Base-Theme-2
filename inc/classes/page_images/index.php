<?php

define("PAGE_IMAGES_URL", TEMPLATE_PATH."/inc/classes/page_images");

class sc_page_images {

        public $options = null;

        public $unquie_key = 'sc_page_images';

        //Build 'Defaults' Object
        public function build_options() {
            return array(
                'single'      => false, //set more than one image
                'post_types'  => array('post', 'page'), //post types
                'title'       => 'Image(s)', //title
                'context'     => 'normal', //normal, advanced, side
                'priority'    => 'default', //default, core, high, low
                'description' => '', //description text to appear in meta box
                'show_on'     => false //show only on specified pages (array of post ids)
            );
        }

        public function custom_meta_add() {

            //Show Only On Specific Pages
            if( $this->options->show_on && !in_array(get_the_id(), $this->options->show_on) ){
                return false;
            }

            foreach($this->options->post_types as $post_type){
                add_meta_box(
                    $this->unique_key, // Unique ID
                    $this->options->description ? $this->options->title.' <span class="title-caption">'.$this->options->description.'</span>' : $this->options->title, //Title
                    array(&$this, 'custom_meta_render'),
                    $post_type, // Admin page (or post type)
                    $this->options->single ? 'side' : 'normal' , // Context
                    $this->options->priority, // Priority
                    $callback_args = null
                );
            }

        }

        public function custom_meta_render($object, $box){

            wp_nonce_field( basename( __FILE__ ), $this->unique_key.'_nonce' );

            global $post;

            $images = get_page_images( $post->ID, $this->unique_key);

            // Set CSS Options
            $css_mode = $this->options->single ? 'single' : 'multiple' ;
            $button_mode = $images && $this->options->single ? 'hide' : '';

        ?>

        <span class="button button-primary button-large sc-add-image <?php echo $css_mode; ?> <?php echo $button_mode; ?>">Add New Image</span>

        <div class="clear"></div>

        <ul class="sc_gallery_container <?php echo $css_mode; ?>">

            <?php if(isset($images) && is_array($images) ): ?>

                <?php foreach($images as $image): ?>

                    <li class="sc_gallery_item">
                        <div class="image-mask" style="background-image:url('<?php echo $image[0]; ?>');"></div>
                        <input type="hidden" name="<?php echo $this->unique_key; ?>[]" class="upload_image_id" value="<?php echo $image[4]; ?>" />
                        <span>
                            <a title="Change Image" href="#" class="sc-set-image"><span>Change Image</span></a>
                            <a title="Remove Image" href="#" class="remove-image"><span>Remove Image</span></a>
                        </span>
                    </li>

                <?php endforeach; ?>

            <?php endif; ?>

            <li class="clear"></li>

        </ul>

        <!-- template -->
            <script id="sc_gallery_image_single" type="text/template">
                <li class="sc_gallery_item">
                    <div class="image-mask"></div>
                    <input type="hidden" name="<?php echo $this->unique_key; ?>[]" class="upload_image_id" value="" />
                    <span>
                        <a title="Change Image" href="#" class="sc-set-image"><span>Change Image</span></a>
                        <a title="Remove Image" href="#" class="remove-image"><span>Remove Image</span></a>
                    </span>
                </li>
            </script>
        <!-- /template -->

        <?php }

        public function custom_meta_save($post_id, $post=false){

                // Verify the nonce before proceeding.
                if ( !isset( $_POST[$this->unique_key.'_nonce'] ) || !wp_verify_nonce( $_POST[$this->unique_key.'_nonce'], basename( __FILE__ ) ) ){
                    return $post_id;
                }

                //Get the posted data and sanitize it for use as an HTML class.
                $new_meta_value = ( isset( $_POST[$this->unique_key] ) ? sanitize_html_class( $_POST[$this->unique_key] ) : '' );

                //Get the meta value of the custom field key.
                $meta_value = get_post_meta( $post_id, $this->unique_key, true );

                //If a new meta value was added and there was no previous value, add it.
                if ( $new_meta_value && '' == $meta_value ){
                    add_post_meta( $post_id, $this->unique_key, $new_meta_value, true );
                }

                //If the new meta value does not match the old value, update it.
                elseif ( $new_meta_value && $new_meta_value != $meta_value ){
                    update_post_meta( $post_id, $this->unique_key, $new_meta_value );
                }

                //If there is no new meta value but an old value exists, delete it.
                elseif ( '' == $new_meta_value && $meta_value ){
                    delete_post_meta( $post_id, $this->unique_key, $meta_value );
                }

        }

        public function custom_meta_setup() {

            //Add Box
            add_action( 'add_meta_boxes', array(&$this, 'custom_meta_add' ));
            //Save Box
            add_action( 'save_post', array(&$this, 'custom_meta_save'));

        }

        public function load_assets(){

            global $pagenow, $typenow, $wp_version;

            if( $pagenow == "post.php" || $pagenow == "post-new.php" ){

                //Load Javascript
                wp_register_script( 'sc_page_images_script', PAGE_IMAGES_URL.'/js/page_images.js', false, null, true );
                wp_enqueue_script( 'sc_page_images_script');

                //Load CSS
                wp_enqueue_style( 'sc_page_images_style', PAGE_IMAGES_URL.'/css/page_images.css' );

            }

        }

        public function __construct($unique_key = '', $params = array()){

            //Check Unique ID Isset
            if( !isset( $unique_key ) ){
                return false;
            }

            //Create 'Options' Object
            $this->unique_key = $unique_key;
            $this->options = (object)array_merge($this->build_options(), $params);

            add_action( 'init', array(&$this, 'custom_meta_setup'));

            //Load CSS & JS
            add_action( 'admin_enqueue_scripts', array( &$this,'load_assets' ) );

        }
}

//Get Images Wrapper Function
function get_page_images($id = false, $key = '', $size = '', $single = false){

    if( $id == false || $key == '' ){
        return false;
    }
    $size = $size == '' ? 'full' : $size;
    $images = get_post_meta($id, $key, true);
    if( is_array($images) ){
        $image_array = array();
        foreach($images as $image){
            $image_object = wp_get_attachment_image_src( $image, $size );
            if( $image_object ){
                $image_object[] = $image;
                $image_object[] = get_the_title($image);
                $image_array[] = $image_object;
            }
        }
        if($single){
            return $image_array[0];
        }
        return $image_array;
    }
    return false;

}

//Shortcode Function
// function page_images_shortcode_function( $atts ) {

//     if( is_single() || is_page() ){

//         $defaults = array(
//                     'id'     => get_the_id(),
//                     'images' => array()
//                 );

//         foreach($images as $image){
//             $image_object = wp_get_attachment_image_src( 16, $size );
//         }

//         return $content;
//     }

// }

//Add Shortcode
//add_shortcode( 'page_images', 'page_images_shortcode_function' );



?>