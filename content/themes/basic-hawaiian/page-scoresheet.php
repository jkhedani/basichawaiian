<?php
/**
 * Template Name: Scoresheet
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

	<div id="primary" class="col-sm-9 content-area">
		<main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'template-parts/content', 'page' ); ?>

				<?php echo get_field('scoresheet_blurb','option'); ?>

				<?php
					// Display units & lessons
					$units = new WP_Query(array(
						'post_type' => 'units',
						'order'			=> 'ASC'
					));
					while ( $units->have_posts() ) : $units->the_post(); ?>
						<div class="units">
							<?php the_title(); ?>
							<?php
								$related_modules = get_field('related_modules', false, false);
								$modules = new WP_Query(array(
									'post_type' => 'modules',
									'post__in'	=> $related_modules,
									'orderby'		=> 'post__in',
									'order'			=> 'ASC'
								));
							?>
								<ul class="modules">
								<?php while ( $modules->have_posts() ) : $modules->the_post(); ?>
									<li>
										<?php the_title(); ?>
										<?php
											$related_topics = get_field('related_topics', false, false);
											$topics = new WP_Query(array(
												'post_type' => 'topics',
												'post__in'	=> $related_topics,
												'orderby'		=> 'post__in',
												'order'			=> 'ASC'
											));
										?>
										<ul class="topics">
										<?php while ( $topics->have_posts() ) : $topics->the_post(); ?>
											<li>
												<?php the_title(); ?>
												<?php
													$related_lessons = get_field('related_lessons', false, false);
													$lessons = new WP_Query(array(
														'post_type' => array('instruction_lessons', 'video_lessons', 'listenrepeat_lessons', 'readings', 'vocabulary_lessons', 'phrases_lessons', 'pronoun_lessons', 'song_lessons', 'chants_lessons'),
														'post__in'	=> $related_lessons,
														'orderby'		=> 'post__in',
														'order'			=> 'ASC'
													));
												?>
												<ul class="lessons">
												<?php while ( $lessons->have_posts() ) : $lessons->the_post(); ?>
													<!--<li><?php the_title(); ?></li>-->
												<?php
													endwhile;
													wp_reset_postdata();
												?>
												</ul>
											</li>
										<?php
											endwhile;
											wp_reset_postdata();
										?>
										</ul>

									</li>
								<?php
									endwhile;
									wp_reset_postdata();
								?>
								</ul>

						</div>
				<?php
					endwhile;
					wp_reset_postdata();
				?>

			<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php //get_sidebar(); ?>
<?php get_footer(); ?>
