<?php
/**
 * Template Name: Sign Up
 * @package Basic Hawaiian
 *
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'template-parts/content', 'page' ); ?>

				<!--<div class="banner">
					<p>Discounts, etc.</p>
				</div>-->

				<?php
					function cents_to_dollars($cents) {
						$dollars  = '$';
						// $dollars .= number_format($cents/100,2,'.','');
						$dollars .= $cents/100;
						return $dollars;
					}
				?>

				<div class="container">
				<div class="row">
					<div class="col-sm-4">
						<?php $cost_free = get_field('basic_membership_cost_1','option'); ?>
						<h2>Free</h2>
						<h3><?php echo cents_to_dollars($cost_free); ?></h3>
						<!-- Stripe: Shopping Cart -->
						<form action="" method="POST">
						  <script
						    src="https://checkout.stripe.com/checkout.js" class="stripe-button"
						    data-key="pk_test_9A16AVNKaUWhk8gFTfPv6RfE"
						    data-amount="<?php echo $cost_free; ?>"
						    data-name="Basic Hawaiian"
						    data-description="Membership"
						    data-image="<?php echo get_template_directory_uri(); ?>/images/stripe-avatar.jpg">
						  </script>
						</form>
					</div>
					<div class="col-sm-4">
						<?php $cost_basic = get_field('basic_membership_cost_2','option'); ?>
						<h2>Basic</h2>
						<h3><?php echo cents_to_dollars($cost_basic); ?></h3>
						<!-- Stripe: Shopping Cart -->
						<form action="" method="POST">
						  <script
						    src="https://checkout.stripe.com/checkout.js" class="stripe-button"
						    data-key="pk_test_9A16AVNKaUWhk8gFTfPv6RfE"
						    data-amount="<?php echo $cost_basic; ?>"
						    data-name="Basic Hawaiian"
						    data-description="Basic Membership"
						    data-image="<?php echo get_template_directory_uri(); ?>/images/stripe-avatar.jpg">
						  </script>
						</form>
						<ul>
							<li>2 Modules over 1 Month</li>
						</ul>
					</div>
					<div class="col-sm-4">
						<?php $cost_premium = get_field('premium_membership_cost_1','option'); ?>
						<h2>Premium</h2>
						<h3><?php echo cents_to_dollars($cost_premium); ?></h3>
						<!-- Stripe: Shopping Cart -->
						<form action="" method="POST">
						  <script
						    src="https://checkout.stripe.com/checkout.js" class="stripe-button"
						    data-key="pk_test_9A16AVNKaUWhk8gFTfPv6RfE"
						    data-amount="<?php echo $cost_premium; ?>"
						    data-name="Basic Hawaiian"
						    data-description="Membership"
						    data-image="<?php echo get_template_directory_uri(); ?>/images/stripe-avatar.jpg">
						  </script>
						</form>
						<ul>
							<li>1 Professional Assessment – Hawaiian Language Proficiency</li>
							<li>4 hrs of 1-on-1 Instruction – answering questions re: Hawaiian language and culture</li>
							<li>4 1 hr One-Stop Language Check</li>
						</ul>
					</div>
				</div><!-- .row -->
				</div><!-- .container -->

				<?php
				\Stripe\Stripe::setApiKey("sk_test_qJBsn2OXqaYdedFCh9l6pmDc");

				// Get the credit card details submitted by the form
				$token = $_POST['stripeToken'];

				// Create the charge on Stripe's servers - this will charge the user's card
				try {
					$charge = \Stripe\Charge::create(array(
					"amount" => $cost_basic, // amount in cents, again
					"currency" => "usd",
					"source" => $token,
					"description" => "Example charge")
					);
					wp_redirect( home_url() );
					exit;
				} catch(\Stripe\Error\Card $e) {
					error_log('error');
				}
				?>

			<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php //get_sidebar(); ?>
<?php get_footer(); ?>
