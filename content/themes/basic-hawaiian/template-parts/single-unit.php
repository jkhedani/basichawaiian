<?php
/**
 * @package Basic Hawaiian
 */
?>

<!--<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>-->
	<header class="unit-header">
		<?php the_title( '<h1 class="unit-title">', '</h1>' ); ?>
		<h2><?php echo get_field('unit_subtitle'); ?></h2>
		<?php $header_image_object = get_field('unit_page_image'); ?>
		<img src="<?php  echo $header_image_object['url']; ?>" />
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
			/**
			 * Modules
			 */
			$related_modules = get_field('related_modules', false, false);
			if ( !empty($related_modules) ) :
			$modules = new WP_Query(array(
				'post_type' => 'modules',
				'post__in'	=> $related_modules,
				'orderby'		=> 'post__in',
				'order'			=> 'ASC'
			));
			error_log($modules->post_count);
		?>
		<div class="coverflow">
			<ul class="modules">
			<?php $moduleCount = 0; ?>
			<?php while( $modules->have_posts() ) : $modules->the_post(); ?>
				<?php if ( !$moduleCount++ ) { ?>
					<li class="module active">
				<?php } else { ?>
					<li class="module">
				<?php } ?>
					<p class="module-title">Module <span><?php echo $moduleCount; ?> of <?php echo $modules->post_count; ?></span></p>
					<?php
						/**
						 * Topics
						 */
						$related_topics = get_field('related_topics', false, false);
						if ( !empty($related_topics) ) :
						$topics = new WP_Query(array(
							'post_type' => 'topics',
							'post__in'	=> $related_topics,
							'orderby'		=> 'post__in',
							'order'			=> 'ASC'
						));
					?>
					<ol class="topics">
						<?php while( $topics->have_posts() ) : $topics->the_post(); ?>
						<li class="topic">
							<div class="topic-info">
								<p class="topic-title"><?php the_title(); ?></p>
								<div class="image-wrapper">

								</div>
							</div>
							<?php
								/**
								 * Lessons
								 */
								$related_lessons = get_field('related_lessons', false, false);
								if ( !empty($related_lessons) ) :
								$lessons = new WP_Query(array(
									'post_type' => array('instruction_lessons', 'video_lessons', 'listenrepeat_lessons', 'readings', 'vocabulary_lessons', 'phrases_lessons', 'pronoun_lessons', 'song_lessons', 'chants_lessons'),
									'post__in'	=> $related_lessons,
									'orderby'		=> 'post__in',
									'order'			=> 'ASC'
								));
							?>
							<ol class="lessons">
								<?php while( $lessons->have_posts() ) : $lessons->the_post(); ?>
								<li class="lesson">
									<a href="<?php the_permalink(); ?>">
										<?php $post_type_object = get_post_type_object( get_post_type() ); ?>
										<p class="lesson-type"><?php echo $post_type_object->labels->name; ?> <i class="fa fa-pencil"></i></p>
										<i class="icon icon-unit-currency"></i>
										<?php the_title(); ?>
									</a>
								</li>
								<?php
									endwhile;
									wp_reset_postdata();
								?>
							</ol><!-- .lessons -->
							<?php endif; // !empty() ?>
						</li>
						<?php
							endwhile;
							wp_reset_postdata();
						?>
					</ol><!-- .topics -->
					<?php endif; // !empty() ?>
				</li>
			<?php
				endwhile;
				wp_reset_postdata();
			endif; // if $related_modules
			?>
		</ul><!-- .modules -->

		<div class="coverflow-controls">
			<a href="#" data-slide-to="prev"><i class="fa fa-chevron-left"></i></a>
			<a href="#" data-slide-to="next"><i class="fa fa-chevron-right"></i></a>
		</div>
	</div>

	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php basic_hawaiian_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
