<div class="content-wrapper left">

	<?php if( is_archive() || is_search() ) : ?>

		<?php

			$title_template = "<h1><i class='fa %s'></i> %s</h1>";
			$post = $posts[0]; // Hack. Set $post so that the_date() works.

			if(is_category()){
			 	//category archive
				$archive_title = sprintf( $title_template, 'fa-folder-open', 'Archive for the "'.single_cat_title('', false).'" Category' );
			} elseif(is_tag() || is_tax() ){
				//tag archive
				$archive_title = sprintf( $title_template, 'fa-tags', 'Posts Tagged "'.single_tag_title('', false).'"' );
			} elseif (is_day()){
				//daily archive
				$archive_title = sprintf( $title_template, 'fa-calendar', 'Archive for '.get_the_time('F jS, Y') );
			} elseif (is_month()){
				//monthly archive
				$archive_title = sprintf( $title_template, 'fa-calendar', 'Archive for '.get_the_time('F, Y') );
			} elseif (is_year()){
				//yearly archive
				$archive_title = sprintf( $title_template, 'fa-calendar', 'Archive for '.get_the_time('Y') );
			} elseif (is_author()){
				//author archive
				$archive_title = sprintf( $title_template, 'fa-user', 'Archive for '.wp_title('') );
			} elseif( is_search() ){
				//search archive
				$archive_title = sprintf( $title_template, 'fa-search', 'Search Results for "'.get_search_query().'"' );
			} elseif (isset($_GET['paged']) && !empty($_GET['paged'])){
				//paged archive
				$archive_title = sprintf( $title_template, 'fa-folder-open', 'Archive' );
			}

			echo $archive_title;

		?>

	<?php endif; ?>

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

		<!-- Pagination -->
			<?php if( $pagination = sc_pagination() ) : ?>

				<div class="pagination"><?php echo $pagination; ?></div>

			<?php endif; ?>
		<!-- /Pagination -->

	<?php else: ?>

		Sorry, no enteries found.

	<?php endif; ?>

</div>

<?php get_sidebar(); ?>