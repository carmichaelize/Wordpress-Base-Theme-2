<?php

/* Page Template Option */
class sc_icon_meta {

	public $options = null;

	//Build 'Defaults' Object
	public function build_options() {
		return array(
			'post_types' => array('post'), //post types
			'unique_id'=>'sc_icon_meta', //unique prefix
			'title'=>'Icon Meta', //title
			'context'=>'side', //normal, advanced, side
			'priority'=>'default', //default, core, high, low
			'show_on'=> false, //show only on specified pages
			'description' => 'Select an icon to be displayed.'
		);
	}

	public function custom_meta_add() {

		//Show Only On Specific Pages
		if( $this->options->show_on && !in_array(get_the_id(), $this->options->show_on) ){
			return false;
		}

		foreach($this->options->post_types as $post_type){
			add_meta_box(
				$this->options->unique_id, // Unique ID
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

		//Load Font Awesome
        wp_register_style( 'font-awesome', TEMPLATE_PATH.'/css/font-awesome.css' );
        wp_enqueue_style( 'font-awesome', TEMPLATE_PATH.'/css/font-awesome.css' );

		//Load CSS
        add_action('admin_footer', array(&$this, 'load_css'), 998);
        //Load JS
        add_action('admin_footer', array(&$this, 'load_js'), 999);

		$icon_list = array(
		             //0 => 'fa-glass',
		             //1 => 'fa-music',
		             2 => 'fa-search',
		             3 => 'fa-envelope',
		             //4 => 'fa-heart',
		             //5 => 'fa-star',
		             //6 => 'fa-star-empty',
		             7 => 'fa-user',
		             //8 => 'fa-film',
		             9 => 'fa-th-large',
		             10 => 'fa-th',
		             11 => 'fa-th-list',
		             12 => 'fa-ok',
		             13 => 'fa-remove',
		             14 => 'fa-zoom-in',
		             15 => 'fa-zoom-out',
		             16 => 'fa-off',
		             17 => 'fa-signal',
		             18 => 'fa-cog',
		             //19 => 'fa-trash',
		             20 => 'fa-home',
		             21 => 'fa-file',
		             //22 => 'fa-time',
		             //23 => 'fa-road',
		             24 => 'fa-download-alt',
		             25 => 'fa-download',
		             26 => 'fa-upload',
		             27 => 'fa-inbox',
		             28 => 'fa-play-circle',
		             29 => 'fa-repeat',
		             30 => 'fa-refresh',
		             31 => 'fa-list-alt',
		             32 => 'fa-lock',
		             //33 => 'fa-flag',
		             //34 => 'fa-headphones',
		             //35 => 'fa-volume-off',
		             //36 => 'fa-volume-down',
		             //37 => 'fa-volume-up',
		             38 => 'fa-qrcode',
		             //39 => 'fa-barcode',
		             40 => 'fa-tag',
		             41 => 'fa-tags',
		             42 => 'fa-book',
		             43 => 'fa-bookmark',
		             44 => 'fa-print',
		             45 => 'fa-camera',
		             //46 => 'fa-font',
		             //47 => 'fa-bold',
		             //48 => 'fa-italic',
		             //49 => 'fa-text-height',
		             //50 => 'fa-text-width',
		             51 => 'fa-align-left',
		             52 => 'fa-align-center',
		             53 => 'fa-align-right',
		             54 => 'fa-align-justify',
		             55 => 'fa-list',
		             //56 => 'fa-indent-left',
		             //57 => 'fa-indent-right',
		             //58 => 'fa-facetime-video',
		             59 => 'fa-picture',
		             60 => 'fa-pencil',
		             61 => 'fa-map-marker',
		             //62 => 'fa-adjust',
		             //63 => 'fa-tint',
		             64 => 'fa-edit',
		             65 => 'fa-share',
		             66 => 'fa-check',
		             //67 => 'fa-move',
		             //68 => 'fa-step-backward',
		             //69 => 'fa-fast-backward',
		             //70 => 'fa-backward',
		             //71 => 'fa-play',
		             //72 => 'fa-pause',
		             //73 => 'fa-stop',
		             //74 => 'fa-forward',
		             //75 => 'fa-fast-forward',
		             //76 => 'fa-step-forward',
		             //77 => 'fa-eject',
		             //78 => 'fa-chevron-left',
		             //79 => 'fa-chevron-right',
		             //80 => 'fa-plus-sign',
		             //81 => 'fa-minus-sign',
		             //82 => 'fa-remove-sign',
		             //83 => 'fa-ok-sign',
		             //84 => 'fa-question-sign',
		             85 => 'fa-info-sign',
		             //86 => 'fa-screenshot',
		             //87 => 'fa-remove-circle',
		             //88 => 'fa-ok-circle',
		             //89 => 'fa-ban-circle',
		             //90 => 'fa-arrow-left',
		             //91 => 'fa-arrow-right',
		             //92 => 'fa-arrow-up',
		             //93 => 'fa-arrow-down',
		             94 => 'fa-share-alt',
		             //95 => 'fa-resize-full',
		             //96 => 'fa-resize-small',
		             97 => 'fa-plus',
		             //98 => 'fa-minus',
		             99 => 'fa-asterisk',
		             100 => 'fa-exclamation-sign',
		             //101 => 'fa-gift',
		             //102 => 'fa-leaf',
		             //103 => 'fa-fire',
		             //104 => 'fa-eye-open',
		             //105 => 'fa-eye-close',
		             106 => 'fa-warning-sign',
		             //107 => 'fa-plane',
		             108 => 'fa-calendar',
		             109 => 'fa-random',
		             110 => 'fa-comment',
		             111 => 'fa-magnet',
		             //112 => 'fa-chevron-up',
		             //113 => 'fa-chevron-down',
		             114 => 'fa-retweet',
		             //115 => 'fa-shopping-cart',
		             116 => 'fa-folder-close',
		             117 => 'fa-folder-open',
		             //118 => 'fa-resize-vertical',
		             //119 => 'fa-resize-horizontal',
		             120 => 'fa-bar-chart',
		             //121 => 'fa-twitter-sign',
		             //122 => 'fa-facebook-sign',
		             //123 => 'fa-camera-retro',
		             //124 => 'fa-key',
		             125 => 'fa-cogs',
		             126 => 'fa-comments',
		             //127 => 'fa-thumbs-up',
		             //128 => 'fa-thumbs-down',
		             //129 => 'fa-star-half',
		             //130 => 'fa-heart-empty',
		             131 => 'fa-signout',
		             //132 => 'fa-linkedin-sign',
		             //133 => 'fa-pushpin',
		             //134 => 'fa-external-link',
		             //135 => 'fa-signin',
		             //136 => 'fa-trophy',
		             //137 => 'fa-github-sign',
		             //138 => 'fa-upload-alt',
		             //139 => 'fa-lemon',
		             140 => 'fa-phone',
		             //141 => 'fa-check-empty',
		             //142 => 'fa-bookmark-empty',
		             //143 => 'fa-phone-sign',
		             //144 => 'fa-twitter',
		             //145 => 'fa-facebook',
		             //146 => 'fa-github',
		             //147 => 'fa-unlock',
		             //148 => 'fa-credit-card',
		             //149 => 'fa-rss',
		             //150 => 'fa-hdd',
		             //151 => 'fa-bullhorn',
		             //152 => 'fa-bell',
		             //153 => 'fa-certificate',
		             //154 => 'fa-hand-right',
		             //155 => 'fa-hand-left',
		             //156 => 'fa-hand-up',
		             //157 => 'fa-hand-down',
		             //158 => 'fa-circle-arrow-left',
		             //159 => 'fa-circle-arrow-right',
		             //160 => 'fa-circle-arrow-up',
		             //161 => 'fa-circle-arrow-down',
		             //162 => 'fa-globe',
		             163 => 'fa-wrench',
		             //164 => 'fa-tasks',
		             //165 => 'fa-filter',
		             //166 => 'fa-briefcase',
		             //167 => 'fa-fullscreen',
		             //168 => 'fa-group',
		             169 => 'fa-link',
		             //170 => 'fa-cloud',
		             //171 => 'fa-beaker',
		             //172 => 'fa-cut',
		             173 => 'fa-copy',
		             174 => 'fa-paper-clip',
		             //175 => 'fa-save',
		             //176 => 'fa-sign-blank',
		             //177 => 'fa-reorder',
		             //178 => 'fa-list-ul',
		             //179 => 'fa-list-ol',
		             //180 => 'fa-strikethrough',
		             //181 => 'fa-underline',
		             //182 => 'fa-table',
		             //183 => 'fa-magic',
		             //184 => 'fa-truck',
		             //185 => 'fa-pinterest',
		             //186 => 'fa-pinterest-sign',
		             //187 => 'fa-google-plus-sign',
		             //188 => 'fa-google-plus',
		             //189 => 'fa-money',
		             //190 => 'fa-caret-down',
		             //191 => 'fa-caret-up',
		             //192 => 'fa-caret-left',
		             //193 => 'fa-caret-right',
		             //194 => 'fa-columns',
		             //195 => 'fa-sort',
		             //196 => 'fa-sort-down',
		             //197 => 'fa-sort-up',
		             198 => 'fa-envelope-alt',
		             //199 => 'fa-linkedin',
		             200 => 'fa-undo',
		             //201 => 'fa-legal',
		             //202 => 'fa-dashboard',
		             //203 => 'fa-comment-alt',
		             //204 => 'fa-comments-alt',
		             //205 => 'fa-bolt',
		             206 => 'fa-sitemap',
		             //207 => 'fa-umbrella',
		             //208 => 'fa-paste',
		             209 => 'fa-lightbulb',
		             //210 => 'fa-exchange',
		             //211 => 'fa-cloud-download',
		             //212 => 'fa-cloud-upload',
		             //213 => 'fa-user-md',
		             //214 => 'fa-stethoscope',
		             //215 => 'fa-suitcase',
		             //216 => 'fa-bell-alt',
		             //217 => 'fa-coffee',
		             //218 => 'fa-food',
		             219 => 'fa-file-alt',
		             //220 => 'fa-building',
		             //221 => 'fa-hospital',
		             //222 => 'fa-ambulance',
		             //223 => 'fa-medkit',
		             //224 => 'fa-fighter-jet',
		             //225 => 'fa-beer',
		             //226 => 'fa-h-sign',
		             //227 => 'fa-plus-sign-alt',
		             //228 => 'fa-double-angle-left',
		             //229 => 'fa-double-angle-right',
		             //230 => 'fa-double-angle-up',
		             //231 => 'fa-double-angle-down',
		             //232 => 'fa-angle-left',
		             //233 => 'fa-angle-right',
		             //234 => 'fa-angle-up',
		             //235 => 'fa-angle-down',
		             236 => 'fa-desktop',
		             237 => 'fa-laptop',
		             238 => 'fa-tablet',
		             239 => 'fa-mobile-phone',
		             240 => 'fa-circle-blank',
		             241 => 'fa-quote-left',
		             242 => 'fa-quote-right',
		             243 => '\f110 fa-spinner',
		                 244 => 'fa-circle',
		        //   245 => 'fa-reply',
		        //   246 => '\f113 fa-github-alt',
		             247 => 'fa-folder-close-alt',
		             248 => 'fa-folder-open-alt',
		     	);

                wp_nonce_field( basename( __FILE__ ), $this->options->unique_id.'_nonce' );

                $data = get_post_meta($object->ID, $this->options->unique_id, true);

                ?>

                <?php if( $this->options->description ) : ?>
					<p><em><?php echo $this->options->description; ?></em></p>
				<?php endif; ?>

                <div id="icon-preview">
                        <i <?php echo !$data['icon'] ? 'style="display:none;"': '' ; ?> class="fa <?php echo $data['icon']; ?>"></i>
                </div>

                <p>
                    <select id="sc_icon_select" class="widefat" name="<?php echo $this->options->unique_id; ?>[icon]">

                        <option value=""> -- Select -- </option>

                        <?php foreach($icon_list as $key => $icon) : ?>

                            <option class="fa <?php echo $icon; ?>" value="<?php echo $icon; ?>" <?php echo $icon == $data['icon'] ? 'selected' : '' ; ?> ><?php $icon = explode('-', $icon); echo $icon[1]; ?></option>

                        <?php endforeach; ?>

                    </select>
                </p>

                <em>Please view the <a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">Font Awesome Documentation</a> for further details.</em>

	<?php }

	public function load_js(){ ?>

		<script>

            jQuery(document).ready(function($){

            	var container = $('#<?php echo $this->options->unique_id; ?>');

                //Wrap Text in Span (Not Web Standard!)
                container.find('#sc_icon_select option').each(function(){
                    $(this).html('<span> - ' + $(this).text()+'</span>');
                });

                //Display Icon On Select
                container.find('#sc_icon_select').on('change', function(){
                    $('#icon-preview i').show().removeClass().addClass('fa '+$(this).val());
                });

            });

        </script>

	<?php }

	public function load_css(){ ?>

		<style>

            #icon-preview {
                    text-align:center; 
                    font-size:70px;
            }

            #icon-preview i {
            	display: inline-block;
            	padding:10px 0;
            }

            #sc_icon_select option {
                    display: block;
                    font-size: 18px;
                    color:#333333;
            }

            #sc_icon_select option span {
                    font-family: sans-serif;
                    font-size: 13px;
            }

	    </style>

	<?php }

	public function custom_meta_save($post_id, $post=false){

		/* Verify the nonce before proceeding. */
		if ( !isset( $_POST[$this->options->unique_id.'_nonce'] ) || !wp_verify_nonce( $_POST[$this->options->unique_id.'_nonce'], basename( __FILE__ ) ) ){
			return $post_id;
		}

		/* Get the post type object. */
		$post_type = get_post_type_object( $post->post_type );

		/* Get the posted data and sanitize it for use as an HTML class. */
		$new_meta_value = ( isset( $_POST[$this->options->unique_id] ) ? sanitize_html_class( $_POST[$this->options->unique_id] ) : '' );

		/* Get the meta value of the custom field key. */
		$meta_value = get_post_meta( $post_id, $this->options->unique_id, true );

		/* If a new meta value was added and there was no previous value, add it. */
		if ( $new_meta_value && '' == $meta_value ){
			add_post_meta( $post_id, $this->options->unique_id, $new_meta_value, true );
		}

		/* If the new meta value does not match the old value, update it. */
		elseif ( $new_meta_value && $new_meta_value != $meta_value ){
			update_post_meta( $post_id, $this->options->unique_id, $new_meta_value );
		}

		/* If there is no new meta value but an old value exists, delete it. */
		elseif ( '' == $new_meta_value && $meta_value ){
			delete_post_meta( $post_id, $this->options->unique_id, $meta_value );
		}


	}

	public function custom_meta_setup() {

		//Add Box
		add_action( 'add_meta_boxes', array(&$this, 'custom_meta_add' ));

		//Save Box
		add_action( 'save_post', array(&$this, 'custom_meta_save'));
		
	}

	public function __construct($params = array()){

		//Check Unique ID Isset
		if( !isset($params['unique_id']) ){
			return false;
		}

		//Create 'Options' Object
		$this->options = (object)array_merge($this->build_options(), $params);

		add_action( 'init', array(&$this, 'custom_meta_setup'));

	}
	
}


?>