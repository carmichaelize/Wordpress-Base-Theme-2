<div class="sidebar right">

	<?php if ( function_exists('dynamic_sidebar') ) echo "<ul class='no-list'>"; dynamic_sidebar(); echo "</ul>"; ?>

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


<?php/*

	$page_id = $post->ID;

	//Menu Data
	$args = array(
			'post_type' => array('page'),
			'post_status' => 'publish',
			'post_parent' => $page_id,
			'orderby' => 'menu_order',
			'order' => 'ASC',
			'posts_per_page' => -1
		);

	$menu = new Wp_Query($args);
	$menu_title = "<a href='".get_permalink()."'>".get_the_title()."</a>";

	if(!$menu->posts && $post->post_parent > 0){
		$args['post_parent'] = $post->post_parent;
		$menu = new Wp_Query($args);
		$menu_title = "<a href='".get_permalink($post->post_parent)."'>".get_the_title($post->post_parent)."</a>";
	}
*/
?>

<?php /*if( $menu->have_posts() ) : ?>

	<div class="sidebar beige right">

		<h2><?php echo $menu_title; ?></h2>

		<?php while($menu->have_posts()) : $menu->the_post(); ?>

			<a class="<?php echo $page_id == get_the_id() ? 'active' : ''; ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>

		<?php endwhile; ?>

	</div>

<?php endif; wp_reset_query();*/ ?>