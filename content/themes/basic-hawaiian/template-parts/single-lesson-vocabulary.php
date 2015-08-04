<?php
/**
 * @package Basic Hawaiian
 */

// Get Related Terms
$related_vocabulary_terms = get_field('related_vocabulary_terms', false, false);
$vocabulary_terms = new WP_Query(array(
	'post_type' => 'vocabulary_terms',
	'post__in'	=> $related_vocabulary_terms,
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
					echo 'E hoʻolohe a e hoʻopili mai a paʻa ka huaʻōlelo! Listen and repeat until you have memorized the word.';
				endif;
			?>
		</h2>
	</header><!-- .entry-header -->

	<div class="lesson-content row">
		<div class="lesson-health-container">
			<?php
				// Percentile for passing: 90%;
				$total_health = $vocabulary_terms->post_count * 0.9 % 2;
				for( $i=0; $i < $total_health; $i++ ) {
			?>
			<div class="lesson-health"></div>
			<?php } ?>
		</div>

		<div class="cards col-sm-12">

			<?php // Create test cards here. ?>
			<?php for( $i = 0; $i < $vocabulary_terms->post_count; $i++ ) { ?>
				<div class="card test">
					<?php
						// Add correct answer to choice array
						$correctChoice = $vocabulary_terms->posts[$i];
						$choices[] = $correctChoice;

						// Create a range of integers equal to the amount of testable options
						$range = range(0, $vocabulary_terms->post_count-1);
						unset($range[$i]); // remove the current card from the choice pool
						shuffle($range); // shuffle all other choices

						// Add two other cards to test options
						$choices[] = $vocabulary_terms->posts[$range[0]];
						$choices[] = $vocabulary_terms->posts[$range[1]];

						// Shuffle choices
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
								<li>
									<a class="choice <?php if ($correctIndex === $k) { echo 'correct'; } ?>" href="javascript:void(0);">
										<p class="choice-title"><?php echo $choices[$k]->post_title; ?></p>
									</a>
								</li>
						<?php } ?>
						</ul>

						<?php
						// Reset options for the next card
						unset($choices);
					?>
				</div>
			<?php } ?>

			<?php while($vocabulary_terms->have_posts()) : $vocabulary_terms->the_post(); ?>
					<div class="card">
						<h3><?php echo get_the_title(); ?></h3>
						<button class="audio-toggle" onclick="document.getElementById('<?php echo $post->ID; ?>-audio').play()"><i class="fa fa-volume-off"></i></button>
						<audio id="<?php echo $post->ID; ?>-audio">
							<source src="<?php //echo get_field('audio_track'); ?>" type="audio/ogg">
							<source src="<?php //echo get_field('audio_track_mp3'); ?>" type="audio/mpeg">
								Your browser does not support the audio element.
						</audio>

						<a class="show-translation" href="#"><div class="translate show-english"></div></a>

						<div class="image-wrapper">
						<?php
							if (get_the_post_thumbnail()) {
								echo get_the_post_thumbnail();
							} else {
						?>
						<div class="image-substitute"><?php echo get_field('english_translation'); ?></div>
						<?php } ?>
						</div>
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
	<?php for ( $i=0; $i < $vocabulary_terms->post_count; $i++ ) { ?>
		<div class="lei-counter <?php if ($i === 0) { echo 'active'; } ?>"></div>
	<?php } ?>
	</div>

<?php get_template_part('template-parts/single','lesson-footer'); ?>
