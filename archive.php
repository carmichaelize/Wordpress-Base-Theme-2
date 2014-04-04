<?php get_header(); ?>

<div class="content-wrapper left">

	<h1>
		<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
		<?php if (is_category()) : ?>
		 	<!--If this is a category archive -->
			<i class="fa fa-folder-open"></i> Archive for the "<?php single_cat_title(); ?>" Category
		<?php elseif(is_tag() || is_tax() ) : ?>
			<!-- If this is a tag archive -->
			<i class="fa fa-tags"></i> Posts Tagged "<?php single_tag_title(); ?>"
		<?php elseif (is_day()) : ?>
			<!-- If this is a daily archive -->
			<i class="fa fa-calendar"></i> Archive for <?php the_time('F jS, Y'); ?>
		<?php elseif (is_month()) : ?>
			<!-- If this is a monthly archive -->
			<i class="fa fa-calendar"></i> Archive for <?php the_time('F, Y'); ?>
		<?php elseif (is_year()) : ?>
			<!-- If this is a yearly archive -->
			<i class="fa fa-calendar"></i> Archive for <?php the_time('Y'); ?>
		<?php elseif (is_author()) : ?>
			<!-- If this is an author archive -->
			<i class="fa fa-user"></i> Author Archive <?php wp_title(''); ?>
		<?php elseif (isset($_GET['paged']) && !empty($_GET['paged'])) : ?>
			<!-- If this is a paged archive  -->
			Archive
		<?php endif; ?>
	</h1>

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

	<?php else : ?>

		Sorry, No Entries Found

	<?php endif; ?>

</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>