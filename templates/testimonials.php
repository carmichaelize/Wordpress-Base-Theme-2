<?php
	$args = array(
		'post_type'      => 'testimonials',
		'post_status'    => 'publish',
		'orderby' 	     => 'menu_order',
		'order'		     => 'ASC',
		'posts_per_page' => -1
		);
	$post_query = new Wp_Query($args);
?>

<?php if( $post_query->have_posts()) : $count = 0; ?>

	<section class="">

		<div class="wrapper">
			<ul>

				<?php while( $post_query->have_posts() ) : $post_query->the_post(); $count++; ?>

					<li>

						<?php $data = (object)get_post_meta(get_the_id(), 'sc_testimonial_details', true ); ?>

						<h3><?php the_title(); ?></h3>

						<div>

							<?php the_content(); ?>

							<?php echo $data->name; echo $data->position || $data->company ? " - " : "";  ?>

							<?php echo $data->position; ?>

							<?php echo $data->company; ?>

						</div>

					</li>

				<?php endwhile; ?>

			</ul>

		</div>

	</section><!-- /.container -->

<?php endif; wp_reset_query(); ?>