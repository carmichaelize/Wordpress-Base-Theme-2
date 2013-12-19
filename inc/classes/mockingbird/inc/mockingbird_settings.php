<?php

class Mockingbird_settings extends Mockingbird {

    public function render_page() { ?>

        <div class='wrap'>
            <div class="icon32" id="icon-options-general"><br></div>
            <h2>Mockingbird Settings</h2>

            <form method='post' action='options.php' enctype='multipart/form'>

                <?php settings_fields( $this->unique_key."_options" ); //register group name ?>
                <?php do_settings_sections( $this->options->options_page ); //page name ?>

                <p class="submit">
                    <input type="submit" value="Save Changes" class="button button-primary" id="Update" name="Update">
                </p>

            </form>

        </div>

    <?php }

    public function validate_inputs( $input ){
        //exit;
    }

    public function form_validation( $input ){

        //Select Box Validation
        if( !isset($input['types_to_display']) ){
            $input['types_to_display'] = array();
        }

        if( !isset($input['display_on']) ){
            $input['display_on'] = array();
        }

        $show_ons = array();
        foreach( $input['show_on'] as $show_on ){
            $show_ons[] = (int)$show_on;
        }
        $input['show_on'] = $show_ons;

        return $input;
    }

    public function add_page(){
        add_utility_page(
            'Mockingbird Settings',
            'Mockingbird',
            'manage_options',
            $this->options->options_page,
            array($this,'render_page')
        );
    }

    public function register_settings(){

        register_setting( $this->unique_key."_options", $this->unique_key."_options", array($this, 'form_validation') );

        //General Plugin Setting
        add_settings_section('sc_mockingbird_section', 'Plugin Configuration', array($this, 'validate_inputs'), $this->options->options_page);
        add_settings_field('types_to_display', 'Post types to filter:', array($this, 'plugin_post_type_input'), $this->options->options_page, 'sc_mockingbird_section', array('types_to_display'));
        add_settings_field('displayon', 'Post types to appear on:', array($this, 'plugin_post_type_input'), $this->options->options_page, 'sc_mockingbird_section', array('display_on'));
        add_settings_field('show_on', 'Individual posts to appear on:', array($this, 'showon_input'), $this->options->options_page, 'sc_mockingbird_section');
        add_settings_field('allow_relabel', 'Allow list item relabeling:', array($this, 'plugin_checkbox_input'), $this->options->options_page, 'sc_mockingbird_section', array('allow_relabel'));
        add_settings_field('render', 'Automatically display list at the bottom of each post:', array($this, 'plugin_checkbox_input'), $this->options->options_page, 'sc_mockingbird_section', array('render'));

        //Plugin Labeling
        add_settings_section('sc_mockingbird_labeling_section', 'Admin / Label Settings', array($this, 'validate_inputs'), $this->options->options_page);
        add_settings_field('plugin_title', 'Title:', array($this, 'plugin_text_input'), $this->options->options_page, 'sc_mockingbird_labeling_section', array('title'));
        add_settings_field('plugin_description', 'Description:', array($this, 'plugin_textarea_input'), $this->options->options_page, 'sc_mockingbird_labeling_section', array('description'));
        add_settings_field('plugin_context', 'Admin context:', array($this, 'plugin_select_input'), $this->options->options_page, 'sc_mockingbird_labeling_section', array('context', array('side', 'normal', 'advanced')));
        add_settings_field('plugin_priority', 'Admin priority:', array($this, 'plugin_select_input'), $this->options->options_page, 'sc_mockingbird_labeling_section', array('priority', array('default', 'core', 'high', 'low')));

        //Plugin Styling
        add_settings_section('sc_mockingbird_styling_section', 'List Style Settings', array($this, 'validate_inputs'), $this->options->options_page);
        add_settings_field('container_class', 'Container class:', array($this, 'plugin_text_input'), $this->options->options_page, 'sc_mockingbird_styling_section', array('container_class'));
        add_settings_field('wrapper', 'Wrapper tag:', array($this, 'plugin_text_input'), $this->options->options_page, 'sc_mockingbird_styling_section', array('wrapper'));
        add_settings_field('before', 'Before item:', array($this, 'plugin_text_input'), $this->options->options_page, 'sc_mockingbird_styling_section', array('before'));
        add_settings_field('after', 'After item:', array($this, 'plugin_text_input'), $this->options->options_page, 'sc_mockingbird_styling_section', array('after'));
        add_settings_field('before_title', 'Before title:', array($this, 'plugin_text_input'), $this->options->options_page, 'sc_mockingbird_styling_section', array('before_title'));
        add_settings_field('after_title', 'After title:', array($this, 'plugin_text_input'), $this->options->options_page, 'sc_mockingbird_styling_section', array('after_title'));
        add_settings_field('include_thumbnail', 'Include thumbnail:', array($this, 'plugin_checkbox_input'), $this->options->options_page, 'sc_mockingbird_styling_section', array('include_thumbnail'));
        add_settings_field('include_excerpt', 'Include excerpt:', array($this, 'plugin_checkbox_input'), $this->options->options_page, 'sc_mockingbird_styling_section', array('include_excerpt'));
        add_settings_field('excerpt_length', 'Excerpt length:', array($this, 'plugin_text_input'), $this->options->options_page, 'sc_mockingbird_styling_section', array('excerpt_length'));
        add_settings_field('excerpt_link_text', 'Excerpt link text (leave blank to hide):', array($this, 'plugin_text_input'), $this->options->options_page, 'sc_mockingbird_styling_section', array('excerpt_link_text'));

    }

    //Render Inputs

    public function showon_input(){

        //Get Posts
        $args = array(
            'post_type' =>  $this->get_post_types(),
            'order' => 'ASC',
            'orderby' => 'title',
            'posts_per_page'=>-1
            );
        $post_query = new WP_Query( $args );
        $posts = $post_query->posts;

        ?>

        <select class="sc_mockingbird_input" name="<?php echo $this->unique_key."_options"; ?>[show_on][]" multiple style="width:292px;">

            <?php foreach( $posts as $post ): ?>

                <option value="<?php echo $post->ID; ?>" <?php echo isset( $this->options->show_on ) && in_array( $post->ID, $this->options->show_on ) ? "selected='selected'" : "" ; ?>>
                    <?php echo $post->post_title; ?>
                </option>

            <?php endforeach; ?>

        </select>

        <?php

        wp_reset_postdata();

    }

    //Render post type selects
    public function plugin_post_type_input($args){
        echo "<select class='sc_mockingbird_input' name='{$this->unique_key}_options[$args[0]][]' multiple style='width:292px;'>";
        foreach( $this->get_post_types() as $post_type ){
            $selected = isset( $this->options->{$args[0]} ) && in_array( $post_type, $this->options->{$args[0]} ) ? "selected='selected'" : "" ;
            echo "<option value='{$post_type}' {$selected}>{$post_type}</option>";
        }
        echo "</select>";
    }

    //Render text input
    public function plugin_text_input($args){
        echo "<input class='regular-text' type='text' name='{$this->unique_key}_options[{$args[0]}]' value='{$this->options->{$args[0]}}' />";
    }

    //Render textarea input
    public function plugin_textarea_input($args){
        echo "<textarea class='sc_mockingbird_input' type='text' name='{$this->unique_key}_options[{$args[0]}]' style='width:298px;'>{$this->options->{$args[0]}}</textarea>";
    }

    //Render checkbox input
    public function plugin_checkbox_input($args){
        $checked = $this->options->{$args[0]} ? "checked='checked'": "";
        echo "<input type='checkbox' name='{$this->unique_key}_options[{$args[0]}]' {$checked} />";
    }

    //Render select input
    public function plugin_select_input($args){
        echo "<select class='sc_mockingbird_input' name='sc_mockingbird_options[{$args[0]}]'>";
        foreach( $args[1] as $option){
            $selected = $this->options->{$args[0]} == $option ? "selected='selected'": "";
            echo "<option value='{$option}' {$selected}>".ucfirst($option)."</option>";
        }
        echo "</select>";
    }

    public function your_plugin_settings_link( $links ){
        $settings_link = '<a href="options-general.php?page='.$this->options->options_page.'">Settings</a>';
        array_unshift( $links, $settings_link );
        return $links;
    }

    public function __construct(){

        //Build Options
        $this->build_options();

        add_action( "admin_menu", array($this, "add_page") );
        add_action( 'admin_init', array($this, "register_settings") );

        //Add settings link on plugin page
        $plugin = plugin_basename( MOCKINGBIRD_SERVER_PATH.'/index.php' );
        add_filter( "plugin_action_links_$plugin", array($this, 'your_plugin_settings_link') );

    }
}

?>