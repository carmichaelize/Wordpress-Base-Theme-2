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
        //var_dump($input);
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
        add_settings_section('sc_mockingbird_section', 'Main Plugin Configuration', array($this, 'validate_inputs'), $this->options->options_page);
        add_settings_field('types_to_display', 'Post types to filter', array($this, 'typestodisplay_input'), $this->options->options_page, 'sc_mockingbird_section');
        add_settings_field('displayon', 'Post types to appear on', array($this, 'displayon_input'), $this->options->options_page, 'sc_mockingbird_section');
        add_settings_field('show_on', 'Individual posts to appear on', array($this, 'showon_input'), $this->options->options_page, 'sc_mockingbird_section');
        add_settings_field('render', 'Automatically display at bottom of posts', array($this, 'render_in_content'), $this->options->options_page, 'sc_mockingbird_section');

        //Plugin Labeling
        add_settings_section('sc_mockingbird_labeling_section', 'Admin / Label Settings', array($this, 'validate_inputs'), $this->options->options_page);
        add_settings_field('plugin_title', 'Title', array($this, 'plugin_title_input'), $this->options->options_page, 'sc_mockingbird_labeling_section');
        add_settings_field('plugin_description', 'Description', array($this, 'plugin_description_input'), $this->options->options_page, 'sc_mockingbird_labeling_section');
        add_settings_field('plugin_context', 'Admin Context', array($this, 'plugin_context_input'), $this->options->options_page, 'sc_mockingbird_labeling_section');
        add_settings_field('plugin_priority', 'Admin Priority', array($this, 'plugin_priority_input'), $this->options->options_page, 'sc_mockingbird_labeling_section');

        //Plugin Styling
        add_settings_section('sc_mockingbird_styling_section', 'Style Settings', array($this, 'validate_inputs'), $this->options->options_page);
        add_settings_field('container_class', 'Container Class', array($this, 'container_class_input'), $this->options->options_page, 'sc_mockingbird_styling_section');
        add_settings_field('wrapper', 'Wrapper', array($this, 'wrapper_input'), $this->options->options_page, 'sc_mockingbird_styling_section');
        add_settings_field('before', 'Before item', array($this, 'before_input'), $this->options->options_page, 'sc_mockingbird_styling_section');
        add_settings_field('after', 'After item', array($this, 'after_input'), $this->options->options_page, 'sc_mockingbird_styling_section');
        add_settings_field('before_title', 'Before title', array($this, 'before_title_input'), $this->options->options_page, 'sc_mockingbird_styling_section');
        add_settings_field('after_title', 'After title', array($this, 'after_title_input'), $this->options->options_page, 'sc_mockingbird_styling_section');
        add_settings_field('include_thumbnail', 'Include Thumbnail', array($this, 'include_thumbnail_input'), $this->options->options_page, 'sc_mockingbird_styling_section');
        add_settings_field('include_excerpt', 'Include Excerpt', array($this, 'include_excerpt_input'), $this->options->options_page, 'sc_mockingbird_styling_section');
        add_settings_field('excerpt_length', 'Excerpt Length', array($this, 'excerpt_length_input'), $this->options->options_page, 'sc_mockingbird_styling_section');
        add_settings_field('excerpt_link_text', 'Excerpt Link Text (leave blank to hide)', array($this, 'excerpt_link_text_input'), $this->options->options_page, 'sc_mockingbird_styling_section');

    }

    //Render Inputs

    public function displayon_input(){

        $post_types = get_post_types( array('public'=>true) );
        unset($post_types['attachment']);

        ?>

        <select class="sc_mockingbird_input" name="<?php echo $this->unique_key."_options"; ?>[display_on][]" multiple style="width:292px;">

            <?php foreach( $post_types as $post_type ): ?>

                <option value="<?php echo $post_type; ?>" <?php echo isset( $this->options->display_on ) && in_array( $post_type, $this->options->display_on ) ? "selected='selected'" : "" ; ?>>
                    <?php echo $post_type; ?>
                </option>

            <?php endforeach; ?>

        </select>

    <?php }

    public function typestodisplay_input(){

        $post_types = get_post_types( array('public'=>true) );
        unset($post_types['attachment']);

        ?>

        <select class="sc_mockingbird_input" name="<?php echo $this->unique_key."_options"; ?>[types_to_display][]" multiple style="width:292px;">

            <?php foreach( $post_types as $post_type ): ?>

                <option value="<?php echo $post_type; ?>" <?php echo isset( $this->options->types_to_display ) && in_array( $post_type, $this->options->types_to_display ) ? "selected='selected'" : "" ; ?>>
                    <?php echo $post_type; ?>
                </option>

            <?php endforeach; ?>

        </select>

    <?php }

    public function showon_input(){

        //Get Posts
        $args = array(
            'post_type' => get_post_types( array('public'=>true) ),
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

    public function render_in_content(){
        $checked = $this->options->render ? "checked='checked'": "";
        echo "<input type='checkbox' name='sc_mockingbird_options[render]' {$checked} />";
    }

    public function plugin_title_input(){ ?>
        <input class='regular-text' type='text' name='sc_mockingbird_options[title]' value='<?php echo $this->options->title; ?>' />
    <?php }

    public function plugin_description_input(){ ?>
        <textarea class="sc_mockingbird_input" type='text' name='sc_mockingbird_options[description]' style="width:298px;"><?php echo $this->options->description; ?></textarea>
    <?php }

    public function plugin_context_input(){ ?>
        <select class="sc_mockingbird_input" name='sc_mockingbird_options[context]'>
            <option <?php echo $this->options->context == 'side' ? 'selected="selected"' : '' ; ?> value="side">Side</option>
            <option <?php echo $this->options->context == 'normal' ? 'selected="selected"' : '' ; ?> value="normal">Normal</option>
            <option <?php echo $this->options->context == 'advanced' ? 'selected="selected"' : '' ; ?> value="advanced">Advanced</option>
        </select>
    <?php }

    public function plugin_priority_input(){ ?>
        <select class="sc_mockingbird_input" name='sc_mockingbird_options[priority]'>
            <option <?php echo $this->options->priority == 'default' ? 'selected="selected"' : '' ; ?> value="default">Default</option>
            <option <?php echo $this->options->priority == 'core' ? 'selected="selected"' : '' ; ?> value="core">Core</option>
            <option <?php echo $this->options->priority == 'high' ? 'selected="selected"' : '' ; ?> value="high">High</option>
            <option <?php echo $this->options->priority == 'low' ? 'selected="selected"' : '' ; ?> value="low">Low</option>
        </select>
    <?php }

    public function container_class_input(){ ?>
        <input class='regular-text' type='text' name='sc_mockingbird_options[container_class]' value='<?php echo $this->options->container_class; ?>' />
    <?php }

    public function wrapper_input(){ ?>
        <input class='regular-text' type='text' name='sc_mockingbird_options[wrapper]' value='<?php echo $this->options->wrapper; ?>' />
    <?php }

    public function before_input(){ ?>
        <input class='regular-text' type='text' name='sc_mockingbird_options[before]' value='<?php echo $this->options->before; ?>' />
    <?php }

    public function after_input(){ ?>
        <input class='regular-text' type='text' name='sc_mockingbird_options[after]' value='<?php echo $this->options->after; ?>' />
    <?php }

    public function before_title_input(){ ?>
        <input class='regular-text' type='text' name='sc_mockingbird_options[before_title]' value='<?php echo $this->options->before_title; ?>' />
    <?php }

    public function after_title_input(){ ?>
        <input class='regular-text' type='text' name='sc_mockingbird_options[after_title]' value='<?php echo $this->options->after_title; ?>' />
    <?php }

    public function include_thumbnail_input(){
        $checked = $this->options->include_thumbnail ? "checked='checked'": "";
        echo "<input type='checkbox' name='sc_mockingbird_options[include_thumbnail]' {$checked} />";
    }

    public function include_excerpt_input(){
        $checked = $this->options->include_excerpt ? "checked='checked'": "";
        echo "<input type='checkbox' name='sc_mockingbird_options[include_excerpt]' {$checked} />";
    }

    public function excerpt_length_input(){ ?>
        <input class='regular-text' type='text' name='sc_mockingbird_options[excerpt_length]' value='<?php echo $this->options->excerpt_length; ?>' />
    <?php }

    public function excerpt_link_text_input(){ ?>
        <input class='regular-text' type='text' name='sc_mockingbird_options[excerpt_link_text]' value='<?php echo $this->options->excerpt_link_text; ?>' />
    <?php }

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