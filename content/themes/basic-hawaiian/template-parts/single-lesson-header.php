<?php
/**
 * @package Basic Hawaiian
 */
	$unitID = $_GET['unit'];
	$post_type_object = get_post_type_object( get_post_type() );
	$post_type = $post_type_object->labels->singular_name;
	if ( $post_type === 'Video Lesson' ) {
		$post_type_icon = 'fa-tv';
	}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('container'); ?>>

	<header class="lesson-header row">

		<?php // TODO: Jump back to the right unit & module ?>
		<a id="back-to-unit" href="<?php echo get_permalink( $unitID ); ?>">Quit</a>

		<p class="lesson-type"><i class="fa <?php echo $post_type_icon; ?>"></i> <?php echo $post_type_object->labels->singular_name; ?></p>
		<?php the_title( '<h1 class="lesson-title">', '</h1>' ); ?>
