<?php
	$images_thumb = get_page_images(get_the_id(), 'sc_gallery', 'sc_gallery');
	$images_large = get_page_images(get_the_id(), 'sc_gallery', 'large');
?>

<?php if( $images_thumb ) : $count = 1; ?>

	<ul id="gallery">

		<?php foreach($images_thumb as $thumb) : ?>

			<li class="<?php echo $count % 3 == 0 ? 'right' : 'left'; ?>">
				<a href="<?php echo $images_large[$count-1][0]; ?>" rel="example_group">
					<img src="<?php echo $thumb[0]; ?>" alt="<?php echo $thumb[5]; ?>" />
				</a>
			</li>

		<?php $count++; endforeach; ?>

		<li class="clear"></li>

	<ul>

<?php endif; ?>