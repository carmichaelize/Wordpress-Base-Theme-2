<h1>Home Page</h1>

	<div class="content-wrapper left">
		<?php if(have_posts()) : ?>

			<?php while(have_posts()) : the_post(); ?>

				<h1><?php the_title(); ?></h1>

				<?php the_content(); ?>

			<?php endwhile; ?>

		<?php endif; ?>
	</div>

<?php get_sidebar(); ?>