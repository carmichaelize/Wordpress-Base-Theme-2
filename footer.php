				<div class="clear"></div>

			</div><!-- /.wrapper -->

		</section><!-- /#content -->

		<footer id="footer">

			<div class="wrapper">

				<?php global $global_options; ?>
				<!-- Social -->
				<?php if( $global_options->twitter ) : ?>
					<a href="<?php echo $global_options->twitter; ?>"><img src="<?php echo IMAGE_PATH.'' ?>" alt="Twitter" title="Twitter" /></a>
				<?php endif; ?>
				<?php if( $global_options->facebook ) : ?>
					<a href="<?php echo $global_options->facebook; ?>"><img src="<?php echo IMAGE_PATH.'' ?>" alt="Facebook" title="Facebook" /></a>
				<?php endif; ?>
				<?php if( $global_options->linkedin ) : ?>
					<a href="<?php echo $global_options->linkedin; ?>"><img src="<?php echo IMAGE_PATH.'' ?>" alt="LinkedIn" title="LinkedIn" /></a>
				<?php endif; ?>

				<?php if ( is_active_sidebar( 'footer-widget-area' ) ) : ?>
					<div class="footer-bucket">
						<ul>
							<?php dynamic_sidebar( 'footer-widget-area' ); ?>
						</ul>
					</div>
				<?php endif; ?>

				&copy; Copyright <?php echo date('Y'); ?> <?php bloginfo('name'); ?> | All Rights Reserved.
				Designed by <a href="http://www.scottcarmichael.co.uk">Scott Carmichael</a>

				<div class="clear"></div>

			</div><!-- /.wrapper -->

		</footer><!-- /#footer -->

		<!--[if lt IE 8]>
    		<script src="<?php echo TEMPLATE_PATH; ?>/js/json2.js"></script>
  		<![endif]-->

		<?php wp_footer(); ?>

	</body>
</html>