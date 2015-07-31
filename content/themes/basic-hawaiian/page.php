<?php
/**
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

	<?php if ( is_user_logged_in() ) : ?>
		<div id="primary" class="col-sm-9 content-area">
	<?php else : ?>
		<div id="primary" class="col-sm-12 content-area">
	<?php endif; ?>
		<main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php if ( is_user_logged_in() ) : ?>
					<?php get_template_part( 'template-parts/content', 'page' ); ?>
				<?php else : ?>
					<?php get_template_part( 'template-parts/content', 'page-public' ); ?>
				<?php endif; ?>

				<?php
					// If comments are open or we have at least one comment, load up the comment template
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;
				?>

			<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php //get_sidebar(); ?>
<?php get_footer(); ?>
