<?php
/**
 * @package Basic Hawaiian
 */
 $slideCount = 0;
?>

<?php get_template_part('template-parts/single','lesson-header'); ?>

	<?php while ( have_rows('instructional_slide') ) : the_row(); ?>
		<h2 class="lesson-instructions">

			<?php
				if ( get_sub_field( 'instructional_slide_optional_instructions' ) ) :
					// Display optional instructions if they exist.
					the_sub_field( 'instructional_slide_optional_instructions' );
				else :
					echo 'E heluhelu. Go over instructions.';
				endif;
			?>
		</h2>
	<?php endwhile; ?>

	</header><!-- .entry-header -->

	<div class="lesson-content row">
			<div class="cards">
			<?php while ( have_rows('instructional_slide') ) : the_row(); ?>
				<div class="card">

					<?php
						$slideContent = get_sub_field('instructional_slide_content');
						$slideTranslation = get_sub_field('instructional_slide_translation');
						$slideAudioOGG = get_sub_field('instructional_slide_audio_ogg');
						$slideAudioMP3 = get_sub_field('instructional_slide_audio_mp3');
					?>

					<?php if ( $slideAudioOGG || $slideAudioMP3 ) : ?>
					<button class="audio-toggle off" data-audio-id="<?php echo $slideCount; ?>" ><i class="fa fa-volume-off"></i></button>
					<audio id="<?php echo $slideCount; ?>-audio">
						<source src="<?php echo $slideAudioOGG; ?>" type="audio/ogg">
						<source src="<?php echo $slideAudioMP3; ?>" type="audio/mpeg">
							Your browser does not support the audio element.
					</audio>
					<?php endif; ?>

					<?php if ( $slideTranslation ) : ?>
						<a class="show-translation" data-translation-id="<?php echo $slideCount; ?>" href="javascript:void(0);"><div class="translate show-english"></div></a>
					<?php endif; ?>

					<div class="instructional-slide-content">
						<?php echo $slideContent; ?>
					</div>

					<?php if ( $slideTranslation ) : ?>
						<div class="instructional-slide-translation">
							<?php echo $slideTranslation; ?>
						</div>
					<?php endif; ?>

				</div>
				<?php $slideCount++; ?>
			<?php endwhile; ?>
			</div>
	</div><!-- .entry-content -->

	<footer class="lesson-footer row">

		<div class="lesson-progress">
		<?php for ( $i=0; $i < $slideCount; $i++ ) { ?>
			<div class="lei-counter <?php if ($i === 0) { echo 'active'; } ?>"></div>
		<?php } ?>
		</div>

<?php get_template_part('template-parts/single','lesson-footer'); ?>
