<?php
/**
 * @package Basic Hawaiian
 */

// Get Related Terms
$related_song_lines = get_field('related_song_lines', false, false);
$song_lines = new WP_Query(array(
	'post_type' => 'song_lines',
	'post__in'	=> $related_song_lines,
	'orderby'		=> 'post__in',
	'order'			=> 'ASC'
));



?>

<?php get_template_part('template-parts/single','lesson-header'); ?>

		<h2 class="lesson-instructions">
			<?php
				if ( get_field( 'optional_instructions' ) ) :
					// Display optional instructions if they exist.
					echo get_field( 'optional_instructions' );
				else :
					echo 'Complete te line of the song below.';
				endif;
			?>
		</h2>
	</header><!-- .entry-header -->

	<div class="lesson-content row">
		<div class="lesson-health-container">
			<?php
				// Percentile for passing: 90%;
				$total_health = $song_lines->post_count * 0.9 % 2;
				for( $i=0; $i < $total_health; $i++ ) {
			?>
			<div class="lesson-health"></div>
			<?php } ?>
		</div>

		<div class="cards col-sm-12">

			<?php while ($song_lines->have_posts()) : $song_lines->the_post(); ?>
				<div class="card test">
					<h3><?php echo get_the_title(); ?></h3>
					<?php
						$correctChoice = get_field('song_answer');
						$choices[] = $correctChoice;
						if (get_field('song_assessment_option_one'))
							$choices[] = get_field('song_assessment_option_one');
						if (get_field('song_assessment_option_two'))
							$choices[] = get_field('song_assessment_option_two');
						shuffle($choices);
						// Identify correct index in randomly shuffled array
						for( $j=0; $j < count($choices); $j++ ) {
							if ($choices[$j] ===  $correctChoice ) {
								$correctIndex = $j;
							}
						}
					?>
					<ul class="choices">
						<?php for( $k=0; $k < count($choices); $k++ ) { ?>
							<li class="col-sm-4">
								<a class="choice <?php if ($correctIndex === $k) { echo 'correct'; } ?>" data-id="<?php echo $post->ID; ?>" data-O="0" data-X="0" href="javascript:void(0);">
									<?php echo $choices[$k]; ?>
								</a>
							</li>
						<?php } ?>
					</ul>
				</div>
			<?php endwhile; ?>
			<?php wp_reset_postdata(); ?>

		</div>

		<div class="lesson-message-container">
			<p class="lesson-message correct">That's correct!</p>
			<p class="lesson-message wrong">Aue! The correct answer was <strong></strong>.</p>
		</div>
	</div><!-- .lesson-content -->

	<footer class="lesson-footer row">

	<div class="lesson-progress">
	<?php for ( $i=0; $i < $song_lines->post_count; $i++ ) { ?>
		<div class="lei-counter <?php if ($i === 0) { echo 'active'; } ?>"></div>
	<?php } ?>
	</div>

<?php get_template_part('template-parts/single','lesson-footer'); ?>
