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
					echo 'Watch and learn from the video below.';
				endif;
			?>
		</h2>
	</header><!-- .entry-header -->

	<div class="lesson-content row">
			<div class="cards">
			<?php $slideCount = 0; ?>
			<?php while ( have_rows('instructional_slide') ) : the_row(); ?>
				<?php if ( !$slideCount++ ) : ?>
					<div class="card active">
				<?php else : ?>
					<div class="card">
				<?php endif; ?>
				<?php the_sub_field('instructional_slide_content'); ?>
				</div>
			<?php endwhile; ?>
			</div>
	</div><!-- .entry-content -->

	<footer class="lesson-footer row">

<?php get_template_part('template-parts/single','lesson-footer'); ?>
