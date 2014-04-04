<?php get_header(); ?>

<div class="content-wrapper left">

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

		<div class="pagination">

			<?php

				$current_page = max( 1, get_query_var('paged') );
				$total_pages = $wp_query->max_num_pages;

				$args = array(
					'base'     => esc_url(get_pagenum_link()).'?paged=%#%',
					'format'   => '?paged=%#%',
					'total'    => $total_pages,
					'current'  => max( 1, get_query_var('paged') ),
					'show_all' => true,
					//'end_size'     => 1,
					//'mid_size'     => 2,
					//'prev_next'    => True,
					//'prev_text'    => __('« Previous'),
					//'next_text'    => __('Next »'),
					//'type'         => 'plain',
					//'add_args'     => False,
					//'add_fragment' => ''
				);

				echo paginate_links($args);

			?>
		</div>

	<?php else: ?>

		Sorry, No Entries Found

	<?php endif; ?>

</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>