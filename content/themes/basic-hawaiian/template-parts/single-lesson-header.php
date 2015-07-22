<?php
/**
 * @package Basic Hawaiian
 */
?>

<header class="entry-header">

	<?php // TODO: Jump back to the right unit & module ?>
	<a id="back-to-unit" href="<?php echo home_url() . '/unit/aunty-aloha/'; ?>">Quit</a>

	<?php $post_type_object = get_post_type_object( get_post_type() ); ?>
										<p class="lesson-type"><?php echo $post_type_object->labels->singular_name; ?></p>
	<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	<h2>
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
