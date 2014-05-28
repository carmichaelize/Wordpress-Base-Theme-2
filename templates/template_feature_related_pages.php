<!-- Related Pages -->
	<?php if( $related = get_mockingbird(get_the_id(), true, 'sc_related_pages') ) : $related_count = 0; ?>

		<ul class="no-list related-pages">

			<?php foreach( $related as $item ) : $related_count++; ?>

				<li class="<?php echo $related_count % 3 == 0 ? 'right' : 'left'; ?>">

					<a href="<?php echo get_permalink($item->ID); ?>" title="<?php echo $item->post_title; ?>">
						<h2><?php echo $item->post_title; ?></h2>
					</a>

						<!--<div class="related-image">
							<?php if( $thumbnail = get_the_post_thumbnail( $item->ID, 'sc_thumbnail_image' ) ) : ?>
								<?php echo $thumbnail; ?>
							<?php endif; ?>
						</div>-->

					<?php echo get_the_content(); ?>

					<a href="<?php echo get_permalink($item->ID); ?>">
						Read More
					</a>


				</li>

			<?php endforeach; ?>

			<li class="clear"></li>

		</ul>

	<?php endif; ?>
<!-- /Related Pages -->