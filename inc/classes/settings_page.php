<?php

class sc_theme_settings_page {

	public $options;

	public function render_page() { ?>

		<div class='wrap'>
			<?php screen_icon(); ?>
			<h2>Themes Options</h2>

			<form method='post' action='options.php' enctype='multipart/form'>

				<?php settings_fields('sc_theme_options'); //register group name ?>
				<?php do_settings_sections('sc-theme-options'); //page name ?>

				<p class="submit">
					<input type="submit" value="Save Changes" class="button button-primary" id="Update" name="Update">
				</p>

			</form>

		</div>

	<?php }

	public function validate_inputs(){
		//validation
	}

	public function add_page(){
		add_options_page('Theme Options', 'Theme Options', 'administrator', 'sc-theme-options', array($this,'render_page'));
	}

	public function register_settings(){

    	register_setting('sc_theme_options', 'sc_theme_options');

    	//General Contact Details
    	add_settings_section('sc_contact_section', 'Contact Details', array($this, 'validate_inputs'), 'sc-theme-options');
    	add_settings_field('name', 'Contact Name', array($this, 'text_input'), 'sc-theme-options', 'sc_contact_section', array('name'));
    	add_settings_field('address', 'Company Address', array($this, 'textarea_input'), 'sc-theme-options', 'sc_contact_section', array('address'));
    	add_settings_field('phone', 'Phone Number', array($this, 'text_input'), 'sc-theme-options', 'sc_contact_section', array('phone'));
    	add_settings_field('email', 'Email Address', array($this, 'text_input'), 'sc-theme-options', 'sc_contact_section', array('email'));

    	//Social Media Links
    	add_settings_section('sc_social_section', 'Social Media Links', array($this, 'validate_inputs'), 'sc-theme-options');
   		add_settings_field('facebook', 'Facebook URL', array($this, 'text_input'), 'sc-theme-options', 'sc_social_section', array('facebook'));
    	add_settings_field('twitter', 'Twitter URL', array($this, 'text_input'), 'sc-theme-options', 'sc_social_section', array('twitter'));
    	add_settings_field('linkedin', 'LinkedIn URL', array($this, 'text_input'), 'sc-theme-options', 'sc_social_section', array('linkedin'));
        //add_settings_field('googleplus', 'GooglePlus URL', array($this, 'text_input'), 'sc-theme-options', 'sc_social_section', array('googleplus'));

    	//Social Media Links
    	add_settings_section('sc_analytics_section', 'Analytics & SEO', array($this, 'validate_inputs'), 'sc-theme-options');
    	add_settings_field('google_analytics_key', 'Google Analytics Key', array($this, 'text_input'), 'sc-theme-options', 'sc_analytics_section', array('google_analytics_key'));

    	//Special Page Settings
    	//add_settings_section('sc_page_select_section', 'Special Page Settings', array($this, 'validate_inputs'), 'sc-theme-options');
    	//add_settings_field('contact_page', 'Contact Page', array($this, 'page_select_input'), 'sc-theme-options', 'sc_page_select_section', array('contact_page'));

	}

	//Render text input
    public function text_input($args){
        echo "<input class='regular-text' type='text' name='sc_theme_options[{$args[0]}]' value='{$this->options->{$args[0]}}' />";
    }

    //Render textarea input
    public function textarea_input($args){
        echo "<textarea class='sc_mockingbird_input' type='text' name='sc_theme_options[{$args[0]}]' style='width:298px;'>{$this->options->{$args[0]}}</textarea>";
    }

    //Checkbox input
    public function plugin_checkbox_input($args){
        $checked = $this->options->{$args[0]} ? "checked='checked'": "";
        echo "<input type='checkbox' name='sc_theme_options[{$args[0]}]' {$checked} />";
    }

    //Render Page Select input
    public function page_select_input($args){
        $argss = array(
            'post_type' => 'page',
            'orderby' => 'title',
            'order'  => 'ASC',
            'posts_per_page' => -1
        );
        $pages = new Wp_Query($argss);
        $pages = $pages->posts;
        wp_reset_query();
        echo "<select class='regular-text' type='text' name='sc_theme_options[{$args[0]}]'>";
        echo "<option value='0'>-- Select Page --</option>";
            foreach($pages as $page){
                $selected = $this->options->{$args[0]} == $page->ID ? "selected='selected'" : "";
                echo "<option value='{$page->ID}' {$selected}>{$page->post_title}</option>";
            }
        echo "</select>";
    }

	public function __construct(){
		//Get and Set Previously Saved Data
		$this->options = (object)get_option('sc_theme_options');
		add_action("admin_menu", array($this, "add_page"));
		add_action('admin_init', array($this, "register_settings"));
	}
}

?>