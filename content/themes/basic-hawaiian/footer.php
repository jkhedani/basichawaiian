<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Basic Hawaiian
 */
?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer row" role="contentinfo">
		<?php if ( !is_user_logged_in() ) : ?>
			<div class="site-info col-sm-12">

				<p><?php bloginfo('name'); ?> &copy; <?php echo date('Y'); ?></p>
				<?php
					wp_nav_menu(array(
						'theme_location' => 'footer-menu',
						'container'			 => false,
						// 'items_wrap'		 => '<ul id="%1$s" class="%2$s nav navbar-nav navbar-right">%3$s</ul>'
					));
				?>

			</div><!-- .site-info -->
		<?php endif; ?>
	</footer><!-- #colophon -->

	<?php if ( ! is_user_logged_in() ) : ?>
	<!-- Sign In Modal -->
	<div class="modal fade" id="signIn" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<div class="logo"></div>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<!--<h4 class="modal-title" id="myModalLabel">Sign In</h4>-->
				</div>
				<div class="modal-body">
					<?php wp_login_form(); ?>
				</div>
				<div class="modal-footer">
					<a href="<?php echo home_url();  ?>/wp-login.php?action=register">Need an account?</a>
				</div>
			</div>
		</div>
	</div><!-- .modal -->
	<?php endif; ?>

</div><!-- .row -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
