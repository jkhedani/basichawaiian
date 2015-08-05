<?php
/**
 * @package Basic Hawaiian
 */
?>

<?php get_template_part('template-parts/single','lesson-header'); ?>

		<h2 class="lesson-instructions">
			<?php
				if ( get_field( 'optional_instructions' ) ) :
					// Display optional instructions if they exist.
					echo get_field( 'optional_instructions' );
				else :
					echo 'E hoʻolohe mua a laila e heluhelu pū. Listen first and then try to read along.';
				endif;
			?>
		</h2>
	</header><!-- .entry-header -->

	<?php
		$originalNewspaper = get_field('original_newspaper');
		$typedNewspaper = get_field('typed_newspaper');
		$typedOkinaKahako = get_field('typed_newspaper_with_okinas_and_kahako');
	?>

	<div class="lesson-content row">
			<div class="cards">
				<div class="card">
					<div class="toggled-content" id="original-newspaper">
						<img src-"<?php echo $originalNewspaper; ?>" />
					</div>
					<div class="toggled-content" id="typed-newspaper">
						<?php echo $typedNewspaper; ?>
					</div>
					<div class="toggled-content" id="typed-okina-kahako">
						<?php echo $typedOkinaKahako; ?>
					</div>
				</div>
			</div>
	</div><!-- .entry-content -->

	<footer class="lesson-footer row">
		<div class="lesson-readings-control">
			<button class="audio-toggle off" data-audio-id="<?php echo $post->ID; ?>" ><i class="fa fa-volume-off"></i></button>
			<audio id="<?php echo $post->ID; ?>-audio">
				<source src="<?php echo get_field('readings_audio_track'); ?>" type="audio/ogg">
				<source src="<?php echo get_field('readings_audio_mp3'); ?>" type="audio/mpeg">
					Your browser does not support the audio element.
			</audio>
			<button class="toggle-content <?php echo ($originalNewspaper) ? 'available' : ''; ?>" data-show-id="original-newspaper"><i class="fa fa-newspaper-o"></i> Original Newspaper</button>
			<button class="toggle-content <?php echo ($typedNewspaper) ? 'available' : ''; ?>" data-show-id="typed-newspaper"><i class="fa fa-file-text-o"></i> Typed Text</button>
			<button class="toggle-content <?php echo ($typedOkinaKahako) ? 'available' : ''; ?>" data-show-id="typed-okina-kahako"><i class="fa fa-file-text"></i> Typed Text with 'Okina &amp; Kahakō</button>
		</div>

<?php get_template_part('template-parts/single','lesson-footer'); ?>
