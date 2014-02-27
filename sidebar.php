<div class="sidebar right">

	<?php if ( function_exists('dynamic_sidebar') ) echo "<ul>"; dynamic_sidebar(); echo "</ul>"; ?>

</div>


<?php/*

	$post_parent = $post->post_parent > 0 ? $post->post_parent : $post->ID;

	$args = array(
		'post_type'      => 'page',
		'post_parent'	 => $post_parent,
		'post_status'    => 'publish',
		'orderby' 	     => 'menu_order',
		'order'		     => 'ASC'
		);
	$post_query = new Wp_Query($args);
	wp_reset_query();

	$menu = array_merge(array(get_post($post_parent)), $post_query->posts);

?>

<?php if(count($menu) > 1) : ?>

	<div class="sidebar left red">

		<h2><a href="<?php echo get_permalink($menu[0]->ID); ?>"><?php echo $menu[0]->post_title; ?></a></h2>

		<ul class="sidemenu no-list">
			<?php if( isset($menu[1]) ) : array_shift($menu); ?>
				<?php foreach($menu as $item): ?>
					<li <?php echo $item->ID == $post->ID ? "class='current'" : ""; ?>>
						<a href="<?php echo get_permalink($item->ID); ?>"><?php echo $item->post_title; ?></a>
					</li>
				<?php endforeach; ?>
			<?php endif; ?>
		</ul>

	</div>

<?php endif;*/ ?>