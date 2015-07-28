<?php
/**
 * Template Name: Payment
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

	<div id="primary-twin" class="content-area col-sm-10 col-sm-offset-1">
		<main id="main" class="site-main" role="main">

			<!-- Slide 1: Enrollment -->
			<div id="enrollment" class="slide active">
				<h1>Thanks for signing up!</h1>
				<h4>Please select a course to enroll in. Your semester starts today!</h4>

				<!-- Payment plans -->
				<ul class="pricing">
					<li>
						<h2 class="large">1 Unit/Kukui</h2>
						<p>One semester worth of lessons and activities.</p>
						<hr />
						<?php echo cents_to_dollars( get_field('one_unit_cost','option') ); ?>/semester
						<a class="enroll btn btn-primary" data-cost="<?php echo get_field('one_unit_cost','option'); ?>">Enroll</a>
					</li>
					<li>
						<h2 class="large">4 Unit/Kukui</h2>
						<p>Two years worth of lessons and activities.</p>
						<hr />
						<?php echo cents_to_dollars( get_field('four_unit_cost','option') ); ?>
						<a class="enroll btn btn-primary" data-cost="<?php echo get_field('four_unit_cost','option'); ?>">Enroll</a>

					</li>
				</ul>
			</div>

			<div id="payment" class="slide">
				<h1>Payment</h1>
				<h4>Please enter your payment details.</h4>

				<div class="enrollment-type">
					cost/type
				</div>

				<!-- Payment form -->
				<form action="" method="POST" id="payment-form">
				  <span class="payment-errors"></span>

				  <div class="form-row">
				    <label>
				      <span>Card Number</span>
				      <input type="text" size="20" data-stripe="number"/>
				    </label>
				  </div>

				  <div class="form-row">
				    <label>
				      <span>CVC</span>
				      <input type="text" size="4" data-stripe="cvc"/>
				    </label>
				  </div>

				  <div class="form-row">
				    <label>
				      <span>Expiration (MM/YYYY)</span>
				      <input type="text" size="2" data-stripe="exp-month"/>
				    </label>
				    <span> / </span>
				    <input type="text" size="4" data-stripe="exp-year"/>
				  </div>

					<input type="hidden" name="action" value="stripe"/>
					<input type="hidden" name="cost" value="3000"/>
					<input type="hidden" name="cost_type" value="3000"/>
					<input type="hidden" name="stripe_nonce" value="<?php echo wp_create_nonce('stripe-nonce'); ?>"/>
				  <button type="submit">Submit Payment</button>
				</form>

				<p>Powered by Stripe</p>
			</div>

			<div id="results" class="slide">
				<h1>Success!</h1>
				<h4>Thanks for enrolling in Basic Hawaiian. Your receipt was sent to your email.</h4>
				<a href="<?php echo home_url(); ?>" class="btn btn-primary">E Komo Mai!</a>
			</div>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php //get_sidebar(); ?>
<?php get_footer(); ?>
