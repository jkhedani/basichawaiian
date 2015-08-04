<?php
/**
 * The template for displaying all lessons and blog posts.
 *
 * @package Basic Hawaiian
 */

get_header(); ?>

	<div id="primary" class="col-sm-9 content-area">
		<main id="main" class="site-main" role="main">

		<?php
			$post_type = get_post_type( $post->ID );
			switch($post_type) {
				case 'units':
					get_template_part( 'template-parts/single', 'unit' );
					break;
				case 'instruction_lessons':
					get_template_part( 'template-parts/single', 'lesson-instruction' );
					break;
				case 'video_lessons':
					get_template_part( 'template-parts/single', 'lesson-video' );
					break;
				case 'vocabulary_lessons':
					get_template_part( 'template-parts/single', 'lesson-vocabulary' );
					break;
				case 'readings':
					get_template_part( 'template-parts/single', 'lesson-readings' );
					break;
				case 'phrases_lessons':
					get_template_part( 'template-parts/single', 'lesson-phrases' );
					break;
				case 'chants_lessons':
					get_template_part( 'template-parts/single', 'lesson-chants' );
					break;
				case 'song_lessons':
					get_template_part( 'template-parts/single', 'lesson-song' );
					break;
			}
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
