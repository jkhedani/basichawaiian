<?php
/**
 * The template for displaying an individual's score
 * @package Basic Hawaiian
 */
?>

<h1>My Progress</h1>
<?php
  // Show Users Scores
	$units = new WP_Query(array(
		'post_type' => 'units',
		'orderby' => 'menu_order',
		'order' => 'ASC',
		'posts_per_page' => 10,
	));
?>
<?php while ( $units->have_posts() ) : $units->the_post(); ?>
<?php if ( !$unitCount++ ) : ?>
<li id="<?php echo $post->post_name; ?>" class="unit active <?php echo $post->post_name; ?>">
<?php else : ?>
<li id="<?php echo $post->post_name; ?>" class="unit <?php echo $post->post_name; ?>">
<?php endif; ?>
  <h2><?php echo get_the_title(); ?></h2>
  <?php if ( get_field('unit_subtitle') ) : ?>
  <h3><?php echo get_field('unit_subtitle'); ?></h3>
  <?php endif; ?>
  <a class="unit-info" href="#<?php echo $post->post_name; ?>">?</a>
  <a class="view-unit btn btn-cta blue" href="<?php echo get_permalink(); ?>"><?php _e('E komo mai','basic_hawaiian'); ?></a>
</li>
<?php
  endwhile;
  wp_reset_postdata();
?>
