<?php
/**
 * @package Basic Hawaiian
 */
?>

<!--<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>-->
	<header class="unit-header">
		<?php the_title( '<h1 class="unit-title">', '</h1>' ); ?>
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
		?>
		<ul class="modules">
		<?php while( $modules->have_posts() ) : $modules->the_post(); ?>
			<li class="module">
				<p class="module-title"><?php the_title(); ?></p>
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
				<ul class="topics">
					<?php while( $topics->have_posts() ) : $topics->the_post(); ?>
					<li class="topic">
						<p class="topic-title"><?php the_title(); ?></p>
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
						<ul class="lessons">
							<?php while( $lessons->have_posts() ) : $lessons->the_post(); ?>
							<li class="lesson">
								<a href="<?php the_permalink(); ?>"><i class="icon icon-unit-currency"></i><?php the_title(); ?></a>
							</li>
							<?php
								endwhile;
								wp_reset_postdata();
							?>
						</ul><!-- .lessons -->
						<?php endif; // !empty() ?>
					</li>
					<?php
						endwhile;
						wp_reset_postdata();
					?>
				</ul><!-- .topics -->
				<?php endif; // !empty() ?>
			</li>
		<?php
			endwhile;
			wp_reset_postdata();
		endif; // if $related_modules
		?>
	</ul><!-- .modules -->

	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php basic_hawaiian_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
