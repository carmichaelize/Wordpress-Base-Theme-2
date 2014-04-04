<?php get_header(); ?>

	<div id="content">

		<h1><i class="icon-search"></i> Search Results for "<?php echo get_search_query(); ?>"</h1>

		<?php if(have_posts()) : ?>

			<?php while(have_posts()) : the_post(); ?>

				<article>

					<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

					<div class="post-meta">

						<i class="fa fa-calendar"></i> <?php the_time('jS M Y') ?>

						<i class="fa fa-folder-open"></i> <?php the_category(', ') ?>

						<?php the_tags('<i class="fa fa-tags"></i>:', ', ', ''); ?>

					</div>

					<?php the_content('Read More >>'); ?>

				</article>

			<?php endwhile; ?>

			<div class="navigation">
				<?php previous_posts_link( 'Newer posts &raquo;' ); ?>
        		<?php next_posts_link('Older &raquo;') ?>
			</div>

		<?php else : ?>

			Sorry, No Results Found For "<?php echo get_search_query(); ?>"

		<?php endif; ?>

	</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>