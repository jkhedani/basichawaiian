<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package Basic Hawaiian
 */

get_header(); ?>

	<?php if ( ! is_user_logged_in() ) : ?>

		<!--<div id="primary" class="content-area">-->
		<div id="content" class="site-content" role="main">

		<!-- Hero -->
		<div class="wrapper">
			<div class="container">
				<div class="banner row">
					<div class="col-sm-10 col-sm-offset-1">
						<div class="image-container">
							<?php if ( $primary_image_object = get_field('home_primary_image') ) : ?>
							<img src="<?php echo $primary_image_object['url']; ?>" alt="<?php echo $primary_image_object['alt']; ?>" />
							<?php endif; ?>
						</div>

						<div class="banner-content-container">
							<h1><?php echo get_field('home_primary_title'); ?></h1>
							<h2><?php echo get_field('home_secondary_title'); ?></h2>
							<p><?php echo get_field('home_primary_blurb'); ?></p>
							<?php
								echo smlsubform(array(
									"showname" 		=> false,
									"emailtxt" 		=> "",
									"emailholder" => "example@example.com",
									"submittxt"		=> "Notify Me",
									"thankyou"		=> "Thanks for your interest! We'll let you know when you can sign up for Basic Hawaiian."
								));
							?>
						</div>
					</div>
				</div><!--- .banner.row -->
			</div>
		</div>

		<!-- Testimonials -->
		<div class="wrapper">
			<div class="testimonials-container container-fluid">
				<div class="row">
					<div class="col-sm-12">
						<?php
							$testimonials = new WP_Query( array(
								'post_type' => 'testimonials',
								'posts_per_page' => 1,
								'orderby' => 'rand'
							));
						?>
						<div class="testimonials span12">
							<?php while ( $testimonials->have_posts() ) : $testimonials->the_post(); ?>
								<div class="image-container">
									<?php echo get_the_post_thumbnail($post->ID, 'thumbnail'); ?>
								</div>
								<div class="content-container">
									<h3><?php echo get_the_content(); ?></h3>
									<h4 class="client">- <?php echo get_the_title(); ?></h4>
								</div>
							<?php endwhile; ?>
							<?php wp_reset_postdata(); ?>
						</div>
					</div><!-- .col -->
				</div><!-- .testimonials-container.row -->
			</div>
		</div>

		<!-- Home Page Slides -->
		<div class="wrapper">
			<div class="container">
				<div class="row">
					<div class="col-sm-10 col-sm-offset-1">
						<div class="home-page-slides">
							<?php if ( have_rows('home_info_panels') ) : ?>
								<?php $index = 0; ?>
								<?php while ( have_rows('home_info_panels') ) : the_row(); ?>
									<?php $row_id = str_replace(' ', '-', strtolower( get_sub_field('home_info_panel_title') ) ); ?>
									<div id="<?php echo substr( $row_id, 0, 9);  ?>" class="home-page-slide <?php if ( $index%2 === 0 ) { echo "text-right"; } else { echo "text-left"; } ?> padded">
										<div class="home-page-featured-image-container">
											<img src="<?php the_sub_field('home_info_panel_image'); ?>" class="home-page-featured-image" />
										</div>
										<div class="home-page-slide-content-container">
											<h3 class="home-page-slide-title"><?php the_sub_field('home_info_panel_title'); ?></h3>
											<p class="home-page-slide-content"><?php the_sub_field('home_info_panel_content'); ?></p>
											<a class="view-more" href="<?php the_sub_field('home_info_panel_link'); ?>">Learn More <i class="icon-chevron-right"></i></a>
										</div>
										<!--<hr / >-->
									</div>
									<?php $index++; ?>
								<?php endwhile; ?>
							<?php endif; // have_rows ?>
						</div><!-- .home-page-slides -->
					</div>
				</div>
			</div>
		</div>

		<!-- Latest Updates -->
		<div class="wrapper">
			<div class="container">
				<div class="row">
					<div class="col-sm-12">

						<!-- Latest Updates (posts) -->
							<div class="latest-updates container">
								<h2>Latest Updates</h2>
								<?php
									$idObj = get_category_by_slug('screenshots');
									$id = $idObj->term_id;
									$latestPosts = new WP_Query( array(
										'post_type' => 'post',
										'category__not_in' => $id,
										'posts_per_page' => 3
									));
								?>
								<ul class="three-up row">
									<?php while ( $latestPosts->have_posts() ) : $latestPosts->the_post(); ?>
										<li class="col-sm-4">
											<span class="post-date"><?php echo get_the_date('F j, Y'); ?></span>
											<h3><a href="<?php echo the_permalink(); ?>"><?php echo get_the_title(); ?></a></h3>
											<div><?php //echo the_excerpt_max_charlength(100); ?></div>
											<a class="btn btn-primary read-more" href="<?php echo the_permalink(); ?>" target="_blank">Read More</a>
										</li>
									<?php endwhile; ?>
									<?php wp_reset_postdata(); ?>
								</ul>
							</div>

					</div>
				</div>
			</div>
		</div>

	<?php else : ?>

		<div id="primary" class="content-area col-sm-9">
			<div id="content" class="site-content" role="main">

				<!-- User Metadata -->
				<header id="primary-alert" class="message">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					  <span aria-hidden="true"><i class="fa fa-times"></i></span>
					</button>
					<img class="message-image" src="<?php echo get_stylesheet_directory_uri(); ?>/images/alert-aunty-aloha.png" />
					<div class="message-content">
						<span class="alert-content-title"><?php _e('E kipa mai i&#257; <span class="inline-kukui aunty-aloha">&#8216;Anak&#275; Aloha</span> ma ka m&#257;la.','hwn'); ?></span>
						<span class="alert-content-subtitle">Completing the first Kukui will unlock the rest!</span>
					</div>
				</header>

				<!-- Unit Navigation -->
				<?php
					$units = new WP_Query(array(
						'post_type' => 'units',
						'orderby' => 'menu_order',
						'order' => 'ASC',
						'posts_per_page' => 10,
					));

					// Grab all post IDs from units...
					$unitIDs = array();
					while ( $units->have_posts() ) : $units->the_post();
						$unitIDs[] = $post->ID;
					endwhile;
				?>

				<div class="coverflow">
					<ul class="units">
						<li class="unit shop">
							<h1>Shop</h1>
							<h2>Redeem points for gear &amp; upgrades!</h2>
							<a class="view-unit btn btn-cta blue" href="#">Shop</a>
							<a class="unit-info" href="#">?</a>
						</li>
						<?php $unitCount = 0; ?>
						<?php while ( $units->have_posts() ) : $units->the_post(); ?>
						<?php if ( !$unitCount++ ) : ?>
						<li id="<?php echo $post->post_name; ?>" class="unit active <?php echo $post->post_name; ?>">
						<?php else : ?>
						<li id="<?php echo $post->post_name; ?>" class="unit <?php echo $post->post_name; ?>">
						<?php endif; ?>
							<h1><?php echo get_the_title(); ?></h1>
							<?php if ( get_field('unit_subtitle') ) : ?>
							<h2><?php echo get_field('unit_subtitle'); ?></h2>
							<?php endif; ?>
							<a class="unit-info" href="#<?php echo $post->post_name; ?>">?</a>
							<a class="view-unit btn btn-cta blue" href="<?php echo get_permalink(); ?>"><?php _e('E komo mai','basic_hawaiian'); ?></a>
						</li>
						<?php endwhile;
									wp_reset_postdata(); ?>
					</ul>
					<div class="coverflow-controls">
						<a href="#" data-slide-to="prev"><i class="fa fa-chevron-left"></i></a>
						<a href="#" data-slide-to="next"><i class="fa fa-chevron-right"></i></a>
					</div>
					<div class="coverflow-counter-container">
						<div class="coverflow-counter"></div>
						<?php $unitCount = 0; ?>
						<?php while ( $units->have_posts() ) : $units->the_post(); ?>
							<?php if ( !$unitCount++ ) : ?>
							<div class="coverflow-counter active"></div>
							<?php else : ?>
							<div class="coverflow-counter"></div>
						<?php endif; ?>
						<?php endwhile;
									wp_reset_postdata(); ?>
					</div>

					<!-- User Avatar -->
					<?php
						$user = wp_get_current_user();
		    		$user_id = $user->ID;
						$gender = get_user_meta( $user_id, 'gender', true );
					?>
					<div class="user-avatar <?php echo $gender; ?> default"></div>
				</div><!-- .coverflow -->

				<!-- Welcome Modal -->
				<button type="button" id="welcome-modal-trigger" class="btn btn-default navbar-btn" data-toggle="modal" data-target="#welcome-modal">View Modal</button>

				<div class="modal fade" id="welcome-modal" tabindex="-1" role="dialog" aria-labelledby="welcome-modal" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								<h4 class="modal-title" id="myModalLabel">Welcome Modal</h4>
							</div>
							<div class="modal-body">
								<p>Welcome Modal</p>
							</div>
						</div>
					</div>
				</div><!-- .modal -->

	<?php endif; ?>

<?php get_footer(); ?>
