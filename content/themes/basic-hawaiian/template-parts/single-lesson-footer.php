<?php
/**
 * @package Basic Hawaiian
 */

$user = wp_get_current_user();
$user_id = $user->ID;
$gender = get_user_meta($user_id,'gender',true);
$current_url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$unitID = $_GET['unit'];
?>

		<div class="lesson-controls">
			<a id="finish-lesson" class="btn btn-primary" href="javascript:void(0);" data-post-id="<?php echo $post->ID; ?>" data-user-id="<?php echo $user_id; ?>" data-lesson-outcome="success"><?php echo __('Pau!'); ?></a>
			<a id="advance-lesson" class="btn btn-primary" href="javascript:void(0);">Next<i class="fa fa-arrow-right"></i></a>
			<a id="check-lesson" class="btn btn-primary" href="javascript:void(0);">Check</a>
		</div>
	</footer>

	<div class="lesson-results success <?php echo $gender; ?>">
		<h1 class="lesson-results-title">Maika'i</h1>
		<p class="lesson-results-blurb">You completed this lesson!</p>
		<div class="lesson-results-control">
			<a class="replay-lesson" href="<?php echo $current_url; ?>"><i class="fa fa-refresh"></i></a>
			<a class="btn btn-primary" href="<?php echo get_permalink($unitID); ?>">continue</a>
		</div>
	</div>

	<div class="lesson-results fail <?php echo $gender; ?>">
		<h1 class="lesson-results-title">Auwe</h1>
		<p class="lesson-results-blurb">Give the lesson another try!</p>
		<div class="lesson-results-control">
			<a class="replay-lesson" href="<?php echo $current_url; ?>"><i class="fa fa-refresh"></i></a>
			<a class="btn btn-primary" href="<?php echo get_permalink($unitID); ?>">continue</a>
		</div>
	</div>

</article><!-- #post-## -->
