<?php
/**
 * Template Name: Sign Up
 * @package Basic Hawaiian
 *
 */

get_header();

if ( get_field('stripe_is_live','option') === false ) {
	$publishable = get_field('stripe_test_publishable','option');
} elseif ( get_field('stripe_is_live','option') === true ) {
	$publishable = get_field('stripe_live_publishable','option');
}

?>
		<div id="primary" class="content-area col-sm-12">
			<main id="main" class="site-main" role="main">

				<div class="container">
				<div class="row">
				<div class="col-sm-10 col-sm-offset-1">

				<?php while ( have_posts() ) : the_post(); ?>

					<?php get_template_part( 'template-parts/content', 'page' ); ?>

					<?php
						// If comments are open or we have at least one comment, load up the comment template
						if ( comments_open() || get_comments_number() ) :
							comments_template();
						endif;
					?>

				<?php endwhile; // end of the loop. ?>

				<ul class="pricing">
					<li>
						<h2 class="large">1 Unit/Kukui</h2>
						<p>One semester worth of lessons and activities.</p>
						<hr />
						<?php echo cents_to_dollars( get_field('one_unit_cost','option') ); ?>/semester
					</li>
					<li>
						<h2 class="large">4 Unit/Kukui</h2>
						<p>Two years worth of lessons and activities.</p>
						<hr />
						<?php echo cents_to_dollars( get_field('four_unit_cost','option') ); ?>
					</li>
				</ul>

				<a class="btn btn-primary" href="<?php echo wp_registration_url(); ?>">Sign up!</a>

				<p>
					If you wish to procure multiple licenses for schools, businesses,
					organizations and other programs, please contact us at: <?php echo get_field('info_email','option'); ?>
				</p>

				</div>
				</div><!-- row -->
				</div><!-- container -->

			</main><!-- #main -->
		</div><!-- #primary -->
<?php //get_sidebar(); ?>
<?php get_footer(); ?>
