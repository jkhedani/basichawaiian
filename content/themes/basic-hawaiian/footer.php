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

	<footer id="colophon" class="site-footer" role="contentinfo">
		<?php if ( !is_user_logged_in() ) : ?>
			<div class="site-info">
				<p><?php bloginfo('name'); ?> &copy; <?php echo date('Y'); ?></p>
	 		</div><!-- .site-info -->
		<?php endif; ?>
	</footer><!-- #colophon -->

	<?php if ( ! is_user_logged_in() ) : ?>
	<!-- Sign In Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Sign In</h4>
				</div>
				<div class="modal-body">
					<?php wp_login_form(); ?>
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
