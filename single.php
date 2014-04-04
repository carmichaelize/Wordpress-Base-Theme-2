<?php get_header(); ?>

<div class="content-wrapper left">

	<?php if(have_posts()) : ?>

		<?php while(have_posts()) : the_post(); ?>

				<h1><?php the_title(); ?></h1>

				<div class="post-meta">

					<i class="fa fa-calendar"></i> <?php the_time('jS M Y') ?>

					<i class="fa fa-folder-open"></i> <?php the_category(', ') ?>

					<?php the_tags('<i class="fa fa-tags"></i>:', ', ', ''); ?>

				</div>

				<?php //the_post_thumbnail(); ?>

				<?php the_content('Read More >>'); ?>

		<?php endwhile; ?>

		<div class="navigation">
			<?php previous_post_link('< %link') ?> <?php next_post_link(' %link >') ?>
		</div>

	<?php endif; ?>
</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>