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

$user = wp_get_current_user();


?>

	<div id="primary-twin" class="content-area col-sm-8 col-sm-offset-2">
		<main id="main" class="site-main" role="main">

			<a class="logo" href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo get_stylesheet_directory_uri() . '/images/logo-new-large.png'?>" alt="Basic Hawaiian Logo" /></a>

			<!-- Slide 1: Enrollment -->
			<div id="enrollment" class="slide active">
				<h1>Thanks for signing up!</h1>
				<h4>Please select a course to enroll in. Your semester starts today!</h4>

				<!-- Payment plans -->
				<ul class="pricing">
					<?php
						// Allow upgrades for one unit users
						if ( is_user_logged_in() && in_array('student',$user->roles) ) { ?>
							<li class="three-more">
								<h2 class="large">3 More Unit/Kukui</h2>
								<p>One and a half years worth of lessons and activities.</p>
								<hr />
								<?php echo cents_to_dollars( get_field('upgrade_three_cost','option') ); ?>
								<a class="enroll btn btn-primary" data-cost="<?php echo get_field('upgrade_three_cost','option'); ?>" data-cost-type="three_unit" data-cost-blurb="One and a half years worth of lessons and activities.">Enroll</a>
							</li>

					<?php } else { ?>
						<li>
							<h2 class="large">1 Unit/Kukui</h2>
							<p>One semester worth of lessons and activities.</p>
							<hr />
							<?php echo cents_to_dollars( get_field('one_unit_cost','option') ); ?>
							<a class="enroll btn btn-primary" data-cost="<?php echo get_field('one_unit_cost','option'); ?>" data-cost-type="one_unit" data-cost-blurb="One semester worth of lessons and activities.">Enroll</a>
						</li>
						<li>
							<h2 class="large">4 Unit/Kukui</h2>
							<p>Two years worth of lessons and activities.</p>
							<hr />
							<?php echo cents_to_dollars( get_field('four_unit_cost','option') ); ?>
							<a class="enroll btn btn-primary" data-cost="<?php echo get_field('four_unit_cost','option'); ?>" data-cost-type="four_unit" data-cost-blurb="Two years worth of lessons and activities.">Enroll</a>
						</li>
					<?php } ?>
				</ul>
			</div>

			<div id="payment" class="slide">
				<h1>Payment</h1>
				<h4>Please enter your payment details.</h4>

				<!-- Payment Cost -->
				<div class="payment-cost">
					<h2>$120</h2>
					<p>Two years worth of lessons and activities.</p>
				</div>

				<!-- Payment form -->
				<form action="" method="POST" id="payment-form">
				  <span class="payment-errors"></span>
				  <div class="input-group">
			      <span class="input-group-addon"><i class="fa fa-credit-card"></i></span>
			      <input class="form-control" type="text" size="20" placeholder="Card Number" data-stripe="number"/>
				  </div>
				  <div class="input-group">
			      <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
			      <input class="form-control" type="text" size="2" placeholder="MM" data-stripe="exp-month"/>
				    <!--<span> / </span>-->
				    <input class="form-control" type="text" size="4" placeholder="YYYY" data-stripe="exp-year"/>
				  </div>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-lock"></i></span>
						<input class="form-control" type="text" size="4" placeholder="CVC" data-stripe="cvc"/>
					</div>
					<input type="hidden" name="action" value="stripe"/>
					<input type="hidden" name="cost" value="3000"/>
					<input type="hidden" name="cost_type" value="one_unit"/>
					<input type="hidden" name="stripe_nonce" value="<?php echo wp_create_nonce('stripe-nonce'); ?>"/>
				  <button type="submit" class="btn btn-primary">Submit Payment</button>
				</form>

				<a id="back-to-enrollment" href="#">Choose another enrollment type</a>

				<a href="https://stripe.com/" id="powered-by-stripe"><img src="<?php echo get_stylesheet_directory_uri() . '/images/powered-by-stripe.png'?>" alt="Powered by Stripe" /></a>
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
