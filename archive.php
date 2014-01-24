<?php get_header(); ?>

<div class="content-wrapper left">

	<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
	<?php if (is_category()) : ?>
	 	<!--If this is a category archive -->
		<h1><i class="fa fa-folder-open"></i> Archive for the "<?php single_cat_title(); ?>" Category</h1>
	<?php elseif(is_tag() || is_tax() ) : ?>
		<!-- If this is a tag archive -->
		<h1><i class="fa fa-tags"></i> Posts Tagged "<?php single_tag_title(); ?>"</h1>
	<?php elseif (is_day()) : ?>
		<!-- If this is a daily archive -->
		<h1><i class="fa fa-calendar"></i> Archive for <?php the_time('F jS, Y'); ?></h1>
	<?php elseif (is_month()) : ?>
		<!-- If this is a monthly archive -->
		<h1><i class="fa fa-calendar"></i> Archive for <?php the_time('F, Y'); ?></h1>
	<?php elseif (is_year()) : ?>
		<!-- If this is a yearly archive -->
		<h1><i class="fa fa-calendar"></i> Archive for <?php the_time('Y'); ?></h1>
	<?php elseif (is_author()) : ?>
		<!-- If this is an author archive -->
		<h1><i class="fa fa-user"></i> Author Archive <?php wp_title(''); ?></h1>
	<?php elseif (isset($_GET['paged']) && !empty($_GET['paged'])) : ?>
		<!-- If this is a paged archive  -->
		<h1>Archive</h1>
	<?php endif; ?>

	<?php if(have_posts()) : ?>

		<?php while(have_posts()) : the_post(); ?>

			<div class="post">

				<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

				<div class="entry">
				<?php the_content('Read On...'); ?>

					<p class="postmetadata">
					<?php _e('Filed under&#58;'); ?> <?php the_category(', ') ?> <?php _e('by'); ?> <?php  the_author(); ?><br />
					<?php comments_popup_link('No Comments &#187;', '1 Comment &#187;', '% Comments &#187;'); ?> <?php edit_post_link('Edit', ' &#124; ', ''); ?>
					</p>

				</div>

			</div>

		<?php endwhile; ?>

		<div class="navigation">
			<?php posts_nav_link(); ?>
		</div>

	<?php else : ?>

		Sorry, No Entries Found

	<?php endif; ?>

</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>