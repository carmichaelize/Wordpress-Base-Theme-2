				<div class="clear"></div>

			</div><!-- /.wrapper -->

		</section><!-- /#content -->

		<footer id="footer">

			<div class="wrapper">

				<?php/*
					if( has_nav_menu('footer-menu')){
						wp_nav_menu(array(
							'theme_location' => 'footer-menu',
							'container'=> 'nav',
							'container_class' => 'footer-nav',
							'items_wrap' => '<ul id="%1$s" class="no-list %2$s">%3$s<li class="clear"></li></ul>',
							'sort_column' => 'menu_order'
						));
					}
				*/?>

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

				<!-- Social -->
				<?php if( $global_options->twitter ) : ?>
					<a class="circle" href="<?php echo $global_options->twitter; ?>">
						<div>
							<i class="fa fa-twitter"></i>
						</div>
					</a>
				<?php endif; ?>
				<?php if( $global_options->facebook ) : ?>
					<a class="circle" href="<?php echo $global_options->facebook; ?>">
						<div>
							<i class="fa fa-facebook"></i>
						</div>
					</a>
				<?php endif; ?>
				<?php if( $global_options->googleplus ) : ?>
					<a class="circle" href="<?php echo $global_options->googleplus; ?>">
						<div>
							<i class="fa fa-google-plus"></i>
						</div>
					</a>
				<?php endif; ?>
				<?php if( $global_options->linkedin ) : ?>
					<a class="circle" href="<?php echo $global_options->linkedin; ?>">
						<div>
							<i class="fa fa-linkedin"></i>
						</div>
					</a>
				<?php endif; ?>

				<!-- Contact Details -->
				<?php if( $global_options->address ) : ?>
					Address
					<br />
					<?php echo $global_options->address; ?>
				<?php endif; ?>

				<?php if( $global_options->phone ) : ?>
					Telephone
					<br />
					<?php echo $global_options->phone; ?>
				<?php endif; ?>

				<?php if( $global_options->email ) : ?>
					Email
					<br />
					<a href="mailto:<?php echo $global_options->email; ?>"><?php echo $global_options->email; ?></a>
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