<?php get_header(); ?>

<?php
/*
if( is_front_page() ) : ?>
	<?php include('templates/page_home.php'); ?>
elseif( sc_is_page( contact_page ) ) : ?>
	<?php include('templates/page_contact.php'); ?>
<?php else : ?>
	<?php include('templates/page_standard.php'); ?>
<?php endif;
*/
?>

	<div class="content-wrapper left">
		<?php if(have_posts()) : ?>

			<?php while(have_posts()) : the_post(); ?>

				<h1><?php the_title(); ?></h1>

				<?php the_content(); ?>

			<?php endwhile; ?>

		<?php endif; ?>
	</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>