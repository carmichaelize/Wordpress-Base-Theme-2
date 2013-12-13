http://codex.wordpress.org/AJAX_in_Plugins


Usage

$related_posts = get_dispatcher( $id, $return_posts, $key );

Parameters

$id (integer) (optional)

The ID of the post from which you want the data. Use get_the_ID() while in The Loop to get the post’s ID, or use your sub-loop’s post object ID property (eg $my_post_object->ID). You may also use the global $post object’s ID property (eg $post->ID), but this may not always be what you intend.

Default: none

$return_posts (boolean) (optional)

A boolean value specifing the type of result you wish to return. By default an array of related id will be returned, by setting this value to true an array of post will be returned instead, it should be noted that these posts are always ordered in the order they are saved. To change the ordering of related posts, use the returned a array of id to perforn you’re own custom wp query which will give you further control over how related results are extracted from WordPress.

Default: false

$key (string) (optional)

A string value specifiy the meta key used to retried the saved dispatcher values. If extra instances of dispatcher have been set up a unique key is required to distinquish it from other instances. Aimed at advanced development, its unlikely for convential development that you will need to deviate from the default key.

Default: 'sc_dispatcher'

Return Value

If $id is left blank the function return results for the current post, page or custom post type.
If $id is specified, the function will return results for the specified post, page or custom post type.
If $return_posts is set to false, the function will return an array of related ids.
If $return_posts is set to true, the function will return an array of related posts.


Usage

dispatcher( $id, $custom_styles, $key );

Parameters

$id (integer) (optional)

The ID of the post from which you want the data. Use get_the_ID() while in The Loop to get the post’s ID, or use your sub-loop’s post object ID property (eg $my_post_object->ID). You may also use the global $post object’s ID property (eg $post->ID), but this may not always be what you intend.

Default: none

$custom_styles (array) (optional)

An array of specified styling when outputig/printing the list. This provides a framework for styling the list of results, again this may prove restritive for more advance development where it might be more approiate to output the list m,anually from returned data.

“wrapper” – html tag to use as list container. Defaults to “<ul>”.
“before” – html to appear before item, typically an opening tag. Defaults to “<li>”.
“after” – html to appear after item, typically a closing tag. Defaults to “</li>”.
“before_title” – html to appear before item title, typically an opening tag. Defaults to “<h2>”.
“after_title” – html to appear after item title, typically a closing tag. Defaults to “</h2>”.

Default: array()





Examples

Get related ids for the current post, page or custom post type.

<pre><?php $related_posts = dispatcher(); ?></pre>

Get related posts for the current post, page or custom post type.

<pre><?php $related_posts = dispatcher( get_the_id(), true ); ?></pre>

Get related ids for the post with the id 22.

<pre><?php $related_posts = dispatcher( 22, true ); ?></pre>

Get related ids for the current post, page or custom post type from a custom key.

<pre><?php $related_posts = dispatcher( 22, true ); ?></pre>


Print related posts for the current post, page or custom post type and apply custom styling.

$styles= array(
	'before_title' => '<h2 class="related-posts">',
	'after_title' => '</h2>'
);
dispatcher(get_the_id(), $styles );

Print related posts for the post with an id of 5.

<?php dispatcher( 5 ); ?>

Print related posts for the current post, page or custom post type from a custom key.

<?php dispatcher(get_the_id(), array(), ); ?>




Mockingbird Shortcode

The mockingbird shortcode lets you add related lists into the post body content without having to edit any theme or template files.
It will output the list for either the current post or for a specified one that is passed to the id attribute.

Usage

[mockingbird id="$id" title="$title"]

Attributes

id (integer) (optional)
The ID of the post for the list to output the list. Leave blank to get the current post.

title (string) (optional)
The title for the outputed list, if this is left blank the title will default to title set in the Mockingbird settings.

Notes

The shortcode is intented for basic usage so styling of the outputed list will inherit those set in the Mockingbird settings. For more advance usage consider using the mockingbird() in the theme template files instead.

Notes

Mockingbird Admin Class

Multiple Mockingbird instances can be created manually using the Mockingbird_admin class. This will allow for more than one Mockingbird to be displayed on an individual post type (with different configuration) to be installed.

Usage

new Mockingbird_admin( $unique_key, $params );

Parameters

$unique_key (string) (required)

A string value specifing the unique key used to save data to the Wordpress post_meta table. The unique key is required to seperate data from different Mockingbird instances preventing any plugin conflicts.

Default: none

$params (array) (optional)

An array of specified configuration values for the Mockingbird instance. This provides a framework outling how the instance should behave.

"display_on" - an array of post types to display. Defaults to array("post").
"types_to_display" - an array of post types to choose from. Defaults to array("post").
"show_on" - an array of post ids to display on. Defaults to array().
"title" - a string to display as the metabox title. Defaults to "Related Content".
"description" - a string to display as the metabox summary. Defaults to "Choose Items".
"priority" - (default, core, high, low). Defaults to "default".
"context" - position of the metabox (normal, side, advanced). Defaults to "side".

Default: array()

Notes
If a unique key is not supplied the Mockingbird_admin class will simple overide the initial plugin instance with any new configuration set by the $params array.
As this function is creating a new instance, the saved Mockingbird configuration and settings will not be applied to the new instance. Any intended deviation from the default settings has to be configured manually using the $params array.

Examples

Set up a new Mockingbird instance to stored related testimonials.

$params = array(
			'display_on'		=> array('page', 'project'),
			'types_to_display'  => array('testimonials'),
			'title' 		    => 'Client Feedback',
			'priority'			=> 'default',
			'context'			=> 'side',
);
new Mockingbird_admin( 'my_feedback', $params );

A development API for further theme integration including the ability too:

Get related post id array for the current post, page or custom post type.
Get related post id array by the id of a post, page or custom post type.
Get related post data array for post, page or custom post type.
Output related list for the current post, page or custom post type.
Output related list by the id of a post, page or custom post type.
Style outputted list with a custom style array.
Set up multiple Mockingbird instances with indivudal configurations.

for deeper level theme integration and development.

Short

//Validate / sanatise settings page.